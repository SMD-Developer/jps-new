<?php namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\UuidModel;
use App\Notifications\ClientResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\ClientRegister;


class Client extends Authenticatable{
    use UuidModel,Notifiable;
    public $incrementing = false;
    protected $appends = ['login_link'];
    protected $fillable = ['client_no', 'name', 'email', 'address1', 'address2', 'city', 'state', 'postal_code', 'country', 'phone', 'mobile', 'website', 'notes','password','photo','force_password_reset'];
    /**
     * Main table primary key
     * @var string
     */
    protected $primaryKey = 'uuid';
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
    /**
     * @return HasMany
     */
    public static function boot() {
        parent::boot();
        static::deleting(function($client) {
            if($client->photo != ''){
                \File::delete(config('app.images_path').'uploads/client_images/'.$client->photo);
            }
            $client->invoices()->delete();
            $client->estimates()->delete();
        });
    }
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class,'client_id');
    }
    /**
     * @return HasMany
     */
    public function estimates(): HasMany
    {
        return $this->hasMany(Estimate::class, 'client_id');
    }
    
    public function scopeOrdered($query){
        return $query->orderBy('created_at', 'desc')->get();
    }
    public function getLoginLinkAttribute()
    {
        return route('client_login');
    }

    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }


    public function sendPasswordResetNotification($token)
    {
        $url = url(route('client.password.reset', [
            'token' => $token,
            'email' => $this->email,
        ], false));

        $this->notify(new class($url) extends \Illuminate\Auth\Notifications\ResetPassword {
            public $url;

            public function __construct($url)
            {
                $this->url = $url;
            }

            public function toMail($notifiable)
            {
                return (new MailMessage)
                    ->subject('Reset Password Notification')
                    ->view('emails.password-reset', [
                        'actionUrl' => $this->url,
                        'notifiable' => $notifiable,
                    ]);
            }
        });
    }
    
        // In your Client model (app/Models/Client.php)
    public function clientRegister()
    {
        return $this->hasOne(ClientRegister::class, 'client_id');
    }

}
