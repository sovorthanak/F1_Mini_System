<x-app-layout>

{{-- ✅ Make sure you have this in your main layout <head> --}}
{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

<!-- ================= REQUIRED LIBRARIES ================= -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

<style>
  /* ===== Updated Modal Styles ===== */
  .x-modal {
    position: fixed;
    inset: 0;
    display: none;
    z-index: 99999;
    align-items: center;
    justify-content: center;
  }
  .x-modal.is-open { display: flex; }

  .x-modal__backdrop {
    position: absolute;
    inset: 0;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(8px);
    animation: fadeIn 0.25s ease-out;
  }
  @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

  .x-modal__dialog {
    position: relative;
    width: min(540px, 92vw);
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    transform: scale(0.9);
    opacity: 0;
    animation: popIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
  }
  @keyframes popIn { to { transform: scale(1); opacity: 1; } }

  .x-modal__header {
    display: flex;
    gap: 16px;
    align-items: flex-start;
    padding: 28px 24px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    position: relative;
    overflow: hidden;
  }
  .x-modal__header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 180px;
    height: 180px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
  }

  .x-modal__icon {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.95);
    color: #059669;
    flex: 0 0 auto;
    font-size: 24px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 1;
  }

  .x-modal__titles { flex: 1; position: relative; z-index: 1; }
  .x-modal__titles h3 {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: #ffffff;
    letter-spacing: -0.3px;
  }
  .x-modal__titles p {
    margin: 6px 0 0;
    color: rgba(255, 255, 255, 0.9);
    font-size: 14px;
    line-height: 1.5;
  }

  .x-modal__close {
    margin-left: auto;
    border: none;
    background: rgba(255, 255, 255, 0.2);
    width: 32px;
    height: 32px;
    border-radius: 8px;
    font-size: 20px;
    line-height: 1;
    color: #ffffff;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 1;
  }
  .x-modal__close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg);
  }

  .x-modal__body { padding: 24px; }

  .x-modal__meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    padding: 18px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 14px;
    font-size: 14px;
    border: 1px solid #e2e8f0;
  }
  .x-modal__meta > div { display: flex; flex-direction: column; gap: 4px; }
  .x-modal__meta span {
    color: #64748b;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .x-modal__meta b {
    color: #0f172a;
    font-size: 15px;
    font-weight: 600;
  }
  @media(max-width: 520px) { .x-modal__meta { grid-template-columns: 1fr; } }

  .x-modal__msg {
    margin-top: 16px;
    padding: 14px 16px;
    border-radius: 12px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 500;
  }
  .x-modal__msg::before {
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    font-size: 16px;
  }
  .x-modal__msg.success {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.1) 100%);
    color: #047857;
    border: 1px solid rgba(16, 185, 129, 0.3);
  }
  .x-modal__msg.success::before { content: "\f058"; }

  .x-modal__msg.error {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.1) 100%);
    color: #b91c1c;
    border: 1px solid rgba(239, 68, 68, 0.3);
  }
  .x-modal__msg.error::before { content: "\f06a"; }

  .x-modal__footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 20px 24px 24px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
  }

  .x-btn {
    border: none;
    border-radius: 12px;
    padding: 11px 20px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
  }
  .x-btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
  }
  .x-btn:active::before { width: 300px; height: 300px; }

  .x-btn--ghost {
    background: #ffffff;
    color: #475569;
    border: 2px solid #e2e8f0;
  }
  .x-btn--ghost:hover { background: #f8fafc; border-color: #cbd5e1; }

  .x-btn--success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
  }
  .x-btn--success:hover {
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
    transform: translateY(-1px);
  }
  .x-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none !important; }

  .x-btn__spinner {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top-color: #ffffff;
    animation: spin 0.7s linear infinite;
  }
  @keyframes spin { to { transform: rotate(360deg); } }

  /* Action icons in table (your style) */
  .btn-complete {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
    width: 25px;
    height: 25px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
  }
  .btn-complete:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35); }
  .btn-complete:disabled {
    background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
  }

  .btn-delete{
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color:#fff;
    width: 25px;
    height: 25px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25);
    margin-left: 8px;
  }
  .btn-delete:hover{ transform: translateY(-2px); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35); }
  .btn-delete:disabled{
    background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
    cursor:not-allowed;
    transform:none;
    box-shadow:none;
  }
</style>

<!-- ================= HEADER ================= -->
<div class="card-header">
  <h4>Schedule New Register</h4>
</div>

<div class="cust-row">
  <div class="cust-row-box total-cust">
    <div class="cust-icon">
      <i class="fa fa-user" aria-hidden="true"></i>
    </div>
    <div class="cust-num">
      <p>Total Schedule:</p>
      <h1 id="total-customer-count"></h1>
    </div>
  </div>
