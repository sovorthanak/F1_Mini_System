<x-app-layout>
    
    <style>
        /* Overlay background */
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.45);
            display: none; 
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        
        /* Modal Box */
        .custom-modal {
            background: #ececec;
            width: 700px;
            max-width: 90%;
            padding: 0;
            border-radius: 12px;
            animation: fadeIn 0.25s ease-in-out;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        /* Header */
        .custom-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #1f559d; /* blue */
            color: white;
            padding: 12px 18px;
        }
        
        .custom-modal-header h3 {
            margin: 0;
            font-size: 20px;
        }
        
        .modal-close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 26px;
            cursor: pointer;
            padding: 0;
        }
        
        .custom-modal-body {
            padding: 20px;
            max-height: 60vh;
            overflow-y: auto;
        }
        
        /* Footer */
        .custom-modal-footer {
            padding: 12px 20px;
            background: #f5f5f5;
            text-align: right;
        }
        
        .modal-close-button {
            background: #ef4444;
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }
        
        .modal-close-button:hover {
            background: #dc2626;
        }
        
        /* View Button */
        .btn-view {
            background: #2563eb;
            color: white;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }
        
        .btn-view i {
            margin-right: 4px;
        }
        
        .btn-view:hover {
            background: #1e4fd6;
        }

        .modal-complete-button:hover {
            background: #047857 !important;
        }

        .modal-complete-button:disabled {
            background: #9ca3af !important;
            cursor: not-allowed !important;
        }
        
        .custom-modal-overlay.show{
          display:flex !important;
        }
        
        .modal-cancel-btn:hover {
            background:#e5e7eb !important;
            border-color:#d1d5db !important;
        }
        
        .modal-delete-btn:hover {
            background:#b91c1c !important;
            box-shadow:0 4px 12px rgba(220, 38, 38, 0.4) !important;
        }
        
        .modal-delete-btn:disabled {
            background:#9ca3af !important;
            cursor:not-allowed !important;
            box-shadow:none !important;
        }
        
        #deleteExtraInfo > div {
            background:#f9fafb !important;
            border:1px solid #e5e7eb !important;
            border-radius:8px !important;
            padding:12px !important;
        }
        
        #deleteExtraInfo strong {
            color:#111827;
            font-weight:600;
        }
        
        #deleteExtraInfo div > div {
            color:#6b7280;
            font-size:13px;
        }

        
        /* Fade animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
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
        <h4>Schedule Request
            <span>

            </span>
        </h4>
    </div>
    <div class="cust-row">
        <div class="cust-row-box total-cust">
            <div class="cust-icon">
                <i class="fa fa-user" aria-hidden="true"></i>
            </div>
            <div class="cust-num">
                <p>Pending Tasks:</p>
                <h1 id="pendingCount"></h1>
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
                    <th>Location</th>
                    <th>Request At</th>
                    <th>Created By</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    
    <!-- Custom Modal -->
    <div id="requestDetailModal" class="custom-modal-overlay">
        <div class="custom-modal">
            <div class="custom-modal-header">
                <h3>Request Details</h3>
                <button class="modal-complete-button" id="completeRequestBtn" onclick="completeRequest()" style="background: #059669; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; margin-right: 10px; font-weight: 500;">
                    <i class="fa fa-check"></i> Complete Request
                </button>
            </div>

            <div class="custom-modal-body" id="modalContent">
                Loading...
            </div>

            <div class="custom-modal-footer">
            <button class="modal-close-button" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>
    
    <!-- Confirm Delete Modal -->
    <div id="deleteConfirmModal" class="custom-modal-overlay">
      <div class="custom-modal" style="width:480px; max-width:92%;">
        <!-- Warning Icon Header -->
        <div style="text-align:center; padding:24px 24px 0 24px;">
          <div style="width:64px; height:64px; margin:0 auto 16px; background:linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 12px rgba(220, 38, 38, 0.2);">
            <i class="fas fa-exclamation-triangle" style="font-size:28px; color:#dc2626;"></i>
          </div>
          <h3 style="margin:0 0 8px 0; font-size:22px; color:#111827; font-weight:600;">Delete Request</h3>
          <p style="margin:0; color:#6b7280; font-size:14px;">This action cannot be undone</p>
        </div>
    
        <div class="custom-modal-body" style="padding:20px 24px;">
    
          <div id="deleteExtraInfo" style="margin-top:16px;"></div>
        </div>
    
        <div class="custom-modal-footer" style="display:flex; gap:12px; justify-content:center; padding:16px 24px 24px 24px; background:transparent;">
          <button type="button"
            class="modal-cancel-btn"
            onclick="closeDeleteModal()"
            style="flex:1; padding:10px 20px; background:#f3f4f6; color:#374151; border:1px solid #e5e7eb; border-radius:8px; font-size:14px; font-weight:500; cursor:pointer; transition:all 0.2s;">
            <i class="fas fa-times" style="margin-right:6px;"></i>Cancel
          </button>
    
          <button type="button"
            id="confirmDeleteBtn"
            class="modal-delete-btn"
            style="flex:1; padding:10px 20px; background:#dc2626; color:white; border:none; border-radius:8px; font-size:14px; font-weight:500; cursor:pointer; transition:all 0.2s; box-shadow:0 2px 8px rgba(220, 38, 38, 0.3);">
            <i class="fas fa-trash-alt" style="margin-right:6px;"></i>Delete
          </button>
        </div>
      </div>
    </div>

    <script>
        // Store current request ID globally
        let currentRequestId = null;
        let currentRequestData = null;

        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('IP addresses copied to clipboard!');
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }

        $(document).ready(function () {

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
                processing: false,
                deferRender: true,

                ajax: {
                    url: "/api/request-change/schedule",
                    dataSrc: function (json) {
                
                        // Count pending tasks from the API response
                        let pendingCount = json.data.length;
                
                        // Display count
                        $('#pendingCount').text(pendingCount);
                
                        return json.data;
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
                        data: "customer.customer_id",
                        className: "text-center",
                        render: function (data) {
                            return `<a href="/customers/${data}/view-details">${data}</a>`;
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
                            let tariff = row.customer.tariff_name || "---";
                            let bandwidth = row.customer.bandwidth || "---";
                            return `${tariff} ${bandwidth}`;
                        }
                    },
                    
                    {
                        data: "customer.province",        // or "customer.location" depending on your API
                        visible: true,                   // hidden but searchable
                        searchable: true,
                        defaultContent: ""
                    },  

                    {
                        data: "date",
                        className: "text-center"
                    },

                    {
                        data: "created_by",
                        className: "text-left",
                        render: d => d || "---"
                    },
                    {
                        data: "status",
                        className: "text-left",
                        render: d => d || "---"
                    },
                    {
                        data: null,
                        className: "text-center",
                        render: row => `
                          <button class="btn-view" onclick="showDetails(${row.id})">
                            <i class="fa fa-eye"></i> View
                          </button>
                          &nbsp;
                        
                          <form
                            action="/request-change/${row.id}"
                            method="POST"
                            class="delete-form"
                            data-id="${row.id}"
                            data-customer="${(row.customer && row.customer.customer_name) ? row.customer.customer_name : ''}"
                            data-type="${row.request_type || ''}"
                            style="display:inline;"
                          >
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-danger btn-sm" style="padding: 0.2rem 0.4rem; font-size: 0.75rem;">
                              <i class="fas fa-trash"></i>
                            </button>
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
                table.column(1).search(val ? '^' + val + '$' : '', true, false).draw();
            });
            
            $('#pppoeSearch').on('keyup', function () {
                table.column(4).search(this.value).draw();
            });
            
            $('#ipSearch').on('keyup', function () {
                // Search in the Info column (column 7) for IP addresses
                table.column(7).search(this.value).draw();
            });
            
            $('#location-filter').on('change', function () {
                const val = $(this).val();

                // Location column index = 9 (because we inserted it before Action)
                table.column(6).search(val ? '^' + $.fn.dataTable.util.escapeRegex(val) + '$' : '', true, false).draw();
            });

            // FIXED: Date range filter - checking correct column index (8 for "Request At")
            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                let min = $('#minDate').val();
                let max = $('#maxDate').val();
                
                // data[8] is the "Request At" column (0-indexed)
                let requestDateStr = data[6];
                
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
            
            $('#minDate, #maxDate').on('change', () => table.draw());

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

        });

        function showDetails(id) {
            // Store the request ID globally
            currentRequestId = id;
            
            $('#modalContent').html('<div style="text-align:center; padding:40px;"><div class="spinner"></div><p>Loading...</p></div>');
            $('#requestDetailModal').css('display', 'flex');
            
            // Enable the complete button by default
            $('#completeRequestBtn').prop('disabled', false);

            $.get(`/api/request-change/${id}`, function (response) {
                let item = response.data;
                
                // Store the complete request data globally
                currentRequestData = item;
                
                // Disable complete button if already completed
                if (item.status === 'Completed') {
                    $('#completeRequestBtn').prop('disabled', true);
                }
                
                let changeDetails = buildChangeDetails(item);

                let html = `
                    <div style="max-width: 800px; margin: 0 auto;">
                        <!-- Header Section -->
                        <div style="background: #1a3f6f;
                                    color: white; padding: 24px; margin: -20px -20px 20px -20px;">
                            <h2 style="margin: 0 0 8px 0; font-size: 24px;">${item.request_type || 'Request Details'}</h2>
                            <div style="display: flex; gap: 20px; align-items: center; flex-wrap: wrap;">
                                <span style="background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 6px; font-size: 14px;">
                                    <strong>Status:</strong> ${getStatusBadge(item.status)}
                                </span>
                                <span style="font-size: 14px; opacity: 0.9;">
                                    📅 ${item.formatted_created_at || 'N/A'}
                                </span>
                            </div>
                        </div>

                        <!-- Customer Information Section -->
                        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 10px;">
                            <h3 style="margin: 0 0 16px 0; color: #374151; font-size: 18px; border-bottom: 2px solid #667eea; padding-bottom: 8px;">
                                👤 Customer Information
                            </h3>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                                ${buildInfoCard('Customer ID', item.customer.customer_id)}
                                ${buildInfoCard('Customer Name', item.customer.customer_name)}
                                ${buildInfoCard('PPPOE', item.customer.pppoe)}
                                ${buildInfoCard('Current Tariff', `${item.customer.tariff_name || '---'} ${item.customer.bandwidth || ''}`)}
                                ${buildInfoCard('Remark', item.customer.remark || item.remark)}
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div style="background: #fffbeb; padding: 16px; border-radius: 8px; border-left: 4px solid #f59e0b; margin-bottom: 10px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                                <div>
                                    <small style="color: #92400e; font-weight: 600;">Created By</small>
                                    <p style="margin: 4px 0 0 0; color: #78350f; font-weight: 500;">${item.created_by || '---'}</p>
                                </div>
                                <div style="text-align: right;">
                                    <small style="color: #92400e; font-weight: 600;">Request ID</small>
                                    <p style="margin: 4px 0 0 0; color: #78350f; font-weight: 500;">#${id}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Change Details Section -->
                        <div style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #e5e7eb;">
                            <h3 style="margin: 0 0 16px 0; color: #374151; font-size: 18px; border-bottom: 2px solid #667eea; padding-bottom: 8px;">
                                🔄 Change Details
                            </h3>
                            ${changeDetails}
                        </div>
                    </div>
                `;

                $('#modalContent').html(html);
            }).fail(function() {
                $('#modalContent').html('<div style="text-align:center; padding:40px; color:#dc2626;"><p>❌ Failed to load request details</p></div>');
                $('#completeRequestBtn').prop('disabled', true);
            });
        }

        // Function to complete the request
        function completeRequest() {
            if (!currentRequestId || !currentRequestData) {
                alert('No request data available');
                return;
            }
            
            // Confirm before proceeding
            if (!confirm('Are you sure you want to complete this request?')) {
                return;
            }
            
            // Disable button and show loading state
            let btn = $('#completeRequestBtn');
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
            
            // Prepare data to send to backend
            let requestData = {
                id: currentRequestId,
                request_type: currentRequestData.request_type,
                customer_id: currentRequestData.customer.customer_id,
                
                // Old values
                old_customer_name: currentRequestData.old_customer_name,
                old_tariff: currentRequestData.old_tariff,
                old_bandwidth: currentRequestData.old_bandwidth,
                old_address: currentRequestData.old_address,
                old_province: currentRequestData.old_province,
                old_ip_address: currentRequestData.old_ip_address,
                old_remark: currentRequestData.old_remark,
                old_customer_status: currentRequestData.old_customer_status,
                
                // New values
                new_customer_name: currentRequestData.new_customer_name,
                new_tariff: currentRequestData.new_tariff,
                new_bandwidth: currentRequestData.new_bandwidth,
                new_address: currentRequestData.new_address,
                new_province: currentRequestData.new_province,
                new_ip_address: currentRequestData.new_ip_address,
                new_remark: currentRequestData.new_remark,
                new_customer_status: currentRequestData.new_customer_status,
                
                // Additional info
                status: 'Completed',
                _token: $('meta[name="csrf-token"]').attr('content') // Laravel CSRF token
            };
            
            // Send POST request to Laravel backend
            $.ajax({
                url: '/api/request-change/complete', // Change this to your Laravel route
                method: 'POST',
                data: requestData,
                dataType: 'json',
                success: function(response) {
                    alert('Request completed successfully!');
                    
                    // Close modal
                    closeModal();
                    
                    // Reload the DataTable
                    $('#all-cust-table').DataTable().ajax.reload();
                    
                    // Reset button state
                    btn.prop('disabled', false).html('<i class="fa fa-check"></i> Complete Request');
                },
                error: function(xhr, status, error) {
                    console.error('Error completing request:', error);
                    
                    let errorMessage = 'Failed to complete request. Please try again.';
                    
                    // Try to get error message from response
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    alert(errorMessage);
                    
                    // Re-enable button
                    btn.prop('disabled', false).html('<i class="fa fa-check"></i> Complete Request');
                }
            });
        }

        function buildInfoCard(label, value) {
            return `
                <div>
                    <small style="color: #6b7280; font-size: 12px; text-transform: uppercase; font-weight: 600;">${label}</small>
                    <p style="margin: 6px 0 0 0; color: #111827; font-size: 15px; font-weight: 500;">
                        ${value || '---'}
                    </p>
                </div>
            `;
        }

        function getStatusBadge(status) {
            const statusColors = {
                'Pending': '#fbbf24',
                'Approved': '#34d399',
                'Rejected': '#f87171',
                'Completed': '#60a5fa'
            };
            const color = statusColors[status] || '#9ca3af';
            return `<span style="background: ${color}; color: white; padding: 2px 8px; border-radius: 4px; font-weight: 600;">${status || 'Unknown'}</span>`;
        }

        function buildChangeDetails(item) {
            let content = '';

            // Upgrade / Downgrade / Change Service
            if (['Upgrade', 'Downgrade', 'Change Service'].includes(item.request_type)) {
                content = buildComparisonView([
                    {
                        field: 'Customer Name',
                        oldValue: `${item.old_customer_name || '---'}`,
                        newValue: `${item.new_customer_name || item.old_customer_name}`,
                        icon: '👤'
                    },
                    {
                        field: 'Tariff Plan',
                        oldValue: `${item.old_tariff || '---'} ${item.old_bandwidth || ''}`,
                        newValue: `${item.new_tariff || '---'} ${item.new_bandwidth || ''}`,
                        icon: '📦'
                    }
                ]);
            }

            // Relocation
            else if (item.request_type === 'Relocation') {
                content = buildComparisonView([
                    {
                        field: 'Customer Name',
                        oldValue: `${item.old_customer_name || '---'}`,
                        newValue: `${item.new_customer_name || item.old_customer_name}`,
                        icon: '👤'
                    },
                    {
                        field: 'Address',
                        oldValue: item.old_address || '---',
                        newValue: item.new_address || '---',
                        icon: '🏘️'
                    },
                    {
                        field: 'Province',
                        oldValue: item.old_province || '---',
                        newValue: item.new_province || '---',
                        icon: '📍'
                    }
                ]);
            }

            // Add / Change IP
            else if (['Add IP Address', 'Change IP Address', 'Remove IP Address'].includes(item.request_type)) {
                content = buildComparisonView([
                    {
                        field: 'Customer Name',
                        oldValue: `${item.old_customer_name || '---'}`,
                        newValue: `${item.new_customer_name || item.old_customer_name}`,
                        icon: '👤'
                    },
                    {
                        field: 'IP Address',
                        oldValue: formatIpAddresses(item.old_ip_address) || 'No IPs',
                        newValue: formatIpAddresses(item.new_ip_address) || '---',
                        icon: '🌐'
                    }
                ]);
            }

            // Change Remark
            else if (item.request_type === 'Change Remark') {
                content = buildComparisonView([
                    {
                        field: 'Customer Name',
                        oldValue: `${item.old_customer_name || '---'}`,
                        newValue: `${item.new_customer_name || item.old_customer_name}`,
                        icon: '👤'
                    },
                    {
                        field: 'Remark',
                        oldValue: item.old_remark || '---',
                        newValue: item.new_remark || '---',
                        icon: '📝'
                    }
                ]);
            }

            // Change Status (Deactivate / Reactivate / Termination)
            else if (['Deactivate', 'Reactivate', 'Termination'].includes(item.request_type)) {
                content = buildComparisonView([
                    {
                        field: 'Customer Name',
                        oldValue: `${item.old_customer_name || '---'}`,
                        newValue: `${item.new_customer_name || item.old_customer_name}`,
                        icon: '👤'
                    },

                    {
                        field: 'Customer Status',
                        oldValue: item.old_customer_status || '---',
                        newValue: item.new_customer_status || '---',
                        icon: '🔄'
                    }
                ]);
            }

            // Default
            else {
                content = '<p style="text-align:center; color:#6b7280; padding:20px;">No change details available</p>';
            }

            return content;
        }

        function buildComparisonView(changes) {
            let html = '';
            
            changes.forEach((change, index) => {
                html += `
                    <div style="background: #f9fafb; padding: 10px; border-radius: 8px;">
                        <div style="display: flex; align-items: center; margin-bottom: 12px;">
                            <span style="font-size: 20px; margin-right: 8px;">${change.icon}</span>
                            <strong style="color: #374151; font-size: 14px;">${change.field}</strong>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 12px; align-items: center;">
                            <div style="background: white; padding: 12px; border-radius: 6px; border: 1px solid #e5e7eb;">
                                <small style="color: #6b7280; font-size: 11px; text-transform: uppercase;">From</small>
                                <p style="margin: 4px 0 0 0; color: #dc2626; font-weight: 500; word-break: break-word;">
                                    ${change.oldValue}
                                </p>
                            </div>
                            <div style="color: #667eea; font-size: 20px; font-weight: bold;">→</div>
                            <div style="background: white; padding: 12px; border-radius: 6px; border: 1px solid #e5e7eb;">
                                <small style="color: #6b7280; font-size: 11px; text-transform: uppercase;">To</small>
                                <p style="margin: 4px 0 0 0; color: #059669; font-weight: 500; word-break: break-word;">
                                    ${change.newValue}
                                </p>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            return html;
        }
        
        function closeModal() {
            document.getElementById('requestDetailModal').style.display = "none";
            // Reset global variables
            currentRequestId = null;
            currentRequestData = null;
        }

        function formatIpAddresses(ipString) {
            if (!ipString || ipString.trim() === '') {
                return null;
            }
            
            // Split by comma and clean up whitespace
            const ips = ipString.split(',').map(ip => ip.trim()).filter(ip => ip);
            
            if (ips.length === 0) {
                return null;
            }
            
            // Format as HTML with styling
            return ips.map(ip => 
                `<span style="display: inline-block; background: #e0e7ff; color: #3730a3; padding: 4px 10px; border-radius: 4px; margin: 2px 4px 2px 0; font-family: monospace; font-size: 13px;">${ip}</span>`
            ).join('');
        }
        
        let pendingDeleteForm = null;

        function openDeleteModal(formEl) {
          pendingDeleteForm = formEl;
        
          // Optional: show some info inside modal
          const id = $(formEl).data('id');
          const customer = $(formEl).data('customer');
          const type = $(formEl).data('type');
        
          let infoHtml = `
            <div style="background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:10px;">
              <div style="display:flex; gap:10px; flex-wrap:wrap; font-size:13px;">
                <div>ID: <strong>#${id}</strong></div>
                ${type ? `<div>Type: <strong>${type}</strong></div>` : ``}
                ${customer ? `<div>Customer: <strong>${customer}</strong></div>` : ``}
              </div>
            </div>
          `;
          $('#deleteExtraInfo').html(infoHtml);
        
          $('#deleteConfirmModal').addClass('show');
        }
        
        function closeDeleteModal() {
          $('#deleteConfirmModal').removeClass('show');
          pendingDeleteForm = null;
        
          // reset button state
          $('#confirmDeleteBtn')
            .prop('disabled', false)
            .html('<i class="fas fa-trash"></i> Delete');
        }
        
        // Event delegation (works with DataTables redraw)
        $(document).on('submit', 'form.delete-form', function (e) {
          e.preventDefault();
          openDeleteModal(this);
        });
        
        // Confirm button submits the original form
        $(document).on('click', '#confirmDeleteBtn', function () {
          if (!pendingDeleteForm) return;
        
          $(this)
            .prop('disabled', true)
            .html('<i class="fa fa-spinner fa-spin"></i> Deleting...');
        
          pendingDeleteForm.submit();
        });
        
        // Close modal when clicking overlay background
        $(document).on('click', '#deleteConfirmModal', function (e) {
          if (e.target.id === 'deleteConfirmModal') closeDeleteModal();
        });
        
        // ESC to close
        $(document).on('keydown', function (e) {
          if (e.key === 'Escape') closeDeleteModal();
        });

    </script>

</x-app-layout>