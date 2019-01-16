<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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

    public function validateImage(Request $request)
    {
        $rules = [
            'logo'             => ['mimes:jpeg,jpg,gif,bmp,png', 'dimensions:min_width=100,min_height=100','max:1024']
        ];

        $messages = [
            'logo.mimes' => 'This file format is not accepted',
            'logo.dimensions' => 'Please upload a file greater than 100x100 and below 10Mb',
            'logo.max' => 'Please upload a file smaller than 10MB'

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // check if the validator failed -----------------------
        if ($validator->fails()) {
            return $this->_validatorReturn($validator);
        }

        return true;
    }

    protected function _validatorReturn($validator)
    {
        // get the error messages from the validator
        $messages = $validator->messages();
        $messages = json_decode($messages, true);

        $returnMessages = [];
        foreach ($messages as $id => $message) {
            if (is_array($message)) {
                $message = $message[0];
            }
            $returnMessages[] = ["id" => $id, "message" => $message];
        }

        // redirect our user back to the form with the errors from the validator
        return response()->json(["error" => true, "message" => $returnMessages], 200);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $company = Company::create($request->all());
        Log::debug('HERE');
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
        $valid = $this->validateImage($request);

        if ($valid !== true) {
            return $valid;
        }
        $company->update($request->all());
        if (isset($request['logo'])) {
            if ($company->hasMedia("logos")) {
                Log::debug('HERE2');
                $company->updateMedia([], "logos");
            }
            $added = $company->addMediaFromRequest('logo')->toMediaCollection('logos');
        }
        $company->logo = $added->getUrL();
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
