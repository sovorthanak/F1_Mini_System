<x-app-layout>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Register New Customer</h4>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @error('ips')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="register-form">
            <form id="add-cust-form" action="{{ route('storeRegister') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- ================= GENERAL INFO ================= -->
                <h3 class="title">General Info</h3>
                <div class="grid">

                    <!-- LEFT COLUMN -->
                    <div class="col">

                        <!-- Customer ID -->
                        <div class="row">
                            <div class="label">Customer ID <span class="req">*</span></div><div class="colon">:</div>
                            <div class="control">
                                <input type="text" name="customer_id"
                                    value="{{ old('customer_id') }}"
                                    placeholder="e.g. CUST-0001"
                                    class="@error('customer_id') is-invalid @enderror" required>
                                @error('customer_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Customer Name -->
                        <div class="row">
                            <div class="label">Customer Name <span class="req">*</span></div><div class="colon">:</div>
                            <div class="control">
                                <input type="text" name="customer_name"
                                    value="{{ old('customer_name') }}"
                                    placeholder="Enter customer full name"
                                    class="@error('customer_name') is-invalid @enderror" required>
                                @error('customer_name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Customer Name Khmer -->
                        <div class="row">
                            <div class="label">Customer Name (Khmer)</div><div class="colon">:</div>
                            <div class="control">
                                <input type="text" name="alt_customer_name"
                                    value="{{ old('alt_customer_name') }}"
                                    placeholder="Enter customer full name in Khmer"
                                    class="@error('alt_customer_name') is-invalid @enderror">
                                @error('alt_customer_name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="row">
                            <div class="label">Phone Number</div><div class="colon">:</div>
                            <div class="control">
                                <input type="text" name="phone_number"
                                    value="{{ old('phone_number') }}"
                                    placeholder="e.g. 012345678"
                                    class="@error('phone_number') is-invalid @enderror">
                                @error('phone_number')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Agent -->
                        <div class="row">
                            <div class="label">Agent <span class="req">*</span></div><div class="colon">:</div>
                            <div class="control">
                                <select name="agent" class="@error('agent') is-invalid @enderror" required>
                                    <option value="">-- Select Agent --</option>
                                    @foreach([
                                        'Unspecified','Sale Admin','Mr. Tep Theara','Mr. Uch Kaing',
                                        'Agency MongKol','Mr. Gouv Leangchea','Mr. Dao Kiheng',
                                        'Mr. Se Samnang','Agency Jing Jing','Mr. Sorn Daniel'
                                    ] as $agent)
                                        <option value="{{ $agent }}" {{ old('agent')==$agent?'selected':'' }}>
                                            {{ $agent }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('agent')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN -->
                    <div class="col">

                        <!-- Province -->
                        <div class="row">
                            <div class="label">Location (Area) <span class="req">*</span></div><div class="colon">:</div>
                            <div class="control">
                                <select name="province" class="@error('province') is-invalid @enderror" required>
                                    <option value="">-- Select Province --</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->name }}" {{ old('province')==$location->name?'selected':'' }}>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('province')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Lat Long -->
                        <div class="row">
                            <div class="label">Lat / Long</div><div class="colon">:</div>
                            <div class="control">
                                <input type="text" name="lat_long"
                                    value="{{ old('lat_long') }}"
                                    placeholder="11.5564, 104.9282"
                                    class="@error('lat_long') is-invalid @enderror">
                                @error('lat_long')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Address EN -->
                        <div class="row">
                            <div class="label">Address (English) <span class="req">*</span></div><div class="colon">:</div>
                            <div class="control">
                                <input type="text" name="address_line_1"
                                    value="{{ old('address_line_1') }}"
                                    placeholder="House No, Street, Village"
                                    class="@error('address_line_1') is-invalid @enderror" required>
                                @error('address_line_1')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Address KH -->
                        <div class="row">
                            <div class="label">Address (Khmer)</div><div class="colon">:</div>
                            <div class="control">
                                <input type="text" name="alt_address_line_1"
                                    value="{{ old('alt_address_line_1') }}"
                                    placeholder="House No, Street, Village in Khmer"
                                    class="@error('alt_address_line_1') is-invalid @enderror">
                                @error('alt_address_line_1')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Upload ID -->
                        <div class="row">
                            <div class="label">National ID / Passport</div><div class="colon">:</div>
                            <div class="control">
                                <input type="file" name="id_or_passport_image"
                                    class="@error('id_or_passport_image') is-invalid @enderror">
                                @error('id_or_passport_image')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ================= TECHNICAL INFO ================= -->
                <h3 class="title sub-title">Technical Info</h3>
                <div class="grid">

                    <div class="col">

                        <!-- Tariff -->
                        <div class="row">
                            <div class="label">Tariff <span class="req">*</span></div><div class="colon">:</div>
                            <div class="control">
                                <select name="tariff_name" class="@error('tariff_name') is-invalid @enderror" required>
                                    <option value="">-- Select Tariff --</option>
                                    @foreach($tariffs as $t)
                                        <option value="{{ $t }}" {{ old('tariff_name')==$t?'selected':'' }}>{{ $t }}</option>
                                    @endforeach
                                </select>
                                @error('tariff_name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Bandwidth -->
                        <div class="row">
                            <div class="label">Bandwidth <span class="req">*</span></div><div class="colon">:</div>
                            <div class="control">
                                <select name="bandwidth" class="@error('bandwidth') is-invalid @enderror" required>
                                    <option value="">-- Select Speed --</option>
                                    @foreach($bandwidths as $b)
                                        <option value="{{ $b->speed }}" {{ old('bandwidth')==$b->speed?'selected':'' }}>
                                            {{ $b->speed }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bandwidth')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- PPPoE -->
                        <div class="row">
                            <div class="label">PPPoE</div><div class="colon">:</div>
                            <div class="control">
                                <input type="text" name="pppoe"
                                    value="{{ old('pppoe') }}"
                                    placeholder="PPPoE Username"
                                    class="@error('pppoe') is-invalid @enderror">
                                @error('pppoe')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="row">
                            <div class="label">Password</div><div class="colon">:</div>
                            <div class="control">
                                <input type="text" name="password"
                                    placeholder="PPPoE password"
                                    class="@error('password') is-invalid @enderror">
                                @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                    </div>

                    <div class="col">

                        <!-- Complete Date -->
                        <div class="row">
                            <div class="label">Complete Date <span class="req">*</span></div><div class="colon">:</div>
                            <div class="control">
                                <input type="date" name="complete_date"
                                    value="{{ old('complete_date') }}"
                                    class="@error('complete_date') is-invalid @enderror" required>
                                @error('complete_date')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Remark -->
                        <div class="row">
                            <div class="label">Remark</div><div class="colon">:</div>
                            <div class="control">
                                <input type="text" name="remark"
                                    value="{{ old('remark') }}"
                                    placeholder="Additional notes"
                                    class="@error('remark') is-invalid @enderror">
                                @error('remark')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Router -->
                        <div class="row">
                            <div class="label">Router</div><div class="colon">:</div>
                            <div class="control">
                                <input type="text" name="router"
                                    value="{{ old('router') }}"
                                    placeholder="Router model / serial"
                                    class="@error('router') is-invalid @enderror">
                                @error('router')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- IP Quantity -->
                        <div class="row">
                            <div class="label">IP Quantity</div>
                            <div class="colon">:</div>

                            <div class="control ip-control">
                                <input type="number"
                                    name="ip_quantity"
                                    id="ip_quantity"
                                    min="0"
                                    value="{{ old('ip_quantity', 0) }}"
                                    readonly>

                                <button type="button" class="qty-btn plus">+</button>
                            </div>
                        </div>

                        @error('ip_quantity')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <div id="ip-rows-container">
                            <!-- Dynamic rows will be added here -->
                        </div>

                        <script id="free-by-pool-data" type="application/json">
                            @json($freeByPool)
                        </script>

                        <template id="ip-row-template">

                            <div class="row ip-row" style="margin-bottom: 5px">
                                <select class="pool-select label">
                                    <option value="">-- Select Pool --</option>
                                    @foreach ($pools as $pool)
                                        <option value="{{ $pool->id }}">{{ $pool->name }}</option>
                                    @endforeach
                                </select>

                                <div class="control">
                                    <select class="ip-input" required>
                                        <option value="">-- Select IP --</option>
                                    </select>
                                    <input type="text" class="ip-note" placeholder="note">
                                    <button type="button" class="qty-btn minus">-</button>
                                </div>
                            </div>
                        </template>

                        <input type="hidden" id="ip_required_flag" required>

                    </div>
                </div>

                <!-- ================= BILL INFO ================= -->
                <h3 class="title sub-title">Bill Info</h3>
                <div class="grid">

                    <div class="col">

                        <div class="row">
                            <div class="label">Start Date</div><div class="colon">:</div>
                            <div class="control">
                                <input type="date" name="start_date"
                                    value="{{ old('start_date') }}"
                                    class="@error('start_date') is-invalid @enderror">
                                @error('start_date')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="label">Bill Cycle</div><div class="colon">:</div>
                            <div class="control">
                                <select name="bill_cycle" class="@error('bill_cycle') is-invalid @enderror">
                                    <option value="">-- Select Cycle --</option>
                                    @foreach([1,3,6,12,24,36] as $c)
                                        <option value="{{ $c }}" {{ old('bill_cycle')==$c?'selected':'' }}>
                                            {{ $c }} Month{{ $c>1?'s':'' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bill_cycle')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="label">Currency</div><div class="colon">:</div>
                            <div class="control">
                                <select name="currency">
                                    <option value="U.S. Dollar" selected>[USD] U.S Dollar</option>
                                    <option value="K.H Riel">[KHR] Khmer Riel</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="col">

                        <div class="row">
                            <div class="label">Internet Fee</div><div class="colon">:</div>
                            <div class="control">
                                <input type="number" step="any" name="internet_fee"
                                    value="{{ old('internet_fee') }}"
                                    placeholder="e.g. 25.00"
                                    class="@error('internet_fee') is-invalid @enderror">
                                @error('internet_fee')<span class="text-danger">{{ $message }}</span>@enderror
                                <span>$</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="label">Installation Fee</div><div class="colon">:</div>
                            <div class="control">
                                <input type="number" step="any" name="installation_fee"
                                    value="{{ old('installation_fee') }}"
                                    placeholder="e.g. 50.00"
                                    class="@error('installation_fee') is-invalid @enderror">
                                @error('installation_fee')<span class="text-danger">{{ $message }}</span>@enderror
                                <span>$</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="label">IP Fee</div><div class="colon">:</div>
                            <div class="control">
                                <input type="number" step="any" name="ip_fee"
                                    value="{{ old('ip_fee') }}"
                                    placeholder="e.g. 10.00"
                                    class="@error('ip_fee') is-invalid @enderror">
                                @error('ip_fee')<span class="text-danger">{{ $message }}</span>@enderror
                                <span>$</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ================= ACTION BUTTONS ================= -->
                <div style="margin-top: 30px; display: flex; justify-content: flex-end;">
                    <button type="reset" class="btn btn-v2 btn-danger">Clear</button>
                    <button type="submit" class="btn btn-v2 btn-primary">Register Customer</button>
                </div>

            </form>
        </div>
    </div>
    
    {{-- Searchable Select Styles --}}
    <style>
        .ss-wrapper {
            position: relative;
        }
        .ss-wrapper > select {
            display: none !important;
        }

        /* Force ip-row items on a single line */
        .register-form .ip-row {
            flex-wrap: nowrap;
        }
        .ss-display {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 7px;
            border: 1px solid var(--input-border, #bfbfbf);
            border-radius: 3px;
            background: #fff;
            cursor: pointer;
            font-size: 15px;
            height: 25px;
            user-select: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            box-sizing: border-box;
        }
        .ss-display:hover { border-color: #999; }
        .ss-arrow {
            margin-left: 8px;
            font-size: 10px;
            color: #666;
            flex-shrink: 0;
        }
        /* Override global .register-form input rules for the search inside dropdown */
        .register-form .ss-search {
            height: auto !important;
            padding: 6px 10px !important;
            border: none !important;
            border-bottom: 1px solid #eee !important;
            border-radius: 0 !important;
        }
        .ss-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 1000;
            background: #fff;
            border: 1px solid #ccc;
            border-top: none;
            border-radius: 0 0 4px 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            max-height: 220px;
            overflow: hidden;
            display: none;
        }
        .ss-dropdown.open { display: block; }
        .ss-search {
            width: 100%;
            padding: 7px 10px;
            border: none;
            border-bottom: 1px solid #eee;
            outline: none;
            font-size: 13px;
            box-sizing: border-box;
        }
        .ss-search::placeholder { color: #aaa; }
        .ss-list {
            max-height: 175px;
            overflow-y: auto;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .ss-item {
            padding: 7px 10px;
            cursor: pointer;
            font-size: 13px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .ss-item:hover,
        .ss-item.highlighted { background: #e8f0fe; }
        .ss-item.selected { background: #4a90d9; color: #fff; }
        .ss-item.hidden { display: none; }
        .ss-no-results {
            padding: 8px 10px;
            color: #999;
            font-size: 13px;
            font-style: italic;
        }

        /* Fixed widths for Pool and IP searchable selects */
        .register-form .ip-row .pool-ss-wrapper {
            width: 200px;
            min-width: 200px;
            flex: 0 0 200px;
        }
        .register-form .ip-row .ip-ss-wrapper {
            width: 200px;
            min-width: 200px;
            flex: 0 0 200px;
        }
    </style>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            /* =========================
                SEARCHABLE SELECT
            ========================== */
            function makeSearchable(selectEl) {
                // Skip if already enhanced
                if (selectEl.parentElement && selectEl.parentElement.classList.contains('ss-wrapper')) return;

                const wrapper = document.createElement('div');
                wrapper.className = 'ss-wrapper';

                // Add identifying class for CSS targeting
                if (selectEl.classList.contains('pool-select')) wrapper.classList.add('pool-ss-wrapper');
                if (selectEl.classList.contains('ip-input')) wrapper.classList.add('ip-ss-wrapper');

                selectEl.parentNode.insertBefore(wrapper, selectEl);
                wrapper.appendChild(selectEl);

                // Display button
                const display = document.createElement('div');
                display.className = 'ss-display';
                const textSpan = document.createElement('span');
                textSpan.className = 'ss-text';
                const selectedOpt = selectEl.options[selectEl.selectedIndex];
                textSpan.textContent = selectedOpt ? selectedOpt.textContent : '-- Select --';
                const arrow = document.createElement('span');
                arrow.className = 'ss-arrow';
                arrow.innerHTML = '&#9662;';
                display.appendChild(textSpan);
                display.appendChild(arrow);
                wrapper.appendChild(display);

                // Dropdown
                const dropdown = document.createElement('div');
                dropdown.className = 'ss-dropdown';
                const search = document.createElement('input');
                search.type = 'text';
                search.className = 'ss-search';
                search.placeholder = 'Type to search...';
                search.autocomplete = 'off';
                dropdown.appendChild(search);

                const list = document.createElement('ul');
                list.className = 'ss-list';
                dropdown.appendChild(list);
                wrapper.appendChild(dropdown);

                // Build list items from select options
                function buildItems() {
                    list.innerHTML = '';
                    Array.from(selectEl.options).forEach((opt, idx) => {
                        const li = document.createElement('li');
                        li.className = 'ss-item';
                        li.dataset.value = opt.value;
                        li.dataset.index = idx;
                        li.textContent = opt.textContent;
                        if (opt.selected && opt.value !== '') li.classList.add('selected');
                        list.appendChild(li);
                    });
                }
                buildItems();

                // Toggle dropdown
                display.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isOpen = dropdown.classList.contains('open');
                    closeAllSearchables();
                    if (!isOpen) {
                        dropdown.classList.add('open');
                        display.classList.add('open');
                        search.value = '';
                        filterItems('');
                        search.focus();
                    }
                });

                // Filter on typing
                search.addEventListener('input', function() {
                    filterItems(search.value);
                });

                // Prevent click on search from closing
                search.addEventListener('click', function(e) {
                    e.stopPropagation();
                });

                function filterItems(query) {
                    const q = query.toLowerCase();
                    let hasVisible = false;
                    list.querySelectorAll('.ss-item').forEach(li => {
                        if (li.dataset.value === '' && !q) {
                            li.classList.remove('hidden');
                            hasVisible = true;
                        } else if (li.textContent.toLowerCase().includes(q)) {
                            li.classList.remove('hidden');
                            hasVisible = true;
                        } else {
                            li.classList.add('hidden');
                        }
                    });
                    // Show/hide no-results message
                    let noRes = dropdown.querySelector('.ss-no-results');
                    if (!hasVisible) {
                        if (!noRes) {
                            noRes = document.createElement('div');
                            noRes.className = 'ss-no-results';
                            noRes.textContent = 'No matches found';
                            list.after(noRes);
                        }
                        noRes.style.display = '';
                    } else if (noRes) {
                        noRes.style.display = 'none';
                    }
                }

                // Select an item
                list.addEventListener('click', function(e) {
                    const li = e.target.closest('.ss-item');
                    if (!li) return;
                    e.stopPropagation();
                    const val = li.dataset.value;
                    selectEl.value = val;
                    selectEl.dispatchEvent(new Event('change', { bubbles: true }));
                    textSpan.textContent = li.textContent;
                    list.querySelectorAll('.ss-item').forEach(el => el.classList.remove('selected'));
                    if (val !== '') li.classList.add('selected');
                    dropdown.classList.remove('open');
                    display.classList.remove('open');
                });

                // Keyboard navigation
                search.addEventListener('keydown', function(e) {
                    const visible = Array.from(list.querySelectorAll('.ss-item:not(.hidden)'));
                    let idx = visible.findIndex(li => li.classList.contains('highlighted'));
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        visible.forEach(li => li.classList.remove('highlighted'));
                        idx = (idx + 1) % visible.length;
                        visible[idx].classList.add('highlighted');
                        visible[idx].scrollIntoView({ block: 'nearest' });
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        visible.forEach(li => li.classList.remove('highlighted'));
                        idx = idx <= 0 ? visible.length - 1 : idx - 1;
                        visible[idx].classList.add('highlighted');
                        visible[idx].scrollIntoView({ block: 'nearest' });
                    } else if (e.key === 'Enter') {
                        e.preventDefault();
                        if (idx >= 0 && visible[idx]) visible[idx].click();
                    } else if (e.key === 'Escape') {
                        dropdown.classList.remove('open');
                        display.classList.remove('open');
                    }
                });

                // Expose refresh method
                selectEl._ssRefresh = function() {
                    buildItems();
                    const selOpt = selectEl.options[selectEl.selectedIndex];
                    textSpan.textContent = selOpt ? selOpt.textContent : '-- Select --';
                };
            }

            // Close all open dropdowns
            function closeAllSearchables() {
                document.querySelectorAll('.ss-dropdown.open').forEach(dd => {
                    dd.classList.remove('open');
                    dd.previousElementSibling.classList.remove('open');
                });
            }
            document.addEventListener('click', function() {
                closeAllSearchables();
            });

            // Refresh the searchable overlay after options change
            function refreshSearchable(selectEl) {
                if (selectEl._ssRefresh) selectEl._ssRefresh();
            }

            const form = document.getElementById("add-cust-form");
            const container = document.getElementById("ip-rows-container");
            const template = document.getElementById("ip-row-template");
            const plusBtn = document.querySelector(".qty-btn.plus");
            const qtyInput = document.getElementById("ip_quantity");
            const requiredFlag = document.getElementById("ip_required_flag");

            // Load free IPs by pool from server data
            const freeByPool = JSON.parse(
                document.getElementById("free-by-pool-data").textContent
            );
            console.log("freeByPool data:", freeByPool);

            /* =========================
                ERROR MESSAGE
            ========================== */
            let dupMsg = document.getElementById("ip-duplicate-msg");
            if (!dupMsg) {
                dupMsg = document.createElement("div");
                dupMsg.id = "ip-duplicate-msg";
                dupMsg.style.cssText =
                    "color:#dc2626; font-size:13px; margin-top:6px; display:none;";
                dupMsg.textContent =
                    "Duplicate IP detected. Please make all IPs unique.";
                container.after(dupMsg);
            }

            function markInvalid(input) {
                input.style.borderColor = "#dc2626";
            }

            function clearInvalid(input) {
                input.style.borderColor = "";
            }

            function updateQuantity() {
                const count = container.querySelectorAll(".ip-row").length;
                qtyInput.value = count;
            }

            function updateRequiredFlag() {
                const rows = container.querySelectorAll(".ip-row");
                if (rows.length === 0) {
                    requiredFlag.setAttribute("required", "required");
                } else {
                    requiredFlag.removeAttribute("required");
                }
            }

            /* =========================
                RE-INDEX ROWS
            ========================== */
            function reindexRows() {
                const rows = container.querySelectorAll(".ip-row");
                rows.forEach((row, i) => {
                    const ipSelect = row.querySelector(".ip-input");
                    const noteInput = row.querySelector(".ip-note");
                    if (ipSelect) ipSelect.name = `ip_items[${i}][id]`;
                    if (noteInput) noteInput.name = `ip_items[${i}][note]`;
                });
            }

            /* =========================
                ADD ROW
            ========================== */
            function addRow(value = "") {
                const clone = template.content.cloneNode(true);
                const input = clone.querySelector(".ip-input");

                input.value = value;
                container.appendChild(clone);

                // Enhance the newly added selects with searchable dropdowns
                const rows = container.querySelectorAll('.ip-row');
                const lastRow = rows[rows.length - 1];
                const poolSel = lastRow.querySelector('.pool-select');
                const ipSel = lastRow.querySelector('.ip-input');
                if (poolSel) makeSearchable(poolSel);
                if (ipSel) makeSearchable(ipSel);

                reindexRows();
                updateQuantity();
                updateRequiredFlag();
            }

            /* =========================
                POOL CHANGE -> POPULATE IPs
            ========================== */
            function getSelectedIps() {
                const allSelects = container.querySelectorAll(".ip-input");
                const selected = [];
                allSelects.forEach(s => {
                    if (s.value) selected.push(s.value);
                });
                return selected;
            }

            function populateIpSelect(ipSelect, poolId, currentValue) {
                ipSelect.innerHTML = '<option value="">-- Select IP --</option>';
                if (!poolId || !freeByPool[poolId]) {
                    refreshSearchable(ipSelect);
                    return;
                }

                const usedIps = getSelectedIps();

                freeByPool[poolId].forEach(item => {
                    // Show if it's the current value or not already used
                    if (item.id == currentValue || !usedIps.includes(String(item.id))) {
                        const opt = document.createElement("option");
                        opt.value = item.id;
                        opt.textContent = item.ip;
                        if (item.id == currentValue) opt.selected = true;
                        ipSelect.appendChild(opt);
                    }
                });

                // Refresh the searchable overlay with new options
                refreshSearchable(ipSelect);
            }

            container.addEventListener("change", function (e) {
                if (e.target.classList.contains("pool-select")) {
                    const row = e.target.closest(".ip-row");
                    const ipSelect = row.querySelector(".ip-input");
                    populateIpSelect(ipSelect, e.target.value, "");
                }
            });

            /* =========================
                REMOVE ROW
            ========================== */
            container.addEventListener("click", function (e) {
                if (e.target.classList.contains("minus")) {
                    e.target.closest(".ip-row").remove();
                    reindexRows();
                    validateDuplicateIPs();
                    updateQuantity();
                    updateRequiredFlag();
                }
            });

            /* =========================
                PLUS BUTTON
            ========================== */
            if (plusBtn) {
                plusBtn.addEventListener("click", function () {
                    addRow("");
                });
            }

            /* =========================
                DUPLICATE CHECK
            ========================== */
            function validateDuplicateIPs() {
                const inputs = Array.from(
                    container.querySelectorAll(".ip-input")
                );

                inputs.forEach(clearInvalid);
                dupMsg.style.display = "none";

                const map = new Map();

                inputs.forEach(input => {
                    const value = input.value.trim();
                    if (!value) return;

                    if (!map.has(value)) map.set(value, []);
                    map.get(value).push(input);
                });

                let hasDuplicate = false;

                map.forEach(arr => {
                    if (arr.length > 1) {
                        hasDuplicate = true;
                        arr.forEach(markInvalid);
                    }
                });

                dupMsg.style.display = hasDuplicate ? "block" : "none";

                return !hasDuplicate;
            }

            /* =========================
                INPUT EVENTS
            ========================== */
            container.addEventListener("input", function (e) {
                if (!e.target.classList.contains("ip-input")) return;
                clearInvalid(e.target);
                dupMsg.style.display = "none";
            });

            container.addEventListener("blur", function (e) {
                if (!e.target.classList.contains("ip-input")) return;
                validateDuplicateIPs();
            }, true);

            container.addEventListener("change", function (e) {
                if (!e.target.classList.contains("ip-input")) return;
                validateDuplicateIPs();
            });

            /* =========================
                FORM SUBMIT
            ========================== */
            form.addEventListener("submit", function (e) {

                const rows = container.querySelectorAll(".ip-row");

                if (rows.length === 0) {
                    e.preventDefault();
                    addRow("");
                    return;
                }

                if (!validateDuplicateIPs()) {
                    e.preventDefault();
                }
            });

            /* =========================
                INIT
            ========================== */
            if (container.querySelectorAll(".ip-row").length === 0) {
                addRow("");
            }

        });
    </script>




</div>
</x-app-layout>