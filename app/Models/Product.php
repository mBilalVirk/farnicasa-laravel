<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Product extends Model {
 protected $fillable=['category_id','name','slug','sku','description','price','compare_at_price','stock','low_stock_threshold','image','material','dimensions','is_active','is_featured'];
 protected function casts():array{return ['price'=>'decimal:2','compare_at_price'=>'decimal:2','stock'=>'integer','is_active'=>'boolean','is_featured'=>'boolean'];}
 public function category():BelongsTo{return $this->belongsTo(Category::class);}
 public function reviews():HasMany{return $this->hasMany(Review::class);}
 public function approvedReviews():HasMany{return $this->hasMany(Review::class)->where('is_approved',true);}
 public function movements():HasMany{return $this->hasMany(InventoryMovement::class);}
 public function getRouteKeyName():string{return 'slug';}
 public function getImageUrlAttribute():string{return str_starts_with($this->image??'','http')?$this->image:($this->image?asset('storage/'.$this->image):asset('images/placeholder.svg'));}
 public function getIsLowStockAttribute():bool{return $this->stock<=$this->low_stock_threshold;}
}
