<!-- Required Fields: Customer Name, PPPOE+Password, Router -->
<div class="grid">
    <!-- LEFT COLUMN (Old) -->
    <div class="col">
        <div class="row">
            <div class="label">Old Customer Name</div><div class="colon">:</div>
            <div class="control">
                <input type="text" name="old_customer_name" value="{{ old('old_customer_name') }}" readonly placeholder="Import customer name"/>
                @error('old_customer_name')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="row">
            <div class="label">Old PPPOE</div><div class="colon">:</div>
            <div class="control">
                <input type="text" name="old_pppoe" value="{{ old('old_pppoe') }}" readonly placeholder="Imported from customer"/>
                @error('old_pppoe')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="row">
            <div class="label">Old Password</div><div class="colon">:</div>
            <div class="control">
                <input type="text" name="old_password" value="{{ old('old_password') }}" readonly placeholder="Imported from customer"/>
                @error('old_password')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="row">
            <div class="label">Old Router</div><div class="colon">:</div>
            <div class="control">
                <input type="text" name="old_router" value="{{ old('old_router') }}" readonly placeholder="Imported from customer"/>
                @error('old_router')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN (New) -->
    <div class="col">
        <div class="row">
            <div class="label">New Customer Name</div><div class="colon">:</div>
            <div class="control">
                <input type="text" name="new_customer_name" value="{{ old('new_customer_name') }}" placeholder="Enter new customer name"/>
                @error('new_customer_name')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="row">
            <div class="label">New PPPOE</div><div class="colon">:</div>
            <div class="control">
                <input type="text" name="new_pppoe" value="{{ old('new_pppoe') }}" placeholder="Enter new PPPOE"/>
                @error('new_pppoe')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="row">
            <div class="label">New Password</div><div class="colon">:</div>
            <div class="control">
                <input type="text" name="new_password" value="{{ old('new_password') }}" placeholder="Enter new password"/>
                @error('new_password')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="row">
            <div class="label">New Router</div><div class="colon">:</div>
            <div class="control">
                <input type="text" name="new_router" value="{{ old('new_router') }}" placeholder="Enter new router"/>
                @error('new_router')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>
</div>
