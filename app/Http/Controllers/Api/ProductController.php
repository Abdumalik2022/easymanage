<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index()
    {
        $products = DB::table('products')
                    ->join('categories', 'products.category_id', 'categories.id')
                    ->join('suppliers', 'products.supplier_id', 'suppliers.id')
                    ->select('categories.category_name', 'suppliers.name', 'products.*')
                    ->orderBy('products.id', 'DESC')
                    ->get();
                    return response()->json($products);
    }


    public function store(Request $request)
    {
        $validate = $request->validate([
            'product_name' => 'required|max:255',
            'product_code' => 'required|max:255',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'buying_price' => 'required',
            'selling_price' => 'required',
            'product_quantity' => 'required',
            'buying_date' => 'required',
        ]);

        if ($request->image) {
         $position = strpos($request->image, ';');
         $sub = substr($request->image, 0, $position);
         $exist = explode('/', $sub)[1];

         $name = time().".".$exist;
         $img = Image::make($request->image)->resize(240, 200);
         $upload_path = 'backend/product/';
         $image_url = $upload_path.$name;
         $img->save($image_url);

         DB::table('products')->insert([
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'product_code' => $request->product_code,
            'root' => $request->root,
            'buying_price' => $request->buying_price,
            'selling_price' => $request->selling_price,
            'supplier_id' => $request->supplier_id,
            'buying_date' => $request->buying_date,
            'product_quantity' => $request->product_quantity,
            'image' => $image_url,
         ]);
      } else {
         DB::table('products')->insert([
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'product_code' => $request->product_code,
            'root' => $request->root,
            'buying_price' => $request->buying_price,
            'selling_price' => $request->selling_price,
            'supplier_id' => $request->supplier_id,
            'buying_date' => $request->buying_date,
            'product_quantity' => $request->product_quantity,
         ]);
      }
    }


    public function show($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        return response()->json($product);
    }


    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'product_name' => 'required|max:255',
            'product_code' => 'required|max:255',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'buying_price' => 'required',
            'selling_price' => 'required',
            'product_quantity' => 'required',
            'buying_date' => 'required',
        ]);

        $data = array();
        $data['category_id'] = $request->category_id;
        $data['product_name'] = $request->product_name;
        $data['product_code'] = $request->product_code;
        $data['root'] = $request->root;
        $data['buying_price'] = $request->buying_price;
        $data['selling_price'] = $request->selling_price;
        $data['supplier_id'] = $request->supplier_id;
        $data['buying_date'] = $request->buying_date;
        $data['product_quantity'] = $request->product_quantity;
        $image = $request->newImage;

      if ($image) {
         $position = strpos($image, ';');
         $sub = substr($image, 0, $position);
         $exist = explode('/', $sub)[1];

         $name = time().".".$exist;
         $img = Image::make($image)->resize(240, 200);
         $upload_path = 'backend/product/';
         $image_url = $upload_path.$name;
         $success = $img->save($image_url);

         if ($success) {
            $data['image'] = $image_url;

            // Unlinking old image fm DB (start)
            $img = DB::table('products')->where('id', $id)->first();
            $img_path = $img->image;
            $done = unlink($img_path);
            // (finish)
            
            $user = DB::table('products')->where('id', $id)->update($data);
         }
      } else {
         $oldphoto = $request->image;
         $data['image'] = $oldphoto;
         $user = DB::table('products')->where('id', $id)->update($data);
      }
    }

    
    public function destroy($id)
    {
        $products = DB::table('products')->where('id', $id)->first();
        $photo = $products->image;
        if($photo) {
            unlink($photo);
            DB::table('products')->where('id', $id)->delete();
        } else {
            DB::table('products')->where('id', $id)->delete();
        }
    }
}
