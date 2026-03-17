@extends('layouts.administration-nav')

@section('content')

<style>
/* ===============================
   IP POOL CREATE – MATCH EDIT STYLE
   =============================== */

.ip-page{
    max-width: 900px;
    margin: 8px auto;
}

.ip-card{
    background:#ffffff;
    border:1px solid #e5e7eb;
    border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,.06);
    padding:22px 24px;
}

.ip-card-header{
    margin-bottom:18px;
}

.ip-card-header h3{
    margin:0;
    font-size:20px;
    font-weight:700;
    color:#0f172a;
}

.ip-card-header p{
    margin-top:6px;
    font-size:13px;
    color:#64748b;
}

.ip-divider{
    height:1px;
    background:#e5e7eb;
    margin:16px 0 22px;
}

.ip-form-group{
    margin-bottom:16px;
}

.ip-form-group label{
    font-weight:600;
    font-size:14px;
    display:block;
    margin-bottom:6px;
    color:#0f172a;
}

.ip-help{
    font-size:12px;
    color:#64748b;
    margin-top:6px;
}

.ip-radio-wrap{
    display:flex;
    gap:16px;
    flex-wrap:wrap;
}

.ip-radio{
    display:flex;
    align-items:center;
    gap:8px;
    padding:10px 14px;
    border:1px solid #e5e7eb;
    border-radius:10px;
    background:#f8fafc;
}

.ip-actions{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:24px;
}

.ip-btn{
    padding:10px 18px;
    border-radius:10px;
    font-weight:600;
    border:1px solid transparent;
    cursor:pointer;
    transition:.15s;
}

.ip-btn-primary{
    background:#2563eb;
    color:#fff;
    border-color:#2563eb;
}

.ip-btn-primary:hover{
    filter:brightness(.96);
}

.ip-btn-outline{
    background:#fff;
    color:#0f172a;
    border-color:#e5e7eb;
    text-decoration:none;
}

.ip-btn-outline:hover{
    background:#f8fafc;
}

.ip-alert-success{
    background:#d1fae5;
    border:1px solid #a7f3d0;
    color:#065f46;
    padding:12px 14px;
    border-radius:10px;
    margin-bottom:16px;
}

.ip-alert-danger{
    background:#fee2e2;
    border:1px solid #fecaca;
    color:#7f1d1d;
    padding:12px 14px;
    border-radius:10px;
    margin-bottom:16px;
}

.ip-alert-danger ul{
    margin:0;
    padding-left:18px;
}

.form-control{
    border-radius:10px;
}
</style>

    <div class="ip-page">

        @if(session('success'))
            <div class="ip-alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="ip-alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="ip-card">

            <div class="ip-card-header">
                <h3>Create CIDR IP Pool</h3>
                <p>
                    Define a new network prefix.  
                    Example: <b>10.175.6.0/24</b> → 254 usable IP addresses.
                </p>
            </div>

            <div class="ip-divider"></div>

            <form action="{{ route('ip.pools.create') }}" method="POST">
                @csrf

                <div class="ip-form-group">
                    <label>Network Name <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        required
                    >
                </div>

                <div class="ip-form-group">
                    <label>Network Description</label>
                    <textarea
                        name="description"
                        class="form-control"
                        rows="3"
                    >{{ old('description') }}</textarea>
                </div>

                <div class="ip-form-group">
                    <label>CIDR (Network Prefix) <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="cidr"
                        class="form-control"
                        value="{{ old('cidr') }}"
                        required
                    >
                    <div class="ip-help">
                        Format: x.x.x.x/xx (example: 103.139.16.64/28)
                    </div>
                </div>

                <div class="ip-form-group">
                    <label>Visible? <span class="text-danger">*</span></label>

                    <div class="ip-radio-wrap">
                        <label class="ip-radio">
                            <input
                                type="radio"
                                name="is_active"
                                value="1"
                                {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                            >
                            Active (Visible)
                        </label>

                        <label class="ip-radio">
                            <input
                                type="radio"
                                name="is_active"
                                value="0"
                                {{ old('is_active') == '0' ? 'checked' : '' }}
                            >
                            Inactive (Hidden)
                        </label>
                    </div>
                </div>

                <div class="ip-actions">
                    <a href="{{ route('ip.pools.index') }}" class="ip-btn ip-btn-outline">
                        ← Back
                    </a>

                    <button type="submit" class="ip-btn ip-btn-primary">
                        Create Pool & Generate IPs
                    </button>
                </div>

            </form>

        </div>
    </div>

@endsection
