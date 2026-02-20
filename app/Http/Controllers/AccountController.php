<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display the account dashboard.
     */
    public function index()
    {
        return view('account.dashboard', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Display user's order history.
     */
    public function orders()
    {
        $user = Auth::user();
        $orders = $user->orders()->with(['items.annonce', 'seller.user'])->latest()->paginate(10);
        
        return view('account.orders', compact('orders'));
    }
}
