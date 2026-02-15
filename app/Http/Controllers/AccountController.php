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
}
