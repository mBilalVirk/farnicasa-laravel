<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Coupon;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
class CartController extends Controller {
 public function index(CartService $cart){return view('shop.cart',$cart->summary());}
 public function add(Request $request,Product $product){
  abort_unless($product->is_active,404);
  $data=$request->validate(['quantity'=>['nullable','integer','min:1','max:99']]);
  $qty=(int)($data['quantity']??1);$cart=session('cart',[]);$current=(int)($cart[$product->id]??0);
  if($current+$qty>$product->stock)return back()->withErrors(['quantity'=>'Insufficient stock. Available: '.$product->stock]);
  $cart[$product->id]=$current+$qty;session(['cart'=>$cart]);
  return back()->with('success',$product->name.' added to cart.');
 }
 public function update(Request $request){
  $data=$request->validate(['quantities'=>['required','array'],'quantities.*'=>['required','integer','min:0','max:99']]);
  $cart=session('cart',[]);
  foreach($data['quantities'] as $id=>$quantity){
   $quantity=(int)$quantity;
   if(!array_key_exists($id,$cart))continue;
   $product=Product::where('is_active',true)->find($id);
   if(!$product||$quantity===0){unset($cart[$id]);continue;}
   if($quantity>$product->stock)throw ValidationException::withMessages(['quantities'=>'Not enough stock for '.$product->name.'.']);
   $cart[$id]=(int)$quantity;
  }
  session(['cart'=>$cart]);return back()->with('success','Cart updated.');
 }
 public function remove(Product $product){$cart=session('cart',[]);unset($cart[$product->id]);session(['cart'=>$cart]);return back()->with('success','Item removed.');}
 public function applyCoupon(Request $request,CartService $cart){
  $data=$request->validate(['code'=>['required','string','max:50']]);
  $coupon=Coupon::where('code',strtoupper(trim($data['code'])))->first();
  if(!$coupon||!$coupon->usableFor($cart->summary()['subtotal']))return back()->withErrors(['code'=>'Coupon is invalid, expired, exhausted, or the minimum spend has not been met.']);
  session(['coupon_code'=>$coupon->code]);return back()->with('success','Promo code applied.');
 }
 public function removeCoupon(){session()->forget('coupon_code');return back()->with('success','Coupon removed.');}
}
