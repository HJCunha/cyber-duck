<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name','email','logo','website'];
    public static $datatableConfig = ["header" => ["Name","Email","Website"], "columns" => ["name","email","website"], "routeToData" => 'get.data.companies',
        "form" => [
            "Name" => ["column" => "name", "type"=>"text"],
            "Email" => ["column" => "email", "type"=>"text"],
            "Website" => ["column" => "website", "type"=>"text"],
        ],
        "routeSuffix" => "companies"
    ];
}
