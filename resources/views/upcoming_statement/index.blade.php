@extends('layouts.next-month-invoices')

@section('content')
    <!-- Required libraries (ensure jQuery and DataTables are included) -->
    <!-- Buttons extension for Excel export -->
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css"> --}}

    <div class="card-header">
        <h4>Next Month Invoices</h4>
    </div>

    <div class="cust-row">
        <div class="cust-row-box total-cust">
            <div class="cust-icon">
                <i class="fa fa-user" aria-hidden="true"></i>
            </div>
            <div class="cust-num">
                <p>Total Statements:</p>
                <h1>{{ str_pad($total, 4, '0', STR_PAD_LEFT) }}</h1>
            </div>
        </div>
    </div>

    <div class="card-header">
        <span style="display: flex; align-items: center; justify-content:space-between;">
            <button id="generate-invoices" class="btn btn-success" >Generate Invoices</button>

            <span style="display: flex; align-items: center; gap: 10px;">
                <label for="province-filter">Filter by Province: </label>
                <select id="province-filter" class="form-control" style="width: 200px; display: inline-block;">
                    <option value="">All Provinces</option>
                    @foreach ([
                        "Phnom Penh", "Banteay Meanchey", "Battambang", "Kampong Cham", "Kampong Chhnang",
                        "Kampong Speu", "Kampong Thom", "Kampot", "Kandal", "Koh Kong", "Kep", "Kratie", 
                        "Mondulkiri", "Oddar Meanchey", "Pailin", "Preah Sihanouk", "Preah Vihear", 
                        "Pursat", "Prey Veng", "Ratanak Kiri", "Siem Reap", "Stung Treng", 
                        "Svay Rieng", "Takeo", "Tboung Khmum"
                    ] as $province)
                        <option value="{{ $province }}">{{ $province }}</option>
                    @endforeach
                </select>
            </span>
        </span>
    </div>
    @foreach (['order-type-update-status', 'order-type-add-success', 'delete-success'] as $msg)
        @if (session($msg))
            <div class="alert alert-success">{{ session($msg) }}</div>
        @endif
    @endforeach

    <div class="card">
        <table class="table table-bordered table-striped" id="all-cust-table" style="font-size: 15px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Location</th>
                    <th>Tariff</th>
                    <th>Bill Cycle</th>
                    <th>Start Date</th>
                    <th>Internet Fee</th>
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
                        <td>{{ $customer->province }}</td>
                        <td style="text-align: start">{{ $customer->tariff_name }} {{ $customer->bandwidth }}</td>
                        <td>{{ $customer->bill_cycle }} Month(s)</td>
                        <td class="date-format">{{ $customer->start_date }}</td>
                        <td>${{ $customer->internet_fee }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            function formatDate(dateString) {
                if (!dateString) return "N/A";
                try {
                    let date = new Date(dateString);
                    if (isNaN(date.getTime())) return "Invalid Date";
                    let day = String(date.getDate()).padStart(2, '0');
                    let month = date.toLocaleString("en-US", { month: "short" });
                    let year = date.getFullYear();
                    return `${day} ${month}, ${year}`;
                } catch (e) {
                    console.error("Date formatting error:", e);
                    return "Invalid Date";
                }
            }

            function applyCustomFormatting() {
                $(".date-format").each(function () {
                    let originalDate = $(this).text().trim();
                    if (originalDate) {
                        $(this).text(formatDate(originalDate));
                    }
                });

                const statusColors = {
                    "Active": "#24ba474c",
                    "Inactive": "#dc35463a",
                    "Suspended": "#ff98003a"
                };

                $(".account_status_disp").each(function () {
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

            let table = $('#all-cust-table').DataTable({
                pageLength: 15,
                dom: '<"top"fip><"clear">', // Removed 'B' to exclude Buttons placeholder
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                language: {
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries available",
                    emptyTable: "No matching records found",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                columnDefs: [
                    { targets: 2, visible: true, searchable: true }
                ],
                initComplete: function () {
                    applyCustomFormatting();
                }
            });

            table.on('draw', function () {
                applyCustomFormatting();
            });

            $('#province-filter').on('change', function () {
                let province = $(this).val();
                if (province) {
                    table.column(2).search('^' + $.fn.dataTable.util.escapeRegex(province) + '$', true, false).draw();
                } else {
                    table.column(2).search('').draw();
                }
            });

            // Handle Generate Invoices Button Click
            $('#generate-invoices').on('click', function () {
                // Get all visible (filtered) rows from the DataTable
                let filteredIds = table.rows({ search: 'applied' }).data().toArray().map(function (row) {
                    // Extract the customer ID from the first column (strip <a> tag)
                    return $(row[0]).text().trim();
                });

                if (filteredIds.length === 0) {
                    alert('🚫 No customers found to generate invoices for! 😕');
                    return;
                }

                // Confirm with user
                if (!confirm(`📋 Are you sure you want to generate invoices for ${filteredIds.length} customer(s)? 🤔`)) {
                    return;
                }

                // Send AJAX request to server
                $.ajax({
                    url: '{{ route("accounting.upcoming-invoice-generate") }}', // Replace with your route for invoice generation
                    type: 'POST',
                    data: {
                        customer_ids: filteredIds,
                        _token: '{{ csrf_token() }}' // Include CSRF token for Laravel security
                    },
                    success: function (response) {
                        if (response.success) {
                            alert('🎉 Invoices generated successfully for ' + filteredIds.length + ' customer(s)! ✅');
                            // Optionally reload the page or update the table
                            location.reload();
                        } else {
                            alert('❌ Error: ' + (response.message || 'Failed to generate invoices.') + ' 😞');
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('⚠️ An error occurred while generating invoices: ' + error + ' 😱');
                    }
                });
            });
        });

        function confirmDeleteCustomer(customerName) {
            const input = prompt(`To confirm deletion, type the customer's name: "${customerName}"`);
            if (input === null) return false;
            if (input.trim() !== customerName.trim()) {
                alert("Customer name does not match. Deletion cancelled.");
                return false;
            }
            return true;
        }
    </script>

@endsection