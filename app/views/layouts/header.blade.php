<div class="navbar navbar-inverse" role="navigation">
    <div class="container">

        <!-- Group Brand and toggle for mobile -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed"
                data-toggle="collapse" data-target="#bs-example-nabar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <img src="/img/projectify.jpg"
                height="35" /></a>
        </div>

        <!-- Links and dropdowns -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())

                <li><a href="/login">Login</a></li>
                <li><a href="/register">Sign Up</a></li>

                @else

                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    {{{ User::find(Auth::id())->display_name }}}
                    <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
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
