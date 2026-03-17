<x-app-layout>
<!-- Ensure libraries are included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<style>
</style>
<!-- Your HTML with static province filter -->
<div class="card-header">
    @php
        $userRoles = auth()->user()->roles->pluck('name');

        // Filter roles that start with 'TS ' and are not 'TS Team Leader'
        $provinceRole = $userRoles->first(function($role) {
            return str_starts_with($role, 'TS ') && $role !== 'TS Team Leader';
        });

        $province = $provinceRole ? substr($provinceRole, 3) : 'All Provinces';
    @endphp

    <h4>
        Customers in {{ $province }}
    </h4>

</div>
<div class="cust-row">
    <div class="cust-row-box total-cust">
        <div class="cust-icon">
            <i class="fa fa-user" aria-hidden="true"></i>
        </div>
        <div class="cust-num">
            <p>Total Customer:</p>
            <h1 id="total-count">0000</h1>
        </div>
    </div>
    <div class="cust-row-box active-cust">
        <div class="cust-icon">
            <i class="fa fa-check" aria-hidden="true"></i>
        </div>
        <div class="cust-num">
            <p>Active Customer:</p>
            <h1 id="active-count">0000</h1>
        </div>
    </div>
</div>

<div class="card-header" style="display: flex; align-items: center; gap: 20px;">
    <div style="display: flex; align-items: center; gap: 10px;">
        <label for="column-select" style="width: 80px;">Search By:</label>
        <select id="column-select" class="form-control" style="width: 170px;">
            <option value="0">Customer ID</option>
            <option value="1">Customer Name</option>
            <option value="2">PPPOE</option>
            <option value="3">Router</option>
            <option value="4">Remark</option>
            <option value="5">Location</option>
            <option value="6">Tariff</option>
            <option value="7">Agent</option>
            <option value="9">Status</option>
        </select>
    </div>
    <input type="text" id="column-search-input" placeholder="Type to search..." class="form-control" />
    
    <!-- Status Filter -->
    <div style="display: flex; align-items: center; gap: 10px;">
        <label for="status-filter">Status:</label>
        <select id="status-filter" class="form-control" style="width: 150px;">
            <option value="">All</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
            <option value="Suspended">Suspended</option>
            <option value="Deactivated">Deactivated</option>
            <option value="Terminated">Terminated</option>
            <option value="Pending">Pending</option>
        </select>
    </div>

    <!-- Date Range Filter -->
    <div style="display: flex; align-items: center; gap: 10px;">
        <label for="min-date">From:</label>
        <input type="date" id="min-date" class="form-control" style="width: 180px;">
        <label for="max-date">To:</label>
        <input type="date" id="max-date" class="form-control" style="width: 180px;">
    </div>
</div>

<div class="card-header" style="margin-bottom: 15px;">
    <button id="reset-filters" class="btn btn-danger">Reset Filters</button>
</div>

@if (session('order-type-update-status'))
    <div class="alert alert-success">
        {{ session('order-type-update-status') }}
    </div>
@endif

@if (session('order-type-add-success'))
    <div class="alert alert-success">
        {{ session('order-type-add-success') }}
    </div>
@endif
    
@if (session('delete-success')) 
    <div class="alert alert-success">
        {{ session('delete-success') }}
    </div>
@endif

