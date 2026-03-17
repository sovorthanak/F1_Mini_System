<x-app-layout>

<style>
    .btn-complete{
        background:#059669;
        color:#fff;
        padding:6px 10px;
        border-radius:6px;
        font-size:14px;
        border:none;
        cursor:pointer;
    }
    .btn-complete:hover{ background:#047857; }
    .btn-complete:disabled{
        background:#9ca3af;
        cursor:not-allowed;
    }
    
    
    /* ===== Updated Modal Styles ===== */
    .x-modal {
      position: fixed;
      inset: 0;
      display: none;
      z-index: 99999;
      align-items: center;
      justify-content: center;
    }
    
    .x-modal.is-open {
      display: flex;
    }
    
    .x-modal__backdrop {
      position: absolute;
      inset: 0;
      background: rgba(15, 23, 42, 0.75);
      backdrop-filter: blur(8px);
      animation: fadeIn 0.25s ease-out;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    
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
    
    @keyframes popIn {
      to {
        transform: scale(1);
        opacity: 1;
      }
    }
    
    /* Header with gradient */
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
    
    .x-modal__titles {
      flex: 1;
      position: relative;
      z-index: 1;
    }
    
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
    
    /* Body */
    .x-modal__body {
      padding: 24px;
    }
    
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
    
    .x-modal__meta > div {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }
    
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
    
    @media(max-width: 520px) {
      .x-modal__meta {
        grid-template-columns: 1fr;
      }
    }
    
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
    
    .x-modal__msg.success::before {
      content: "\f058";
    }
    
    .x-modal__msg.error {
      background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.1) 100%);
      color: #b91c1c;
      border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    .x-modal__msg.error::before {
      content: "\f06a";
    }
    
    /* Footer */
    .x-modal__footer {
      display: flex;
      justify-content: flex-end;
      gap: 12px;
      padding: 20px 24px 24px;
      background: #f8fafc;
      border-top: 1px solid #e2e8f0;
    }
    
    /* Buttons */
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
    
    .x-btn:active::before {
      width: 300px;
      height: 300px;
    }
    
    .x-btn--ghost {
      background: #ffffff;
      color: #475569;
      border: 2px solid #e2e8f0;
    }
    
    .x-btn--ghost:hover {
      background: #f8fafc;
      border-color: #cbd5e1;
    }
    
    .x-btn--success {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .x-btn--success:hover {
      box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
      transform: translateY(-1px);
    }
    
    .x-btn:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none !important;
    }
    
    .x-btn__spinner {
      width: 16px;
      height: 16px;
      border-radius: 50%;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-top-color: #ffffff;
      animation: spin 0.7s linear infinite;
    }
    
    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }
    
    /* Complete button in table */
    .btn-complete {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: #fff;
      padding: 8px 16px;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: all 0.2s ease;
      box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
    }
    
    .btn-complete:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
    }
    
    .btn-complete:disabled {
      background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    .btn-delete{
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color:#fff;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25);
        margin-left: 8px;
    }
    .btn-delete:hover{
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35);
    }
    .btn-delete:disabled{
        background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
        cursor:not-allowed;
        transform:none;
        box-shadow:none;
    }

    .btn-complete,
    .btn-delete {
        width: 25px;
        height: 25px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50px;
        font-size: 12px;
    }



