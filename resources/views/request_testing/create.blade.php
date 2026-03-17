<x-app-layout>
<div class="container">
    <span class="add-cust">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create New Request Testing
                            <span>
                                <a href="/request-change" class="btn btn-primary float-end">Back</a>
                            </span>
                        </h4>
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

                    <div class="card-body">
                        <form action="{{ route('request-testing.store') }}" method="post" id="add-cust-form" enctype="multipart/form-data">
                            @csrf

                            <div class="acc-details">
                                <div class="register_box_left">      

                                <div class="register-mb-3 register-mb-3-with-import">

                                    <div>
                                        <label for="">Customer's ID</label>
                                        <input type="text" name="customer_id" id="customerId" class="form-control" value="{{ old('customer_id', request()->query('customer_id')) }}" required/>
                                        @error('customer_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        </div>
                                        <button type="button" class="btn btn-primary" id="importBtn">Import</button>
                                    </div>

                                    <div id="customerInfo" style="display:none"></div>

                                    <br>
                                    <h5 style="font-size: 18px; width:100%; text-align:center">----------- Old Information -----------</h5>

                                    <div class="register-mb-3">
                                        <label for="">Old Customer Name</label>
                                        <input type="text" name="old_customer_name" class="form-control" value="{{ old('old_customer_name') }}" readonly/>
                                        @error('old_customer_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="register-mb-3 register-mb-3-double-input">
                                        <div class="double-input">
                                            <label for="">Old PPPOE</label>
                                            <input type="text" name="old_pppoe" class="form-control" value="{{ old('old_pppoe') }}" readonly/>
                                            @error('old_pppoe')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="old_pw">Old Password</label>
                                            <input type="text" name="old_pw" class="form-control" value="{{ old('old_pw') }}" readonly/>
                                            @error('old_pw')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="register-mb-3 register-mb-3-double-input">
                                        <div class="double-input" id="old-tariff-group">
                                            <label for="">Old Tariff</label>
                                            <select name="old_tariff" id="old_tariff" class="form-control">
                                                <option value="">-- Choose a tariff --</option>
                                                @foreach ($tariffs as $name)
                                                    <option value="{{ $name }}" {{ old('old_tariff') == $name ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @error('old_tariff')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="double-input" id="old-bandwidth-group">
                                            <label for="old_bandwidth">Old Bandwidth</label>
                                            <select name="old_bandwidth" id="old_bandwidth" class="form-control">
                                                <option value="">-- Choose old bandwidth --</option>
                                                @foreach ($bandwidths as $bandwidth)
                                                    <option value="{{ $bandwidth->speed }}" {{ old('old_bandwidth') == $bandwidth->speed ? 'selected' : '' }}>
                                                        {{ $bandwidth->speed }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('old_bandwidth')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="register-mb-3">
                                        <label for="">Old Router</label>
                                        <input type="text" name="old_router" class="form-control" value="{{ old('old_router') }}" readonly/>
                                        @error('old_router')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <h5 style="font-size: 18px; width:100%; text-align:center">--------------------------------------------</h5>

                                    <div class="register-mb-3">
                                        <label for="">Request Date</label>
                                        <input type="date" name="request_date" class="form-control" value="{{ old('request_date') }}" required/>
                                        @error('request_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="register-mb-3">
                                        <label for="remark">Remark</label>
                                        <textarea
                                            name="remark"
                                            id="remark"
                                            class="form-control"
                                            rows="1"
                                            style="resize: vertical;"
                                        >{{ old('remark', $remark ?? '') }}</textarea>
                                        @error('remark')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                <br>

                                <div class="register_box_right">
                                    <div class="register-mb-3">
                                        <label for="request_type">Request Type <span>*</span></label>
                                        <select name="request_type" class="form-control" required>
                                            <option value="">Select Request Type</option>
                                            <option value="Testing Upgrade" {{ old('request_type') == 'Testing Upgrade' ? 'selected' : '' }}>Testing Upgrade</option>
                                            <option value="Testing Change Service" {{ old('request_type') == 'Testing Change Service' ? 'selected' : '' }}>Testing Change Service</option>
                                        </select>
                                        @error('request_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <br>
                                    <h5 style="font-size: 18px; width:100%; text-align:center">----------- New Information -----------</h5>

                                    <div class="register-mb-3">
                                        <label for="">New Customer Name</label>
                                        <input type="text" name="new_customer_name" class="form-control" value="{{ old('new_customer_name') }}"/>
                                        @error('new_customer_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="register-mb-3 register-mb-3-double-input">
                                        <div class="double-input">
                                            <label for="">New PPPOE</label>
                                            <input type="text" name="new_pppoe" class="form-control" value="{{ old('new_pppoe') }}"/>
                                            @error('new_pppoe')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="new_pw">New Password</label>
                                            <input type="text" name="new_pw" class="form-control" value="{{ old('new_pw') }}"/>
                                            @error('new_pw')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="register-mb-3 register-mb-3-double-input">
                                        <div class="double-input" id="new-tariff-group">
                                            <label for="">New Tariff</label>
                                            <select name="new_tariff" id="new_tariff" class="form-control">
                                                <option value="">-- Choose a tariff --</option>
                                                @foreach ($tariffs as $name)
                                                    <option value="{{ $name }}" {{ old('new_tariff') == $name ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @error('new_tariff')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="double-input" id="new-bandwidth-group">
                                            <label for="new_bandwidth">New Bandwidth</label>
                                            <select name="new_bandwidth" id="new_bandwidth" class="form-control">
                                                <option value="">-- Choose new bandwidth --</option>
                                                @foreach ($bandwidths as $bandwidth)
                                                    <option value="{{ $bandwidth->speed }}" {{ old('new_bandwidth') == $bandwidth->speed ? 'selected' : '' }}>
                                                        {{ $bandwidth->speed }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('new_bandwidth')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="register-mb-3">
                                        <label for="">New Router</label>
                                        <input type="text" name="new_router" class="form-control" value="{{ old('new_router') }}"/>
                                        @error('new_router')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <h5 style="font-size: 18px; width:100%; text-align:center">--------------------------------------------</h5>

                                    <div class="register-mb-3">
                                        <label for="">End Testing Date</label>
                                        <input type="date" name="end_testing_date" class="form-control" value="{{ old('end_testing_date') }}" required/>
                                        @error('end_testing_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <br>
                            
                            <span class="register-mb-3-btn">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <button type="reset" id="clearButton" class="btn btn-danger">Clear</button>
                            </span>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </span>
</div>
<script>
    // === Form Initialization ===
    const form = document.getElementById('add-cust-form');
    const clearButton = document.getElementById('clearButton');
    let importedCustomer = null;

    // === Clear Button Event Listener ===
    clearButton.addEventListener('click', function() {
        form.reset();
        document.getElementById('customerInfo').innerHTML = '';
        
    });

    // === Import Button Event Listener ===
    document.getElementById('importBtn').addEventListener('click', function () {

        const requestTypeSelect = document.querySelector('select[name="request_type"]');
        const requestType = requestTypeSelect.value;

        // === Block import for certain request types ===
        const disabledRequestTypes = ['Testing Upgrade','Testing Change Service'];
        if (disabledRequestTypes.includes(requestType)) {
            console.log(`❌ Import blocked: request type "${requestType}" is not allowed`);
            return; // stop the function here
        }

        const customerId = document.getElementById('customerId').value;
        console.log('🔹 Clicked Import Button');
        console.log('customerId:', customerId);

        // Fetch customer data from server
        fetch(`/customers/${customerId}`)
            .then(res => res.json())
            .then(data => {
                console.log('🔹 Server response (data):', data);

                if (!data.success) {
                    document.getElementById('customerInfo').innerHTML = '<p style="color:red;">Customer not found.</p>';
                    const customerInfo = document.getElementById('customerInfo');
                    customerInfo.style.display = 'block';
                    customerInfo.innerHTML = '<p style="color:red;">Customer not found.</p>';
                    return;
                }

                // Cache customer
                importedCustomer = data.customer;
                const customer = importedCustomer;
                console.log('🔹 Fetched customer object (customer):', customer);

                // Populate old customer fields
                const oldFields = {
                    old_customer_name: customer.name,
                    old_tariff: customer.old_tariff,
                    old_bandwidth: customer.old_bandwidth,
                    old_pppoe: customer.old_pppoe,
                    old_pw: customer.old_pw,
                    old_router: customer.old_router,
                };

                console.log('🔹 Old fields object (oldFields):', oldFields);

                Object.keys(oldFields).forEach(key => {
                    const el = document.querySelector(`[name="${key}"]`);
                    if (el) {
                        el.value = oldFields[key] || '';
                        console.log(`Set field ${key} =`, oldFields[key]);
                    }
                });

                const customerInfo = document.getElementById('customerInfo');
                customerInfo.style.display = 'none';
            })
            .catch(err => {
                console.error('❌ Fetch error:', err);
                const customerInfo = document.getElementById('customerInfo');
                customerInfo.style.display = 'block';
                customerInfo.innerHTML = '<p style="color:red;">Something went wrong.</p>';
            });
    });

</script>


</x-app-layout>
               