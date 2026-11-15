<?php
namespace App\Http\Controllers;
use App\Models\User;use Illuminate\Http\Request;use Illuminate\Http\RedirectResponse;use Illuminate\Support\Facades\Auth;use Illuminate\View\View;
class AuthController {
 public function registerForm():View{return view('auth.register');} public function loginForm():View{return view('auth.login');}
 public function register(Request $r):RedirectResponse{$d=$r->validate(['name'=>'required|string|max:120','email'=>'required|email|max:190|unique:users','password'=>'required|string|min:10|confirmed']);$u=User::create($d);Auth::login($u);$r->session()->regenerate();return redirect()->intended(route('store.index'));}
 public function login(Request $r):RedirectResponse{$d=$r->validate(['email'=>'required|email','password'=>'required|string']);if(!Auth::attempt($d,$r->boolean('remember')))return back()->withErrors(['email'=>'Invalid email or password'])->onlyInput('email');$r->session()->regenerate();return redirect()->intended(route('store.index'));}
 public function logout(Request $r):RedirectResponse{Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();return redirect()->route('store.index');}
}
