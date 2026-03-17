<x-app-layout>
    <div class="admin-nav">
        <div class="admin-nav-conrtainer">
            <a href="/accounting/upcoming-statement">
                <button class="{{ Request::segment(2) == 'upcoming-statement' ? 'active' : '' }}">
                    Generate Next Month Invoices
                </button>
            </a>  
            <a href="/accounting/view-and-download-invoices">
                <button class="{{ Request::segment(2) == 'view-and-download-invoices' ? 'active' : '' }}">
                    View and Download Invoices
                </button>
            </a>

        </div>
        <div class="har-line">

        </div>
    </div>



    <div>
        @yield('content')
    </div>

</x-app-layout>