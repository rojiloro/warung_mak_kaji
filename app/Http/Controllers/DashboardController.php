<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        $todayTransactions = Transaction::whereDate(
            'created_at',
            today()
        )->count();

        $todayIncome = Transaction::whereDate(
            'created_at',
            today()
        )->sum('total');

        return view(
            'dashboard',
            compact(
                'totalProducts',
                'todayTransactions',
                'todayIncome'
            )
        );
    }
}