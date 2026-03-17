<x-app-layout>

<div class="container">
    <span class="add-cust">
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Create New Request
                            <span>
                                <a href="/request-change" class="btn btn-primary float-end">Back</a>
                            </span>
                        </h4>

                    </div>

                    @include('request_change.partials._alerts')

                    <div class="card-body">
                        <div class="register-form">
                        <form action="" method="post" id="add-cust-form" enctype="multipart/form-data">
                            @csrf

                            <!-- ================= OLD / NEW INFORMATION ================= -->
                            <h3 class="title">Old / New Information</h3>

                            <div class="grid">

                                <!-- LEFT COLUMN -->
                                <div class="col">

                                    <!-- Customer ID -->
                                    <div class="row">
                                        <div class="label">Customer ID <span class="req">*</span></div><div class="colon">:</div>
                                        <div class="control">
                                            <input type="text" name="customer_id" id="customerId" value="{{ old('customer_id', request()->query('customer_id')) }}" required placeholder="Enter customer id"/>
                                            <button type="button" class="btn-v2" id="importBtn">Import</button>
                                            @error('customer_id')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="row" style="display:none;" id="customerIdImport">
                                        <div class="label"></div><div class="colon"></div>
                                        <div id="customerInfo"></div>
                                    </div>

                                </div>

                                <!-- RIGHT COLUMN -->
                                <div class="col">
                                    <!-- Request Type -->
                                    <div class="row">
                                        <div class="label">Request Type <span class="req">*</span></div><div class="colon">:</div>
                                        <div class="control">
                                            <select name="request_type" required>
                                                <option value="">Select Request Type</option>
                                                <option value="Upgrade" {{ old('request_type') == 'Upgrade' ? 'selected' : '' }}>Upgrade</option>
                                                <option value="Downgrade" {{ old('request_type') == 'Downgrade' ? 'selected' : '' }}>Downgrade</option>
                                                <option value="Change Service" {{ old('request_type') == 'Change Service' ? 'selected' : '' }}>Change Service</option>
                                                <option value="Deactivate" {{ old('request_type') == 'Deactivate' ? 'selected' : '' }}>Deactivate</option>
                                                <option value="Reactivate" {{ old('request_type') == 'Reactivate' ? 'selected' : '' }}>Reactivate</option>
                                                <option value="Termination" {{ old('request_type') == 'Termination' ? 'selected' : '' }}>Termination</option>
                                                <option value="Relocation" {{ old('request_type') == 'Relocation' ? 'selected' : '' }}>Relocation</option>
                                                <option value="Add IP Address" {{ old('request_type') == 'Add IP Address' ? 'selected' : '' }}>Add IP Address</option>
                                                <option value="Remove IP Address" {{ old('request_type') == 'Remove IP Address' ? 'selected' : '' }}>Remove IP Address</option>
                                                <option value="Change IP Address" {{ old('request_type') == 'Change IP Address' ? 'selected' : '' }}>Change IP Address</option>
                                                <option value="Change Remark" {{ old('request_type') == 'Change Remark' ? 'selected' : '' }}>Change Remark</option>
                                            </select>
                                            @error('request_type')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="section-required">
                            @include('request_change.partials._required_fields')
                            </div>

                            <div id="section-tariff">
                            <h3 class="title sub-title">Tariff Info</h3>
                            @include('request_change.partials._tariff')
                            </div>

                            <div id="section-address">
                            <h3 class="title sub-title">Address Info</h3>
                            @include('request_change.partials._address_line')
                            </div>

                            <div id="section-status">
                            <h3 class="title sub-title">Customer Status</h3>
                            @include('request_change.partials._customer_status')
                            </div>

                            <div id="section-remark">
                            <h3 class="title sub-title">Remark</h3>
                            @include('request_change.partials._remark_field')
                            </div>

                            <div id="section-ip">
                            <h3 class="title sub-title">IP Address</h3>
                            @include('request_change.partials._ip_addresses_field')
                            </div>

                            <!-- ================= DATE ================= -->
                            <h3 class="title sub-title">Date</h3>
                            <div class="grid">
                                <div class="col">
                                    <div class="row">
                                        <div class="label">Date <span class="req">*</span></div><div class="colon">:</div>
                                        <div class="control">
                                            <input type="date" name="date" value="{{ old('date') }}" required/>
                                            @error('date')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col"></div>
                            </div>

                            <!-- ================= ACTION BUTTONS ================= -->
                            <div style="margin-top: 30px; display: flex; justify-content: flex-end;">
                                <button type="submit" class="btn btn-v2 btn-primary">Create</button>
                                <button type="reset" id="clearButton" class="btn btn-v2 btn-danger">Clear</button>
                            </div>

                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </span>