</div>

<div class="card-header" style="display: flex; align-items: center; gap: 20px; flex-wrap:wrap;">
  <div style="display: flex; align-items: center; gap: 10px;">
    <label for="column-select" style="width: 150px;">Search By:</label>
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
    <input type="text" id="column-search-input" placeholder="Type to search..." class="form-control" style="min-width:300px;" />
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

  <!-- Date Range -->
  <div style="display: flex; align-items: center; gap: 10px;">
    <label for="min-date">From:</label>
    <input type="date" id="min-date" class="form-control" style="width: 180px;">
    <label for="max-date">To:</label>
    <input type="date" id="max-date" class="form-control" style="width: 180px;">
  </div>
</div>

<div class="card-header" style="margin-bottom: 15px;">
  <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
    <label for="tariff-filter">Tariff:</label>
    <select id="tariff-filter" class="form-control" style="width: 400px; max-width:100%;">
      <option value="">All</option>
      @foreach ($tariffs as $tariff)
        <option value="{{ $tariff->name }}">{{ $tariff->name }}</option>
      @endforeach
    </select>
  </div>
</div>

<div class="card-header" style="margin-bottom: 15px;">
  <button id="reset-filters" class="btn btn-danger">Reset Filters</button>
</div>

<!-- ================= TABLE ================= -->
<div class="card">
  <table id="all-cust-table" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
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
    <tbody></tbody>
  </table>
</div>

<!-- ================= COMPLETE MODAL ================= -->
<div id="completeModal" class="x-modal" aria-hidden="true">
  <div class="x-modal__backdrop"></div>

  <div class="x-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="xModalTitle">
    <div class="x-modal__header">
      <div class="x-modal__icon">
        <i class="fa-solid fa-circle-check"></i>
      </div>
      <div class="x-modal__titles">
        <h3 id="xModalTitle">Complete schedule?</h3>
        <p id="xModalDesc">This will mark the schedule as completed. You can’t undo this action.</p>
      </div>
      <button type="button" class="x-modal__close" aria-label="Close">&times;</button>
    </div>

    <div class="x-modal__body">
      <div class="x-modal__meta">
        <div><span>Customer ID:</span> <b id="xCustId">—</b></div>
        <div><span>Customer Name:</span> <b id="xCustName">—</b></div>
        <div><span>PPPOE:</span> <b id="xPPPOE">—</b></div>
      </div>

      <div id="xModalMsg" class="x-modal__msg" style="display:none;"></div>
    </div>

    <div class="x-modal__footer">
      <button type="button" class="x-btn x-btn--ghost" id="xCancelBtn">Cancel</button>
      <button type="button" class="x-btn x-btn--success" id="xConfirmBtn">
        <span class="x-btn__label">Yes, Complete</span>
        <span class="x-btn__spinner" style="display:none;"></span>
      </button>
    </div>
  </div>
</div>

<!-- ================= DELETE MODAL (same style) ================= -->
<div id="deleteModal" class="x-modal" aria-hidden="true">
  <div class="x-modal__backdrop"></div>

  <div class="x-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="xDeleteTitle">
    <div class="x-modal__header" style="background:linear-gradient(135deg,#ef4444 0%,#dc2626 100%);">
      <div class="x-modal__icon" style="color:#dc2626;">
        <i class="fa-solid fa-trash"></i>
      </div>
      <div class="x-modal__titles">
        <h3 id="xDeleteTitle">Delete schedule?</h3>
        <p id="xDeleteDesc">This will permanently delete the schedule. This action can’t be undone.</p>
      </div>
      <button type="button" class="x-modal__close" aria-label="Close">&times;</button>
    </div>

    <div class="x-modal__body">
      <div class="x-modal__meta">
        <div><span>Customer ID:</span> <b id="xDelCustId">—</b></div>
        <div><span>Customer Name:</span> <b id="xDelCustName">—</b></div>
        <div><span>PPPOE:</span> <b id="xDelPPPOE">—</b></div>
        <div><span>Action:</span> <b style="color:#dc2626;">Delete Schedule</b></div>
      </div>

      <div id="xDeleteMsg" class="x-modal__msg" style="display:none;"></div>
    </div>

    <div class="x-modal__footer">
      <button type="button" class="x-btn x-btn--ghost" id="xDelCancelBtn">Cancel</button>
      <button type="button" class="x-btn" id="xDelConfirmBtn" style="background:linear-gradient(135deg,#ef4444 0%,#dc2626 100%); color:#fff;">
        <span class="x-btn__label">Yes, Delete</span>
        <span class="x-btn__spinner" style="display:none;"></span>
      </button>
    </div>
  </div>
