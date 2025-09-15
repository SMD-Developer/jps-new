<?php namespace App\Models;
use App\Notifications\AdminResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\UuidModel;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Messages\MailMessage;

class User extends Authenticatable {
    use Notifiable;
    use UuidModel;
    protected $appends = ['login_link'];
    public $incrementing = false;
	protected $keyType = 'string';
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
    /**
     * Main table primary key
     * @var string
     */
    protected $primaryKey = 'uuid';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['username','name','email','password','phone','photo','role_id','department_id', 'status', 'force_password_reset'	];
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
			'uuid' => 'string',
            'password' => 'hashed',
        ];
    }

// 	public function hasRole($role){
// 		if(is_string($role) && $this->role->name == $role){
// 			return true;
// 		}
// 		return false;
// 	}


    public function hasRole($role){
		if(is_string($role) && $this->role && $this->role->name == $role){ 
			return true; 
		}
		
		if(is_array($role)){
			return in_array($this->role->name, $role);
		}
		
		return false; 
	}

	public function role()
	{
		return $this->belongsTo(Role::class, 'role_id', 'uuid');
	}
// 	public function hasPermission($perm = null)
// 	{
// 		if(is_null($perm)) return false;
// 		if($this->role->permissions->contains('name', $perm))
// 			return true;
// 		else
// 			return false;
// 	}


    public function hasPermission($perm = null) 
    { 
		if(is_null($perm) || !$this->role) return false;
		
		// Check if it's an array of permissions
		if(is_array($perm)){
			foreach($perm as $p){
				if($this->role->permissions->contains('name', $p)){
					return true;
				}
			}
			return false;
		}
    
			// Single permission check
	 		return $this->role->permissions->contains('name', $perm);
    }
    public function scopeOrdered($query){
        return $query->orderBy('created_at', 'desc')->get();
    }
    // public function sendPasswordResetNotification($token){
    //     $this->notify(new AdminResetPassword($token));
    // }
    public function getLoginLinkAttribute()
    {
        return route('admin_login');
    }

	public function department()
	{
		return $this->belongsTo(Department::class, 'department_id','uuid');
	}

	// public function staffDepartment()
	// {
	// 	return $this->hasOne(Department::class, 'department_id');
	// }

	public function staffRole():HasOne
	{
		return $this->hasOne(Role::class,'uuid', 'role_id');
	}

	public function isActive()
	{
		return $this->status === 'active';
	}
	
	public function sendPasswordResetNotification($token)
    {
        $url = url(route('admin.password.reset', [
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
                    ->view('emails.admin-password-reset', [
                        'actionUrl' => $this->url,
                        'notifiable' => $notifiable,
                    ]);
            }
        });
    }
    
    
    public function assignedReviews()
    {
        return $this->hasMany(ReportReview::class, 'assigned_to');
    }

    public function submittedReports()
    {
        return $this->hasMany(ReportReview::class, 'submitted_by');
    }
    
    
    public function assignedApprovals()
    {
        return $this->hasMany(ReportApproval::class, 'assigned_to', 'uuid');
    }
    


    // public function hasRole($roleName)
    // {
    //     return $this->roles()->where('name', $roleName)->exists();
    // }
}