</div>
<!-- ✅ MAIN PAGE SCRIPT (NO IP-RELATED LOGIC) -->
<script>
    document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('add-cust-form');
    const clearButton = document.getElementById('clearButton');
    const importBtn = document.getElementById('importBtn');
    const requestTypeSelect = document.querySelector('select[name="request_type"]');

    const sections = {
        required: document.getElementById('section-required'),
        tariff: document.getElementById('section-tariff'),
        address: document.getElementById('section-address'),
        status: document.getElementById('section-status'),
        remark: document.getElementById('section-remark'),
        ip: document.getElementById('section-ip'),
    };

    // ✅ Route map: request type → dedicated route
    const routeMap = {
        'Upgrade':           '{{ route("request-change.store.tariff") }}',
        'Downgrade':         '{{ route("request-change.store.tariff") }}',
        'Change Service':    '{{ route("request-change.store.tariff") }}',
        'Deactivate':        '{{ route("request-change.store.status") }}',
        'Reactivate':        '{{ route("request-change.store.status") }}',
        'Termination':       '{{ route("request-change.store.status") }}',
        'Relocation':        '{{ route("request-change.store.relocation") }}',
        'Change Remark':     '{{ route("request-change.store.remark") }}',
        'Add IP Address':    '{{ route("request-change.store.add-ip") }}',
        'Remove IP Address': '{{ route("request-change.store.remove-ip") }}',
        'Change IP Address': '{{ route("request-change.store.change-ip") }}',
    };

    let importedCustomer = null;

    function getRequestType() {
        return requestTypeSelect?.value || '';
    }

    function hideAllSections() {
        Object.values(sections).forEach(el => {
        if (el) el.style.display = 'none';
        });
    }

    function showAllSections() {
        Object.values(sections).forEach(el => {
        if (el) el.style.display = 'block';
        });
    }

    function showOnly(keys = []) {
        keys.forEach(k => {
        if (sections[k]) sections[k].style.display = 'block';
        });
    }

    function setRemarkRequired(isRequired) {
        const remarkField = document.getElementById('remark');
        if (remarkField) remarkField.required = !!isRequired;
    }

    function notifyIpModule(requestType) {
        window.RequestChangeIP?.onRequestTypeChange?.({
        requestType,
        customer: importedCustomer
        });
    }

    // ==========================================
    // ✅ MAIN CONDITION LOGIC (ALL REQUEST TYPES)
    // ==========================================
    function toggleFields() {
        const requestType = getRequestType();

        // ✅ Update form action based on request type
        const route = routeMap[requestType];
        if (route) {
            form.action = route;
        } else {
            form.action = '';
        }

        // default state (no selected)
        if (!requestType) {
        showAllSections();
        setRemarkRequired(false);
        notifyIpModule(requestType);
        return;
        }

        // reset
        hideAllSections();
        setRemarkRequired(false);

        // ✅ required always show
        showOnly(['required']);

        // ===== Tariff-related =====
        if (['Upgrade', 'Downgrade', 'Change Service'].includes(requestType)) {
        showOnly(['tariff']);
        }

        // ===== Status-related =====
        else if (['Deactivate', 'Reactivate', 'Termination'].includes(requestType)) {
        showOnly(['status']);
        }

        // ===== Address-related =====
        else if (requestType === 'Relocation') {
        showOnly(['address']);
        }

        // ===== Remark-related =====
        else if (requestType === 'Change Remark') {
        showOnly(['remark']);
        setRemarkRequired(true);
        }

        // ===== IP-related =====
        else if (['Add IP Address', 'Remove IP Address', 'Change IP Address'].includes(requestType)) {
        showOnly(['ip']);
        }

        // ✅ always notify IP module (for Add/Remove/Change behavior)
        notifyIpModule(requestType);
    }

    // init + change handler
    toggleFields();
    requestTypeSelect?.addEventListener('change', toggleFields);

    // ==========================
    // ✅ Clear button
    // ==========================
    clearButton?.addEventListener('click', function () {
        form?.reset();

        const customerInfo = document.getElementById('customerInfo');
        if (customerInfo) customerInfo.innerHTML = '';

        const customerIdImport = document.getElementById('customerIdImport');
        if (customerIdImport) customerIdImport.style.display = 'none';

        importedCustomer = null;

        // reset IP module
        window.RequestChangeIP?.reset?.();

        // reset UI
        toggleFields();
    });

    // ==========================
    // ✅ Import button
    // ==========================
    importBtn?.addEventListener('click', function () {
        const customerId = document.getElementById('customerId')?.value?.trim();
        if (!customerId) return;

        fetch(`/customers/${customerId}`)
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
            const customerInfo = document.getElementById('customerInfo');
            const customerIdImport = document.getElementById('customerIdImport');
            if (customerIdImport) customerIdImport.style.display = 'flex';
            if (customerInfo) customerInfo.innerHTML = '<p style="color:red;">Customer not found.</p>';

            importedCustomer = null;
            window.RequestChangeIP?.reset?.();
            toggleFields();
            return;
            }

            importedCustomer = data.customer;
            const customer = importedCustomer;

            // Hide the import message row on success
            const customerIdImport = document.getElementById('customerIdImport');
            if (customerIdImport) customerIdImport.style.display = 'none';
            const customerInfo = document.getElementById('customerInfo');
            if (customerInfo) customerInfo.innerHTML = '';

            // Fill old fields (non-IP)
            const oldFields = {
            old_customer_name: customer.name,
            old_customer_status: customer.status,
            old_tariff_name: customer.old_tariff,
            old_bandwidth: customer.old_bandwidth,
            old_address: customer.old_address,
            old_alt_address: customer.old_alt_address,
            old_location: customer.old_location,
            old_pppoe: customer.old_pppoe,
            old_password: customer.old_password,
            old_router: customer.old_router,
            old_remark: customer.old_remark
            };

            Object.keys(oldFields).forEach(key => {
            const el = document.querySelector(`[name="${key}"]`);
            if (el) el.value = oldFields[key] || '';
            });

            // ✅ Tell IP module to populate IP section
            window.RequestChangeIP?.setCustomer?.(customer);

            // re-render based on current request type
            toggleFields();
        })
        .catch(err => {
            console.error('❌ Fetch error:', err);
            const customerInfo = document.getElementById('customerInfo');
            const customerIdImport = document.getElementById('customerIdImport');
            if (customerIdImport) customerIdImport.style.display = 'flex';
            if (customerInfo) customerInfo.innerHTML = '<p style="color:red;">Something went wrong.</p>';
        });
    });

    // ==========================
    // ✅ Auto import via URL ?customer_id=
    // ==========================
    (function autoImportFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        const customerIdFromUrl = urlParams.get('customer_id');

        if (customerIdFromUrl) {
        const customerIdInput = document.getElementById('customerId');
        if (customerIdInput) customerIdInput.value = customerIdFromUrl;
        importBtn?.click();
        }
    })();

    });
</script>

</x-app-layout>