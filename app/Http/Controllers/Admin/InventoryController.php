<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Product,InventoryMovement};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class InventoryController extends Controller {
 public function index(Request $request){
  $products=Product::with('category')->when($request->filled('q'),fn($q)=>$q->where(fn($w)=>$w->where('name','like','%'.$request->q.'%')->orWhere('sku','like','%'.$request->q.'%')))->orderBy('stock')->paginate(15)->withQueryString();
  $movements=InventoryMovement::with(['product','user','order'])->latest()->take(20)->get();
  return view('admin.inventory.index',compact('products','movements'));
 }
 public function adjust(Request $request,Product $product){
  $data=$request->validate(['change'=>['required','integer','min:-100000','max:100000','not_in:0'],'reason'=>['required','in:restock,damage,correction,return'],'notes'=>['nullable','string','max:500']]);
  DB::transaction(function()use($data,$product){
   $p=Product::whereKey($product->id)->lockForUpdate()->firstOrFail();$after=$p->stock+(int)$data['change'];
   if($after<0)throw ValidationException::withMessages(['change'=>'Adjustment exceeds available stock.']);
   if($after>1000000)throw ValidationException::withMessages(['change'=>'Stock ceiling exceeded.']);
   $p->update(['stock'=>$after]);
   InventoryMovement::create(['product_id'=>$p->id,'user_id'=>auth()->id(),'change'=>$data['change'],'stock_after'=>$after,'reason'=>$data['reason'],'notes'=>$data['notes']??null]);
  },3);
  return back()->with('success','Stock adjusted and logged.');
 }
}