<div class="card">
    <table class="table table-bordered table-striped" id="all-cust-table" style="font-size: 15px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>PPPOE</th>
                <th>Router</th>
                <th>Remark</th>
                <th>Location</th>
                <th>Tariff</th>
                <th>Agent</th>
                <th>Register Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        let table = $('#all-cust-table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            pageLength: 15,
            dom: '<"top"fip><"clear">',
            ajax: {
                url: "{{ route('ts-customers.data') }}",
                type: "GET",
                data: function (d) {
                    // Add date range parameters to the AJAX request
                    d.min_date = $('#min-date').val();
                    d.max_date = $('#max-date').val();
                    // Add location filter for consistency
                    d.location = $('#location-filter').val();
                    // Add status filter
                    d.status = $('#status-filter').val();
                }
            },
            columns: [
                {
                    data: 'customer_id',
                    name: 'customer_id',
                    defaultContent: '',
                    className: 'text-center',
                    render: function (data, type, row) {
                        if(type === 'display') {
                            return `<a href="/customers/${data}/view-details">${data}</a>`;
                        }
                        return data;
                    }
                },
                {
                    data: 'customer_name',
                    name: 'customer_name',
                    defaultContent: '',
                    className: 'text-left'
                },
                { 
                    data: 'pppoe', 
                    name: 'pppoe', 
                    defaultContent: '---', 
                    className: 'text-center'
                },
                {
                    data: 'router',
                    name: 'router',
                    defaultContent: '---',
                    className: 'text-center'
                },
                {
                    data: 'remark',
                    name: 'remark',
                    defaultContent: '---',
                    className: 'text-center'
                },
                { 
                    data: 'province', 
                    name: 'province', 
                    defaultContent: '---', 
                    className: 'text-left' 
                },
                {
                    data: null,
                    name: 'tariff_bandwidth',
                    defaultContent: '',
                    className: 'text-left',
                    render: function (data, type, row) {
                        return (row.tariff_name || '---') + ' ' + (row.bandwidth || '---');
                    }
                },
                {
                    data: 'agent',
                    name: 'agent',
                    defaultContent: '---',
                    className: 'text-left'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    defaultContent: '',
                    className: 'text-center',
                    render: function (data, type, row) {
                        if(type === 'display' || type === 'filter') {
                            return `<span class="date-format" data-original-date="${data}">${data}</span>`;
                        }
                        return data;
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    defaultContent: '',
                    className: 'text-center',
                    render: function (data, type, row) {
                        return '<div class="account_status_disp">' + (data ?? '') + '</div>';
                    }
                },
                { 
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false, 
                    defaultContent: '', 
                    className: 'text-center' 
                }
            ],
            createdRow: function(row, data) {
                if(data.customer_id) data.customer_id = data.customer_id.toString().trim().toLowerCase();
                if(data.pppoe) data.pppoe = data.pppoe.trim().toLowerCase();
            },
            initComplete: function () {
                const statusColors = {
                    "Active": "#24ba474c",
                    "Inactive": "#dc35463a",
                    "Suspended": "#ff98003a",
                    "Deactivated": "#f443363a",
                    "Terminated": "#f443363a",
                    "Pending": "#ffc1073a"
                };
                $(".account_status_disp").each(function() {
                    let statusText = $(this).text().trim();
                    if (statusColors[statusText]) {
                        $(this).css({
                            "backgroundColor": statusColors[statusText],
                            "padding": "3px 14px",
                            "borderRadius": "15px"
                        });
                    }
                });
                $(".date-format").each(function() {
                    let originalDate = $(this).attr('data-original-date') || $(this).text().trim();
                    if (originalDate) {
                        let date = new Date(originalDate);
                        if (!isNaN(date.getTime())) {
                            let day = String(date.getDate()).padStart(2, '0');
                            let month = date.toLocaleString("en-US", { month: "long" });
                            let year = date.getFullYear();
                            $(this).text(`${day} ${month}, ${year}`);
                        } else $(this).text("N/A");
                    }
                });
            },
            drawCallback: function () {
                const statusColors = {
                    "Active": "#24ba474c",
                    "Inactive": "#dc35463a",
                    "Suspended": "#ff98003a",
                    "Deactivated": "#f443363a",
                    "Terminated": "#f443363a",
                    "Pending": "#ffc1073a"
                };
                $(".account_status_disp").each(function() {
                    let statusText = $(this).text().trim();
                    if (statusColors[statusText]) {
                        $(this).css({
                            "backgroundColor": statusColors[statusText],
                            "padding": "3px 14px",
                            "borderRadius": "15px"
                        });
                    }
                });
                $(".date-format").each(function() {
                    let originalDate = $(this).attr('data-original-date') || $(this).text().trim();
                    if (originalDate) {
                        let date = new Date(originalDate);
                        if (!isNaN(date.getTime())) {
                            let day = String(date.getDate()).padStart(2, '0');
                            let month = date.toLocaleString("en-US", { month: "long" });
                            let year = date.getFullYear();
                            $(this).text(`${day} ${month}, ${year}`);
                        } else $(this).text("N/A");
                    }
                });
            }
        });

        // Column search
        $('#column-search-input').on('keyup', function () {
            let colIndex = $('#column-select').val();
            table.column(colIndex).search(this.value).draw();
        });

        // Location filter
        $('#location-filter').on('change', function () {
            table.draw(); // Trigger AJAX with location parameter
        });

        // Status filter
        $('#status-filter').on('change', function () {
            table.draw(); // Trigger AJAX with status parameter
        });

        // Date range filter
        $('#min-date, #max-date').on('change', function () {
            table.draw(); // Trigger AJAX with date parameters
        });

        // Reset filters
        $('#reset-filters').on('click', function () {
            $('#column-search-input').val('');
            $('#location-filter').val('');
            $('#status-filter').val('');
            $('#min-date').val('');
            $('#max-date').val('');
            table.search('').columns().search('').draw();
        });

        table.on('xhr', function () {
            let json = table.ajax.json();

            if (json) {
                let total = json.total_count ?? 0;
                let active = json.active_count ?? 0;

                // Format with leading zero
                $("#total-count").text(String(total).padStart(4, '0'));
                $("#active-count").text(String(active).padStart(4, '0'));
            }
        });

    });
</script>
</x-app-layout>