</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="card-header">
    <h4>Request Testing List
        <span>
            <a href="{{ route('request-testing.create') }}" class="btn btn-primary float-end">
                Create New Request Testing
            </a>
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
            <h1 id="pendingCount">0</h1>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card-header" style="display:flex; align-items:center; gap:30px;">
    <div>
        <label for="requestTypeFilter">Filter by Request Type:</label>
        <select id="requestTypeFilter" class="form-control" style="width: 220px; display:inline-block; margin-left:10px;">
            <option value="">All</option>
            <option value="Testing Upgrade">Testing Upgrade</option>
            <option value="Testing Change Service">Testing Change Service</option>
        </select>
    </div>

    <div>
        <label for="statusFilter">Filter by Status:</label>
        <select id="statusFilter" class="form-control" style="width: 180px; display:inline-block; margin-left:10px;">
            <option value="">All</option>
            <option value="Active">Active</option>
            <option value="Completed">Completed</option>
        </select>
    </div>

    <div>
        <label for="minDate">Request Date From:</label>
        <input type="date" id="minDate" class="form-control" style="display:inline-block; width:200px; margin-left:10px; margin-right:10px;">
        <label for="maxDate">To:</label>
        <input type="date" id="maxDate" class="form-control" style="display:inline-block; width:200px; margin-left:10px;">
    </div>
</div>

<div class="card-header" style="margin-bottom: 15px; display:flex; align-items:center; gap:30px;">
    <div>
        <label for="pppoeSearch">Search Customer ID / Plan / User:</label>
        <input type="text" id="pppoeSearch" class="form-control"
               placeholder="Type to search..."
               style="width: 260px; display:inline-block; margin-left:10px;">
    </div>
</div>

<div class="card">
    <table class="table table-bordered table-striped" id="all-cust-table" style="font-size: 15px; width:100%;">
        <thead>
        <tr>
            <th>ID</th>
            <th>Request Type</th>
            <th>Customer ID</th>
            <th>Customer Name</th>
            <th>PPPOE</th>
            <th>Old Tariff</th>
            <th>New Tariff</th>
            <th>Request Date</th>
            <th>End Testing Date</th>
            <th>Created By</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Complete Testing Modal -->
<div id="completeModal" class="x-modal" aria-hidden="true">
  <div class="x-modal__backdrop"></div>

  <div class="x-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="xModalTitle">
    <div class="x-modal__header">
      <div class="x-modal__icon">
        <i class="fa-solid fa-circle-check"></i>
      </div>
      <div class="x-modal__titles">
        <h3 id="xModalTitle">Complete testing?</h3>
        <p id="xModalDesc">This will restore the customer’s old plan. You can’t undo this action.</p>
      </div>
      <button type="button" class="x-modal__close" aria-label="Close">&times;</button>
    </div>

    <div class="x-modal__body">
      <div class="x-modal__meta">
        <div><span>Request ID:</span> <b id="xReqId">—</b></div>
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

<!-- Delete Testing Modal -->
<div id="deleteModal" class="x-modal" aria-hidden="true">
  <div class="x-modal__backdrop"></div>

  <div class="x-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="xDeleteTitle">
    <div class="x-modal__header" style="background:linear-gradient(135deg,#ef4444 0%,#dc2626 100%);">
      <div class="x-modal__icon" style="color:#dc2626;">
        <i class="fa-solid fa-trash"></i>
      </div>
      <div class="x-modal__titles">
        <h3 id="xDeleteTitle">Delete this request?</h3>
        <p id="xDeleteDesc">This will permanently delete the testing request. This action can’t be undone.</p>
      </div>
      <button type="button" class="x-modal__close" aria-label="Close">&times;</button>
    </div>

    <div class="x-modal__body">
      <div class="x-modal__meta">
        <div><span>Request ID:</span> <b id="xDelReqId">—</b></div>
        <div><span>Customer ID:</span> <b id="xDelCustId">—</b></div>
        <div><span>Customer Name:</span> <b id="xDelCustName">—</b></div>
        <div><span>PPPOE:</span> <b id="xDelPPPOE">—</b></div>
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


