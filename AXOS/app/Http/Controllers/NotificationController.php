<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class NotificationController extends Controller {
 public function index(Request $r){$notifications=$r->user()->notifications()->latest()->paginate(20);return view('notifications.index',compact('notifications'));}
 public function unread(Request $r){return response()->json(['count'=>$r->user()->unreadNotifications()->count()]);}
 public function read(Request $r,string $id){$n=$r->user()->notifications()->where('id',$id)->firstOrFail();$n->markAsRead();return back();}
 public function all(Request $r){$r->user()->unreadNotifications->markAsRead();return back();}
}