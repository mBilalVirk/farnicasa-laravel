<?php
namespace Tests\Feature;
use App\Models\{User,Product,Category,Order,InventoryMovement,Coupon};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class StoreFlowsTest extends TestCase {
 use RefreshDatabase;
 private function customer(string $email='customer@example.test'):User{
  return User::create(['name'=>'Example Customer','email'=>$email,'password'=>'correct-horse-battery-staple','role'=>'customer','is_active'=>true]);
 }
 private function admin():User{return User::create(['name'=>'Store Admin','email'=>'admin@example.test','password'=>'correct-horse-battery-staple','role'=>'admin','is_active'=>true]);}
 private function product(int $stock=5):Product{
  $c=Category::firstOrCreate(['slug'=>'living-room'],['name'=>'Living Room','sort_order'=>1]);
  return Product::create(['category_id'=>$c->id,'name'=>'Luna Sofa','slug'=>'luna-sofa','sku'=>'SKU-SOFA-001','price'=>100,'stock'=>$stock,'is_active'=>true,'is_featured'=>true]);
 }
 public function test_public_storefront_is_accessible():void {
  $this->get('/')->assertOk();$this->get('/shop')->assertOk();
 }
 public function test_customer_cannot_open_admin():void {
  $this->actingAs($this->customer())->get('/admin')->assertForbidden();
 }
 public function test_add_to_cart_rejects_overselling():void {
  $p=$this->product(2);
  $this->post('/cart/add/'.$p->slug,['quantity'=>3])->assertSessionHasErrors('quantity');
  $this->post('/cart/add/'.$p->slug,['quantity'=>2])->assertSessionHas('cart.'.$p->id,2);
 }
 public function test_checkout_deducts_stock_and_creates_order():void {
  $p=$this->product(5);$u=$this->customer();
  $this->actingAs($u)->withSession(['cart'=>[$p->id=>2]])->post('/checkout',[
   'name'=>'Example Customer','email'=>$u->email,'phone'=>'1234567890','address'=>'123 High St','city'=>'Test City','postal_code'=>'01000','payment_method'=>'cod'
  ])->assertRedirect();
  $this->assertDatabaseHas('orders',['user_id'=>$u->id,'subtotal'=>200,'status'=>'pending','payment_status'=>'unpaid']);
  $this->assertSame(3,$p->fresh()->stock);
  $this->assertDatabaseHas('inventory_movements',['product_id'=>$p->id,'change'=>-2,'reason'=>'sale']);
 }
 public function test_cancel_restock_occurs_only_once():void {
  $p=$this->product(4);$u=$this->customer();$admin=$this->admin();
  $o=Order::create(['order_number'=>'FC-TEST-1','user_id'=>$u->id,'status'=>'pending','payment_method'=>'cod','payment_status'=>'unpaid','subtotal'=>100,'discount'=>0,'shipping'=>25,'tax'=>0,'total'=>125,'name'=>'Example Customer','email'=>$u->email,'phone'=>'123','address'=>'1 St','city'=>'Test City']);
  $o->items()->create(['product_id'=>$p->id,'product_name'=>$p->name,'sku'=>$p->sku,'unit_price'=>100,'quantity'=>1,'line_total'=>100]);
  $this->actingAs($admin)->patch('/admin/orders/'.$o->id,['status'=>'cancelled','payment_status'=>'unpaid'])->assertRedirect();
  $this->assertSame(5,$p->fresh()->stock);
  $this->actingAs($admin)->patch('/admin/orders/'.$o->id,['status'=>'cancelled','payment_status'=>'unpaid'])->assertRedirect();
  $this->assertSame(5,$p->fresh()->stock);
  $this->assertEquals(1,InventoryMovement::where('order_id',$o->id)->where('reason','order_cancellation')->count());
 }
 public function test_cannot_access_another_customers_order():void {
  $owner=$this->customer();$other=$this->customer('other@example.test');
  $order=Order::create(['order_number'=>'FC-TEST-2','user_id'=>$owner->id,'status'=>'pending','payment_method'=>'cod','payment_status'=>'unpaid','subtotal'=>100,'discount'=>0,'shipping'=>0,'tax'=>0,'total'=>100,'name'=>'Owner','email'=>$owner->email,'phone'=>'123','address'=>'1 St','city'=>'Test City']);
  $this->actingAs($other)->get('/account/orders/'.$order->id)->assertForbidden();
 }
 public function test_coupon_calculation_is_bounded_by_subtotal():void {
  $coupon=Coupon::create(['code'=>'EXAMPLE','type'=>'fixed','value'=>500,'min_order'=>0,'is_active'=>true]);
  $this->assertSame(100.0,$coupon->discount(100));
 }
}
