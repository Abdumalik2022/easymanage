<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class CustomerController extends Controller
{
   public function index()
   {
      $customers = DB::table('customers')->get();
      return response()->json($customers);
   }


   public function store(Request $request)
   {
      $validate = $request->validate([
         'name' => 'required|max:255',
         'email' => 'required',
         'phone' => 'required',
         'address' => 'required',
      ]);

      if ($request->photo) {
         $position = strpos($request->photo, ';');
         $sub = substr($request->photo, 0, $position);
         $exist = explode('/', $sub)[1];

         $name = time().".".$exist;
         $img = Image::make($request->photo)->resize(240, 200);
         $upload_path = 'backend/customer/';
         $image_url = $upload_path.$name;
         $img->save($image_url);

         DB::table('customers')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'photo' => $image_url,
            'created_at' => Carbon::now()
         ]);
      } else {
         DB::table('customers')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'photo' => $image_url,
            'created_at' => Carbon::now()
         ]);
      }
   }


   public function show($id)
   {
      $customer = DB::table('customers')->where('id', $id)->first();
      return response()->json($customer);
   }


   public function update(Request $request, $id)
   {
      $data = array();
      $data['name'] = $request->name;
      $data['email'] = $request->email;
      $data['address'] = $request->address;
      $data['phone'] = $request->phone;
      $image = $request->newPhoto;

      if ($image) {
         $position = strpos($image, ';');
         $sub = substr($image, 0, $position);
         $exist = explode('/', $sub)[1];

         $name = time().".".$exist;
         $img = Image::make($image)->resize(240, 200);
         $upload_path = 'backend/customer/';
         $image_url = $upload_path.$name;
         $success = $img->save($image_url);

         if ($success) {
            $data['photo'] = $image_url;

            // Unlinking old image fm DB (start)
            $img = DB::table('customers')->where('id', $id)->first();
            $img_path = $img->photo;
            $done = unlink($img_path);
            // (finish)
            
            $user = DB::table('customers')->where('id', $id)->update($data);
         }
      } else {
         $oldphoto = $request->photo;
         $data['photo'] = $oldphoto;
         $user = DB::table('customers')->where('id', $id)->update($data);
      }
   }


   public function destroy($id)
   {
      $customer = DB::table('customers')->where('id', $id)->first();
      $photo = $customer->photo;
      if($photo) {
         unlink($photo);
         DB::table('customers')->where('id', $id)->delete();
      } else {
         DB::table('customers')->where('id', $id)->delete();
      }
   }
}
