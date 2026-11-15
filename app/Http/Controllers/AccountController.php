<?php
namespace App\Http\Controllers;
use App\Models\Order;use Illuminate\Http\Request;use Illuminate\View\View;
class AccountController {public function orders(Request $r):View{return view('account.orders',['orders'=>Order::where('user_id',$r->user()->id)->with('items')->latest()->paginate(10)]);}}
