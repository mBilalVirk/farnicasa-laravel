<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{User,Review,Setting,ContactMessage,NewsletterSubscriber};
use Illuminate\Http\Request;
class ManagementController extends Controller {
 public function customers(Request $request){return view('admin.customers.index',['customers'=>User::where('role','customer')->when($request->filled('q'),fn($q)=>$q->where(fn($w)=>$w->where('name','like','%'.$request->q.'%')->orWhere('email','like','%'.$request->q.'%')))->withCount('orders')->latest()->paginate(20)->withQueryString()]);}
 public function toggleCustomer(User $user){abort_if($user->role!=='customer',403);$user->update(['is_active'=>!$user->is_active]);return back()->with('success','Customer status updated.');}
 public function reviews(){return view('admin.reviews.index',['reviews'=>Review::with(['user','product'])->latest()->paginate(20)]);}
 public function approveReview(Review $review){$review->update(['is_approved'=>!$review->is_approved]);return back()->with('success','Review moderation updated.');}
 public function destroyReview(Review $review){$review->delete();return back()->with('success','Review removed.');}
 public function settings(){return view('admin.settings.index',['values'=>Setting::pluck('value','key')]);}
 public function updateSettings(Request $request){
  $data=$request->validate(['store_name'=>['required','string','max:100'],'support_email'=>['required','email','max:190'],'support_phone'=>['nullable','string','max:40'],
   'address'=>['nullable','string','max:200'],'announcement'=>['nullable','string','max:180'],'bank_instructions'=>['nullable','string','max:1200']]);
  foreach($data as $key=>$value)Setting::updateOrCreate(['key'=>$key],['value'=>$value??'']);
  return back()->with('success','Store settings saved.');
 }
 public function contacts(){return view('admin.contacts.index',['contacts'=>ContactMessage::latest()->paginate(20)]);}
 public function readContact(ContactMessage $message){$message->update(['is_read'=>true]);return back()->with('success','Message marked as read.');}
 public function newsletters(){return view('admin.newsletters',['subscribers'=>NewsletterSubscriber::latest()->paginate(25)]);}
}
