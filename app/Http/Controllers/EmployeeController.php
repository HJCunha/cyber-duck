<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function index()
    {
        return view("pages/employees/index", ["dtconfig" => Employee::$datatableConfig]);
    }

    public function show(Employee $employee)
    {
        return $employee;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $employee = Employee::create($request->all());
        return response()->json($employee, 201);
    }

    public function update(Request $request, Employee $employee)
    {
        $employee->update($request->all());

        return response()->json($employee, 200);
    }

    /**
     * @param Request $request
     * @param Employee $employee
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(Request $request, Employee $employee)
    {
        $employee->delete();

        return response()->json(null, 204);
    }

    public function deleteRow(Request $request)
    {
        if ($request->has('id')) {
            $employee = Employee::find($request->id);
            $employee->delete();
        }

        return response()->json("deleted", 200);
    }

    /**
     * Process ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getData()
    {
        //$employees = Employee::with('company')->select("firstName","lastName","email","phone","company_id");

        $employees = Employee::join('companies', 'companies.id', '=', 'employees.company_id')
        ->select('employees.*', 'companies.name as companyName');

        /*$employees = Employee::query();
        foreach ($employees as $employee) {
            if($employee->company->count() > 0) {
                $employee->company_id = $employee->company->name;

            }
        }*/

        return Datatables::of($employees)->make(true);
    }
}
