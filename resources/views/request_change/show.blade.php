<x-app-layout>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.0/css/all.css">

    <div class="container">
        <span class="add-cust">
            <div class="row">
                <div class="col-md-12" style="min-width: 1200px;">
                    <div class="card">
                        <div class="card-header">
                            <h4>Request Change ID: {{ $requestChange->id }}
                                <span>
                                    <a href="{{ route('request-change') }}" class="btn btn-primary float-end">Back</a>
                                </span>
                            </h4>
                        </div>

                        <div class="cust-row">
                            <div class="cust-row-box active-cust deails-cust-row-box">
                                <div class="cust-icon">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </div>
                                <div class="cust-num">
                                    <p>Customer Name:</p>
                                    <h2>{{ $requestChange->customer->customer_name ?? 'N/A' }}</h2>
                                </div>
                            </div>

                            <div class="cust-row-box active-cust deails-cust-row-box">
                                <div class="cust-icon">
                                    <i class="fa fa-tag" aria-hidden="true"></i>
                                </div>
                                <div class="cust-num">
                                    <p>Customer ID</p>
                                    <h2>{{ $requestChange->customer_id }}</h2>
                                </div>
                            </div>

                            <div class="cust-row-box active-cust deails-cust-row-box">
                                <div class="cust-icon">
                                    <i class="fa fa-tag" aria-hidden="true"></i>
                                </div>
                                <div class="cust-num">
                                    <p>Request Type</p>
                                    <h2>{{ $requestChange->request_type }}</h2>
                                </div>
                            </div>

                        </div>

                        <div class="card-body">
                            <form id="add-cust-form" enctype="multipart/form-data">
                                @csrf

                                <div class="cust-details">
                                    <div class="register_box_left">
                                        @if(in_array($requestChange->request_type, ['Upgrade', 'Downgrade']))
                                            <!-- Old tariff fields for Upgrade/Downgrade -->
                                            <div class="customer-details-row">
                                                <div class="customer-details-label">Old Tariff</div>
                                                <div class="customer-details-value"><span class="colon">: </span>
                                                    {{ $requestChange->old_tariff ?? 'N/A' }} {{ $requestChange->old_bandwidth ?? '' }}
                                                </div>
                                            </div>
                                            <div class="customer-details-row">
                                                <div class="customer-details-label">Old Internet Fee</div>
                                                <div class="customer-details-value"><span class="colon">: </span>
                                                    $ {{ $requestChange->old_internet_fee ?? 'N/A' }}
                                                </div>
                                            </div>
                                        @endif

                                        @if($requestChange->request_type == 'Change Ip Address')
                                            <!-- Old IP address for Change Ip Address -->
                                            <div class="customer-details-row">
                                                <div class="customer-details-label">Old IP Address</div>
                                                <div class="customer-details-value"><span class="colon">: </span>
                                                    {{ $requestChange->old_ip_address ?? 'N/A' }}
                                                </div>
                                            </div>
                                        @endif

                                        @if($requestChange->request_type == 'Relocation')
                                            <!-- Old address fields for Relocation -->
                                            <div class="customer-details-row">
                                                <div class="customer-details-label">Old Address Line</div>
                                                <div class="customer-details-value"><span class="colon">: </span>
                                                    {{ $requestChange->old_address ?? 'N/A' }}
                                                </div>
                                            </div>
                                            <div class="customer-details-row">
                                                <div class="customer-details-label">Old Address Line (Khmer)</div>
                                                <div class="customer-details-value"><span class="colon">: </span>
                                                    {{ $requestChange->old_alt_address ?? 'N/A' }}
                                                </div>
                                            </div>
                                        @endif

                                        @if(in_array($requestChange->request_type, ['Deactivate', 'Reactivate', 'Termination']))
                                            <!-- Customer status for Deactivate/Reactivate/Termination -->
                                            <div class="customer-details-row">
                                                <div class="customer-details-label">Customer Status</div>
                                                <div class="customer-details-value"><span class="colon">: </span>
                                                    {{ $requestChange->customer->status ?? 'N/A' }}
                                                </div>
                                            </div>
                                        @endif

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Created At</div>
                                            <div class="customer-details-value">
                                                <span class="colon">: </span>
                                                {{ $requestChange->created_at ? \Carbon\Carbon::parse($requestChange->created_at)->format('d M, Y') : 'N/A' }}                                            
                                            </div>
                                        </div>
                                    </div>

                                    <div class="register_box_right">
                                        @if(in_array($requestChange->request_type, ['Upgrade', 'Downgrade']))
                                            <!-- New tariff fields for Upgrade/Downgrade -->
                                            <div class="customer-details-row">
                                                <div class="customer-details-label">New Tariff</div>
                                                <div class="customer-details-value"><span class="colon">: </span>
                                                    {{ $requestChange->new_tariff ?? 'N/A' }} {{ $requestChange->new_bandwidth ?? '' }}
                                                </div>
                                            </div>
                                            <div class="customer-details-row">
                                                <div class="customer-details-label">New Internet Fee</div>
                                                <div class="customer-details-value"><span class="colon">: </span>
                                                    $ {{ $requestChange->new_internet_fee ?? 'N/A' }}
                                                </div>
                                            </div>
                                        @endif

                                        @if($requestChange->request_type == 'Change Ip Address')
                                            <!-- New IP address for Change Ip Address -->
                                            <div class="customer-details-row">
                                                <div class="customer-details-label">New IP Address</div>
                                                <div class="customer-details-value"><span class="colon">: </span>
                                                    {{ $requestChange->new_ip_address ?? 'N/A' }}
                                                </div>
                                            </div>
                                        @endif

                                        @if($requestChange->request_type == 'Relocation')
                                            <!-- New address fields for Relocation -->
                                            <div class="customer-details-row">
                                                <div class="customer-details-label">New Address Line</div>
                                                <div class="customer-details-value"><span class="colon">: </span>
                                                    {{ $requestChange->new_address ?? 'N/A' }}
                                                </div>
                                            </div>
                                            <div class="customer-details-row">
                                                <div class="customer-details-label">New Address Line (Khmer)</div>
                                                <div class="customer-details-value"><span class="colon">: </span>
                                                    {{ $requestChange->new_alt_address ?? 'N/A' }}
                                                </div>
                                            </div>
                                        @endif

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Created By</div>
                                            <div class="customer-details-value">
                                                <span class="colon">: </span>
                                                {{ $requestChange->created_by ? : 'N/A' }}                                            
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </span>
    </div>
</x-app-layout>