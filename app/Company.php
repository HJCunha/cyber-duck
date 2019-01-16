<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Company extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = ['name','email','logo','website'];
    public static $datatableConfig = ["header" => ["Name","Email","Website", "Logo"], "columns" => ["name","email","website","logo"], "routeToData" => 'get.data.companies',
        "form" => [
            "Name" => ["column" => "name", "type"=>"text"],
            "Email" => ["column" => "email", "type"=>"text"],
            "Website" => ["column" => "website", "type"=>"text"],
            "Logo" => ["column" => "logo", "type"=>"image"],
        ],
        "routeSuffix" => "companies"
    ];
}
