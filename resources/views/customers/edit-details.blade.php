<x-app-layout>
    <div class="container">
        <span class="add-cust">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Customer
                                <span>
                                    <a href="/customers" class="btn btn-primary float-end">Back</a>
                                </span>
                            </h4>
                        </div>

                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif


                        <div class="card-body">
                            <form action="{{ route('customers.update-details', $customer->customer_id) }}" method="post" id="add-cust-form" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="acc-details">
                                    <div class="register_box_left">

                                        <div class="register-mb-3">
                                            <label for="">Customer's ID <span>*</span></label>
                                            <input type="text" name="customer_id" class="form-control" value="{{ old('customer_id', $customer->customer_id ?? '') }}" required readonly />
                                            @error('customer_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>





                                        {{-- <div class="register-mb-3">
                                            <label for="">Upload National ID or Passport <span>*</span></label>
                                            <input type="file" name="id_or_passport_image" class="form-control" accept=".jpg,.jpeg,.png,.gif,image/jpeg,image/png,image/gif" required />
                                            @error('id_or_passport_image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div> --}}

                                        <div class="register-mb-3">
                                            <label for="">Phone Number</label>
                                            <input type="number" name="phone_number" class="form-control" value="{{ old('phone_number', $customer->phone_number ?? '') }}" />
                                            @error('phone_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="register-mb-3">
                                            <label for="agent">Agent <span>*</span></label>
                                            <select name="agent" class="form-control" required>
                                                <option value="" disabled {{ old('agent', $customer->agent ?? '') == '' ? 'selected' : '' }}>
                                                    Select Customer Type
                                                </option>
                                                <option value="unspecified" {{ old('agent', $customer->agent ?? '') == 'unspecified' ? 'selected' : '' }}>
                                                    Unspecified
                                                </option>
                                                <option value="Sale Admin" {{ old('agent', $customer->agent ?? '') == 'Sale Admin' ? 'selected' : '' }}>
                                                    Sale Admin
                                                </option>
                                                <option value="Mr. Tep Theara" {{ old('agent', $customer->agent ?? '') == 'Mr. Tep Theara' ? 'selected' : '' }}>
                                                    Mr. Tep Theara
                                                </option>
                                                <option value="Mr. Uch Kaing" {{ old('agent', $customer->agent ?? '') == 'Mr. Uch Kaing' ? 'selected' : '' }}>
                                                    Mr. Uch Kaing
                                                </option>
                                                <option value="Agency MongKol" {{ old('agent', $customer->agent ?? '') == 'Agency MongKol' ? 'selected' : '' }}>
                                                    Agency MongKol
                                                </option>
                                                <option value="Mr. Gouv Leangchea" {{ old('agent', $customer->agent ?? '') == 'Mr. Gouv Leangchea' ? 'selected' : '' }}>
                                                    Mr. Gouv Leangchea
                                                </option>
                                                <option value="Mr. Dao KiHeng" {{ old('agent', $customer->agent ?? '') == 'Mr. Dao KiHeng' ? 'selected' : '' }}>
                                                    Mr. Dao KiHeng
                                                </option>
                                                <option value="Mr. Se Samnang" {{ old('agent', $customer->agent ?? '') == 'Mr. Se Samnang' ? 'selected' : '' }}>
                                                    Mr. Se Samnang
                                                </option>
                                                <option value="Agency Jing Jing" {{ old('agent', $customer->agent ?? '') == 'Agency Jing Jing' ? 'selected' : '' }}>
                                                    Agency Jing Jing
                                                </option>
                                                <option value="Mr. Sorn Daniel" {{ old('agent', $customer->agent ?? '') == 'Mr. Sorn Daniel' ? 'selected' : '' }}>
                                                    Mr. Sorn Daniel
                                                </option>
                                            </select>
                                            @error('agent')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="register-mb-3">
                                            <label for="">Address Line (English) <span>*</span></label>
                                            <input type="text" name="address_line_1" class="form-control" placeholder="House Number, Road Name" value="{{ old('address_line_1', $customer->address_line_1 ?? '') }}" required/>
                                            @error('address_line_1')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="register-mb-3 register-mb-3-double-input">

                                            <div class="double-input" style="width: 50%">
                                                <label for="">PPPoE</label>
                                                <input type="text" name="pppoe" class="form-control" value="{{ old('pppoe', $customer->pppoe ?? '') }}"/>
                                                @error('pppoe')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror                                            
                                            </div>

                                            <div style="width: 50%">
                                                <label for="">Password</label>
                                                <input type="text" name="password" class="form-control" value="{{ old('password', $customer->password ?? '') }}"/>
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="register-mb-3 register-mb-3-double-input">
                                            <div class="double-input">
                                                <label for="">Tariff <span>*</span></label>
                                                <select name="tariff_name" id="tariff" class="form-control" required>
                                                    <option value="">-- Choose a tariff --</option>
                                                    @foreach ($tariffs as $tariff)
                                                        <option value="{{ $tariff }}"
                                                            {{ old('tariff_name', $customer->tariff_name) == $tariff ? 'selected' : '' }}>
                                                            {{ $tariff }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('tariff_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        
                                            <div>
                                                <label for="">Bandwidth <span>*</span></label>
                                                <select name="bandwidth" id="bandwidth" class="form-control" required>
                                                    <option value="">-- Choose bandwidth --</option>
                                                    @foreach ($bandwidths as $bw)
                                                        <option value="{{ $bw->speed }}" 
                                                            {{ old('bandwidth', $customer->bandwidth) == $bw->speed ? 'selected' : '' }}>
                                                            {{ $bw->speed }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('bandwidth')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        

                                        <div class="register-mb-3">
                                            <label for="province">Location (Area) <span>*</span></label>
                                            <select name="province" id="province" class="form-control" required>
                                                <option value="">Select Province</option>

                                                @foreach($locations as $location)
                                                    <option value="{{ $location->name }}" 
                                                        {{ old('province', $customer->province) == $location->name ? 'selected' : '' }}>
                                                        {{ $location->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('province')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="register-mb-3">
                                            <label for="">Router</label>
                                            <input type="text" name="router" class="form-control" value="{{ old('router', $customer->router) }}"/>
                                            @error('router')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="register-mb-3">
                                            <label for="">Upload National ID or Passport (leave blank to keep existing)</label>
                                            <input type="file" name="id_or_passport_image" class="form-control" accept="image/*" />
                                            @error('id_or_passport_image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        
                                            @if ($customer->identity_doc)
                                                <div style="margin-top: 8px;">
                                                    <small>Current file:</small><br>
                                                    <img src="{{ asset('storage/id_cards/' . $customer->identity_doc) }}" width="250" style="border: 1px solid #ccc; border-radius: 4px;">
                                                    <br>
                                                    <a href="{{ asset('storage/id_cards/' . $customer->identity_doc) }}" download style="font-size: 0.8rem;">⬇ Download Current Document</a>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- <div class="register-mb-3">
                                            <label for="">Start Date <span>*</span></label>
                                            <input type="date" id="Start-date" name="start_date" class="form-control" style="width: 100%" 
                                                   value="{{ old('start_date', \Carbon\Carbon::parse($customer->start_date)->format('Y-m-d') ?? '') }}" />
                                            @error('start_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div> --}}

                                    </div>


                                    <div class="register_box_right">

                                        <div class="register-mb-3">
                                            <label for="">Customer's Name <span>*</span></label>
                                            <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $customer->customer_name ?? '') }}" required />
                                            @error('customer_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="register-mb-3">
                                            <label for="">Customer's Name (Khmer)  <span>*</span></label>
                                            <input type="text" name="alt_customer_name" class="form-control" value="{{ old('customer_name', $customer->alt_customer_name ?? '') }}"
                                            required/>
                                            @error('customer-name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="register-mb-3">
                                            <label for="currency">Currency <span>*</span></label>
                                            <select name="currency" id="currency" class="form-control" required>
                                                <option value="">Select Currency Type</option> <!-- Placeholder option -->
                                                <option value="K.H Riel" {{ old('currency') == 'K.H Riel' ? 'selected' : '' }}>[KHR] Khmer Riel</option>
                                                <option value="U.S. Dollar" {{ old('currency', 'U.S. Dollar') == 'U.S. Dollar' ? 'selected' : '' }}>[USD] U.S Dollar</option>
                                            </select>                                    
                                            @error('currency')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="register-mb-3">
                                            <label for="">Address Line (Khmer) <span>*</span></label>
                                            <input type="text" name="alt_address_line_1" class="form-control" placeholder="[House Number, Road Name] in local language" value="{{ old('alt_address_line_1', $customer->alt_address_line_1 ?? '') }}" required/>
                                            @error('alt_address_line_1')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="register-mb-3">
                                            <label for="">Lat/Long</label>
                                            <input type="string" name="lat_long" class="form-control" value="{{ old('lat_long', $customer->lat_long ?? '') }}" />
                                            @error('lat_long')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="register-mb-3 register-mb-3-double-input">
                                            <div class="double-input">
                                                <label for="">Internet Fee <span>*</span></label>
                                                <input type="number" step="any" name="internet_fee" class="form-control" value="{{ old('internet_fee', $customer->internet_fee ?? '') }}" required placeholder="USD ($)"/>
                                                @error('internet_fee')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="bill_cycle">Bill Cycle <span>*</span></label>
                                                <select name="bill_cycle" class="form-control" required >
                                                    <option value=" {{ $customer->bill_cycle }} ">{{ $customer->bill_cycle }} Month(s)</option> <!-- Placeholder option -->
                                                </select>                                  
                                                @error('bill_cycle')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="register-mb-3">
                                            <label for="">Remark</label>
                                            <input type="text" name="remark" class="form-control" value="{{ old('remark', $customer->remark) }}"/>
                                            @error('remark')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- <div class="register-mb-3">
                                            <label for="">Complete Date</label>
                                            <input type="date" id="Complete-date" name="complete_date" class="form-control" style="width: 100%" 
                                                   value="{{ old('complete_date', \Carbon\Carbon::parse($customer->complete_date)->format('Y-m-d') ?? '') }}" />
                                            @error('complete_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div> --}}
                                                                                      
                                    </div>

                                    
                                </div>
                                   
                                <div class="register-mb-3-btn">
                                    <button type="submit" class="btn btn-primary">Update Customer</button>
                                    <button type="reset" id="clearButton" class="btn btn-danger">Clear Form</button>
                                </div>
                            </form>
                            <script>
                                const form = document.getElementById('add-cust-form');
                                const clearButton = document.getElementById('clearButton');
                        
                                // Clear all form fields when "Clear" button is clicked
                                clearButton.addEventListener('click', function() {
                                    // Reset the form to its default state
                                    form.reset();
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </span>
    </div>

</x-app-layout>