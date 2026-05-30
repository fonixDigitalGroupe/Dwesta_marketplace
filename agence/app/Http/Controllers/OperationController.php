<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperationController extends Controller
{
    public function stock()
    {
        return view('operations.stock');
    }

    public function litiges()
    {
        return view('operations.litiges');
    }

    public function journal()
    {
        return view('operations.journal');
    }

    public function statistiques()
    {
        return view('operations.stats');
    }
}
