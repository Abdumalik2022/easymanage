<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class EmployeeController extends Controller
{
   public function index()
   {
      $employee = DB::table('employees')->get();
      return response()->json($employee);
   }


   public function store(Request $request)
   {
      $validate = $request->validate([
         'name' => 'required|unique:employees|max:255',
         'email' => 'required',
         'phone' => 'required|unique:employees',
         
      ]);

      if ($request->photo) {
         $position = strpos($request->photo, ';');
         $sub = substr($request->photo, 0, $position);
         $exist = explode('/', $sub)[1];

         $name = time().".".$exist;
         $img = Image::make($request->photo)->resize(240, 200);
         $upload_path = 'backend/employee/';
         $image_url = $upload_path.$name;
         $img->save($image_url);

         DB::table('employees')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'joining_date' => $request->joining_date,
            'phone' => $request->phone,
            'salary' => $request->salary,
            'nid' => $request->nid,
            'photo' => $image_url,
            'created_at' => Carbon::now()
         ]);
      } else {
         DB::table('employees')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'joining_date' => $request->joining_date,
            'phone' => $request->phone,
            'salary' => $request->salary,
            'nid' => $request->nid,
         ]);
      }
   }


   public function show($id)
   {
      $employee = DB::table('employees')->where('id', $id)->first();
      return response()->json($employee);
   }


   public function update(Request $request, $id)
   {
      $data = array();
      $data['name'] = $request->name;
      $data['email'] = $request->email;
      $data['address'] = $request->address;
      $data['joining_date'] = $request->joining_date;
      $data['phone'] = $request->phone;
      $data['salary'] = $request->salary;
      $data['nid'] = $request->nid;
      $image = $request->newPhoto;

      if ($image) {
         $position = strpos($image, ';');
         $sub = substr($image, 0, $position);
         $exist = explode('/', $sub)[1];

         $name = time().".".$exist;
         $img = Image::make($image)->resize(240, 200);
         $upload_path = 'backend/employee/';
         $image_url = $upload_path.$name;
         $success = $img->save($image_url);

         if ($success) {
            $data['photo'] = $image_url;

            // Unlinking old image fm DB (start)
            $img = DB::table('employees')->where('id', $id)->first();
            $img_path = $img->photo;
            $done = unlink($img_path);
            // (finish)
            
            $user = DB::table('employees')->where('id', $id)->update($data);
         }
      } else {
         $oldphoto = $request->photo;
         $data['photo'] = $oldphoto;
         $user = DB::table('employees')->where('id', $id)->update($data);
      }
   }


   public function destroy($id)
   {
      $employee = DB::table('employees')->where('id', $id)->first();
      $photo = $employee->photo;
      if($photo) {
         unlink($photo);
         DB::table('employees')->where('id', $id)->delete();
      } else {
         DB::table('employees')->where('id', $id)->delete();
      }
   }
}
