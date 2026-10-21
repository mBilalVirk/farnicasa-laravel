<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Category extends Model {
 protected $fillable=['name','slug','description','image','sort_order','is_active'];
 protected function casts():array{return ['is_active'=>'boolean'];}
 public function products():HasMany{return $this->hasMany(Product::class);}
 public function getRouteKeyName():string{return 'slug';}
 public function getImageUrlAttribute():string{return str_starts_with($this->image??'','http')?$this->image:($this->image?asset('storage/'.$this->image):asset('images/placeholder.svg'));}
}
