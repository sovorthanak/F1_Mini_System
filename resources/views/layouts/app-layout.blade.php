<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Fast One - Billing System' }}</title>
    
    <link rel="icon" type="image/png" href="/img/Fast_One_Logo_No_txt.png">
    
    <!-- Custom styles -->
    <link rel="stylesheet" href="/css/style.css">

    <!-- Font Awesome (Latest version only) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- DataTables (latest compatible with Buttons extension) -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons Extension for Excel Export -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>


<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <nav>
            <span>
                <div class="sidebar-header">
                    <a href="/">
                        Mini System
                    </a>
                    <!-- Add the X button here -->
                    <button id="sidebarToggle" class="sidebar-toggle">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </button>
                </div>
                
                <span class="top-links">
                    @role('admin')
                    <div class="top-links-menu top-links-menu-administration">
                        <a href="/administration/users"  class="{{ Request::segment(1) == 'administration' ? 'a-active' : '' }}">
                            <i class="fa-solid fa-user-tie"></i> Administration
                        </a>
                    </div>
                    @endrole

                    <a href="/home" class="top-links-menu {{ Request::segment(1) == 'home' ? 'a-active' : '' }}">
                        <i class="fa-solid fa-house"></i> Home
                    </a>

                    @role('admin|NOC|Accounting|TS Team Leader')
                    <div class="top-links-menu top-links-menu-customers">
                        <a href="{{ route('customers') }}" class="{{ Request::segment(1) == 'customers' ? 'a-active' : '' }}">
                            <i class="fa-solid fa-user"></i> Customers List
                        </a>
                    </div>
                    @endrole

                    {{-- @role('admin|TS Team Leader')
                    <div class="top-links-menu top-links-menu-customers">
                        <a href="{{ route('ts-customers') }}" class="{{ Request::segment(1) == 'ts-customers' ? 'a-active' : '' }}">
                            <i class="fa-solid fa-user"></i> TS - Customers List
                        </a>
                    </div>
                    @endrole --}}

                    @role('admin|NOC|Accounting')
                    <div class="top-links-menu" id="dropdownMenu">
                        <div class="dropdown">
                            <a class="dropbtn {{ Request::segment(1) == 'order' || Request::segment(1) == 'register' ? 'a-active' : '' }}">
                                <i class="fa-solid fa-right-to-bracket" style="margin-left:0px;"></i> Order
                            </a>
                            <div class="dropdown-content">
                                <a href="{{ route('register') }}"> Register</a>
                                <a href="{{ route('request-change') }}"> Customer Request</a>
                            </div>
                        </div>
                    </div>
                    @endrole

                    
                    {{-- <div class="top-links-menu">
                        <a href="{{ route('order') }}" class="{{ Request::segment(1) == 'order' ? 'a-active' : '' }}">
                            Order
                        </a>
                    
                    {{-- <div class="top-links-menu">
                        <a href="{{ route('register') }}" class="{{ Request::segment(1) == 'register' ? 'a-active' : '' }}">
                            Register
                        </a>
                    </div>
                    
                    <div class="top-links-menu">
                        <a href="{{ route('request-change') }}" class="{{ Request::segment(1) == 'request-change' ? 'a-active' : '' }}">
                            Customer Request
                        </a>
                    </div> --}}

                    @role('admin|NOC')
                    <div class="top-links-menu top-links-menu-accounting" id="dropdownMenu">
                        <div class="dropdown">
                            <a class="dropbtn {{ Request::segment(1) == 'noc' || Request::segment(1) == 'request-change' ? 'a-active' : '' }}">
                                <i class="fa-solid fa-gear"></i> NOC Team
                            </a>

                            <div class="dropdown-content">
                                <a href="{{ route('request-testing') }}">Request Testing</a>
                                <a href="{{ route('schedule.request') }}"">Schedule Request</a>
                                <a href="{{ route('schedule.new-register') }}"">Schedule New Register</a>

                            </div>

                        </div>
                    </div>
                    @endrole
                    
                    @role('Accounting')
                    <div class="top-links-menu top-links-menu-accounting" id="dropdownMenu">
                        <div class="dropdown">
                            <a class="dropbtn {{ Request::segment(1) == 'accounting' || Request::segment(1) == 'invoices' || Request::segment(1) == 'unpaid-invoices' ? 'a-active' : '' }}">
                                <i class="fa-solid fa-folder-open"></i> Accounting
                            </a>
                            <div class="dropdown-content">
                                <a href="{{ route('invoices') }}">Invoices</a>
                                <a href="/unpaid-invoices">Unpaid Invoices</a>
                                <a href="/accounting/upcoming-statement">Next Month Invoices</a>
                            </div>
                        </div>
                    </div>
                    @endrole
                    
                    {{-- <a href="/invoices" class="top-links-menu {{ Request::segment(1) == 'invoices' ? 'a-active' : '' }}" >
                        Invoice
                    </a>

                    <a href="/unpaid-invoices" class="top-links-menu {{ Request::segment(1) == 'unpaid-invoices' ? 'a-active' : '' }}">
                        Unpaid Invoices
                    </a> --}}

                    {{-- <div class="top-links-menu">
                        <a href="" class="{{ Request::segment(1) == 'ar-report' ? 'a-active' : '' }}">
                            AR Report
                        </a>
                    </div> --}}

                    {{-- <div class="top-links-menu">
                        <a href="" class="{{ Request::segment(1) == 'weekly-report' ? 'a-active' : '' }}">
                            Weekly Report
                        </a>
                    </div> --}}

                    {{-- <div class="top-links-menu">
                        <a href="" class="{{ Request::segment(1) == 'monthly-report' ? 'a-active' : '' }}">
                            Monthly Report
                        </a>
                    </div> --}}

                    {{-- <div class="top-links-menu">
                        <a href="" class="{{ Request::segment(1) == 'filter-report' ? 'a-active' : '' }}">
                            Filter Report
                        </a>
                    </div> --}}

                </span>
            </span>
            
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header class="main-head">
            <h1>Welcome {{ Auth::user()->name }}!</h1>
            <span class="user">
                <span class="user-inf">
                    <div class="name"><i class="fa-solid fa-user"></i> {{ Auth::user()->name }}</div>
                    <form method="POST" action="{{ route('logout') }}" class="logout">
                        @csrf
                        <a href=""
                            :href="route('logout')"
                            onclick="event.preventDefault();
                            this.closest('form').submit();"
                            class="log-out">

                            {{ __('Log Out') }}

                        </a>
                    </form>
                </span>
            </span>
        </header>

        <div class="main">
            {{ $slot }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mainContent = document.querySelector('.main-content');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            });
        });
        
    </script>
</body>
</html>