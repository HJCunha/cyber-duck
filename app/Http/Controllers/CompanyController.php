<?php

namespace App\Http\Controllers;

use App\Company;
use App\Helpers\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
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
        $valid = Common::validateForm($request);

        if ($valid !== true) {
            return $valid;
        }

        $company = Company::create($request->all());
        if (isset($request['logo'])) {
            $added = $company->addMediaFromRequest('logo')->toMediaCollection('logos');
        }
        if (!empty($added)) {
            $company->logo = $added->getUrL();
        }

        $company->save();
        return response()->json($request, 201);
    }

    public function update(Request $request, Company $company)
    {
        $valid = Common::validateForm($request);

        if ($valid !== true) {
            return $valid;
        }
        $company->update($request->all());
        if (isset($request['logo'])) {
            if ($company->hasMedia("logos")) {
                $company->updateMedia([], "logos");
            }
            $added = $company->addMediaFromRequest('logo')->toMediaCollection('logos');
            $company->logo = $added->getUrL();
        }
        $company->save();

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
