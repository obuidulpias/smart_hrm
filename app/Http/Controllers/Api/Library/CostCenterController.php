<?php

namespace App\Http\Controllers\Api\Library;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth, Hash;

class CostCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function companyList()
    {
        //dd(Company::getAll());
        if(Auth::guard('api')->check()){
            $companies=Company::getAll();
            if(!empty($companies)){
                return response([ 'status' => 'success', 'data' => $companies,],200);
            }
            return response([ 'status' => 'failed', 'message' => 'No data found.'],200);
        }else{
            return response(['status' => 'failed', 'message' => 'Unauthorized'],401);
        }
        
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function companyInsert(Request $request)
    {
        //dd($request->name);
        if(empty(Company::getName($request->name)->name)){
            $company =  new Company();
            $company->name = $request->name;
            $company->save();
            return response([ 'status' => 'success', 'message' => 'Company created successfully.'],200);
        }
        return response([ 'status' => 'failed', 'message' => 'Duplicate name found.'],409);
        //dd($duplicate_company);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}
