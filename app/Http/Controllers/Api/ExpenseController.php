<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = DB::table('expenses')->get();
        return response()->json($expenses);
    }


    public function store(Request $request)
    {
        $validate = $request->validate([
            'details' => 'required',
            'amount' => 'required',
        ]);

        DB::table('expenses')->insert([
            'details' =>  $request->details,
            'amount' => $request->amount,
            'expense_date' => date('d/m/Y')
        ]);
    }

 
    public function show($id)
    {
        $expenses = DB::table('expenses')->where('id', $id)->first();
        return response()->json($expenses);
    }


    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'details' => 'required',
            'amount' => 'required',
        ]);

        DB::table('expenses')->where('id', $id)->update([
            'details' =>  $request->details,
            'amount' => $request->amount,
            'expense_date' => date('d/m/Y')
        ]);
    }

  
    public function destroy($id)
    {
        DB::table('expenses')->where('id', $id)->delete();
    }
}
