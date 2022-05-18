<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoryController extends Controller
{
 
    public function index()
    {
        $category = DB::table('categories')->get();
        return response()->json($category); 
    }

    
    public function store(Request $request)
    {
        $validate = $request->validate([
            'category_name' => 'required|unique:categories|max:20'
        ]);

        DB::table('categories')->insert([
            'category_name' => $request->category_name,
            'created_at' => Carbon::now()
        ]);
    }

 
    public function show($id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        return response()->json($category);
    }


   
    public function update(Request $request, $id)
    {
        DB::table('categories')->where('id', $id)->update([
            'category_name' => $request->category_name
        ]);
    }

   
    public function destroy($id)
    {
        DB::table('categories')->where('id', $id)->delete();
    }
}
