<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id=auth()->id();   
        $sales = Sale::with('user')->join('users', 'sales.user_id', '=', 'users.id')
        ->where('users.parent_id', $user_id)
        ->selectRaw('sales.user_id, SUM(sales.amount) AS amount, users.name')
        ->groupBy('sales.user_id')
        ->get();
    
        $totalcommision=0;
        foreach($sales as &$sale)
         {
            $commissionRate = 0;
            $amount=$sale->amount;
            if ($amount < 1000) {
                $commissionRate = 0.05; // 5%
            } elseif ($amount >= 1000 && $amount <= 5000) {
                $commissionRate = 0.075;
                // 7.5%
            } else {
                $commissionRate = 0.10;
                // 10%
            }
            (float) $commission = (float) $amount * (float) $commissionRate;   
            $sale->commission = $commission;
            $totalcommision += $commission; // Calculate total commission

        }
        // dd($sales);
        return view('sales.index',compact('sales'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sales/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
