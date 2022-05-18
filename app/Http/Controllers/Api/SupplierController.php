<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class SupplierController extends Controller
{
   
    public function index()
    {
        $supplier = DB::table('suppliers')->get();
        return response()->json($supplier);
    }


    public function store(Request $request)
    {
         $validate = $request->validate([
         'name' => 'required|unique:suppliers|max:255',
         'email' => 'required',
         'phone' => 'required|unique:suppliers'
      ]);

      if ($request->photo) {
         $position = strpos($request->photo, ';');
         $sub = substr($request->photo, 0, $position);
         $exist = explode('/', $sub)[1];

         $name = time().".".$exist;
         $img = Image::make($request->photo)->resize(240, 200);
         $upload_path = 'backend/supplier/';
         $image_url = $upload_path.$name;
         $img->save($image_url);

         DB::table('suppliers')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'shopname' => $request->shopName,
            'photo' => $image_url,
         ]);
      } else {
         DB::table('suppliers')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'shopname' => $request->shopName,
         ]);
      }
    }

    
    public function show($id)
    {
        $supplier = DB::table('suppliers')->where('id', $id)->first();
        return response()->json($supplier);
    }

    
    public function update(Request $request, $id)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $data['shopname'] = $request->shopname;
        $data['phone'] = $request->phone;
        $image = $request->newPhoto;

      if ($image) {
         $position = strpos($image, ';');
         $sub = substr($image, 0, $position);
         $exist = explode('/', $sub)[1];

         $name = time().".".$exist;
         $img = Image::make($image)->resize(240, 200);
         $upload_path = 'backend/supplier/';
         $image_url = $upload_path.$name;
         $success = $img->save($image_url);

         if ($success) {
            $data['photo'] = $image_url;

            // Unlinking old image fm DB (start)
            $img = DB::table('suppliers')->where('id', $id)->first();
            $img_path = $img->photo;
            $done = unlink($img_path);
            // (finish)
            
            $user = DB::table('suppliers')->where('id', $id)->update($data);
         }
      } else {
         $oldphoto = $request->photo;
         $data['photo'] = $oldphoto;
         $user = DB::table('suppliers')->where('id', $id)->update($data);
      }
    }


    public function destroy($id)
    {
        $supplier = DB::table('suppliers')->where('id', $id)->first();
        $photo = $supplier->photo;
        if($photo) {
            unlink($photo);
            DB::table('suppliers')->where('id', $id)->delete();
        } else {
            DB::table('suppliers')->where('id', $id)->delete();
        }
    }
}
