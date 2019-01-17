<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['firstName','lastName','email','phone','company_id'];

    /* This variable is meant to be sent to the view. This allow us to have a dynamic datatable file,
        expecting all the variables from the controllers
        header -> Name of the columns to display
        columns -> name of the columns on the database, this has to match the header columns
        routeToData -> name of the route where the datatable should get the data from
        form -> list of fields to present in Add and Edit function
        routeSuffix -> label to use after the common name for routes to insert and delete data
    */
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
