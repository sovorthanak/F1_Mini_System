<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.0/css/all.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/geolib@3.3.1/dist/geolib.min.js"></script>

    <div class="container">
        <span class="add-cust">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            <h4>Details for ID : {{ $customer->customer_id }}

                                <span>
                                    <a href="{{ route('customers.user-agreement', ['customer_id' => $customer->customer_id]) }}" class="btn btn-primary">User Aggreement</a>
                                    <a href="{{ route('customers.edit-details', ['customer_id' => $customer->customer_id]) }}" class="btn btn-primary">Edit</a>
                                    <a href="{{ route('customers') }}" class="btn btn-danger">Back</a>
                                </span>
                            </h4>
                        </div>

                        <div class="cust-row invoice-row details-invoice-row">

                            <div class="cust-row-box active-cust deails-cust-row-box">
                                <div class="cust-icon">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </div>
                                <div class="cust-num">
                                    <p>Customer Name:</p>
                                    <h2>
                                        {{ $customer->customer_name }}
                                    </h2>                                     
                                </div>
                            </div>
                        
                            <div class="cust-row-box active-cust deails-cust-row-box">
                                <div class="cust-icon">
                                    <i class="fa fa-tag" aria-hidden="true"></i>
                                </div>
                                <div class="cust-num">
                                    <p>Tariff:</p>
                                    <h2>
                                        {{ $customer->tariff_name }}
                                        {{ $customer->bandwidth }}
                                    </h2>
                                </div>
                            </div>
                        
                            <div class="cust-row-box total-cust deails-cust-row-box">
                                <div class="cust-icon">
                                    <i class="fa fa-dollar-sign" aria-hidden="true"></i>
                                </div>
                                <div class="cust-num">
                                    <p>Internet Fee:</p>
                                    <h2>
                                        {{ $customer->internet_fee }} $
                                    </h2>          
                                </div>
                            </div>
                        
                            <div class="cust-row-box active-cust deails-cust-row-box">
                                <div class="cust-icon">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </div>
                                <div class="cust-num">
                                    <p>Status:</p>
                                    <h2 style="color: rgb(0, 159, 0);">
                                        {{ $customer->status }}
                                    </h2>          
                                </div>
                            </div>
                        
                        </div>

                        <div class="card-body view-customer-card-body">
                            <form id="add-cust-form" enctype="multipart/form-data">

                                <div class="section-title">1. Customer's Info</div>
                                <div class="cust-details">

                                    <div class="register_box_left">
                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Customer Name</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                <b>{{ $customer->customer_name }}</b>
                                            </div>
                                        </div>

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Phone Number</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                {{ $customer->phone_number }}
                                            </div>
                                        </div>

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Identity Doc</div>
                                            <div class="customer-details-value">
                                                <span class="colon">: </span>
                                                @if ($customer->identity_doc)
                                                    <div style="margin-top: 8px">
                                                        <!-- View Image -->
                                                        <img src="{{ asset('storage/id_cards/' . $customer->identity_doc) }}" alt="ID Card" width="250" style="display: block; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">
                                        
                                                        <!-- Download Button -->
                                                        <a href="{{ asset('storage/id_cards/' . $customer->identity_doc) }}" download class="btny" style="font-size: 0.85rem">
                                                            Download
                                                        </a>
                                                    </div>
                                                @else
                                                    <span style="color:red">No file uploaded</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="register_box_right">
                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Customer Name (Khmer)</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                {{ $customer->alt_customer_name }}
                                            </div>
                                        </div>

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Agent</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                {{ $customer->agent }}
                                            </div>
                                        </div>

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Address Line</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                {{ $customer->address_line_1 }}
                                            </div>
                                        </div>
                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Address Line (Khmer)</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                {{ $customer->alt_address_line_1 }}
                                            </div>
                                        </div>

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Lat/Long</div>
                                            <div class="customer-details-value"><span class="colon">: </span>

                                                {{ $customer->lat_long ? $customer->lat_long : '---' }}

                                            </div>
                                        </div>
                                        
                                        @if ($customer->lat_long && strtolower($customer->lat_long) !== 'null')
                                            <div class="customer-details-row">
                                                <div class="customer-details-label"></div>
                                                <div class="customer-details-value"><span class="colon"></span>
                                                    <div id="map" style="width: 330px; height: 200px; border-radius: 10px;"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                </div>

                                <div class="section-title">2. Technical Info</div>
                                <div class="cust-details">
                                    <div class="register_box_left">
                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Tariff</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                <b>{{ $customer->tariff_name }}{{ $customer->bandwidth }}</b>
                                            </div>
                                        </div>

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">PPPoE</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                {{ $customer->pppoe }}
                                            </div>
                                        </div>

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Router</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                {{ $customer->router }}
                                            </div>
                                        </div>

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Location</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                {{ $customer->province }}
                                            </div>
                                        </div>

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">IP Quantity</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                {{ $customer->ipInventory->count() }}
                                            </div>
                                        </div>
                                        
                                    </div>
                                
                                    <div class="register_box_right">
                                        
                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Bill Cycle</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                {{ $customer->bill_cycle }} Months
                                            </div>
                                        </div>

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Password</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                {{ $customer->password }}
                                            </div>
                                        </div>

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Remark</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                {{ $customer->remark ? $customer->remark : '---' }}
                                            </div>
                                        </div>

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Start Date</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                {{ $customer->first_start_date ? \Carbon\Carbon::parse($customer->complete_date)->format('d M, Y') : 'N/A'  }}
                                            </div>
                                        </div>

                                        {{-- <div class="customer-details-row">
                                            <div class="customer-details-label">IP Address</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                @if ($customer->ipAddresses->isNotEmpty())
                                                    @foreach ($customer->ipAddresses as $ip_addresses)
                                                        <div> {{ $ip_addresses-> ip_address }} </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div> --}}

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">IP Address</div>
                                            <div class="customer-details-value">
                                                <span class="colon">: </span>
                                                @if ($customer->ipInventory->isNotEmpty())
                                                    <div class="ip-scroll-container"
                                                         style=" display: flex;
                                                                flex-direction: column;
                                                                gap: 8px;
                                                                max-height: 150px; /* adjust the height as needed */
                                                                overflow-y: auto;
                                                                padding-right: 4px; /* for scrollbar spacing */"
                                                    >
                                                        @foreach ($customer->ipInventory as $ip)
                                                            <input type="text" 
                                                                value="{{ $ip->ip_address }}"
                                                                style=" display: inline-block;
                                                                        width: 150px;
                                                                        padding: 4px 6px;
                                                                        border: 1px solid #ccc;
                                                                        border-radius: 4px;
                                                                        font-size: 15px;
                                                                        pointer-events: none; /* keeps it readonly */" 
                                                                readonly 
                                                                class="readonly-input" />
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span>No IPs assigned</span>
                                                @endif
                                            </div>
                                        </div>



                                    
                                    </div>
                                </div>  

                                @role('Accounting')
                                
                                <div class="section-title">3. Bill Info</div>
                                <div class="cust-details">
                                    <div class="register_box_left">

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Internet Fee</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                <b>$ {{ $customer->internet_fee }}</b>
                                            </div>
                                        </div>

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Installation Fee</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                $ {{ $customer->installation_fee }}
                                            </div>
                                        </div>

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">IP Fee</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                $ {{ $customer->ip_fee }}
                                            </div>
                                        </div>

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Created By</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                <b>{{ $customer->created_by }}</b> 
                                            </div>
                                        </div>
                                        
                                    </div>
                                
                                    <div class="register_box_right">
                                        
                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Bill Cycle</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                {{ $customer->bill_cycle }} Months
                                            </div>
                                        </div>
                                        


                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Currency</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                {{ $customer->currency }}
                                            </div>
                                        </div>

                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Start Date</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                {{ $customer->first_start_date ? \Carbon\Carbon::parse($customer->complete_date)->format('d M, Y') : 'N/A'  }}
                                            </div>
                                        </div>
                                        
                                        <div class="customer-details-row">
                                            <div class="customer-details-label">Created At</div>
                                            <div class="customer-details-value"><span class="colon">: </span>
                                                {{ $customer->created_at ?  \Carbon\Carbon::parse($customer->created_at)->format('d M, Y') : 'N/A' }}
                                            </div>
                                        </div>
                                
                                    </div>
                                </div>  
                                @endrole


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </span>
    </div>
    <script>
        // Convert DMS to Decimal Degrees
        function dmsToDecimal(dmsStr) {
            const parts = dmsStr.match(/(\d+)[¡Æ]\s*(\d+)[']\s*([\d.]+)["]?\s*([NSEW])/i);
            if (!parts) return NaN;
        
            const degrees = parseFloat(parts[1]);
            const minutes = parseFloat(parts[2]);
            const seconds = parseFloat(parts[3]);
            const direction = parts[4].toUpperCase();
        
            let decimal = degrees + minutes / 60 + seconds / 3600;
            if (direction === 'S' || direction === 'W') decimal = -decimal;
        
            return decimal;
        }
        
        document.addEventListener('DOMContentLoaded', function () {
            const latLongStr = `{!! $customer->lat_long !!}`.trim();
            console.log("Received coordinates:", latLongStr); // Debugging
        
            if (!latLongStr || latLongStr.toLowerCase() === 'null' || latLongStr === '(N/A)') {
                document.getElementById('map').innerHTML = 'No coordinates provided.';
                return;
            }
        
            let lat, lng;
        
            if (latLongStr.includes('¡Æ')) {
                // Split on space to separate lat & lng
                const parts = latLongStr.split(' ');
                if (parts.length === 2) {
                    lat = dmsToDecimal(parts[0]);
                    lng = dmsToDecimal(parts[1]);
                }
            } else {
                // Assume decimal lat,lng
                const parts = latLongStr.split(',');
                if (parts.length === 2) {
                    lat = parseFloat(parts[0].trim());
                    lng = parseFloat(parts[1].trim());
                }
            }
        
            console.log("Parsed lat:", lat, "lng:", lng); // Debugging
        
            if (isNaN(lat) || isNaN(lng)) {
                document.getElementById('map').innerHTML = 'Invalid coordinates.';
                return;
            }
        
            // Initialize Leaflet map
            const map = L.map('map').setView([lat, lng], 13);
        
            // Add OSM tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
        
            // Add marker with popup
            const marker = L.marker([lat, lng]).addTo(map)
                .bindPopup('Customer Location')
                .openPopup();
        
            marker.on('click', () => {
                const googleMapsUrl = `https://www.google.com/maps?q=${lat},${lng}`;
                window.open(googleMapsUrl, '_blank');
            });
        });
    </script>

</x-app-layout>