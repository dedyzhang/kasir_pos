<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use App\Models\Tables;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index() {
        $categories = Categories::with('products')->orderBy('sort','asc')->get();
        $products = Products::orderBy('created_at','asc')->get();
        $transactions = Transactions::with('table')->whereIn('status',['active','process','payment'])->orderBy('created_at','DESC')->get();
        $tables = Tables::orderBy('sort','asc')->get();
        return view('auth.home',compact('categories','products','transactions','tables'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);


        $credentials = $request->only('username', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with('error','Invalid username or password.')->withInput();
    }
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return response()->json(['success' => true, 'message' => 'Logged out successfully']);
    }
}
