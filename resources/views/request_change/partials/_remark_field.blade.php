<!-- Remark -->
<div class="grid">
    <!-- LEFT COLUMN (Old) -->
    <div class="col">
        <div class="row">
            <div class="label">Old Remark</div><div class="colon">:</div>
            <div class="control">
                <textarea
                    name="old_remark"
                    id="old_remark"
                    rows="1"
                    readonly
                    placeholder="Imported from customer"
                >{{ old('old_remark', $old_remark ?? '') }}</textarea>
                @error('old_remark')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN (New) -->
    <div class="col">
        <div class="row">
            <div class="label">New Remark</div><div class="colon">:</div>
            <div class="control">
                <textarea
                    name="remark"
                    id="remark"
                    rows="1"
                    placeholder="Enter new remark"
                >{{ old('remark', $remark ?? '') }}</textarea>
                @error('remark')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>
</div>