</div>

<!-- ================= SCRIPT ================= -->
<script>
$(document).ready(function () {

  let lastDtParams = {};
  let _completePayload = null;
  let _deletePayload = null;

  function csrfToken() {
    return $('meta[name="csrf-token"]').attr('content');
  }

  function updateCustomerCounts(totalRecords) {
    $('#total-customer-count').text(String(totalRecords).padStart(4, '0'));
  }

  function applyStatusBadges() {
    const statusColors = {
      "Active": "#24ba474c",
      "Inactive": "#dc35463a",
      "Suspended": "#ff98003a",
      "Deactivated": "#f443363a",
      "Terminated": "#f443363a",
      "Pending": "#ffc1073a",
      "Completed": "#24ba474c"
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
      if (isNaN(date.getTime())) { $(this).text("N/A"); return; }

      const day = String(date.getDate()).padStart(2, '0');
      const month = date.toLocaleString("en-US", { month: "long" });
      const year = date.getFullYear();
      $(this).text(`${day} ${month}, ${year}`);
    });
  }

  // ==========================================================
  // DataTable Init (Server-side)
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
      url: "{{ route('schedule.new-register.data') }}",
      type: "GET",
      data: function (d) {
        d.min_date  = $('#min-date').val() || '';
        d.max_date  = $('#max-date').val() || '';
        d.location  = $('#location-filter').val() || '';
        d.tariff    = $('#tariff-filter').val() || '';
        d.column_index  = $('#column-select').val() || '';
        d.column_search = $('#column-search-input').val() || '';

        lastDtParams = JSON.parse(JSON.stringify(d));
      },
      dataSrc: function (json) {
        updateCustomerCounts(json.recordsFiltered ?? 0);
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

          // ✅ You said you delete by customer_id
          const encodedRow = encodeURIComponent(JSON.stringify({
            id: row.customer_id ?? null,           // id = customer_id
            customer_id: row.customer_id ?? '—',
            customer_name: row.customer_name ?? '—',
            pppoe: row.pppoe ?? '—'
          }));

          return `
            <button type="button" class="btn-complete" title="Complete"
              onclick="openCompleteModal('${encodedRow}')">
              <i class="fa-solid fa-check"></i>
            </button>

            <button type="button" class="btn-delete" title="Delete"
              onclick="openDeleteModal('${encodedRow}')">
              <i class="fa-solid fa-trash"></i>
            </button>
          `;
        }
      }
    ],

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
  // Filters (debounced)
  // ==========================================================
  let debounce = null;
  $('#column-search-input').on('input', function () {
    clearTimeout(debounce);
    debounce = setTimeout(() => table.draw(), 250);
  });
  $('#column-select').on('change', function () { table.draw(); });
  $('#location-filter, #min-date, #max-date, #tariff-filter').on('change', function () { table.draw(); });

  $('#reset-filters').on('click', function () {
    $('#column-search-input').val('');
    $('#column-select').val($('#column-select option:first').val());
    $('#location-filter').val('');
    $('#min-date').val('');
    $('#max-date').val('');
    $('#tariff-filter').val('');
    table.search('');
    table.draw();
  });

  // ==========================================================
  // COMPLETE MODAL functions
  // ==========================================================
  function setCompleteLoading(isLoading) {
    $('#xConfirmBtn').prop('disabled', isLoading);
    $('#xCancelBtn').prop('disabled', isLoading);
    $('#completeModal .x-modal__close').prop('disabled', isLoading);

    if (isLoading) {
      $('#xConfirmBtn .x-btn__label').text('Completing...');
      $('#xConfirmBtn .x-btn__spinner').show();
    } else {
      $('#xConfirmBtn .x-btn__label').text('Yes, Complete');
      $('#xConfirmBtn .x-btn__spinner').hide();
    }
  }

  function showCompleteMsg(type, text) {
    $('#xModalMsg').removeClass('success error').addClass(type).text(text).show();
  }

  function closeCompleteModal() {
    $('#completeModal').removeClass('is-open').attr('aria-hidden', 'true');
    _completePayload = null;
  }

  window.openCompleteModal = function (encodedRow) {
    try { _completePayload = JSON.parse(decodeURIComponent(encodedRow)); }
    catch (e) { _completePayload = { id: null, customer_id: '—', customer_name: '—', pppoe: '—' }; }

    $('#xCustId').text(_completePayload.customer_id ?? '—');
    $('#xCustName').text(_completePayload.customer_name ?? '—');
    $('#xPPPOE').text(_completePayload.pppoe ?? '—');

    $('#xModalMsg').hide().removeClass('success error').text('');
    setCompleteLoading(false);

    $('#completeModal').addClass('is-open').attr('aria-hidden', 'false');
  };

  // ✅ close COMPLETE modal only
  $(document).on('click',
    '#completeModal #xCancelBtn, #completeModal .x-modal__close, #completeModal .x-modal__backdrop',
    function () { closeCompleteModal(); }
  );

  $(document).on('keydown', function (e) {
    if (e.key === 'Escape' && $('#completeModal').hasClass('is-open')) closeCompleteModal();
  });

  $(document).on('click', '#xConfirmBtn', function () {
    if (!_completePayload || !_completePayload.customer_id) {
      showCompleteMsg('error', 'Missing Customer ID.');
      return;
    }

    setCompleteLoading(true);

    // ✅ Your existing complete endpoint (customer_id)
    $.ajax({
      url: `/noc/schedule/new-register/${_completePayload.customer_id}/complete`,
      method: 'POST',
      data: { _token: csrfToken() },
      success: function (res) {
        showCompleteMsg('success', res.message || 'Completed successfully.');
        table.ajax.reload(null, false);
        setCompleteLoading(false);
        setTimeout(() => closeCompleteModal(), 800);
      },
      error: function (xhr) {
        let msg = 'Failed to complete.';
        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
        showCompleteMsg('error', msg);
        setCompleteLoading(false);
      }
    });
  });

  // ==========================================================
  // DELETE MODAL functions (customer_id + your route)
  // Route: DELETE /noc/schedule/new-register/{id}/delete
  // ==========================================================
  function setDeleteLoading(isLoading) {
    $('#xDelConfirmBtn').prop('disabled', isLoading);
    $('#xDelCancelBtn').prop('disabled', isLoading);
    $('#deleteModal .x-modal__close').prop('disabled', isLoading);

    if (isLoading) {
      $('#xDelConfirmBtn .x-btn__label').text('Deleting...');
      $('#xDelConfirmBtn .x-btn__spinner').show();
    } else {
      $('#xDelConfirmBtn .x-btn__label').text('Yes, Delete');
      $('#xDelConfirmBtn .x-btn__spinner').hide();
    }
  }

  function showDeleteMsg(type, text) {
    $('#xDeleteMsg').removeClass('success error').addClass(type).text(text).show();
  }

  function closeDeleteModal() {
    $('#deleteModal').removeClass('is-open').attr('aria-hidden', 'true');
    _deletePayload = null;
  }

  window.openDeleteModal = function (encodedRow) {
    try { _deletePayload = JSON.parse(decodeURIComponent(encodedRow)); }
    catch (e) { _deletePayload = { id: null, customer_id: '—', customer_name: '—', pppoe: '—' }; }

    $('#xDelCustId').text(_deletePayload.customer_id ?? '—');
    $('#xDelCustName').text(_deletePayload.customer_name ?? '—');
    $('#xDelPPPOE').text(_deletePayload.pppoe ?? '—');

    $('#xDeleteMsg').hide().removeClass('success error').text('');
    setDeleteLoading(false);

    $('#deleteModal').addClass('is-open').attr('aria-hidden', 'false');
  };

  // ✅ close DELETE modal only
  $(document).on('click',
    '#deleteModal #xDelCancelBtn, #deleteModal .x-modal__close, #deleteModal .x-modal__backdrop',
    function () { closeDeleteModal(); }
  );

  $(document).on('keydown', function (e) {
    if (e.key === 'Escape' && $('#deleteModal').hasClass('is-open')) closeDeleteModal();
  });

  $(document).on('click', '#xDelConfirmBtn', function () {
    if (!_deletePayload || !_deletePayload.customer_id) {
      showDeleteMsg('error', 'Missing Customer ID.');
      return;
    }

    setDeleteLoading(true);

    // ✅ Your route: DELETE /noc/schedule/new-register/{id}/delete
    $.ajax({
      url: `/noc/schedule/new-register/${_deletePayload.customer_id}/delete`,
      method: 'DELETE',
      data: { _token: csrfToken() },
      success: function (res) {
        showDeleteMsg('success', res.message || 'Deleted successfully.');
        table.ajax.reload(null, false);
        setDeleteLoading(false);
        setTimeout(() => closeDeleteModal(), 700);
      },
      error: function (xhr) {
        let msg = 'Delete failed.';
        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
        showDeleteMsg('error', msg);
        setDeleteLoading(false);
      }
    });
  });

});
</script>

</x-app-layout>
