<div class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
       
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
               height="30" width="120" /></a>
        </div>

        <!-- Links and dropdowns -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                <li><a href="/login">Login</a></li>
                @else
                <p class="navbar-text">Signed in as (put display name here)</p>
                @endif

                <!--
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                </ul> -->
                </li>
            </ul>
        </div>

    </div>
</div>
