<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CartController extends Controller
{
    public function AddToCart(Request $request, $id) {
        
        $product = DB::table('products')->where('id', $id)->first();
        $check = DB::table('pos')->where('pro_id', $id)->first();

        if ($check) {
            DB::table('pos')->where('pro_id', $id)->increment('pro_quantity');
            $product = DB::table('pos')->where('pro_id', $id)->first();
            $subtotal = $product->pro_quantity * $product->pro_price;
            DB::table('pos')->where('pro_id', $id)->update(['sub_total' => $subtotal]);
        } else {
            DB::table('pos')->insert([
                'pro_id' => $product->id,
                'pro_name' => $product->product_name,
                'pro_quantity' => 1,
                'pro_price' => $product->selling_price,
                'sub_total' => $product->selling_price,
                'created_at' => Carbon::now()
            ]);
        }
    }

    public function getCart() {
        $carts = DB::table('pos')->get();
        return response()->json($carts);
    }

    public function deleteCart($id) {
        DB::table('pos')->where('id', $id)->delete();
        return response()->json('Done');
    }

    public function increment($id) {
        DB::table('pos')->where('id', $id)->increment('pro_quantity');

        $product = DB::table('pos')->where('id', $id)->first();
        $subtotal = $product->pro_quantity * $product->pro_price;
        DB::table('pos')->where('id', $id)->update(['sub_total' => $subtotal]);
        return response('Done');
    }

    public function decrement($id) {
        DB::table('pos')->where('id', $id)->decrement('pro_quantity');

        $product = DB::table('pos')->where('id', $id)->first();
        $subtotal = $product->pro_quantity * $product->pro_price;
        DB::table('pos')->where('id', $id)->update(['sub_total' => $subtotal]);
        return response('Done');
    }

    public function vat() {
        $vats = DB::table('extra')->first();
        return response()->json($vats);
    }

}
