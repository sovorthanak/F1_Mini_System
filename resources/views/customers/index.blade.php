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
    <h4>All Customers
        <span>
            {{-- <a href="customers/download" class="btn btn-primary float-end">Go to Download</a> --}} 
            @role('admin|Accounting|NOC')
            <a href="register" class="btn btn-primary float-end">Add New Customer</a>
            @endrole
        </span>
    </h4>
</div>
<div class="cust-row">
    <div class="cust-row-box total-cust">
        <div class="cust-icon">
            <i class="fa fa-user" aria-hidden="true"></i>
        </div>
        <div class="cust-num">
            <p>Total Customer:</p>
            <h1 id="total-customer-count">{{ str_pad($totalCustomers, 4, '0', STR_PAD_LEFT) }}</h1>
        </div>
    </div>
    <div class="cust-row-box active-cust">
        <div class="cust-icon">
            <i class="fa fa-check" aria-hidden="true"></i>
        </div>
        <div class="cust-num">
            <p>Active Customer:</p>
            <h1 id="active-customer-count">{{ str_pad($activeCustomers, 4, '0', STR_PAD_LEFT) }}</h1>
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

    <!-- Location Filter -->
    <div style="display: flex; align-items: center; gap: 10px;">
        <label for="location-filter">Location:</label>
        <select id="location-filter" class="form-control" style="width: 200px;">
            <option value="">All</option>
            @foreach ($locations as $location)
                <option value="{{ $location->name }}">{{ $location->name }}</option>
            @endforeach
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
    <div style="display:flex; align-items:center; gap:10px;">
        <label for="tariff-filter">Tariff:</label>
        <select id="tariff-filter" class="form-control" style="width: 400px;">
            <option value="">All</option>
            @foreach ($tariffs as $tariff)
                <option value="{{ $tariff->name }}">{{ $tariff->name }}</option>
            @endforeach
        </select>
    </div>

</div>


