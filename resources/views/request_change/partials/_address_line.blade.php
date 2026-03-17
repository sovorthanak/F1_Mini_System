<!-- Address Lines + Location -->
<div class="grid">
    <!-- LEFT COLUMN (Old) -->
    <div class="col">
        <div class="row">
            <div class="label">Old Address Line</div><div class="colon">:</div>
            <div class="control" id="old-address-group">
                <input type="text" name="old_address" value="{{ old('old_address') }}" readonly placeholder="Imported from customer"/>
                @error('old_address')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="row">
            <div class="label">Old Address (Khmer)</div><div class="colon">:</div>
            <div class="control" id="old-alt-address-group">
                <input type="text" name="old_alt_address" value="{{ old('old_alt_address') }}" readonly placeholder="Imported from customer"/>
                @error('old_alt_address')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="row">
            <div class="label">Old Location (Area)</div><div class="colon">:</div>
            <div class="control" id="old-location-group">
                <select name="old_location" id="old_location">
                    <option value="">Select Location</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->name }}"
                            {{ old('old_location') == $location->name ? 'selected' : '' }}>
                            {{ $location->name }}
                        </option>
                    @endforeach
                </select>
                @error('old_location')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN (New) -->
    <div class="col">
        <div class="row">
            <div class="label">New Address Line</div><div class="colon">:</div>
            <div class="control" id="new-address-group">
                <input type="text" name="new_address" value="{{ old('new_address') }}" placeholder="Enter new address"/>
                @error('new_address')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="row">
            <div class="label">New Address (Khmer)</div><div class="colon">:</div>
            <div class="control" id="new-alt-address-group">
                <input type="text" name="new_alt_address" value="{{ old('new_alt_address') }}" placeholder="Enter new address (Khmer)"/>
                @error('new_alt_address')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="row">
            <div class="label">New Location (Area)</div><div class="colon">:</div>
            <div class="control" id="new-location-group">
                <select name="new_location" id="new_location">
                    <option value="">Select Location</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->name }}"
                            {{ old('new_location') == $location->name ? 'selected' : '' }}>
                            {{ $location->name }}
                        </option>
                    @endforeach
                </select>
                @error('new_location')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>
</div>