<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('index')}}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('registerIndex')}}">Register</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Dropdown
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
{{--                    <a class="dropdown-item" href="{{route('logout')}}">Log out</a>--}}

                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{route('logout')}}" tabindex="-1" aria-disabled="true">Logout</a>
            </li>

        </ul>
        @if(Auth::user())
            <span style="float: right ">

        <a style="color: #00FF00;float: right;font-style: normal" class="nav-link disabled" href="#" tabindex="-1"
           aria-disabled="true">{{Auth::user()->name}}</a>

        </span>
        @endif
        {{--<form class="form-inline my-2 my-lg-0">--}}
        {{--<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">--}}
        {{--<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>--}}
        {{--</form>--}}
    </div>
</nav>
