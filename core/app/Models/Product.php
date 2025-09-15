<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidModel;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model {
    use UuidModel;
    public $incrementing = false;
    protected $primaryKey = 'uuid';
    protected $appends = ['imageUrl'];
    protected $fillable =  ['name', 'code', 'category_id', 'price', 'description','image'];

    public static function boot() {
        parent::boot();
        static::deleting(function($product) {
            if($product->image != ''){
                File::delete(config('app.images_path').'uploads/product_images/'.$product->image);
            }
        });
    }
    protected function getImageUrlAttribute(): string
    {
        if(!empty($this->image)){
            if (file_exists($this->image)) {
                return asset($this->image);
            }

            if(file_exists(config('app.images_path').'uploads/product_images/'.$this->image)) {
                return asset(config('app.images_path').'uploads/product_images/'.$this->image);
            }
        }
        return asset(config('app.images_path').'uploads/product_images/no-product-image.png');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
    public function scopeOrdered($query){
        return $query->orderBy('created_at', 'desc')->get();
    }
}