<script>
  function csrfToken() {
    return $('meta[name="csrf-token"]').attr('content');
  }

  // ===== Modal state =====
  let _completePayload = null;

  function openCompleteModal(encodedRow) {
    try {
      _completePayload = JSON.parse(decodeURIComponent(encodedRow));
    } catch (e) {
      _completePayload = { id: null, customer_id: '—', pppoe: '—', customer_name: '—' };
    }

    $('#xReqId').text(_completePayload.id ?? '—');
    $('#xCustId').text(_completePayload.customer_id ?? '—');
    $('#xCustName').text(_completePayload.customer_name ?? '—');
    $('#xPPPOE').text(_completePayload.pppoe || '—');

    $('#xModalMsg').hide().removeClass('success error').text('');
    setModalLoading(false);

    $('#completeModal').addClass('is-open').attr('aria-hidden', 'false');
  }

  function closeCompleteModal() {
    $('#completeModal').removeClass('is-open').attr('aria-hidden', 'true');
    _completePayload = null;
  }

  function setModalLoading(isLoading) {
    $('#xConfirmBtn').prop('disabled', isLoading);
    $('#xCancelBtn').prop('disabled', isLoading);
    $('.x-modal__close').prop('disabled', isLoading);

    if (isLoading) {
      $('#xConfirmBtn .x-btn__label').text('Completing...');
      $('#xConfirmBtn .x-btn__spinner').show();
    } else {
      $('#xConfirmBtn .x-btn__label').text('Yes, Complete');
      $('#xConfirmBtn .x-btn__spinner').hide();
    }
  }

  function showModalMsg(type, text) {
    $('#xModalMsg')
      .removeClass('success error')
      .addClass(type)
      .text(text)
      .show();
  }

  // ===== Modal interactions =====
  $(document).on('click', '#xCancelBtn, .x-modal__close, .x-modal__backdrop', function () {
    closeCompleteModal();
  });

  $(document).on('keydown', function (e) {
    if (e.key === 'Escape' && $('#completeModal').hasClass('is-open')) {
      closeCompleteModal();
    }
  });

  $(document).on('click', '#xConfirmBtn', function () {
    if (!_completePayload || !_completePayload.id) return;

    setModalLoading(true);

    $.ajax({
      url: `/noc/request-testing/${_completePayload.id}/complete`,
      method: 'POST',
      data: { _token: csrfToken() },
      success: function (res) {
        showModalMsg('success', res.message || 'Completed successfully.');
        $('#all-cust-table').DataTable().ajax.reload(null, false);

        setModalLoading(false);
        setTimeout(() => closeCompleteModal(), 800);
      },
      error: function (xhr) {
        let msg = 'Failed to complete.';
        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
        showModalMsg('error', msg);
        setModalLoading(false);
      }
    });
  });

    // ===== Delete modal state =====
    let _deletePayload = null;

    function openDeleteModal(encodedRow) {
    try {
        _deletePayload = JSON.parse(decodeURIComponent(encodedRow));
    } catch (e) {
        _deletePayload = { id: null, customer_id: '—', pppoe: '—', customer_name: '—' };
    }

    $('#xDelReqId').text(_deletePayload.id ?? '—');
    $('#xDelCustId').text(_deletePayload.customer_id ?? '—');
    $('#xDelCustName').text(_deletePayload.customer_name ?? '—');
    $('#xDelPPPOE').text(_deletePayload.pppoe || '—');

    $('#xDeleteMsg').hide().removeClass('success error').text('');
    setDeleteModalLoading(false);

    $('#deleteModal').addClass('is-open').attr('aria-hidden', 'false');
    }

    function closeDeleteModal() {
    $('#deleteModal').removeClass('is-open').attr('aria-hidden', 'true');
    _deletePayload = null;
    }

    function setDeleteModalLoading(isLoading) {
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
    $('#xDeleteMsg')
        .removeClass('success error')
        .addClass(type)
        .text(text)
        .show();
    }

    // Close delete modal
    $(document).on('click', '#xDelCancelBtn, #deleteModal .x-modal__close, #deleteModal .x-modal__backdrop', function () {
    closeDeleteModal();
    });

    // ESC closes delete modal too
    $(document).on('keydown', function (e) {
    if (e.key === 'Escape' && $('#deleteModal').hasClass('is-open')) {
        closeDeleteModal();
    }
    });

    // Confirm delete
    $(document).on('click', '#xDelConfirmBtn', function () {
    if (!_deletePayload || !_deletePayload.id) return;

    setDeleteModalLoading(true);

    // If you prefer DELETE method, see note below.
    $.ajax({
        url: `/noc/request-testing/${_deletePayload.id}`,
        method: 'POST',
        data: { _token: csrfToken(), _method: 'DELETE' },
        success: function (res) {
        showDeleteMsg('success', res.message || 'Deleted successfully.');
        $('#all-cust-table').DataTable().ajax.reload(null, false);
        setDeleteModalLoading(false);
        setTimeout(() => closeDeleteModal(), 700);
        },
        error: function (xhr) {
        let msg = 'Failed to delete.';
        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
        showDeleteMsg('error', msg);
        setDeleteModalLoading(false);
        }
    });
    });

  // ===== DataTable =====
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
        url: "/api/request-testing/data",
        dataSrc: function (json) {
          let pendingCount = (json.data || []).filter(r => r.status === 'Active').length;
          $('#pendingCount').text(pendingCount);
          return json.data || [];
        }
      },

      columns: [
        { data: "id", className: "text-center" },

        { data: "request_type", className: "text-center", render: d => `<b>${d || '---'}</b>` },

        {
          data: "customer_id",
          className: "text-center",
          render: d => d ? `<a href="/customers/${d}/view-details">${d}</a>` : '---'
        },

        { data: "customer.customer_name", className: "text-center", render: d => d || '---' },

        { data: "customer.pppoe", className: "text-center", render: d => d || '---' },

        { data: null, className: "text-center", render: row => `${row.old_tariff || '---'} ${row.old_bandwidth || ''}`.trim() },

        { data: null, className: "text-center", render: row => `${row.new_tariff || '---'} ${row.new_bandwidth || ''}`.trim() },

        { data: "request_date", className: "text-center", render: d => d || '---' },

        { data: "end_testing_date", className: "text-center", render: d => d || '---' },

        { data: "created_by", className: "text-left", render: d => d || '---' },

        { data: "status", className: "text-center", render: d => d || '---' },

        // ✅ Action column: open modal + pass row safely
        {
          data: null,
          className: "text-center",
            render: function (row) {
            const done = (row.status || '').toLowerCase() === 'completed';

            const safeRow = encodeURIComponent(JSON.stringify({
                id: row.id,
                customer_id: row.customer_id,
                customer_name: row.customer?.customer_name || '—',
                pppoe: (row.customer && row.customer.pppoe) ? row.customer.pppoe : ''
            }));

            return `
                <button 
                class="btn-complete"
                ${done ? 'disabled' : ''}
                onclick="openCompleteModal('${safeRow}')"
                title="${done ? 'Already Completed' : 'Complete Testing'}"
                >
                <i class="fa-solid fa-circle-check"></i>
                </button>

                ${
                done
                    ? `
                    <button 
                        class="btn-delete"
                        onclick="openDeleteModal('${safeRow}')"
                        title="Delete Completed Request"
                    >
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    `
                    : ``
                }
            `;
            }
        }
      ]
    });

    // Request type exact filter
    $('#requestTypeFilter').on('change', function () {
      let val = $(this).val();
      table.column(1).search(val ? '^' + $.fn.dataTable.util.escapeRegex(val) + '$' : '', true, false).draw();
    });

    // Status exact filter
    $('#statusFilter').on('change', function () {
      let val = $(this).val();
      table.column(10).search(val ? '^' + $.fn.dataTable.util.escapeRegex(val) + '$' : '', true, false).draw();
    });

    // Search (global)
    $('#pppoeSearch').on('keyup', function () {
      table.search(this.value).draw();
    });

    // Date range filter on Request Date (column index 7)
    $.fn.dataTable.ext.search.push(function (settings, data) {
      let min = $('#minDate').val();
      let max = $('#maxDate').val();

      let requestDateStr = data[7]; // Request Date column
      if (!min && !max) return true;

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
  });
</script>


</x-app-layout>
