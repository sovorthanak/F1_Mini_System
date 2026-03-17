<x-app-layout>
<!-- Ensure libraries are included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<!-- Card header with back button -->
<div class="card-header">
    <h4>Download Customers Data
        <span>
            <a href="/customers" class="btn btn-primary float-end">Back</a>
        </span>
    </h4>
</div>

<!-- Filter dropdowns -->
<div class="card-header" style="display: flex; align-items: center; gap: 20px;">
    <div>
        <label for="province-filter">Filter by Location: </label>
        <select id="province-filter" class="form-control" style="width: 200px; display: inline-block;">
            <option value="" selected>All Locations</option>
            @foreach($locations as $location)
                <option value="{{ $location->name }}" {{ old('province') == $location->name ? 'selected' : '' }}>{{ $location->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="tariff-filter">Tariff: </label>
        <select id="tariff-filter" class="form-control" style="width: 200px; display: inline-block;">
            <option value="">All Tariff</option>
            @foreach($tariffs as $tariff)
                <option value="{{ $tariff->name }}" {{ old('tariff_name') == $tariff->name ? 'selected' : '' }}>{{ $tariff->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="bill-cycle-filter">Bill Cycle: </label>
        <select id="bill-cycle-filter" class="form-control" style="width: 200px; display: inline-block;">
            <option value="">All Bill Cycles</option>
            <option value="1 Month(s)">1 Month(s)</option>
            <option value="3 Month(s)">3 Month(s)</option>
            <option value="6 Month(s)">6 Month(s)</option>
            <option value="12 Month(s)">12 Month(s)</option>
        </select>
    </div>

    <div>
        <label for="status-filter">Status: </label>
        <select id="status-filter" class="form-control" style="width: 200px; display: inline-block;">
            <option value="">All Statuses</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
            <option value="Suspended">Suspended</option>
            <option value="Deactivated">Deactivated</option>
            <option value="Terminated">Terminated</option>
            <option value="Pending">Pending</option>
        </select>
    </div>
    
    <div style="display: flex; align-items: center; gap: 10px;">
        <label for="min-date">From:</label>
        <input type="date" id="min-date" class="form-control" style="width: 180px;">
        <label for="max-date">To:</label>
        <input type="date" id="max-date" class="form-control" style="width: 180px;">
    </div>
</div>

<!-- Search by column -->
<div class="card-header" style="display: flex; align-items: center; gap: 20px;">
    <div style="display: flex; align-items: center; gap: 10px;">
        <div style="display: flex; align-items: center;">
            <label for="column-select" style="width: 80px;">Search By:</label>
            <select id="column-select" class="form-control" style="width: 170px;">
                <option value="0">Customer ID</option>
                <option value="1">Customer Name</option>
                <option value="2">PPPOE</option>
                <option value="3">Location</option>
                <option value="4">Tariff</option>
                <option value="19">Registered At</option>
            </select>
        </div>
        <input type="text" id="column-search-input" placeholder="Type to search..." class="form-control" />
    </div>
</div>

<!-- Reset filters button -->
<div class="card-header" style="margin-bottom: 15px;">
    <button id="reset-filters" class="btn btn-danger">Reset Filters</button>
</div>

<!-- Session messages -->
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

<!-- DataTable -->
<div class="card">
    <table class="table table-bordered table-striped" id="all-cust-table" style="font-size: 15px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>PPPOE</th>
                <th>Location</th>
                <th>Tariff</th>
                <th>Bill Cycle</th>
                <th>Start Date</th>
                <td style="display: none;">Internet Fee</td>
                <th style="display: none;">Installation Fee</th>
                <th style="display: none;">IP Fee</th>
                <th style="display: none;">Next Issue Date</th>
                <th style="display: none;">Phone Number</th>
                <th style="display: none;">IP Address</th>
                <th style="display: none;">Address</th>
                <th style="display: none;">Address (Khmer)</th>
                <th style="display: none;">Currency</th>
                <th style="display: none;">Lat Long</th>
                <th style="display: none;">Agent</th>
                <th style="display: none;">Created By</th>
                <th>Registered At</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr style="height: 40px;">
                    <td style="text-align: center">
                        <a href="{{ route('customers.view-details', ['customer_id' => $customer->customer_id]) }}">
                            {{ $customer->customer_id }}
                        </a>
                    </td>
                    <td style="text-align: start">{{ $customer->customer_name }}</td>
                    <td>{{ $customer->pppoe ?? '---' }}</td>
                    <td>{{ $customer->province }}</td>
                    <td style="text-align: start">{{ $customer->tariff_name }} {{ $customer->bandwidth }}</td>
                    <td>{{ $customer->bill_cycle }} Month(s)</td>
                    <td class="date-format" data-original-date="{{ $customer->first_start_date }}">{{ $customer->first_start_date }}</td>
                    <td style="display: none;">${{ $customer->internet_fee }}</td>
                    <td style="display: none;">{{ $customer->installation_fee ?? 'N/A' }}</td>
                    <td style="display: none;">{{ $customer->ip_fee ?? 'N/A' }}</td>
                    <td style="display: none;" class="date-format" data-original-date="{{ $customer->start_date }}">{{ $customer->start_date ?? 'N/A' }}</td>
                    <td style="display: none;">{{ $customer->phone_number ?? 'N/A' }}</td>
                    <td style="display: none;">{{ $customer->ip_address ?? 'N/A' }}</td>
                    <td style="display: none;">{{ $customer->address_line_1 ?? 'N/A' }}</td>
                    <td style="display: none;">{{ $customer->alt_address_line_1 ?? 'N/A' }}</td>
                    <td style="display: none;">{{ $customer->currency ?? 'N/A' }}</td>
                    <td style="display: none;">{{ $customer->lat_long ?? 'N/A' }}</td>
                    <td style="display: none;">{{ $customer->agent ?? 'N/A' }}</td>
                    <td style="display: none;">{{ $customer->created_by ?? 'N/A' }}</td>
                    <td class="date-format" data-original-date="{{ $customer->created_at }}">{{ $customer->created_at ?? 'N/A' }}</td>
                    <td style="text-align: center"><div class="account_status_disp">{{ $customer->status ?? 'Active' }}</div></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    let table = $('#all-cust-table').DataTable({
        pageLength: 15,
        dom: '<"top"Bfip><"clear">',
        buttons: [
            {
                extend: 'excelHtml5',
                title: `Customer List - ${new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}`,
                text: 'Download Excel',
                className: 'btn btn-primary',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20],
                    modifier: {
                        search: 'applied'
                    },
                    format: {
                        body: function (data, row, column, node) {
                            // Format dates
                            if (column === 6 || column === 10 || column === 19) {
                                let originalDate = $(node).attr('data-original-date') || data;
                                if (!originalDate || originalDate.trim() === "" || originalDate === "N/A") return "N/A";
                                let date = new Date(originalDate);
                                if (isNaN(date.getTime())) return "N/A";
                                let day = String(date.getDate()).padStart(2, '0');
                                let month = date.toLocaleString('en-US', { month: 'long' });
                                let year = date.getFullYear();
                                return `${day} ${month}, ${year}`;
                            }
                            // Format currency
                            if (column === 7 || column === 8) {
                                let value = $(node).text().trim();
                                if (!value || value === "N/A") return "N/A";
                                let num = parseFloat(value.replace('$', ''));
                                if (isNaN(num)) return "N/A";
                                return "$" + num.toFixed(2);
                            }
                            return $(node).text().trim();
                        }
                    }
                }
            }
        ],
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        columnDefs: [
            { targets: [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18], visible: false, searchable: true }
        ]
    });

    // Unified filter function including date range
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        let province = $('#province-filter').val().toLowerCase();
        let tariff = $('#tariff-filter').val().toLowerCase();
        let billCycle = $('#bill-cycle-filter').val().toLowerCase();
        let status = $('#status-filter').val().toLowerCase();
        let colIndex = parseInt($('#column-select').val());
        let keyword = $('#column-search-input').val().toLowerCase();
        
        // Date filter
        let minDate = $('#min-date').val();
        let maxDate = $('#max-date').val();
        
        // Get the original date from the Start Date column (index 6)
        let startDateCell = table.cell(dataIndex, 6).node();
        let startDateStr = $(startDateCell).attr('data-original-date');
        
        // Filter checks
        if (province && data[3].toLowerCase() !== province) return false;
        if (tariff && !data[4].toLowerCase().includes(tariff)) return false;
        if (billCycle && data[5].toLowerCase() !== billCycle) return false;
        if (status && data[20].toLowerCase() !== status) return false;
        if (keyword && !data[colIndex].toLowerCase().includes(keyword)) return false;
        
        // Date range filter
        if (minDate || maxDate) {
            if (!startDateStr || startDateStr === 'N/A') return false;
            
            let startDate = new Date(startDateStr);
            if (isNaN(startDate.getTime())) return false;
            
            // Reset time to midnight for accurate date comparison
            startDate.setHours(0, 0, 0, 0);
            
            if (minDate) {
                let min = new Date(minDate);
                min.setHours(0, 0, 0, 0);
                if (startDate < min) return false;
            }
            
            if (maxDate) {
                let max = new Date(maxDate);
                max.setHours(23, 59, 59, 999);
                if (startDate > max) return false;
            }
        }

        return true;
    });

    // Redraw table on filters
    $('#province-filter, #tariff-filter, #bill-cycle-filter, #status-filter').on('change', function() {
        table.draw();
    });

    $('#column-search-input, #column-select').on('keyup change', function() {
        table.draw();
    });

    // Date filter trigger
    $('#min-date, #max-date').on('change', function() {
        table.draw();
    });

    // Reset filters
    $('#reset-filters').on('click', function () {
        $('#province-filter').val('');
        $('#tariff-filter').val('');
        $('#bill-cycle-filter').val('');
        $('#status-filter').val('');
        $('#column-select').val('0');
        $('#column-search-input').val('');
        $('#min-date').val('');
        $('#max-date').val('');
        table.search('').columns().search('').draw();
    });

    // Re-apply formatting on table draw
    table.on('draw', function() {
        formatDates();
        applyStatusColors();
    });

    // Initial formatting
    formatDates();
    applyStatusColors();

    // Helper functions
    function formatDates() {
        $(".date-format").each(function() {
            let originalDate = $(this).attr('data-original-date') || $(this).text().trim();
            if (!originalDate || originalDate === "N/A") return $(this).text("N/A");
            let date = new Date(originalDate);
            if (isNaN(date.getTime())) return $(this).text("N/A");
            let day = String(date.getDate()).padStart(2, '0');
            let month = date.toLocaleString("en-US", { month: "long" });
            let year = date.getFullYear();
            $(this).text(`${day} ${month}, ${year}`);
        });
    }

    function applyStatusColors() {
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
    }
});
</script>

</x-app-layout>