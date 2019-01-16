@extends('layouts.app')
@section('body_content')
    <div class="wrapper">

    @component("components.top-bar")
    @endcomponent

    @component("components.left-menu")
    @endcomponent

    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    {{ucfirst($current_route_name)}}
                    @isset($page_description)
                        <small>{{$page_description}}</small>
                    @endisset
                </h1>
                <!--<ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                    <li class="active">Here</li>
                </ol>-->
            </section>

            <!-- Main content -->
            <section class="content container-fluid">
                <main class="py-4">
                    @yield('content')
                </main>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
                created by <a href="https://github.com/HJCunha" target="_blank">Hugo Cunha</a>
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; {{date("Y")}} <a href="https://www.cyber-duck.co.uk">Cyber-Duck</a>.</strong> All rights reserved.
        </footer>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


@endsection