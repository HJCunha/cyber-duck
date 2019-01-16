<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
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
        return view("pages/companies/index", ["dtconfig" => Company::$datatableConfig]);
    }

    public function show(Company $company)
    {
        return $company;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $company = Company::create($request->all());
        return response()->json($company, 201);
    }

    public function update(Request $request, Company $company)
    {
        $company->update($request->all());

        return response()->json($company, 200);
    }

    /**
     * @param Request $request
     * @param Company $company
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(Request $request, Company $company)
    {
        $company->delete();

        return response()->json(null, 204);
    }

    public function deleteRow(Request $request)
    {
        if ($request->has('id')) {
            $company = Company::find($request->id);
            $company->delete();
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
        return Datatables::of(Company::query())->make(true);
    }
}
