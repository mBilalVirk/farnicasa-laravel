<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Order extends Model {
 protected $fillable=['order_number','user_id','coupon_id','status','payment_method','payment_status','subtotal','discount','shipping','tax','total','name','email','phone','address','city','postal_code','notes','shipped_at','delivered_at'];
 protected function casts():array{return ['subtotal'=>'decimal:2','discount'=>'decimal:2','shipping'=>'decimal:2','tax'=>'decimal:2','total'=>'decimal:2','shipped_at'=>'datetime','delivered_at'=>'datetime'];}
 public function user():BelongsTo{return $this->belongsTo(User::class);}
 public function items():HasMany{return $this->hasMany(OrderItem::class);}
 public function coupon():BelongsTo{return $this->belongsTo(Coupon::class);}
}
