@extends('customers.show-cust.index')

@section('content')
<div class="cust-article">
    <span class="btn_container">
        <a href="{{ route('customers.finance.index', ['id' => $id]) }}">
            <button class="{{ Request::segment(4) == 'view-invoices' ? 'active' : '' }}">
                View Invoices
            </button>
        </a>
        <a href="{{ route('customers.finance.recurring-charges', ['id' => $id ]) }}">
            <button class="{{ Request::segment(4) == 'recurring-charges' ? 'active' : '' }}">
                Recurring Charges
            </button>
        </a>        
        <a href="{{ route('customers.finance.add-charge', ['id' => $id ]) }}">
            <button class="{{ Request::segment(4) == 'add-charge' ? 'active' : '' }}">
                Add Charge
            </button>
        </a>  
        <a href="{{ route('customers.finance.add-deposite-charge', ['id' => $id ]) }}">
            <button class="{{ Request::segment(4) == 'add-deposit-charge' ? 'active' : '' }}">
                Add Deposit Charge
            </button>
        </a>  
        <a href="{{ route('customers.finance.make-payment-to-invoice', ['id' => $id ]) }}">
            <button class="{{ Request::segment(4) == 'make-payment-to-invoice' ? 'active' : '' }}">
                Make Payment To Invoice
            </button>
        </a>  
        <a href="{{ route('customers.finance.view-payments', ['id' => $id ]) }}">
            <button class="{{ Request::segment(4) == 'view-payments' ? 'active' : '' }}">
                View Payments
            </button>
        </a>  
        <a href="{{ route('customers.finance.book-deposit', ['id' => $id ]) }}">
            <button class="{{ Request::segment(4) == 'book-deposit' ? 'active' : '' }}">
                Book Deposit
            </button>
        </a>  
        <a href="{{ route('customers.finance.increase-credit', ['id' => $id ]) }}">
            <button class="{{ Request::segment(4) == 'increase-credit' ? 'active' : '' }}">
                Increase Credit
            </button>
        </a>
        <a href="{{ route('customers.finance.transfer-deposit-to-invoice', ['id' => $id ]) }}">
            <button class="{{ Request::segment(4) == 'transfer-deposit-to-invoice' ? 'active' : '' }}">
                Transfer Deposit To Invoice
            </button>
        </a>    
        <a href="{{ route('customers.finance.transfer-credit-to-invoice', ['id' => $id ]) }}">
            <button class="{{ Request::segment(4) == 'transfer-credit-to-invoice' ? 'active' : '' }}">
                Transfer Credit To Invoice
            </button>
        </a>    

        <a href="{{ route('customers.finance.transfer-deposit-to-credit', ['id' => $id ]) }}">
            <button class="{{ Request::segment(4) == 'transfer-deposit-to-credit' ? 'active' : '' }}">
                Transfer Deposit To Credit
            </button>
        </a>    
        <a href="{{ route('customers.finance.refund-deposit-to-customer', ['id' => $id ]) }}">
            <button class="{{ Request::segment(4) == 'refund-deposit-to-customer' ? 'active' : '' }}">
                Refund Deposit To Customer
            </button>
        </a>    
        <a href="{{ route('customers.finance.refund-credit-to-customer', ['id' => $id ]) }}">
            <button class="{{ Request::segment(4) == 'refund-credit-to-customer' ? 'active' : '' }}">
                Refund Credit To Customer
            </button>
        </a>    
        <a href="{{ route('customers.finance.write-credit-memo', ['id' => $id ]) }}">
            <button class="{{ Request::segment(4) == 'write-credit-memo' ? 'active' : '' }}">
                Write Credit Memo
            </button>
        </a>    

        <a href="{{ route('customers.finance.write-off-bad-debt', ['id' => $id ]) }}">
            <button class="{{ Request::segment(4) == 'write-off-bad-debt' ? 'active' : '' }}">
                Write Off Bad Debt
            </button>
        </a>    
        <a href="{{ route('customers.finance.write-off-bank-fee', ['id' => $id ]) }}">
            <button class="{{ Request::segment(4) == 'write-off-bank-fee' ? 'active' : '' }}">
                Write Off Bank Fee
            </button>
        </a>    
        <a href="{{ route('customers.finance.write-off-other-fee', ['id' => $id ]) }}">
            <button class="{{ Request::segment(4) == 'write-off-other-fee' ? 'active' : '' }}">
                Write Off Other Fee
            </button>
        </a> 
        <a href="{{ route('customers.finance.customer-balance-history', ['id' => $id ]) }}">
            <button class="{{ Request::segment(4) == 'customer-balance-history' ? 'active' : '' }}">
                Customer Balance History
            </button>
        </a> 
    </span>

    <div class="customer-details">
        @yield('finance-content')
    </div>
</div>

@endsection