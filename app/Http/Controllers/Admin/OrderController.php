<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Order,Product,InventoryMovement};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class OrderController extends Controller {
 public function index(Request $request){
  $orders=Order::with('user')->when($request->filled('status'),fn($q)=>$q->where('status',$request->status))
   ->when($request->filled('q'),fn($q)=>$q->where(fn($w)=>$w->where('order_number','like','%'.$request->q.'%')->orWhere('email','like','%'.$request->q.'%')))
   ->latest()->paginate(15)->withQueryString();return view('admin.orders.index',compact('orders'));
 }
 public function show(Order $order){return view('admin.orders.show',['order'=>$order->load(['items','user'])]);}
 public function update(Request $request,Order $order){
  $data=$request->validate(['status'=>['required','in:pending,processing,shipped,delivered,cancelled'],'payment_status'=>['required','in:unpaid,paid']]);
  DB::transaction(function()use($order,$data){
   $o=Order::whereKey($order->id)->lockForUpdate()->firstOrFail();
   $transitions=['pending'=>['pending','processing','cancelled'],'processing'=>['processing','shipped','cancelled'],'shipped'=>['shipped','delivered'],'delivered'=>['delivered'],'cancelled'=>['cancelled']];
   if(!in_array($data['status'],$transitions[$o->status]??[],true))throw ValidationException::withMessages(['status'=>'Invalid status transition from '.$o->status.'.']);
   if($data['status']==='cancelled' && $data['payment_status']==='paid')throw ValidationException::withMessages(['payment_status'=>'Mark refunded/cancelled payments externally and set unpaid before cancelling.']);
   if($data['status']==='cancelled'&&$o->status!=='cancelled'){
    foreach($o->items as $item){
     if(!$item->product_id)continue;
     $p=Product::whereKey($item->product_id)->lockForUpdate()->first();
     if(!$p)continue;
     $p->increment('stock',$item->quantity);
     InventoryMovement::create(['product_id'=>$p->id,'user_id'=>auth()->id(),'order_id'=>$o->id,'change'=>$item->quantity,'stock_after'=>$p->fresh()->stock,'reason'=>'order_cancellation']);
    }
   }
   $update=['status'=>$data['status'],'payment_status'=>$data['payment_status']];
   if($data['status']==='shipped'&&!$o->shipped_at)$update['shipped_at']=now();
   if($data['status']==='delivered'&&!$o->delivered_at)$update['delivered_at']=now();
   $o->update($update);
  },3);
  return back()->with('success','Order updated.');
 }
}
