<header class="page-header">
    <div class="navbar">
        <ul class="nav navbar-nav navbar-right pull-right">
            <li class="hidden-xs dropdown">
                <a href="#" title="Account" id="account"
                   class="dropdown-toggle"
                   data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i>
                </a>
                <ul id="account-menu" class="dropdown-menu account" role="menu">
                    <li role="presentation" class="account-picture">
                        <img src="{{ asset('img/1.png') }}" alt="">
                        {{ Auth::user()->name }}
                    </li>
                    <li role="presentation">
                        <a href="form_account.html" class="link">
                            <i class="fa fa-user"></i>
                            Profile
                        </a>
                    </li>
                </ul>
            </li>
            <li class="visible-xs">
                <a href="#"
                   class="btn-navbar"
                   data-toggle="collapse"
                   data-target=".sidebar"
                   title="">
                    <i class="fa fa-bars"></i>
                </a>
            </li>
            <li class="hidden-xs">
                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                    <i class="glyphicon glyphicon-off"></i>
                </a>
            </li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</header>