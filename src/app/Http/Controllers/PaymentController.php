<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(){
       $payments = auth()->user()->payments()->latest()->get();

       return view('payments.index', compact('payments'));
    }
}
