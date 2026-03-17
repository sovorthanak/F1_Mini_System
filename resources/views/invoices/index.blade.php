<x-app-layout>
    <div class="card-header">
        <h4>Invoices
            <span>
                <a href="/invoices/create" class="btn btn-primary float-end">Issue New Invoice</a>
            </span>
        </h4>
    </div>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="cust-row invoice-row">
        <div class="cust-row-box total-cust">
            <div class="cust-icon">
                <i class="fa fa-book" aria-hidden="true"></i>
            </div>
            <div class="cust-num">
                <p>Total Invoice:</p>
                <h1>{{ str_pad($total_invoices, 4, '0', STR_PAD_LEFT) }}</h1>          
            </div>
        </div>
        <div class="cust-row-box active-cust">
            <div class="cust-icon">
                <i class="fa-solid fa-dollar-sign"></i>
            </div>
            <div class="cust-num">
                <p>Total Paid Amount:</p>
                <h1>${{ number_format($total_paid ?? 100.00, 2) }}</h1>
            </div>
        </div>
        <div class="cust-row-box active-cust">
            <div class="cust-icon">
                <i class="fa fa-check" aria-hidden="true"></i>
            </div>
            <div class="cust-num">
                <p>Paid Invoice:</p>
                <h1>{{ str_pad($total_paid_invoices, 4, '0', STR_PAD_LEFT) }}</h1>          
            </div>
        </div>
    </div>

        <!-- Province filter dropdown with static options -->
    <div class="card-header">
        <label for="province-filter">Filter by Location: </label>
        <select id="province-filter" class="form-control" style="width: 200px; display: inline-block;">
            <option value="">All Location</option>
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

        &nbsp;&nbsp;

        <!-- Payment Status filter dropdown -->
        <label for="status-filter">Payment Status: </label>
        <select id="status-filter" class="form-control" style="width: 200px; display: inline-block; margin-left: 10px;">
            <option value="">All Statuses</option>
            <option value="Paid">Paid</option>
            <option value="Unpaid">Unpaid</option>
        </select>

    </div>


    <div class="card">
        <table class="table table-bordered table-striped" id="all-cust-table" style="font-size: 15px;">
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Customer Name</th>
                    <th>Location</th>
                    <th>Tariff</th>
                    <th>Billing Period</th>
                    <th>Amount</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr style="height: 40px;">
                    <td style="text-align: center">
                        <a href="{{ route('invoice.view', $invoice->invoice_id) }}">
                            {{ str_pad($invoice->invoice_id, 6, '0', STR_PAD_LEFT) }}
                        </a>
                    </td>
                    <td style="text-align: start">{{ $invoice->customer->customer_name }}</td>
                    <td style="text-align: start">{{ $invoice->customer->province }}</td>
                    <td style="text-align: start">{{ $invoice->tariff_name }} {{ $invoice->bandwidth }}</td>
                    <td>{{ $invoice->bill_cycle }} Month(s) ( {{ \Carbon\Carbon::parse($invoice->start_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($invoice->end_date)->subDay()->format('M d, Y') }} )</td>
                    <td>$ {{ $invoice->total_amount }}</td>
                    <td style="text-align: center;">
                        <div class="account_status_disp">{{ $invoice->payment_status }}</div>
                    </td>                    
                    <td>
                        <!-- View Invoice -->
                        <a href="{{ route('invoice.view', $invoice->invoice_id) }}"
                            class="btn btn-primary"
                            style="padding: 0.2rem 0.4rem; font-size: 0.75rem;" title="View Invoice">
                                <i class="far fa-eye"></i>
                        </a>
                        <!-- Download Invoice -->
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

    <script>
        // Function to format date as "07 Feb 2025, 11:38 AM"
        function formatDate(dateString) {
            if (!dateString) return "N/A"; // Handle empty dates gracefully
            
            let date = new Date(dateString);
            if (isNaN(date.getTime())) return "Invalid Date"; // Handle invalid dates
            
            let day = String(date.getDate()).padStart(2, '0'); // Two-digit day
            let month = date.toLocaleString("en-US", { month: "short" }); // Short month name
            let year = date.getFullYear();

            return `${day} ${month}, ${year}`;
        }


        $(document).ready(function() {
            // Apply date formatting
            $(".date-format").each(function() {
                let originalDate = $(this).text().trim();
                if (originalDate) {
                    $(this).text(formatDate(originalDate));
                }
            });

        $(document).ready(function() {
            // Initialize DataTable and assign it to a variable
            var table = $('#all-cust-table').DataTable({
                "paging": true,
                "pagingType": "full_numbers",
                "lengthChange": false,
                "pageLength": 15,
                "dom": '<"top"fip><"clear">',
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "No entries available",
                    "emptyTable": "No data available in the table",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                }
            });

            // Province filter - column index 2 is the Province column
            $('#province-filter').on('change', function() {
                let province = $(this).val();
                if (province) {
                    table.column(2).search('^' + $.fn.dataTable.util.escapeRegex(province) + '$', true, false).draw();
                } else {
                    table.column(2).search('').draw();
                }
            });

            // Payment Status filter - column index 6 is the Payment Status column
            $('#status-filter').on('change', function() {
                let status = $(this).val();
                if (status) {
                    table.column(6).search('^' + $.fn.dataTable.util.escapeRegex(status) + '$', true, false).draw();
                } else {
                    table.column(6).search('').draw();
                }
            });

        });

        });

        document.addEventListener("DOMContentLoaded", function () {
            // Define status colors
            const statusColors = {
                "Paid": "#24ba474c",       // Green
                "Unpaid": "#dc35463a",   // Red
            };

            // Apply background color to status elements
            document.querySelectorAll(".account_status_disp").forEach(function (el) {
                let statusText = el.textContent.trim();
                if (statusColors[statusText]) {
                    el.style.backgroundColor = statusColors[statusText];
                    el.style.padding = "3px 14px";
                    el.style.borderRadius = "15px";
                }
            });
        });
    </script>
</x-app-layout>
