<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function commissions()
    {
        return view('finances.commissions');
    }

    public function paiements()
    {
        return view('finances.paiements');
    }
}
