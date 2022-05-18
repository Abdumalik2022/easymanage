<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SalaryController extends Controller
{
    public function Paid(Request $request, $id) {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'salary' => 'required',
            'salary_month' => 'required'
        ]);

        DB::table('salaries')->where('id', $id)->insert([
            'employee_id' => $id,
            'amount' => $request->salary,
            'salary_date' => date('d/m/Y'),
            'salary_month' => $request->salary_month,
            'salary_year' => date('Y')
        ]);
    }


    public function AllSalary() {
        $salaries = DB::table('salaries')->select('salary_month')->groupBy('salary_month')
            ->get();
        return response()->json($salaries);
    }


    public function ViewSalary($id) {
        $view = DB::table('salaries')
                ->join('employees', 'salaries.employee_id', 'employees.id')
                ->select('salaries.*', 'employees.name')
                ->where('salaries.salary_month', $id)
                ->get();
        
        return response()->json($view);
    }


    public function EditSalary($id) {
        $view = DB::table('salaries')
                ->join('employees', 'salaries.employee_id', 'employees.id')
                ->select('salaries.*', 'employees.name', 'employees.email')
                ->where('salaries.id', $id)
                ->first();
        
        return response()->json($view);
    }


    public function UpdateSalary(Request $request, $id) {
        DB::table('salaries')->where('id', $id)->update([
            'amount' => $request->amount,
            'salary_month' => $request->salary_month,
        ]);
    }
}
