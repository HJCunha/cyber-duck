<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('images/default-avatar.png')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Users</li>
            <li id="menu-companies"><a href="/companies"><i class="fa fa-suitcase"></i> <span>Companies</span></a></li>
            <li id="menu-employees"><a href="/employees"><i class="fa fa-users"></i> <span>Employees</span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

<script>
    $(document).ready(function(){
        $("li").removeClass("active");
        $("#menu-" + "{{$current_route_name}}").addClass("active");
    });
</script>