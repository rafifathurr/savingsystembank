<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <img src="{{asset('images/bank_logo.png')}}" class="sidebar-brand-text mx-3 images_logo">
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if(str_contains($title, 'Home')) active @endif">
        <a class="nav-link" href="{{ route('home.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Home</span></a>
    </li>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if(str_contains($title, 'History')) active @endif">
        <a class="nav-link" href="{{route('transactions.report.index')}}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>History</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item @if(str_contains($title, 'Transaction')) active @endif">
        <a class="nav-link" href="{{route('transactions.index')}}">
            <i class="fas fa-fw fa-exchange-alt"></i>
            <span>Transactions</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
