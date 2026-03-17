<!-- Tariff + Bandwidth -->
<div class="grid">
    <!-- LEFT COLUMN (Old) -->
    <div class="col">
        <div class="row">
            <div class="label">Old Tariff</div><div class="colon">:</div>
            <div class="control" id="old-tariff-group">
                <select name="old_tariff_name" id="old_tariff_name">
                    <option value="">-- Choose a tariff --</option>
                    @foreach ($tariffs as $name)
                        <option value="{{ $name }}" {{ old('old_tariff_name') == $name ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('old_tariff_name')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="row">
            <div class="label">Old Bandwidth</div><div class="colon">:</div>
            <div class="control" id="old-bandwidth-group">
                <select name="old_bandwidth" id="old_bandwidth">
                    <option value="">-- Choose old bandwidth --</option>
                    @foreach ($bandwidths as $bandwidth)
                        <option value="{{ $bandwidth->speed }}" {{ old('old_bandwidth') == $bandwidth->speed ? 'selected' : '' }}>
                            {{ $bandwidth->speed }}
                        </option>
                    @endforeach
                </select>
                @error('old_bandwidth')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN (New) -->
    <div class="col">
        <div class="row">
            <div class="label">New Tariff</div><div class="colon">:</div>
            <div class="control" id="new-tariff-group">
                <select name="new_tariff_name" id="new_tariff_name">
                    <option value="">-- Choose a tariff --</option>
                    @foreach ($tariffs as $name)
                        <option value="{{ $name }}" {{ old('new_tariff_name') == $name ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('new_tariff_name')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="row">
            <div class="label">New Bandwidth</div><div class="colon">:</div>
            <div class="control" id="new-bandwidth-group">
                <select name="new_bandwidth" id="new_bandwidth">
                    <option value="">-- Choose new bandwidth --</option>
                    @foreach ($bandwidths as $bandwidth)
                        <option value="{{ $bandwidth->speed }}" {{ old('new_bandwidth') == $bandwidth->speed ? 'selected' : '' }}>
                            {{ $bandwidth->speed }}
                        </option>
                    @endforeach
                </select>
                @error('new_bandwidth')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>
</div>