<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name','email','logo'];
    public static $datatableConfig = ["header" => ["Name","Email"], "columns" => ["name","email"], "routeToData" => 'get.data.companies',
        "form" => [
            "Name" => ["column" => "name", "type"=>"text"],
            "Email" => ["column" => "email", "type"=>"text"]
        ],
        "routeSuffix" => "companies"
    ];

}
