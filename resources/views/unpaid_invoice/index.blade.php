<x-app-layout>
    <!-- HTML remains unchanged, only updating the JavaScript section -->
    
    <!-- Existing HTML content (unchanged) -->
    <div class="card-header">
        <h4>Unpaid Invoices
            <a href="invoices/create" class="btn btn-primary float-end">Issue New Invoice</a>
        </h4>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="cust-row invoice-row">
        <div class="cust-row-box active-cust">
            <div class="cust-icon">
                <i class="fa fa-book" aria-hidden="true"></i>
            </div>
            <div class="cust-num unpaid-cust">
                <p>Total:</p>
                <h1>{{ str_pad($total_unpaid_invoices, 4, '0', STR_PAD_LEFT) }}</h1>
            </div>
        </div>
        <div class="cust-row-box active-cust">
            <div class="cust-icon">
                <i class="fa-solid fa-dollar-sign"></i>
            </div>
            <div class="cust-num unpaid-cust">
                <p>Total Unpaid Amount:</p>
                <h1>${{ number_format($total_unpaid ?? 100.00, 2) }}</h1>
            </div>
        </div>
    </div>

    <div class="card-header" style="margin-bottom: 15px; display: flex; align-items: center; gap: 30px;">
        <span style="display: flex; align-items: center; gap: 10px;">
            <label for="province-filter">Filter by Province: </label>
            <select id="province-filter" class="form-control" style="width: 200px; display: inline-block;">
                <option value="">All Provinces</option>
                <option value="Phnom Penh">Phnom Penh</option>
                <option value="Banteay Meanchey">Banteay Meanchey</option>
                <option value="Battambang">Battambang</option>
                <option value="Kampong Cham">Kampong Cham</option>
                <option value="Kampong Chhnang">Kampong Chhnang</option>
                <option value="Kampong Speu">Kampong Speu</option>
                <option value="Kampong Thom">Kampong Thom</option>
                <option value="Kampot">Kampot</option>
                <option value="Kandal">Kandal</option>
                <option value="Koh Kong">Koh Kong</option>
                <option value="Kep">Kep</option>
                <option value="Kratie">Kratie</option>
                <option value="Mondulkiri">Mondulkiri</option>
                <option value="Oddar Meanchey">Oddar Meanchey</option>
                <option value="Pailin">Pailin</option>
                <option value="Preah Sihanouk">Preah Sihanouk</option>
                <option value="Preah Vihear">Preah Vihear</option>
                <option value="Pursat">Pursat</option>
                <option value="Prey Veng">Prey Veng</option>
                <option value="Ratanak Kiri">Ratanak Kiri</option>
                <option value="Siem Reap">Siem Reap</option>
                <option value="Stung Treng">Stung Treng</option>
                <option value="Svay Rieng">Svay Rieng</option>
                <option value="Takeo">Takeo</option>
                <option value="Tboung Khmum">Tboung Khmum</option>            
            </select>        
        </span>

        <span style="display: flex; align-items: center; gap: 10px;">
            <label for="start-date" class="ms-3">From:</label>
            <input type="date" id="start-date" class="form-control" style="width: 180px; display: inline-block; margin-right: 10px;">
            <label for="end-date">To :</label>
            <input type="date" id="end-date" class="form-control" style="width: 180px; display: inline-block;">
        </span>
    </div>

    <div class="card">
        <table class="table table-bordered table-striped" id="all-cust-table" style="font-size: 15px;">
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Customer Name</th>
                    <th>Province</th>
                    <th>Tariff</th>
                    <th>Billing Period</th>
                    <th>Amount</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr style="height: 40px;" data-created-at="{{ \Carbon\Carbon::parse($invoice->created_at)->format('Y-m-d') }}">
                        <td style="text-align: center">
                            <a href="{{ route('invoice.view', $invoice->invoice_id) }}">
                                {{ str_pad($invoice->invoice_id, 6, '0', STR_PAD_LEFT) }}
                            </a>
                        </td>
                        <td style="text-align: start">{{ $invoice->customer->customer_name }}</td>
                        <td style="text-align: start">{{ $invoice->customer->province }}</td>
                        <td style="text-align: start">{{ $invoice->tariff_name }} {{ $invoice->bandwidth }}</td>
                        <td class="date-format" data-start-date="{{ \Carbon\Carbon::parse($invoice->start_date)->format('Y-m-d') }}" data-end-date="{{ \Carbon\Carbon::parse($invoice->end_date)->subDay()->format('Y-m-d') }}">
                            {{ $invoice->bill_cycle }} Month(s) (
                            {{ \Carbon\Carbon::parse($invoice->start_date)->format('Y-m-d') }} -
                            {{ \Carbon\Carbon::parse($invoice->end_date)->subDay()->format('Y-m-d') }}
                            )
                        </td>
                        <td>${{ number_format($invoice->total_amount, 2) }}</td>
                        <td style="text-align: center;">
                            <span class="account_status_disp">{{ $invoice->payment_status }}</span>
                        </td>
                        <td>
                            <a href="{{ route('invoice.view', $invoice->invoice_id) }}"
                               class="btn btn-primary"
                               style="padding: 0.2rem 0.4rem; font-size: 0.75rem;" title="View Invoice">
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-success make-payment"
                               data-invoice-id="{{ $invoice->invoice_id }}"
                               style="padding: 0.2rem 0.4rem; font-size: 0.75rem;" title="Make Payment">
                                <i class="fa fa-check"></i>
                            </a>
                            <a href="{{ route('invoices.print', $invoice->invoice_id) }}"
                               class="btn btn-info"
                               style="padding: 0.2rem 0.4rem; font-size: 0.75rem;" title="Download Invoice" target="_blank">
                                <i class="fa fa-download"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script>
        // Function to format date as "07 Feb 2025"
        function formatDate(dateString) {
            if (!dateString) return "N/A";
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return "Invalid Date";
            const day = String(date.getDate()).padStart(2, '0');
            const month = date.toLocaleString("en-US", { month: "short" });
            const year = date.getFullYear();
            return `${day} ${month}, ${year}`;
        }

        $(document).ready(function() {
            // Log to verify table exists
            console.log("Table exists:", $('#all-cust-table').length);

            // Date formatting for billing period
            $(".date-format").each(function() {
                const originalText = $(this).text().trim();
                if (originalText) {
                    const dateMatches = originalText.match(/(\d{4}-\d{2}-\d{2})/g);
                    if (dateMatches && dateMatches.length === 2) {
                        const formattedStart = formatDate(dateMatches[0]);
                        const formattedEnd = formatDate(dateMatches[1]);
                        const updatedText = originalText.replace(dateMatches[0], formattedStart).replace(dateMatches[1], formattedEnd);
                        $(this).text(updatedText);
                    }
                }
            });

            // Status colors
            const statusColors = {
                "Paid": "#24ba474c", // Green
                "Unpaid": "#dc35463a" // Red
            };
            $(".account_status_disp").each(function() {
                const statusText = $(this).text().trim();
                if (statusColors[statusText]) {
                    $(this).css({
                        "backgroundColor": statusColors[statusText],
                        "padding": "3px 14px",
                        "borderRadius": "15px"
                    });
                }
            });

            // Initialize DataTable
            let table;
            try {
                table = $('#all-cust-table').DataTable({
                    paging: true,
                    pagingType: "full_numbers",
                    lengthChange: false,
                    pageLength: 15,
                    dom: '<"top"fip><"clear">',
                    searching: true,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    language: {
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "No entries available",
                        emptyTable: "No data available in the table",
                        paginate: {
                            first: "First",
                            last: "Last",
                            next: "Next",
                            previous: "Previous"
                        }
                    }
                });
            } catch (e) {
                console.error("DataTable initialization error:", e);
            }

            // Custom search function for month filter
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const monthFilter = $('#month-filter').val(); // e.g., "2025-05"
                    if (!monthFilter) return true; // Show all if no month selected

                    const row = table.row(dataIndex).node();
                    const createdAt = $(row).data('created-at'); // YYYY-MM-DD

                    if (!createdAt) return false;

                    const createdMonth = createdAt.slice(0, 7); // Extract YYYY-MM
                    const selectedMonth = monthFilter; // YYYY-MM from input

                    return createdMonth === selectedMonth;
                }
            );

            // Province filter - column index 2 is the Province column
            $('#province-filter').on('change', function() {
                const province = $(this).val();
                if (province) {
                    table.column(2).search('^' + $.fn.dataTable.util.escapeRegex(province) + '$', true, false).draw();
                } else {
                    table.column(2).search('').draw();
                }
            });
            
            
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const start = $('#start-date').val();
                    const end = $('#end-date').val();
                    
                    const row = table.row(dataIndex).node();
                    const createdAtStr = $(row).data('created-at'); // from <tr data-created-at="YYYY-MM-DD">
            
                    if (!createdAtStr) return true;
            
                    const createdAt = new Date(createdAtStr);
                    const startDate = start ? new Date(start) : null;
                    const endDate = end ? new Date(end) : null;
            
                    if (
                        (!startDate || createdAt >= startDate) &&
                        (!endDate || createdAt <= endDate)
                    ) {
                        return true;
                    }
            
                    return false;
                }
            );


            // Trigger redraw on date change
            $('#start-date, #end-date').on('change', function () {
                table.draw();
            });

            // Handle Make Payment button click using event delegation
            $(document).on('click', '.make-payment', function(e) {
                e.preventDefault();
                const invoiceId = $(this).data('invoice-id');

                if (!confirm(`Are you sure you want to mark invoice #${invoiceId} as paid?`)) {
                    return;
                }

                $.ajax({
                    url: `/invoices/update-payment/${invoiceId}`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        payment_status: 'Paid'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Failed to update payment status.');
                        }
                    },
                    error: function(xhr) {
                        console.error("AJAX error:", xhr);
                        alert('Error: ' + (xhr.responseJSON?.message || 'Unable to update payment status.'));
                    }
                });
            });
        });
    </script>
</x-app-layout>