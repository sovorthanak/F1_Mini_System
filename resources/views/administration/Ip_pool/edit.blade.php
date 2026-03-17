@extends('layouts.administration-nav')

@section('content')

<style>
    /* ===============================
    IP POOL EDIT – CUSTOM STYLES
    =============================== */

    .ip-edit-wrapper{
        max-width: 900px;
        margin: 10px auto;
    }

    .ip-edit-card{
        background: #ffffff;
        border-radius: 10px;
        padding: 24px;
        box-shadow: 0 6px 18px rgba(0,0,0,.06);
    }

    .ip-edit-title{
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .ip-edit-subtitle{
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 20px;
    }

    .ip-stats{
        display: grid;
        grid-template-columns: repeat(auto-fit,minmax(220px,1fr));
        gap: 12px;
        margin: 20px 0;
    }

    .ip-stat-box{
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 14px;
    }

    .ip-stat-label{
        font-size: 12px;
        color: #64748b;
        margin-bottom: 4px;
    }

    .ip-stat-value{
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
    }

    .ip-form-group{
        margin-bottom: 16px;
    }

    .ip-form-group label{
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 6px;
    }


    .ip-actions{
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-top:24px;
    }

    .ip-actions .btn{
        min-width: 120px;
    }

    .ip-readonly{
        background: #f1f5f9;
        cursor: not-allowed;
    }

    .ip-btn{
        padding:10px 18px;
        border-radius:10px;
        font-weight:600;
        border:1px solid transparent;
        cursor:pointer;
        transition:.15s;
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

</style>

<div class="ip-edit-wrapper">
    <div class="ip-edit-card">

        <div class="ip-edit-title">Edit IP Pool</div>
        <div class="ip-edit-subtitle">
            Update CIDR pool details and visibility
        </div>

        <form method="POST" action="{{ route('ip.pools.update', ['ipPool' => $ipPool->id]) }}">
            @csrf
            @method('PUT')

            <div class="ip-form-group">
                <label>Network ID</label>
                <input class="form-control ip-readonly" value="{{ $ipPool->id }}" readonly>
            </div>

            <div class="ip-form-group">
                <label>Network Name</label>
                <input name="name" class="form-control" value="{{ $ipPool->name }}">
            </div>

            <div class="ip-form-group">
                <label>Network Description</label>
                <textarea name="description" class="form-control" rows="3">{{ $ipPool->description }}</textarea>
            </div>

            <div class="ip-form-group">
                <label>Prefix (CIDR)</label>
                <input name="cidr" class="form-control" value="{{ $ipPool->cidr }}">
            </div>

            {{-- Inventory stats --}}
            <div class="ip-stats">
                <div class="ip-stat-box">
                    <div class="ip-stat-label">Begin IP Address</div>
                    <div class="ip-stat-value">{{ $begin_ip ?? '-' }}</div>
                </div>

                <div class="ip-stat-box">
                    <div class="ip-stat-label">End IP Address</div>
                    <div class="ip-stat-value">{{ $end_ip ?? '-' }}</div>
                </div>

                <div class="ip-stat-box">
                    <div class="ip-stat-label">IP Address Count</div>
                    <div class="ip-stat-value">{{ $count_ip }}</div>
                </div>
            </div>

            {{-- Visibility --}}
            <div class="ip-form-group">
                <label>
                    Visible? <span class="text-danger">*</span>
                </label>

                <div class="ip-radio-wrap">
                        <label class="ip-radio">
                            <input class="ip-radio"
                               type="radio"
                               name="is_active"
                               value="1"
                               {{ $ipPool->is_active ? 'checked' : '' }}>

                            Yes (Active)
                        </label>

                        <label class="ip-radio">
                            <input class="ip-radio"
                               type="radio"
                               name="is_active"
                               value="0"
                               {{ !$ipPool->is_active ? 'checked' : '' }}>

                            No (Hidden)
                        </label>

                </div>
            </div>

            {{-- Actions --}}
            <div class="ip-actions">
                <a href="{{ route('ip.pools.index') }}" class="ip-btn ip-btn-outline">
                    ← Back
                </a>

                <button class="ip-btn ip-btn-primary">Save</button>

            </div>

        </form>
    </div>
</div>

@endsection
