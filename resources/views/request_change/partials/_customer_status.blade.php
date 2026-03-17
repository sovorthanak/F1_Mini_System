<!-- Customer Status -->
<div class="grid">
    <!-- LEFT COLUMN (Old) -->
    <div class="col">
        <div class="row">
            <div class="label">Old Customer Status</div><div class="colon">:</div>
            <div class="control" id="old-status-group">
                <select name="old_customer_status">
                    <option value="">Select Customer Status</option>
                    <option value="Active" {{ old('old_customer_status') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('old_customer_status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="Suspended" {{ old('old_customer_status') == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                    <option value="Terminated" {{ old('old_customer_status') == 'Terminated' ? 'selected' : '' }}>Terminated</option>
                    <option value="Deactivated" {{ old('old_customer_status') == 'Deactivated' ? 'selected' : '' }}>Deactivated</option>
                    <option value="Pending" {{ old('old_customer_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                </select>
                @error('old_customer_status')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN (New) -->
    <div class="col">
        <div class="row">
            <div class="label">New Customer Status</div><div class="colon">:</div>
            <div class="control" id="new-status-group">
                <select name="new_customer_status">
                    <option value="">Select Customer Status</option>
                    <option value="Active" {{ old('new_customer_status') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('new_customer_status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="Suspended" {{ old('new_customer_status') == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                    <option value="Terminated" {{ old('new_customer_status') == 'Terminated' ? 'selected' : '' }}>Terminated</option>
                    <option value="Deactivated" {{ old('new_customer_status') == 'Deactivated' ? 'selected' : '' }}>Deactivated</option>
                    <option value="Pending" {{ old('new_customer_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                </select>
                @error('new_customer_status')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>
</div>