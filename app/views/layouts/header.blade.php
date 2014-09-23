<div class="navbar navbar-default" role="navigation">
    <div class="container-fluid">

        <!-- Main nav bar -->
        <div class="navbar-header">
            
            <!-- Button w/ dropdown replaces links if mobile -->
            <button type="button" class="navbar-toggle collapsed"
                data-toggle="collapse" data-target="#navbar-collapse-1">
                <!-- Invisible element for screen reader -->
                <span class="sr-only">Toggle navigation</span>
                <!-- build the button -->
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Site logo -->
            <a class="navbar-brand" href="/">
                <img src="/img/projectify-logo2.jpg"
                height="35" /></a>
        </div>

        <!-- Links and dropdowns -->
        <div class="collapse navbar-collapse" id="navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())

                <!-- User not logged in -->
                <li><a href="/login">Login</a></li>
                <li><a href="/register">Sign Up</a></li>

                @else

                <!-- Username dropdown -->
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    {{{ User::find(Auth::id())->display_name }}}
                    <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="/home">Home</a></li>
                    <li><a href="/editProfile">Edit Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="/logout">Sign Out</a></li>
                </ul>
                </li>

                @endif

            </ul>
        </div>

    </div>
</div>

<div class="container">
