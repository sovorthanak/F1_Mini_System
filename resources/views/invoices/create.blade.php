<x-app-layout>
    <div class="container">
        <span class="add-cust">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Issue New Invoices
                                <span>
                                    <a href="/invoices" class="btn btn-primary float-end">Back</a>
                                </span>
                            </h4>
                        </div>

                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        <div class="card-body">
                            <form action="{{ route('invoices.store') }}" method="post" id="add-cust-form" onsubmit="console.log('Form is submitting');">
                                @csrf

                                <div class="acc-details">
                                    <div class="register_box_left">

                                        <div class="register-mb-3">
                                            <label for="">Customer <span>*</span></label>
                                            <select name="customer_id" class="form-control" id="customer-select">
                                                <option value="">Select Customer</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{ $customer->customer_id }}">
                                                        {{ str_pad($customer->customer_id, 6, '0', STR_PAD_LEFT) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="register_box_right">

                                        <div class="register-mb-3">
                                            <label for="customer_name">Customer's Name </label>
                                            <input type="text" id="customer_name_input" name="customer_name_input" class="form-control" required readonly/>
                                        </div>

                                        <span style="display: none;">
                                            <div class="register-mb-3">
                                                <label for="start_date">Start Date </label>
                                                <input type="date" id="start_date_input" name="start_date_input" class="form-control" required readonly/>
                                            </div>

                                            <div class="register-mb-3">
                                                <label for="end_date">End Date </label>
                                                <input type="date" id="end_date_input" name="end_date_input" class="form-control" required readonly/>
                                            </div>

                                            <div class="register-mb-3">
                                                <label for="internet_fee">Internet Fee </label>
                                                <input type="number" id="internet_fee_input" name="internet_fee_input" class="form-control" required readonly/>
                                            </div>

                                            <div class="register-mb-3">
                                                <label for="installation_fee">Installation Fee </label>
                                                <input type="number" id="installation_fee_input" name="installation_fee_input" class="form-control" required readonly/>
                                            </div>

                                            <div class="register-mb-3">
                                                <label for="bill_cycle">Bill Cycle </label>
                                                <input type="number" id="bill_cycle_input" name="bill_cycle_input" class="form-control" required readonly/>
                                            </div>
                                            <div class="register-mb-3">
                                                <label for="installation_quantity">Installation Quantity </label>
                                                <input type="number" id="installation_quantity_input" name="installation_quantity_input" class="form-control" required readonly/>
                                            </div>

                                            <div class="register-mb-3">
                                                <label for="total_amount">Total Amount </label>
                                                <input type="number" id="total_amount_input" name="total_amount_input" class="form-control" required readonly/>
                                            </div>
                                            
                                        </span>

                                    </div>

                                </div>
                                   
                                <div class="register-mb-3-btn">
                                    <button type="submit" class="btn btn-primary">Create Invoice</button>
                                </div>
                            </form>

                        </div>
                    </div>

                    <div class="card card-invoice">
                        <div class="card-header">
                            <h4>Preview Invoice</h4>
                        </div>

                        <div class="card-body card-body-invoice">
                            <style>
                                /* Import Khmer font */
                                @import url('https://fonts.googleapis.com/css2?family=Khmer+OS+Battambang:wght@400;700&display=swap');                        
                                .card-body-invoice {
                                    width: 794px;
                                    height: 1000px;
                                    margin: 0 auto;
                                    background: white;
                                    padding: 20px;
                                    font-family: 'Khmer OS Battambang', Arial, sans-serif;
                                    font-size: 14px;
                                    color: #000;
                                }

                                .invoice-header {
                                    text-align: center;
                                    margin-bottom: 20px;
                                    font-family: 'Battambang', Arial, sans-serif;
                                }

                                .invoice-header h1 {
                                    font-size: 24px;
                                    font-weight: bold;
                                    margin: 0;
                                }

                                .sub-header {
                                    display: flex;
                                    flex-direction: row;
                                    justify-content: space-between;
                                    font-size: 13px;
                                    font-weight: normal;
                                    font-family: 'Battambang', Arial, sans-serif;
                                    width: 100%;
                                }

                                .sub-header .box-left {
                                    display: flex;
                                    flex-direction: column;
                                    width: 55%;
                                    padding: 12px 10px;
                                    background-color: white;
                                }

                                .label-detail-pair {
                                    display: flex;
                                    flex-direction: row;
                                    align-items: stretch;
                                }

                                .label-detail-pair .label {
                                    display: flex;
                                    width: 25%;
                                    padding: 5px;
                                    line-height: 1.5;
                                    align-items: stretch;
                                    padding-top: 8px;
                                }

                                .label-detail-pair .colon {
                                    width: 1%;
                                    padding: 5px;
                                }

                                .label-detail-pair .details {
                                    width: 65%;
                                    padding: 5px;
                                }

                                .label-detail-pair .details-date {
                                    display: flex;
                                    padding: 0px;
                                    flex-direction: row;
                                    gap: 0px;
                                    justify-content: center;
                                    align-items: center;
                                }

                                .box-right {
                                    display: flex;
                                    flex-direction: column;
                                    width: 45%;
                                    padding: 12px 10px;
                                    text-align: start;
                                    font-family: 'Battambang', Arial, sans-serif;
                                }

                                .box-right .label-detail-pair {
                                    display: flex;
                                    flex-direction: row;
                                    align-items: stretch;
                                }

                                .box-right .label-detail-pair .label {
                                    width: 50%;
                                    line-height: 1.5;
                                    display: flex;
                                    align-items: center;
                                }

                                .box-right .label-detail-pair .colon {
                                    width: 1%;
                                    padding: 5px;
                                    display: flex;
                                    align-items: center;
                                }

                                .box-right .label-detail-pair .details {
                                    width: 30%;
                                    padding: 5px;
                                    line-height: 1.5;
                                    display: flex;
                                    align-items: center;
                                }

                                .invoice-table {
                                    margin-top: 10px;
                                    width: 100%;
                                    border-collapse: collapse;
                                    font-family: 'Battambang', Arial, sans-serif;
                                    margin-bottom: 20px;
                                    font-size: 13px; /* Reduced from 12px */
                                }

                                .invoice-table th,
                                .invoice-table td {
                                    border: 1px solid #000;
                                    padding: 5px; /* Reduced from 6px */
                                    text-align: center;
                                }

                                .invoice-table td:nth-child(2) {
                                    text-align: left; /* Align DESCRIPTION column to the left */
                                    padding-left: 20px
                                }

                                .invoice-table th {
                                    background-color: #4a90e2;
                                    color: white;
                                    font-weight: bold;
                                }

                                .invoice-table tbody tr {
                                    height: 40px; /* Reduced from 60px */
                                }

                                .invoice-table tbody .total-row {
                                    height: 45px; /* Reduced from 40px */
                                    font-weight: bold;
                                    background-color: #f5f5f5;
                                }

                                .invoice-table tbody td {
                                    vertical-align: middle;
                                }

                                .total-amount {
                                    display: none;
                                }

                                .signatures {
                                    font-family: 'Battambang', Arial, sans-serif;
                                    display: flex;
                                    justify-content: space-between;
                                    margin-top: 200px;
                                    font-size: 12px;
                                }

                                .signatures div {
                                    width: 45%;
                                    text-align: center;
                                }

                                .signatures p {
                                    margin: 5px 0;
                                }

                                .signature-placeholder {
                                    border-bottom: 1px solid #000;
                                    height: 40px;
                                    margin-bottom: 20px;
                                    margin-left: 85px;
                                }
                            </style>
                        
                            <!-- Invoice Content -->
                            <div class="invoice-header">
                                <h1>វិក្កយបត្រ<br>INVOICE</h1>
                            </div>
                        
                            {{-- <div class="invoice-details">
                                <div class="left">
                                    <p><strong>អតិថិជន / CUSTOMER:</strong> Wang Jia</p>
                                    <p><strong>អាសយដ្ឋាន / ADDRESS:</strong> Borey Peng Huoth The Star Platinum Athina, NA10, Street 16, Sangkat Nirouth, Khan Chbar Ampov, Phnom Penh</p>
                                </div>
                                <div class="right">
                                    <p><strong>លេខវិក្កយបត្រ / INVOICE NO.:</strong> 25-00044</p>
                                    <p><strong>កាលបរិច្ឆេទ / BILL DATE:</strong> 26-Mar-25</p>
                                    <p><strong>កាលបរិច្ឆេទផុតកំណត់ / DUE DATE:</strong> 29-Mar-25</p>
                                    <p><strong>រយៈពេល / PERIOD:</strong> 26 Mar 2025 - 26 Apr 2025</p>
                                </div>
                            </div> --}}

                            <div class="sub-header">
                                <div class="box-left">
                                    <div class="label-detail-pair">
                                        <div class="label">អតិថិជន <br> Customer</div>
                                        <div class="colon">:</div>
                                        <div class="details" id="name_pre"></div>
                                    </div>

                                    <div class="label-detail-pair">
                                        <div class="label">អាស័យដ្ឋាន</div>
                                        <div class="colon">:</div>
                                        <div class="details" id="alt_address_pre">
                                            {{-- Borey Peng Huoth The Star Platinum Athina, #A10, Street 16, Sangkat Nirouth, Khan Chbar Ampov, Phnom Penh --}}
                                        </div>
                                    </div>

                                    <div class="label-detail-pair">
                                        <div class="label">Address</div>
                                        <div class="colon">:</div>
                                        <div class="details" id="address_pre">
                                            {{-- Borey Peng Huoth The Star Platinum Athina, #A10, Street 16, Sangkat Nirouth, Khan Chbar Ampov, Phnom Penh --}}
                                        </div>
                                    </div>

                                    <div class="label-detail-pair">
                                        <div class="label">រយៈពេល <br> Period</div>
                                        <div class="colon">:</div>
                                        <div class="details">
                                            <span id="startdate_pre"></span> &nbsp; - &nbsp; <span id="enddate_pre"></span>
                                        </div>
                                    </div>

                                </div>
                        
                                <div class="box-right">
                                    <div class="label-detail-pair">
                                        <div class="label">លេខវិក្កយបត្រ <br> Invoice No.</div>
                                        <div class="colon">:</div>
                                        {{-- <div class="details">25-00044</div> --}}
                                    </div>
                                    <div class="label-detail-pair">
                                        <div class="label">កាលបរិច្ឆេទ <br> Bill Date</div>
                                        <div class="colon">:</div>
                                        <div class="details details-date" id="bill_date_pre"></div>
                                    </div>
                                    <div class="label-detail-pair">
                                        <div class="label">កាលបរិច្ឆេទផុតកំណត់ <br> Due Date</div>
                                        <div class="colon">:</div>
                                        <div class="details details-date" id="duedate_pre"></div>
                                    </div>

                                </div>
                            </div>
                        
                            <table class="invoice-table">
                                <thead>
                                    <tr>
                                        <th>ល.រ<br>N<sup>0</sup></th>
                                        <th>បរិយាយ<br>DESCRIPTION</th>
                                        <th>បរិមាណ<br>QUANTITY</th>
                                        <th>តម្លៃឯកតា<br>UNIT PRICE</th>
                                        <th>តម្លៃ<br>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Internet <span id="tariff_pre"></span> <span id="bandwidth_pre"></span></td>
                                        <td id="billrange_pre"></td>
                                        <td>$ <span id="internet_fee_pre"></span></td>
                                        <td>$ <span id="total_amount_display"></span></td>
                                    </tr>
                                    <tr class="inv-ip-fee-row">
                                        <td>2</td>
                                        <td>IP Fee</td>
                                        <td id="ip_quantity"></td>
                                        <td>$ <span id="ip_fee"></span></td>
                                        <td>$ <span id="ip_fee_total"></span></td>
                                    </tr>
                                    <tr class="inv-installation-fee-row">
                                        <td id="nb_installation_row">3</td>
                                        <td>Installation Fee</td>
                                        <td><span id="installation_quantity"></span> time(s)</td>
                                        <td>$ <span id="installation_fee_pre"></span></td>
                                        <td>$ <span id="installation_fee_total"></span></td>
                                    </tr>
                                    <tr class="total-row">
                                        <td colspan="4">សរុប / TOTAL</td>
                                        <td style="text-align: center; padding-left:0px;">$ <span id="overall_total"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        
                            <div class="signatures">
                                <div class="customer-signature">
                                    <div class="signature-placeholder"></div>
                                    <p>ហត្ថលេខា និងឈ្មោះអតិថិជន<br>Customer's Signature & Name</p>
                                </div>
                                <div class="seller-signature">
                                    <div class="signature-placeholder"></div>
                                    <p>ហត្ថលេខា និងឈ្មោះអ្នកលក់<br>Seller's Signature & Name</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </span>
        <script>
            document.getElementById('customer-select').addEventListener('change', function() {
                const customerId = this.value;
                // Format options
                const dateOptions = {
                    day: 'numeric',
                    month: 'numeric',
                    year: 'numeric'
                };

                if (customerId) {
                    fetch("{{ url('/customer') }}/" + customerId, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    
                    .then(response => response.json())
                    .then(data => {
                        const billCycle = Number(data.bill_cycle) || 0;
                        const internetFee = (Number(data.internet_fee) || 0).toFixed(2);                        
                        const ipFee = Number(data.ip_fee) || 0;
                        const ipQuantity = Number(data.ip_quantity) || 0;
                        const ipFeeTotal = ipFee * ipQuantity;
                        const number_of_invoices = Number(data.number_of_invoices) || 0;
                        const installationFee = Number(data.installation_fee) || 0;
                        const installationQuantity = 1;
                        const installationFeeTotal = installationFee * installationQuantity;
                        const unitPrice = (parseFloat(internetFee) / parseFloat(billCycle)).toFixed(2);
                        
                        // Populate the input fields and div
                        document.getElementById('customer_name_input').value = data.customer_name || ''; 
                        document.getElementById('name_pre').innerText = data.customer_name || '';
                        document.getElementById('address_pre').innerText = data.address || '';
                        document.getElementById('alt_address_pre').innerText = data.alt_address || '';
                        document.getElementById('tariff_pre').innerText = data.tariff_name || '';
                        document.getElementById('bandwidth_pre').innerText = data.bandwidth || '';
                        document.getElementById('billrange_pre').innerText = (data.bill_cycle || '') + ' month(s)';
                        document.getElementById('internet_fee_pre').innerText = unitPrice || '';
                        document.getElementById('internet_fee_input').value = data.internet_fee || '';
                        document.getElementById('installation_fee_pre').innerText = data.installation_fee || '';
                        document.getElementById('installation_fee_input').value = data.installation_fee || '';
                        document.getElementById('installation_quantity').innerText = 1;
                        document.getElementById('ip_fee').innerText = data.ip_fee || '';
                        document.getElementById('ip_quantity').innerText = data.ip_quantity || '';
                        document.getElementById('bill_cycle_input').value = data.bill_cycle || '';
                        document.getElementById('installation_quantity_input').value = 1;

                        // Ensure bill_cycle and internet_fee are numbers before multiplyin
                        

                        document.getElementById('installation_fee_total').innerText = installationFeeTotal.toFixed(2); // formats to 2 decimal places
                        document.getElementById('ip_fee_total').innerText = ipFeeTotal.toFixed(2); // formats to 2 decimal places
                        document.getElementById('total_amount_display').innerText = internetFee; // formats to 2 decimal places                        // Start Date
                        
                        function formatDateLocal(dateString) {
                            const date = new Date(dateString);
                            const year = date.getFullYear();
                            const month = String(date.getMonth() + 1).padStart(2, '0');
                            const day = String(date.getDate()).padStart(2, '0');
                            return `${year}-${month}-${day}`;
                        }

                        // Start Date
                        document.getElementById('startdate_pre').innerText = data.start_date ? 
                            new Date(data.start_date).toLocaleDateString('en-GB', dateOptions) : '';
                        document.getElementById('start_date_input').value = data.start_date ? 
                            formatDateLocal(data.start_date) : '';

                        // End Date
                        const endDate = new Date(data.end_date);
                        endDate.setDate(endDate.getDate() - 1);

                        document.getElementById('enddate_pre').innerText = data.end_date ? 
                            endDate.toLocaleDateString('en-GB', dateOptions) : '';

                        document.getElementById('end_date_input').value = data.end_date ? 
                            formatDateLocal(data.end_date) : '';

                        // Set bill date to today's date
                        const today = new Date();
                        document.getElementById('bill_date_pre').innerText = today.toLocaleDateString('en-GB', dateOptions);

                        // Due Date = bill date + 7 days
                        const dueDate = new Date(today); // Create a new Date object to avoid mutating today
                        dueDate.setDate(today.getDate() + 7); // Add 7 days
                        document.getElementById('duedate_pre').innerText = dueDate.toLocaleDateString('en-GB', dateOptions);

                        if (ipFee  === 0) {
                            document.querySelector('.inv-ip-fee-row').style.display = 'none'; // Hide installation fee row if data.ip_fee is falsy
                            document.getElementById('nb_installation_row').innerText = '2'; // Formats to 2 decimal places
                        } else {
                            document.querySelector('.inv-ip-fee-row').style.display = 'table-row'; // Show installation fee row if data.ip_fee is truthy
                        }

                        if (number_of_invoices > 0 || installationFee == 0) {
                            document.querySelector('.inv-installation-fee-row').style.display = 'none'; // Hide installation fee row if there are invoices or installationFee is 0
                            const overallTotal = (parseFloat(internetFee) + parseFloat(ipFeeTotal)).toFixed(2); // Formats to 2 decimal places                      
                            document.getElementById('overall_total').innerText = overallTotal; // Formats to 2 decimal places
                            document.getElementById('total_amount_input').value = overallTotal; // Formats to 2 decimal places
                        } else {
                            document.querySelector('.inv-installation-fee-row').style.display = 'table-row'; // Show installation fee row if no invoices and installationFee is not 0
                            const overallTotal = (parseFloat(internetFee) + parseFloat(ipFeeTotal) + parseFloat(installationFeeTotal)).toFixed(2); // Formats to 2 decimal places                      
                            document.getElementById('overall_total').innerText = overallTotal; // Formats to 2 decimal places
                            document.getElementById('total_amount_input').value = overallTotal; // Formats to 2 decimal places
                        }


                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                } else {
                    // Clear the fields if no customer is selected
                    document.getElementById('customer_name_input').value = '';
                    document.getElementById('name_pre').innerText = '';
                    document.getElementById('address_pre').innerText = ''; 
                    document.getElementById('alt_address_pre').innerText = '';
                    document.getElementById('tariff_pre').innerText = '';
                    document.getElementById('billrange_pre').innerText = '';
                    document.getElementById('internet_fee_pre').innerText = '';
                    document.getElementById('installation_fee_pre').innerText = '';
                    document.getElementById('installation_quantity').innerText = '';
                    document.getElementById('ip_fee').innerText = '';
                    document.getElementById('ip_quantity').innerText = '';
                    document.getElementById('installation_fee_total').innerText = '';
                    document.getElementById('ip_fee_total').innerText = '';
                    document.getElementById('total_amount_display').innerText = '';
                    document.getElementById('startdate_pre').innerText = '';
                    document.getElementById('enddate_pre').innerText = '';
                    document.getElementById('duedate_pre').innerText = '';
                    document.getElementById('bill_date_pre').innerText = '';
                    document.getElementById('overall_total').innerText = '';
                }
            });
        </script>

    </div>
</x-app-layout>