@extends('layouts.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            @DTGeneric($dtconfig)
            @slot('title')
                Employees List
            @endslot
            @endDTGeneric
        </div>
    </div>
@endsection