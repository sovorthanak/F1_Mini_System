<x-app-layout>
    <div class="container">
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
        
        <span class="add-cust">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-invoice">
                        <div class="card-header">
                            <h4>View Invoice ID: {{ $invoice->invoice_id }}
                                <span>
                                @if(trim(strtolower($invoice->payment_status)) !== 'paid')
                                    <a href="#" class="btn btn-success make-payment"
                                        data-invoice-id="{{ $invoice->invoice_id }}"
                                        title="Make Payment">Make Payment
                                    </a>
                                @endif
                                    <a href="/unpaid-invoices" class="btn btn-primary float-end">Back</a>
                                </span>
                            </h4>
                        </div>

                        <div class="card-body card-body-invoice">
                            <!-- Invoice Content -->
                            <div class="invoice-header">
                                <h1>វិក្កយបត្រ<br>INVOICE</h1>
                            </div>

                            <div class="sub-header">
                                <div class="box-left">
                                    <div class="label-detail-pair">
                                        <div class="label">អតិថិជន <br> Customer</div>
                                        <div class="colon">:</div>
                                        <div class="details" id="name_pre">{{ $invoice->customer_name }}</div>
                                    </div>

                                    <div class="label-detail-pair">
                                        <div class="label">អាស័យដ្ឋាន</div>
                                        <div class="colon">:</div>
                                        <div class="details" id="alt_address_pre">{{ $invoice->alt_address_line_1}}</div>
                                    </div>

                                    <div class="label-detail-pair">
                                        <div class="label">Address</div>
                                        <div class="colon">:</div>
                                        <div class="details" id="address_pre">{{ $invoice->customer->address_line_1 }}</div>
                                    </div>

                                    <div class="label-detail-pair">
                                        <div class="label">រយៈពេល <br> Period</div>
                                        <div class="colon">:</div>
                                        <div class="details">
                                            <div id="startdate_pre">{{ \Carbon\Carbon::parse($invoice->start_date)->format('d M, Y') }} &nbsp; - &nbsp; {{ \Carbon\Carbon::parse($invoice->end_date)->subDay()->format('d M, Y') }} </div>    
                                        </div>
                                    </div>
                                </div>

                                <div class="box-right">
                                    <div class="label-detail-pair">
                                        <div class="label">លេខវិក្កយបត្រ <br> Invoice No.</div>
                                        <div class="colon">:</div>
                                        <div class="details details-date">{{ $invoice->invoice_id }}</div>
                                    </div>
                                    <div class="label-detail-pair">
                                        <div class="label">កាលបរិច្ឆេទ <br> Bill Date</div>
                                        <div class="colon">:</div>
                                        <div class="details details-date">{{ \Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="label-detail-pair">
                                        <div class="label">កាលបរិច្ឆេទផុតកំណត់ <br> Due Date</div>
                                        <div class="colon">:</div>
                                        <div class="details details-date" id="duedate_pre">
                                            {{ \Carbon\Carbon::parse($invoice->created_at)->addDays(7)->format('d/m/Y') }}
                                        </div>
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
                                        <td>Internet {{ $invoice->tariff_name }} {{ $invoice->bandwidth }}</td>
                                        <td id="billrange_pre">{{ $invoice->bill_cycle }} month(s)</td>
                                        <td id="internet_fee_pre">${{ number_format($invoice->internet_fee / $invoice->bill_cycle, 2) }}</td>
                                        <td>${{ number_format($invoice->internet_fee, 2) }}</td>                                    
                                    </tr>
                                    @if($invoice->ip_fee > 0)
                                    <tr class="inv-ip-fee-row">
                                        <td>2</td>
                                        <td>IP Fee</td>
                                        <td id="ip_quantity">{{ $invoice->ip_quantity}}</td>
                                        <td><span id="ip_fee">${{ $invoice->ip_fee}}</span></td>
                                        <td><span id="ip_fee_total">${{ number_format($invoice->ip_quantity * $invoice->ip_fee, 2)}}</span></td>
                                    </tr>
                                    @endif
                                    @if($invoice->installation_or_not == 'true')
                                    <tr>
                                        <td>3</td>
                                        <td>Installation Fee</td>
                                        <td>1 Time</td>
                                        <td id="installation_fee_pre">${{ number_format($invoice->installation_fee, 2) }}</td>
                                        <td>${{ number_format($invoice->installation_fee, 2) }}</td>
                                    </tr>
                                    @endif
                                    
                                    <tr class="total-row">
                                        <td colspan="4">សរុប / TOTAL</td>
                                        <td style="text-align: center; padding-left:0px;">${{ number_format($invoice->total_amount, 2) }}</td>
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
    </div>
    <script>
                    $('.make-payment').on('click', function(e) {
                e.preventDefault();
                const invoiceId = $(this).data('invoice-id');

                if (!confirm(`Are you sure you want to mark invoice #${invoiceId} as paid?`)) {
                    return;
                }

                $.ajax({
                    url: `/invoices/update-payment/${invoiceId}`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        payment_status: 'Paid'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Failed to update payment status.');
                        }
                    },
                    error: function(xhr) {
                        console.error("AJAX error:", xhr);
                        alert('Error: ' + (xhr.responseJSON?.message || 'Unable to update payment status.'));
                    }
                });
            });
    </script>
</x-app-layout>