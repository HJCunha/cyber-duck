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

    /* This variable is meant to be sent to the view. This allow us to have a dynamic datatable file,
        expecting all the variables from the controllers
        header -> Name of the columns to display
        columns -> name of the columns on the database, this has to match the header columns
        routeToData -> name of the route where the datatable should get the data from
        form -> list of fields to present in Add and Edit function
        routeSuffix -> label to use after the common name for routes to insert and delete data
    */
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
