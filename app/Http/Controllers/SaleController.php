<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id=auth()->id();   
        $sales = Sale::join('users', 'sales.user_id', '=', 'users.id')
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
    public function indexApi(){
        $user_id=auth()->id();   
        $sales = Sale::join('users', 'sales.user_id', '=', 'users.id')
        // ->where('users.parent_id', $user_id)
        ->selectRaw('sales.user_id, amount, users.name, sales.id')
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
        $data =[
            'sales'=>$sales,
            'totalcommision'=>$totalcommision,
        ];
        return response()->json($data);
    }
    public function showAll(){
        $user_id=auth()->id();   
        $sales = Sale::join('users', 'sales.user_id', '=', 'users.id')
        ->where('users.parent_id', $user_id)
        ->selectRaw('sales.user_id, amount, users.name, sales.id')
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
        $user=User::where('parent_id',auth()->id())->get();
        return view('sales/create',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'user_id' => 'required|integer',
            'amount' => 'required|integer',
        ]);
        $sales = new Sale;
        $sales->user_id=$request->input('user_id');
        $sales->amount=$request->input('amount');
        $sales->save();
        $notification =array(
            'alert-type'=>'success',
           'message'=>'Sale Added Successfully',
        );
        return redirect()->route('sales.index')->with($notification);
        
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
    public function destroy(string $id)
    {
        $sales=Sale::findOrFail($id);
        $sales->delete();
        $notification= array(
            'alert-type'=>'success',
           'message'=>'Sale Deleted Successfully',
        );
        return redirect()->route('sales.all')->with($notification);
    }
}
