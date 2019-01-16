<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="/home" class="logo">
        <img src="{{asset('images/cd.png')}}" height="45" width="auto" alt="Cyber-Duck">
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @component("components.notifications")
                @endcomponent
                @component("components.user-menu")
                @endcomponent

                @isset($showGearsMenu)
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                @endisset
            </ul>
        </div>
    </nav>
</header>