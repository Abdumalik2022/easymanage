<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function GetProduct($id) {
        $product = DB::table('products')
                    ->where('category_id', $id)
                    ->get();
        return response()->json($product);
    }

    public function OrderDone(Request $request) {
        $validateData = $request->validate([
            'payby' => 'required',
            'customer_id' => 'required'
        ]);

        $order_id = DB::table('orders')->insertGetId([
            'customer_id' => $request->customer_id,
            'qty' => $request->qty,
            'subtotal' => $request->subtotal,
            'pay' => $request->pay,
            'due' => $request->due,
            'payby' => $request->payby,
            'vat' => $request->vat,
            'total' => $request->total,
            'order_date' => date('d/m/Y'),
            'order_month' => date('F'),
            'order_year' => date('Y'),
        ]);

        $contents = DB::table('pos')->get();
        foreach ($contents as $content) {
            DB::table('order_details')->insert([
                'order_id' => $order_id,
                'product_id' => $content->pro_id,
                'pro_quantity' => $content->pro_quantity,
                'product_price' => $content->pro_price,
                'sub_total' => $content->sub_total,
            ]);

            DB::table('products')
                    ->where('id', $content->pro_id)
                    ->update(['product_quantity' => DB::raw('product_quantity - ' . $content->pro_quantity)]);
        }

        DB::table('pos')->delete();
    }

    public function todaySell() {
        $date = date('d/m/Y');
        $todaySell = DB::table('orders')->where('order_date', $date)->sum('total');
        return response()->json($todaySell);
    }

    public function TodayIncome() {
        $date = date('d/m/Y');
        $todayPay = DB::table('orders')->where('order_date', $date)->sum('pay');
        return response()->json($todayPay);
    }

    public function TodayDue() {
        $date = date('d/m/Y');
        $todayDue = DB::table('orders')->where('order_date', $date)->sum('due');
        return response()->json($todayDue);
    }

    public function TodayExpense() {
        $date = date('d/m/Y');
        $todayExpense = DB::table('expenses')->where('expense_date', $date)->sum('amount');
        return response()->json($todayExpense);
    }

    public function OffStock() {
        $offStock = DB::table('products')->where('product_quantity', '<', '1')->get();
        return response()->json($offStock);
    }








} 
