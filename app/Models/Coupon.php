<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Coupon extends Model {
 protected $fillable=['code','type','value','min_order','usage_limit','used_count','expires_at','is_active'];
 protected function casts():array{return ['value'=>'decimal:2','min_order'=>'decimal:2','expires_at'=>'datetime','is_active'=>'boolean'];}
 public function usableFor(float $subtotal):bool {
  return $this->is_active && (!$this->expires_at || $this->expires_at->isFuture()) && ($this->usage_limit===null || $this->used_count<$this->usage_limit) && $subtotal >= (float)$this->min_order;
 }
 public function discount(float $subtotal):float {return round(min($subtotal, $this->type==='percent'?$subtotal*(float)$this->value/100:(float)$this->value),2);}
}
