<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['firstName','lastName','email','phone','company_id'];

    public static $datatableConfig = ["header" => ["First Name","Last Name","Email","Phone","Company"],
        "columns" => ["firstName","lastName","email","phone","companyName"], "routeToData" => 'get.data.employees',
        "form" => [
            "First Name" => ["column" => "firstName", "type"=>"text"],
            "Last Name" => ["column" => "lastName", "type"=>"text"],
            "Email" => ["column" => "email", "type"=>"text"],
            "Phone" => ["column" => "phone", "type"=>"text"],
            "Company" => ["column" => "company_id", "type"=>"select", "table" => "companies", "label" => "name", "routeSuffix"=>"companies"],
        ],
        "routeSuffix" => "employees",
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
