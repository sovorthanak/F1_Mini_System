<head>
    <title>{{ $customer->customer_name }} - User Agreement</title>
</head>


<style>
    @media print {
                /* Minimize margins to reduce headers/footers */
        @page {
            margin: 0;
        }
    
        /* Force background graphics and colors to print */
        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
    
    /* Import Khmer font */
    @font-face {
            font-family: 'Battambang';
            src: url('{{ storage_path('fonts/Battambang-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        
    /*@import url('https://fonts.googleapis.com/css2?family=Khmer+OS+Battambang:wght@400;700&display=swap');                        */
    .card-body {
        width: 780px;
        height: 1020px;
        margin: 0 auto;
        padding: 10px;
        font-family: 'Khmer OS Battambang', Arial, sans-serif;
        font-size: 12px;
        color: #000;
    }

    .container { max-width:800px; margin:0 auto; border:1px solid #222; padding:25px; box-shadow: 0 0 5px rgba(0,0,0,0.1); }

    header { 
        display:flex; justify-content: space-between;
        align-items: center; 
        margin-bottom: 10px;
    }

    header img { height: 70px; }

    h1 { font-size:20px; margin:10px 0; text-transform:uppercase; }
    .small { font-size:12px; }
    table { width:100%; border-collapse:collapse; margin-bottom:12px; }
    td, th { padding:6px; vertical-align:top; }
    .bordered td, .bordered th { border:1px solid #000; }
    .two-cols { display:flex; gap:12px; }
    .col { flex:1; }

    .section-title { 
        background: #f0f0f0; 
        padding:0 5px; 
        font-weight:700; 
        margin-top:12px; 
        border:1px solid #000; 
    }

    .checkbox { display:inline-block; width:12px; height:12px; border:1px solid #000; margin-right:6px; vertical-align:middle; }
    .signature { height:50px; border-bottom:1px solid #000; margin-top:20px; }
    .muted { color:#444; font-size:12px; }
    .right { text-align:right; }
    .center { text-align:center; }
    .note { font-size:12px; margin-top:8px; border-top:1px solid #ccc; padding-top:5px; }
    .smallpad td { padding:4px; }
    ol { padding-left:18px; margin:6px 0; }

</style>

<div class="card-body">
  <div class="container">
    <header>
        <img src="/img/Fast_One_Logo_txt.png" alt="">
        <div class="right small">
            <div><strong>Order Form No:</strong> ____________________</div>
            <div><strong>Date:</strong> ____________________________</div>
        </div>
    </header>

    <h1 class="center">Service Order Form</h1>

    <div class="section-title">1. FAST ONE (CAMBODIA) CO., LTD "FASTONE"</div>

    <table class="smallpad">
      <tr>
        <td><strong>Company</strong><br>FAST ONE (CAMBODIA) CO., LTD</td>
        <td><strong>Contact Person</strong><br>__________________________</td>
      </tr>
    </table>

    <div class="section-title">2. CUSTOMER INFORMATION "CUSTOMER"</div>
    <table class="bordered smallpad">
      <tr>
        <td><strong>Company Name</strong><br>__________________________</td>
        <td><strong>Contact Person</strong><br>__________________________</td>
      </tr>
      <tr>
        <td><strong>Address</strong><br>__________________________</td>
        <td><strong>Phone / Email</strong><br>__________________________</td>
      </tr>
    </table>

    <div class="section-title">3. INSTALLATION</div>
    <table class="bordered smallpad">
      <tr>
        <td><strong>LOCATION - A</strong><br>#29, 10th Floor Room 10A, Mao Tse Toung Blvd, S/K Toul Tompoung II, Khan Chamkarmorn, Phnom Penh.</td>
        <td><strong>LOCATION - B</strong><br>__________________________</td>
      </tr>
    </table>

    <div class="section-title">4. SERVICE ORDER</div>
    <table class="bordered smallpad">
      <tr>
        <th style="width:40%">Service Type</th>
        <th>Package / Bandwidth / Remark</th>
      </tr>
      <tr>
        <td>
          <div><span class="checkbox"></span> Internet</div>
          <div><span class="checkbox"></span> DPLC</div>
          <div><span class="checkbox"></span> IPLC</div>
          <div><span class="checkbox"></span> IP Transit</div>
          <div><span class="checkbox"></span> VPLS</div>
          <div><span class="checkbox"></span> MPLS</div>
          <div><span class="checkbox"></span> Other: __________________</div>
        </td>
        <td>
          <div><strong>Package Type:</strong> ____________________________</div>
          <div><strong>Bandwidth:</strong> ________________________________</div>
          <div><strong>Remark:</strong> _________________________________</div>
        </td>
      </tr>
    </table>

    <div class="two-cols">
      <div class="col">
        <div class="section-title">5. BILLING INFORMATION AND CONTRACT TERM</div>
        <table class="smallpad">
          <tr>
            <td><strong>Monthly Fee / Internet Fee:</strong></td>
            <td>__________________</td>
          </tr>
          <tr>
            <td><strong>Contract Term:</strong></td>
            <td>__________________</td>
          </tr>
          <tr>
            <td><strong>IP Address / Installation Fee:</strong></td>
            <td>__________________</td>
          </tr>
        </table>
      </div>
      <div class="col">
        <div class="section-title">6. PAYMENT TERM</div>
        <div class="muted">
          Payment is prepaid and billed at the start of each month. Payment can be monthly, quarterly, or annually via cheque or bank transfer within 7 days from invoice date.
        </div>
        <table class="smallpad">
          <tr><td><strong>Currency:</strong></td><td>USD</td></tr>
          <tr><td><strong>Bank:</strong></td><td>ABA Bank</td></tr>
          <tr><td><strong>Account Name:</strong></td><td>FAST ONE CAMBODIA CO LTD</td></tr>
          <tr><td><strong>Account Number:</strong></td><td>000806246</td></tr>
        </table>
        <div class="muted">Late payments incur a 2% daily penalty on overdue amounts.</div>
      </div>
    </div>

    <div class="section-title">7. ADDITIONAL INFORMATION OR SPECIFIC CLAUSES</div>
    <div class="small">
      <ol>
        <li>The service charge follows the rate in the quotation.</li>
        <li>Equipment provided is on loan unless purchased and must be returned upon service termination.</li>
        <li>Customer bears all taxes and levies required by law.</li>
        <li>Payment must be made within 14 days of invoice receipt.</li>
        <li>Invoices are issued electronically unless otherwise requested.</li>
        <li>Overdue balances incur 1% monthly interest.</li>
        <li>Early termination results in forfeiture of deposit and payment of remaining contract balance.</li>
        <li>Service outages are not counted in cases of maintenance, customer equipment faults, non-payment disconnection, government intervention, or force majeure.</li>
      </ol>
    </div>

    <div class="section-title">8. CUSTOMER DECLARATION AND SIGNATURE</div>
    <div class="small">
      The Customer confirms understanding and acceptance of FAST ONE (CAMBODIA) CO., LTD. Terms & Conditions. These terms override any other proposals, written or oral.
    </div>

    <table style="margin-top:14px">
      <tr>
        <td style="width:50%" class="center">
          <div>Company Stamp & Authorization</div>
          <div class="signature"></div>
          <div>Name : ____________________</div>
          <div>Date : _____________________</div>
        </td>
        <td style="width:50%" class="center">
          <div>Company Stamp & Authorization</div>
          <div class="signature"></div>
          <div>Name : ____________________</div>
          <div>Date : _____________________</div>
        </td>
      </tr>
    </table>

    <div class="note muted">Contract period is 12 months and auto-renews unless one-month termination notice is given. Early termination incurs 100% payment of remaining months.</div>

    <div class="section-title">9. TO BE COMPLETED BY FAST ONE (CAMBODIA) CO., LTD ONLY</div>
    <table class="bordered smallpad">
      <tr><td>Approved By</td><td>Contracting Party's Representative</td></tr>
    </table>

    <div class="muted small">Email: fastone_info@fastone.com.kh</div>

  </div>

</div>

<div style="height: 15px"></div>

{{-- <div class="card-body card-body-invoice">
    <!-- Invoice Content -->
    <div class="invoice-header">
        <h1>User Agreement</h1>
    </div>
</div> --}}

{{-- <script>
    window.onload = function() {
        window.print();
    }
</script> --}}