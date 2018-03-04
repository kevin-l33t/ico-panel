<nav id="sidebar" class="sidebar nav-collapse collapse">
    <ul id="side-nav" class="side-nav">
        <li>
            <a href="{{ route('users.dashboard') }}"><i class="fa fa-home"></i> <span class="name">Dashboard</span></a>
        </li>
        <li class="panel">
            <a class="accordion-toggle collapsed" data-toggle="collapse"
               data-parent="#side-nav" href="#ico-collapse"><i class="fa fa-area-chart"></i> <span class="name">ICO</span></a>
            <ul id="ico-collapse" class="panel-collapse collapse ">
                <li class=""><a href="{{ route('tokens.index') }}">List</a></li>
                <li class=""><a href="{{ route('tokens.create') }}">Issue New</a></li>
            </ul>
        </li>
        <li class="panel">
            <a class="accordion-toggle collapsed" data-toggle="collapse"
               data-parent="#side-nav" href="#users-collapse"><i class="fa fa-users"></i> <span class="name">Users</span></a>
            <ul id="users-collapse" class="panel-collapse collapse ">
                <li class=""><a href="{{ route('users.create') }}">New Artist</a></li>
                <li class=""><a href="{{ route('users.index') }}">List</a></li>
            </ul>
        </li>
    </ul>
</nav> 