@extends('layouts.next-month-invoices')

@section('content')
    <style>
        .overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .overlay-content {
            background: white;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px; height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .error-message {
            color: #dc3545;
            font-weight: 500;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="card-header"><h4>Next Month Invoices</h4></div>

    <div class="cust-row">
        <div class="cust-row-box total-cust">
            <div class="cust-icon"><i class="fa fa-user"></i></div>
            <div class="cust-num">
                <p>Total Statements:</p>
                <h1>{{ str_pad($total, 4, '0', STR_PAD_LEFT) }}</h1>
            </div>
        </div>
        <div class="cust-row-box active-cust">
            <div class="cust-icon"><i class="fa-solid fa-dollar-sign"></i></div>
            <div class="cust-num unpaid-cust">
                <p>Total Unpaid Amount:</p>
                <h1>${{ number_format($totalAmount ?? 100.00, 2) }}</h1>
            </div>
        </div>
    </div>

    <div class="card-header">
        <div style="display: flex; align-items: center;">
            <label for="province-filter">Filter by Province: </label>
            <select id="province-filter" class="form-control" style="width: 200px; margin: 0 10px;">
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
            <a href="#" class="btn btn-info" id="download-all-invoices">Download All as ZIP</a>
        </div>
    </div>

    @foreach ([
        'order-type-update-status',
        'order-type-add-success',
        'delete-success'
    ] as $msg)
        @if (session($msg))
            <div class="alert alert-success">{{ session($msg) }}</div>
        @endif
    @endforeach

    <div class="overlay" id="download-overlay">
        <div class="overlay-content">
            <h3 id="overlay-title">Preparing Download</h3>
            <div class="spinner" id="download-spinner"></div>
            <p id="overlay-message">Generating ZIP file with selected invoices...</p>
            <br>
            <button class="close-btn" id="close-overlay" style="display: none;">Close</button>
        </div>
    </div>

    <div class="card mt-3">
        <table class="table table-bordered table-striped" id="all-cust-table" style="font-size: 15px;">
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Customer Name</th>
                    <th>Location</th>
                    <th>Tariff</th>
                    <th>Bill Cycle</th>
                    <th>Start Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td class="text-center">
                            <a href="{{ route('invoice.view', ['invoiceId' => $invoice->invoice_id]) }}">
                                {{ $invoice->invoice_id }}
                            </a>
                        </td>
                        <td>{{ $invoice->customer_name }}</td>
                        <td>{{ $invoice->customer->province }}</td>
                        <td>{{ $invoice->tariff_name }} {{ $invoice->bandwidth }}</td>
                        <td>{{ $invoice->bill_cycle }} Month(s)</td>
                        <td class="date-format">{{ $invoice->start_date }}</td>
                        <td>${{ $invoice->total_amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const overlay = document.getElementById('download-overlay');
            const spinner = document.getElementById('download-spinner');
            const title = document.getElementById('overlay-title');
            const message = document.getElementById('overlay-message');
            const provinceFilter = document.getElementById('province-filter');
            const downloadBtn = document.getElementById('download-all-invoices');
        
            if (!downloadBtn) return;
        
            downloadBtn.addEventListener('click', async function (e) {
                e.preventDefault();
        
                if (!provinceFilter || provinceFilter.selectedOptions.length === 0) {
                    alert("Please select a province.");
                    return;
                }
        
                const provinceText = provinceFilter.selectedOptions[0].text || "All Provinces";
                const provinceValue = provinceFilter.value.trim();
                const confirmMessage = `Are you sure you want to download invoices in "${provinceText}" as a ZIP file?`;
                if (!confirm(confirmMessage)) return;
        
                overlay.style.display = 'flex';
                spinner.style.display = 'block';
                title.textContent = 'Preparing Download';
                message.textContent = 'Generating ZIP file... Please wait.';
        
                const query = provinceValue ? `?province=${encodeURIComponent(provinceValue)}&cb=${Date.now()}` : `?cb=${Date.now()}`;
        
                const startTime = Date.now();
        
                try {
                    const response = await fetch(`/invoices/download-all-zip${query}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
        
                    if (!response.ok) {
                        throw new Error('Failed to start ZIP generation.');
                    }
        
                    const data = await response.json();
                    const downloadUrl = data.download_url;
                    const zipFileName = data.zip_file_name || 'invoices.zip';
        
                    const maxTries = 1200; // 1200 * 6s = 7200s = 2 hours
                    let attempt = 0;
                    const interval = 6000;
        
                    const pollForZip = async () => {
                        attempt++;
        
                        const elapsed = Math.round((Date.now() - startTime) / 60000);
                        message.textContent = `Still processing... (${elapsed} min elapsed). Please keep this tab open.`;
        
                        try {
                            const res = await fetch(downloadUrl, { method: 'HEAD' });
                            if (res.ok) {
                                spinner.style.display = 'none';
                                message.textContent = 'Download starting...';
        
                                const a = document.createElement('a');
                                a.href = downloadUrl;
                                a.download = zipFileName;
                                document.body.appendChild(a);
                                a.click();
                                a.remove();
        
                                overlay.style.display = 'none';
                            } else {
                                if (attempt < maxTries) {
                                    setTimeout(pollForZip, interval);
                                } else {
                                    throw new Error('ZIP not ready after 2 hours. Please try again later.');
                                }
                            }
                        } catch (err) {
                            title.textContent = 'Error';
                            message.textContent = err.message || 'An error occurred during polling.';
                            message.classList.add('error-message');
                            spinner.style.display = 'none';
                        }
                    };
        
                    setTimeout(pollForZip, 2000);
        
                } catch (err) {
                    title.textContent = 'Error';
                    message.textContent = err.message || 'An error occurred. Please try again.';
                    message.classList.add('error-message');
                    spinner.style.display = 'none';
                }
            });
        });


        $(document).ready(function () {
            const formatDate = dateString => {
                let date = new Date(dateString);
                if (isNaN(date.getTime())) return dateString;
                let day = String(date.getDate()).padStart(2, '0');
                let month = date.toLocaleString('en-US', { month: 'short' });
                let year = date.getFullYear();
                return `${day} ${month}, ${year}`;
            };

            $('.date-format').each(function () {
                const originalDate = $(this).text().trim();
                $(this).text(formatDate(originalDate));
            });

            const table = $('#all-cust-table').DataTable({
                pageLength: 15,
                dom: '<"top"Bfip><"clear">',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: `Customer Statement for the month of ${new Date().toLocaleString('default', { month: 'long' })} ${new Date().getFullYear()}`,
                        text: 'Download Excel',
                        className: 'btn btn-primary',
                        exportOptions: {
                            columns: [0, 1, 2, 5, 6]
                        }
                    }
                ],
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                language: {
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries available",
                    emptyTable: "No matching records found",
                    paginate: {
                        first: "First", last: "Last", next: "Next", previous: "Previous"
                    }
                },
                columnDefs: [
                    { targets: 2, visible: true, searchable: true }
                ]
            });

            $('#province-filter').on('change', function () {
                const province = $(this).val();
                table.column(2).search(province ? '^' + $.fn.dataTable.util.escapeRegex(province) + '$' : '', true, false).draw();
            });
        });
    </script>
@endsection