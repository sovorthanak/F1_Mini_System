<x-app-layout>

    <style>
        /* Alert Styles */
        .alert {
            padding: 12px 20px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 6px;
            font-size: 14px;
            line-height: 1.5;
        }

        .alert-success {
            color: #0f5132;
            background-color: #d1e7dd;
            border-color: #badbcc;
        }

        .alert-danger {
            color: #842029;
            background-color: #f8d7da;
            border-color: #f5c2c7;
        }

        .alert-danger strong {
            font-weight: 600;
        }

        .alert-success strong {
            font-weight: 600;
        }

        /* Tooltip Styles */
        .ip-tooltip-container {
            position: relative;
            display: inline-block;
        }

        .ip-tooltip-trigger {
            cursor: pointer;
            color: #3b82f6;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .ip-tooltip-trigger:hover {
            color: #2563eb;
        }

        .ip-tooltip-trigger .new-value {
            text-decoration: underline;
            text-decoration-style: dotted;
            text-decoration-color: #3b82f6;
            text-underline-offset: 2px;
        }

        .info-label {
            font-weight: 500;
        }

        .info-label.tariff-label {
            color: #8b5cf6; /* Purple */
        }

        .info-label.ip-label {
            color: #3b82f6; /* Blue */
        }

        .info-label.location-label {
            color: #ec4899; /* Pink */
        }

        .info-label.status-label {
            color: #10b981; /* Green */
        }

        .info-label.remark-label {
            color: #f59e0b; /* Amber */
        }

        .ip-tooltip-content {
            position: absolute;
            z-index: 9999;
            left: 0;
            top: 100%;
            margin-top: 4px;
            background-color: #1f2937;
            color: white;
            font-size: 13px;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
            padding: 12px;
            min-width: 300px;
            max-width: 500px;
            display: none;
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
            pointer-events: none;
        }

        .ip-tooltip-container:hover .ip-tooltip-content {
            display: block;
            animation: tooltipFadeIn 0.3s ease-in-out forwards;
            animation-delay: 0.3s;
            pointer-events: auto;
        }

        .text-left {
            text-align: left !important;
        }

        th[style*="text-align"] {
            text-align: center !important;
        }

        @keyframes tooltipFadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .ip-tooltip-content:hover {
            display: block;
            opacity: 1;
        }

        .ip-tooltip-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            border-bottom: 1px solid #374151;
            padding-bottom: 8px;
        }

        .ip-tooltip-header span {
            font-weight: 600;
        }

        .ip-copy-btn {
            font-size: 11px;
            background-color: #374151;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .ip-copy-btn:hover {
            background-color: #4b5563;
        }

        .ip-list {
            max-height: 200px;
            overflow-y: auto;
        }

        .ip-list-item {
            padding: 4px 8px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .ip-list-item:hover {
            background-color: #374151;
        }

        /* Scrollbar styling for tooltip */
        .ip-list::-webkit-scrollbar {
            width: 6px;
        }

        .ip-list::-webkit-scrollbar-track {
            background: #374151;
            border-radius: 3px;
        }

        .ip-list::-webkit-scrollbar-thumb {
            background: #6b7280;
            border-radius: 3px;
        }

        .ip-list::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>

    <!-- Ensure libraries are included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Add SheetJS for Excel export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <!-- Your HTML (unchanged, except for clarity) -->
    <div class="card-header">
        <h4>Request Change
            <span>
                <a href="{{ route('request-change.create') }}" class="btn btn-primary float-end">Create New Request</a>
                <button id="downloadExcel" class="btn btn-success float-end" style="margin-right: 10px;">
                    <i class="fa fa-download"></i> Download Excel
                </button>
            </span>
        </h4>
    </div>
    <div class="cust-row">
        <div class="cust-row-box total-cust">
            <div class="cust-icon">
                <i class="fa fa-user" aria-hidden="true"></i>
            </div>
            <div class="cust-num">
                <p>Total Request:</p>
                <h1 id="totalRequestCount">{{ $total_requests }}</h1>
            </div>
        </div>

    </div>

    @if (session('order-type-update-status'))
        <div class="alert alert-success">
            {{ session('order-type-update-status') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if (session('delete-success')) 
        <div class="alert alert-success">
            {{ session('delete-success') }}
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card-header" style="display: flex; align-items: center; gap: 30px;">
        <div>
            <label for="requestTypeFilter">Filter by Request Type:</label>
            <select id="requestTypeFilter" class="form-control" style="width: 200px; display: inline-block; margin-left: 10px;">
                <option value="">All</option>
                <option value="Upgrade">Upgrade</option>
                <option value="Downgrade">Downgrade</option>
                <option value="Change Service">Change Service</option>
                <option value="Deactivate">Deactivate</option>
                <option value="Reactivate">Reactivate</option>
                <option value="Termination">Termination</option>
                <option value="Relocation">Relocation</option>
                <option value="Add IP Address">Add IP Address</option>
                <option value="Change Ip Address">Change Ip Address</option>
                <option value="Change Remark">Change Remark</option>
            </select>
        </div>
        
        <div style="display: flex; align-items: center; gap: 10px;">
            <label for="location-filter">Location:</label>
            <select id="location-filter" class="form-control" style="width: 200px;">
                <option value="">All</option>
                @foreach ($locations as $location)
                    <option value="{{ $location->name }}">{{ $location->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="minDate">Request Date From:</label>
            <input type="date" id="minDate" class="form-control" style="display:inline-block; width: 200px; margin-left: 10px; margin-right: 10px;">

            <label for="maxDate">To:</label>
            <input type="date" id="maxDate" class="form-control" style="display:inline-block; width: 200px; margin-left: 10px;">
        </div>

    </div>
    
    <div class="card-header" style="margin-bottom: 15px; display: flex; align-items: center; gap: 30px;">
        <div>
            <label for="pppoeSearch">Search PPPOE:</label>
            <input type="text" id="pppoeSearch" class="form-control" 
                placeholder="Enter PPPOE..." 
                style="width: 200px; display:inline-block; margin-left:10px;">
        </div>
        <div>
            <label for="ipSearch">Search IP:</label>
            <input type="text" id="ipSearch" class="form-control" 
                placeholder="Enter IP..." 
                style="width: 200px; display:inline-block; margin-left:10px;">
        </div>
    </div>

    <div class="card">
        <table class="table table-bordered table-striped" id="all-cust-table" style="font-size: 15px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Request Type</th>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>PPPOE</th>
                    <th>Tariff</th>
                    <th>Old Customer Name</th>
                    <th style="text-align: center">Info</th>
                    <th>Request At</th>
                    <!--<th>Created At</th>-->
                    <th>Created By</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <script>
        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('IP addresses copied to clipboard!');
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }

        $(document).ready(function () {
            
            $.fn.dataTable.ext.errMode = 'throw';

            let table = $('#all-cust-table').DataTable({
                paging: true,
                pagingType: "full_numbers",
                lengthChange: false,
                pageLength: 15,
                dom: '<"top"fip><"clear">',
                searching: true,
                info: true,
                autoWidth: false,
                order: false,
                processing: true,
                serverSide: true,

                ajax: {
                    url: "/api/request-changes/data",
                    data: function (d) {
                        d.request_type = $('#requestTypeFilter').val();
                        d.pppoe = $('#pppoeSearch').val();
                        d.ip = $('#ipSearch').val();
                        d.location = $('#location-filter').val();
                        d.minDate = $('#minDate').val();
                        d.maxDate = $('#maxDate').val();
                    }
                },

                columns: [
                    {
                        data: "id",
                        className: "text-center"
                    },
                    {
                        data: "request_type",
                        className: "text-center",
                        render: function (data) {
                            return `<span><b>${data.charAt(0).toUpperCase() + data.slice(1)}</b></span>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let cid = row.customer?.customer_id || row.customer_id || "---";
                            return cid !== "---"
                                ? `<a href="/customers/${cid}/view-details">${cid}</a>`
                                : "---";
                        }
                    },
                    {
                        data: "customer.customer_name",
                        className: "text-left",
                        render: function(data) {
                            return data || "---";
                        }                
                    },
                    {
                        data: "customer.pppoe",
                        className: "text-center",
                        render: d => d || "---"
                    },
                    {
                        data: null, 
                        className: "text-center",
                        render: function(data, type, row) {
                                let tariff = row.customer?.tariff_name || "---";
                                let bandwidth = row.customer?.bandwidth || "---";
                            return `${tariff} ${bandwidth}`;
                        }
                    },
                    {
                        data: "old_customer_name",
                        className: "text-left",
                        render: d => d || "---"
                    },
                    {
                        data: null,
                        className: "text-left",
                        render: row => buildInfoColumn(row)
                    },
                    {
                        data: "date",
                        className: "text-center"
                    },
                    // {
                    //     data: "formatted_created_at",
                    //     className: "text-center"
                    // },
                    {
                        data: "created_by",
                        className: "text-left",
                        render: d => d || "---"
                    },
                    
                    {
                        data: null,
                        visible: false,
                        searchable: true,
                        render: function(data, type, row) {
                            return row.customer?.province || "";
                        }
                    },  

                    {
                        data: null,
                        className: "text-center",
                        render: row => `
                            <form action="/request-change/${row.id}" method="POST" onsubmit="return confirm('Delete?')" style="display:inline;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button class="btn btn-danger btn-sm" style="padding: 0.2rem 0.4rem; font-size: 0.75rem;"><i class="fas fa-trash"></i></button>
                            </form>
                        `
                    }
                ],

                initComplete: function () {
                    applyStyles();
                },
                drawCallback: function () {
                    applyStyles();
                }
            });

            // Download Excel with filters
            $('#downloadExcel').on('click', function() {
                downloadFilteredExcel();
            });

            // Column Filters & Search
            $('#requestTypeFilter').on('change', function () {
                let val = $(this).val();
                table.column(1).search(val ? '^' + val + '$' : '', true, false);
                table.ajax.reload();            
                
            });
            
            $('#pppoeSearch').on('keyup', function () {
                table.column(4).search(this.value);
                table.ajax.reload();
            });
            
            $('#ipSearch').on('keyup', function () {
                table.column(7).search(this.value);
                table.ajax.reload();
            });

            $('#location-filter').on('change', function () {
                const val = $(this).val();

                // Location column index = 9 (because we inserted it before Action)
                table.column(11).search(val ? '^' + $.fn.dataTable.util.escapeRegex(val) + '$' : '', true, false);
                table.ajax.reload();
            });
            
            // FIXED: Date range filter - checking correct column index (8 for "Request At")
            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                let min = $('#minDate').val();
                let max = $('#maxDate').val();
                
                // data[8] is the "Request At" column (0-indexed)
                let requestDateStr = data[8];
                
                if (!min && !max) return true;
                
                // Parse the date string (format: "DD MMM, YYYY" or "YYYY-MM-DD")
                let requestDate = new Date(requestDateStr);
                
                if (isNaN(requestDate.getTime())) return true;
                
                if (min) {
                    let minDate = new Date(min);
                    minDate.setHours(0, 0, 0, 0);
                    if (requestDate < minDate) return false;
                }
                
                if (max) {
                    let maxDate = new Date(max);
                    maxDate.setHours(23, 59, 59, 999);
                    if (requestDate > maxDate) return false;
                }
                
                return true;
            });
            
            $('#minDate, #maxDate').on('change', () => table.ajax.reload());

            // Styling & Date Formatting
            function applyStyles() {
                $(".date-format").each(function () {
                    let el = $(this);
                    let date = new Date(el.attr("data-original-date"));
                    if (!isNaN(date.getTime())) {
                        let day = String(date.getDate()).padStart(2, '0');
                        let month = date.toLocaleString("en-US", { month: "long" });
                        let year = date.getFullYear();
                        el.text(`${day} ${month}, ${year}`);
                    } else el.text("N/A");
                });

                $("#all-cust-table tbody tr").each(function () {
                    let row = $(this);
                    if (row.find('td:eq(5)').text().trim() !== "") {
                        row.css("background-color", "#f9f9f9");
                    }
                });
            }
            
            function updateTotalRequest() {
                let info = table.page.info(); 
                // info.recordsDisplay = filtered count
                // info.recordsTotal = total (no filter)
                $('#totalRequestCount').text(info.recordsDisplay);
            }
            
            // Update on every draw (filter/search/pagination)
            table.on('draw', function () {
                updateTotalRequest();
            });
            
            // Also update right after first load
            table.on('xhr', function () {
                updateTotalRequest();
            });

            // FIXED: Download Excel based on filtered data
            function downloadFilteredExcel() {
                $('#downloadExcel').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Downloading...');
                
                // Get filtered data from DataTable
                let filteredData = table.rows({ search: 'applied' }).data().toArray();
                
                if (filteredData.length === 0) {
                    alert('No data to export with current filters.');
                    $('#downloadExcel').prop('disabled', false).html('<i class="fa fa-download"></i> Download Excel');
                    return;
                }
                
                // Prepare Excel data
                let excelData = [];
                
                // Add headers
                excelData.push([
                    'ID',
                    'Request Type',
                    'Customer ID',
                    'Customer Name',
                    'PPPOE',
                    'Tariff',
                    'Old Customer Name',
                    'Info',
                    'Request At',
                    'Created At',
                    'Created By'
                ]);
                
                // Add filtered rows
                filteredData.forEach(function(row) {
                    let info = buildInfoText(row);
                    
                    excelData.push([
                        row.id,
                        row.request_type,
                        row.customer.customer_id,
                        row.customer.customer_name || '---',
                        row.customer.pppoe || '---',
                        `${row.customer.tariff_name || '---'} ${row.customer.bandwidth || ''}`.trim(),
                        row.old_customer_name || '---',
                        info,
                        row.date || 'N/A',
                        row.formatted_created_at || 'N/A',
                        row.created_by || '---'
                    ]);
                });
                
                // Create workbook and worksheet
                let wb = XLSX.utils.book_new();
                let ws = XLSX.utils.aoa_to_sheet(excelData);
                
                // Set column widths
                ws['!cols'] = [
                    {wch: 8},  // ID
                    {wch: 20}, // Request Type
                    {wch: 15}, // Customer ID
                    {wch: 25}, // Customer Name
                    {wch: 20}, // PPPOE
                    {wch: 20}, // Tariff
                    {wch: 25}, // Old Customer Name
                    {wch: 50}, // Info
                    {wch: 15}, // Request At
                    {wch: 15}, // Created At
                    {wch: 20}  // Created By
                ];
                
                // Add worksheet to workbook
                XLSX.utils.book_append_sheet(wb, ws, "Request Changes");
                
                // Generate filename with current date and filter info
                let today = new Date();
                let dateStr = today.getFullYear() + 
                            ('0' + (today.getMonth() + 1)).slice(-2) + 
                            ('0' + today.getDate()).slice(-2);
                
                let filterInfo = '';
                let requestType = $('#requestTypeFilter').val();
                if (requestType) filterInfo += '_' + requestType.replace(/\s+/g, '_');
                
                let filename = 'Request_Change_' + dateStr + filterInfo + '.xlsx';
                
                // Download file
                XLSX.writeFile(wb, filename);
                
                // Reset button state
                $('#downloadExcel').prop('disabled', false).html('<i class="fa fa-download"></i> Download Excel');
            }

            // Helper function to build info text for Excel
            function buildInfoText(row) {
                let type = row.request_type.toLowerCase();
                let info = '';
                
                switch(type) {
                    case 'upgrade':
                    case 'downgrade':
                    case 'change service':
                        let oldTariff = `${row.old_tariff || ''} ${row.old_bandwidth || ''}`.trim();
                        let newTariff = `${row.new_tariff || ''} ${row.new_bandwidth || ''}`.trim();
                        info = `Tariff: ${oldTariff || 'N/A'} → ${newTariff || 'N/A'}`;
                        break;
                        
                    case 'change ip address':
                    case 'add ip address':
                    case 'remove ip address':
                        info = `IP Address: ${row.old_ip_address || 'N/A'} → ${row.new_ip_address || 'N/A'}`;
                        break;
                        
                    case 'relocation':
                        info = `Location: ${row.old_address || 'N/A'} → ${row.new_address || 'N/A'}`;
                        break;
                        
                    case 'termination':
                    case 'reactivate':
                    case 'deactivate':
                        info = `Status: ${row.old_customer_status || 'N/A'} → ${row.new_customer_status || 'N/A'}`;
                        break;
                        
                    case 'change remark':
                        let oldRemark = row.old_remark ? row.old_remark.replace(/\n/g, ' ') : 'N/A';
                        let newRemark = row.new_remark ? row.new_remark.replace(/\n/g, ' ') : 'N/A';
                        info = `Remark: ${oldRemark} → ${newRemark}`;
                        break;
                        
                    default:
                        info = 'N/A';
                }
                
                return info;
            }
        });

        // Keep your existing buildInfoColumn function as is
        function buildInfoColumn(row) {
            let type = row.request_type.toLowerCase();

            switch (type) {
                case 'upgrade':
                case 'downgrade':
                case 'change service':
                    return `
                        <span class="info-label tariff-label">Tariff</span>: 
                        <span class="old-value">${row.old_tariff} ${row.old_bandwidth}</span> 
                        <span class="arrow">→</span> 
                        <span class="new-value">${row.new_tariff} ${row.new_bandwidth}</span>
                    `;

                case 'change ip address':
                case 'add ip address':
                case 'remove ip address':
                    let oldIps = row.old_ip_address || '';
                    let newIps = row.new_ip_address || '';

                    let oldIpArray = oldIps.split(',').map(ip => ip.trim()).filter(ip => ip);
                    let newIpArray = newIps.split(',').map(ip => ip.trim()).filter(ip => ip);

                    function formatIpArray(ipArray, allText, color = "") {
                        if (ipArray.length > 3) {
                            let displayText = ipArray.slice(0, 2).join(', ') + `... (${ipArray.length} IPs)`;
                            let tooltipContent = ipArray.map(ip => `<div class="ip-list-item">${ip}</div>`).join('');
                            return `
                                <div class="ip-tooltip-container" style="display: inline-block;">
                                    <span class="ip-tooltip-trigger">
                                        <span class="old-value" style="text-decoration: underline; text-decoration-style: dotted; text-underline-offset: 2px; color: ${color};">
                                            ${displayText}
                                        </span>
                                    </span>
                                    <div class="ip-tooltip-content">
                                        <div class="ip-tooltip-header">
                                            <span>${allText} (${ipArray.length})</span>
                                            <button class="ip-copy-btn" onclick="copyToClipboard('${ipArray.join(', ')}')">Copy All</button>
                                        </div>
                                        <div class="ip-list">${tooltipContent}</div>
                                    </div>
                                </div>
                            `;
                        } else {
                            return `<span class="old-value" style="color: ${color};">${ipArray.join(', ')}</span>`;
                        }
                    }

                    let oldIpDisplay = formatIpArray(oldIpArray, "All Old IP Addresses");
                    let newIpDisplay = formatIpArray(newIpArray, "All New IP Addresses", "green");

                    return `
                        <span class="info-label ip-label">IP Address</span>: 
                        ${oldIpDisplay} 
                        <span class="arrow">→</span> 
                        ${newIpDisplay}
                    `;

                case 'relocation':
                    return `
                        <span class="info-label location-label">Location</span>: 
                        <span class="old-value">${row.old_address}</span> 
                        <span class="arrow">→</span> 
                        <span class="new-value">${row.new_address}</span>
                    `;

                case 'termination':
                case 'reactivate':
                case 'deactivate':
                    return `
                        <span class="info-label status-label">Status</span>: 
                        <span class="old-value">${row.old_customer_status}</span> 
                        <span class="arrow">→</span> 
                        <span class="new-value">${row.new_customer_status}</span>
                    `;

                case 'change remark':
                    return `
                        <span class="info-label remark-label">Remark</span>: 
                        <span class="old-value">${row.old_remark ? row.old_remark.replace(/\n/g, '<br>') : ''}</span> 
                        <span class="arrow">→</span> 
                        <span class="new-value">${row.new_remark ? row.new_remark.replace(/\n/g, '<br>') : ''}</span>
                    `;

                default:
                    return `<span class="text-muted">N/A</span>`;
            }
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('IP addresses copied to clipboard!');
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>

</x-app-layout>