<div class="card-header" style="margin-bottom: 15px;">
    <button id="reset-filters" class="btn btn-danger">Reset Filters</button>
    <a href="#" id="btnDownloadExcel" class="btn btn-success">
        Download Excel (Filtered)
    </a>

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

  // ==========================================================
  // State
  // ==========================================================
  let lastDtParams = null;

  // ==========================================================
  // Helpers
  // ==========================================================
  function getQueryParam(name) {
    return new URLSearchParams(window.location.search).get(name);
  }

  function updateCustomerCounts(totalRecords, activeCount) {
    $('#total-customer-count').text(String(totalRecords).padStart(4, '0'));
    $('#active-customer-count').text(String(activeCount).padStart(4, '0'));
  }

  function applyStatusBadges() {
    const statusColors = {
      "Active": "#24ba474c",
      "Inactive": "#dc35463a",
      "Suspended": "#ff98003a",
      "Deactivated": "#f443363a",
      "Terminated": "#f443363a",
      "Pending": "#ffc1073a"
    };

    $(".account_status_disp").each(function () {
      const statusText = $(this).text().trim();
      if (statusColors[statusText]) {
        $(this).css({
          backgroundColor: statusColors[statusText],
          padding: "3px 14px",
          borderRadius: "15px"
        });
      }
    });
  }

  function applyDateFormatting() {
    $(".date-format").each(function () {
      const originalDate = $(this).attr('data-original-date') || $(this).text().trim();
      if (!originalDate) return;

      const date = new Date(originalDate);
      if (isNaN(date.getTime())) {
        $(this).text("N/A");
        return;
      }

      const day = String(date.getDate()).padStart(2, '0');
      const month = date.toLocaleString("en-US", { month: "long" });
      const year = date.getFullYear();
      $(this).text(`${day} ${month}, ${year}`);
    });
  }

  // ==========================================================
  // Apply URL params -> filter inputs (for dashboard chart clicks)
  // ==========================================================
  const initialLocation = getQueryParam('location');
  const initialStatus   = getQueryParam('status');
  const initialMinDate  = getQueryParam('min_date');
  const initialMaxDate  = getQueryParam('max_date');
  const initialTariff   = getQueryParam('tariff');

  if (initialLocation) $('#location-filter').val(initialLocation);
  if (initialStatus)   $('#status-filter').val(initialStatus);
  if (initialMinDate)  $('#min-date').val(initialMinDate);
  if (initialMaxDate)  $('#max-date').val(initialMaxDate);
  if (initialTariff)   $('#tariff-filter').val(initialTariff);

  // ==========================================================
  // DataTable Init
  // ==========================================================
  const table = $('#all-cust-table').DataTable({
    processing: true,
    serverSide: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    pageLength: 15,
    dom: '<"top"fip><"clear">',

    ajax: {
      url: "{{ route('customers.data') }}",
      type: "GET",
      data: function (d) {
        // ✅ Your custom filters (these must match controller keys)
        d.min_date  = $('#min-date').val() || '';
        d.max_date  = $('#max-date').val() || '';
        d.location  = $('#location-filter').val() || '';
        d.status    = $('#status-filter').val() || '';
        d.tariff    = $('#tariff-filter').val() || '';

        // ✅ Your custom "Search By" (backend reads column_index + column_search)
        d.column_index  = $('#column-select').val() || '';
        d.column_search = $('#column-search-input').val() || '';

        // ✅ store latest request (including DataTables search/order/page)
        lastDtParams = JSON.parse(JSON.stringify(d));
      },
      dataSrc: function (json) {
        const filtered = json.recordsFiltered ?? 0;
        const active   = json.activeCount ?? 0;
        updateCustomerCounts(filtered, active);
        return json.data;
      }
    },

    columns: [
      {
        data: 'customer_id',
        name: 'customer_id',
        defaultContent: '',
        className: 'text-center',
        render: function (data, type) {
          if (type === 'display') return `<a href="/customers/${data}/view-details">${data}</a>`;
          return data;
        }
      },
      { data: 'customer_name', name: 'customer_name', defaultContent: '', className: 'text-left' },
      { data: 'pppoe', name: 'pppoe', defaultContent: '---', className: 'text-center' },
      { data: 'router', name: 'router', defaultContent: '---', className: 'text-center' },
      { data: 'remark', name: 'remark', defaultContent: '---', className: 'text-center' },
      { data: 'province', name: 'province', defaultContent: '---', className: 'text-left' },
      {
        data: null,
        name: 'tariff_bandwidth',
        defaultContent: '',
        className: 'text-left',
        render: function (data, type, row) {
          return (row.tariff_name || '---') + ' ' + (row.bandwidth || '---');
        }
      },
      { data: 'agent', name: 'agent', defaultContent: '---', className: 'text-left' },
      {
        data: 'created_at',
        name: 'created_at',
        defaultContent: '',
        className: 'text-center',
        render: function (data, type) {
          // keep raw value for sort/search, format for display
          if (type === 'display' || type === 'filter') {
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
        render: function (data) {
          return `<div class="account_status_disp">${data ?? ''}</div>`;
        }
      },
      {
        data: null,
        name: 'action',
        orderable: false,
        searchable: false,
        className: 'text-center',
        render: function (data, type, row) {
          const id = row.customer_id;
          return `
            <a href="/customers/${id}/view-details" class="btn btn-primary" style="padding: 0.1rem 0.2rem; font-size: 0.75rem;" title="View">
              <i class="fas fa-eye"></i>
            </a>
            <a href="/customers/${id}/edit-details" class="btn btn-success" style="padding: 0.1rem 0.2rem; font-size: 0.75rem;" title="Edit">
              <i class="fas fa-edit"></i>
            </a>
            <a href="/request-change/create?customer_id=${id}" class="btn btn-warning" style="padding: 0.1rem 0.2rem; font-size: 0.75rem;" title="Request Change">
              <i class="fas fa-exchange-alt"></i>
            </a>
          `;
        }
      }
    ],

    // Fix: don't mutate row data in createdRow (can break sorting/search on server-side)
    createdRow: function () {},

    initComplete: function () {
      applyStatusBadges();
      applyDateFormatting();
    },

    drawCallback: function () {
      applyStatusBadges();
      applyDateFormatting();
    }
  });

  // ==========================================================
  // Events
  // ==========================================================

  // ✅ Your "Search By" should trigger server filtering via column_index + column_search
  // (Do NOT use table.column().search(...) because export/controller doesn't read it.)
    $('#column-search-input').on('input', function () {
      table.draw();
    });

      $('#column-select').on('change', function () {
        table.draw();
      });

  // Filters
    $('#location-filter, #status-filter, #min-date, #max-date, #tariff-filter').on('change', function () {
        table.draw();
    });

  // Keep last params updated on every request (covers global search/order/page)
    table.on('preXhr.dt', function (e, settings, data) {
        lastDtParams = JSON.parse(JSON.stringify(data));
    });

    // ==========================================================
    // Download Excel (use the exact DataTables params)
    // ==========================================================
let downloadDebounce = null;

// keep your debounce for searching
$('#column-search-input').on('input', function () {
  clearTimeout(downloadDebounce);
  downloadDebounce = setTimeout(() => table.draw(), 250);
});

$('#btnDownloadExcel').on('click', function (e) {
  e.preventDefault();

  // ✅ Always read the *current* values from the inputs
  // (don’t rely on lastDtParams, it may be stale if the table didn’t redraw yet)
  const exportParams = {
    min_date:  $('#min-date').val() || '',
    max_date:  $('#max-date').val() || '',
    location:  $('#location-filter').val() || '',
    status:    $('#status-filter').val() || '',
    tariff:    $('#tariff-filter').val() || '',

    column_index:  $('#column-select').val() || '',
    column_search: $('#column-search-input').val() || '',
  };

  const query = $.param(exportParams);
  window.location.href = "{{ route('customers.downloadExcel') }}?" + query;
});


    // ==========================================================
    // Reset filters
    // ==========================================================
    $('#reset-filters').on('click', function () {
    $('#column-search-input').val('');
    $('#column-select').val($('#column-select option:first').val());

    $('#location-filter').val('');
    $('#status-filter').val('');
    $('#min-date').val('');
    $('#max-date').val('');
    $('#tariff-filter').val('');

    // Reset DataTables global search too
    table.search('');

    // redraw
    table.draw();

    // also clean URL query (optional)
    // history.replaceState(null, '', window.location.pathname);
  });

});
</script>

</x-app-layout>