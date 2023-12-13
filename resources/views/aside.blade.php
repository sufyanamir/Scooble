<!------ Include the above in your HEAD tag ---------->
<style>
    [data-toggle="collapse"]:after {
        display: inline-block;
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        font-size: inherit;
        position: absolute;
        top: 20px;
        right: 10px;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        content: "\f054";
        transform: rotate(90deg);
        transition: all linear 0.25s;
        float: right;
    }

    [data-toggle="collapse"].collapsed:after {
        transform: rotate(0deg);
    }

    .aside_top a {
        text-decoration: none !important;
    }

    .aside_top {
        background-color: #fff;
        border-radius: 12px 12px 0px 0px !important;
    }

    .aside_bottom {
        background-color: #fff;
        border-radius: 0px 0px 12px 12px !important;
    }

    .aside_body {
        /*width: 318px !important;*/
        height: auto !important;
        background: #F7F7F7 !important;
    }
</style>

@if($user->role!= user_roles('3'))
<div class="row mb-2">
    <div class="col-lg-8">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text bg-white" style="border-right: none; border: 1px solid #DDDDDD;">
                    <svg width="11" height="15" viewBox="0 0 11 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7.56221 14.0648C7.58971 14.3147 7.52097 14.5814 7.36287 14.7563C7.29927 14.8336 7.22373 14.8949 7.14058 14.9367C7.05742 14.9785 6.96827 15 6.87825 15C6.78822 15 6.69907 14.9785 6.61592 14.9367C6.53276 14.8949 6.45722 14.8336 6.39363 14.7563L3.63713 11.4151C3.56216 11.3263 3.50516 11.2176 3.47057 11.0977C3.43599 10.9777 3.42477 10.8496 3.43779 10.7235V6.45746L0.145116 1.34982C0.0334875 1.17612 -0.0168817 0.955919 0.005015 0.737342C0.0269117 0.518764 0.119294 0.319579 0.261975 0.183308C0.392582 0.0666576 0.536937 0 0.688166 0H10.3118C10.4631 0 10.6074 0.0666576 10.738 0.183308C10.8807 0.319579 10.9731 0.518764 10.995 0.737342C11.0169 0.955919 10.9665 1.17612 10.8549 1.34982L7.56221 6.45746V14.0648ZM2.09047 1.66644L4.81259 5.88254V10.4819L6.1874 12.1484V5.8742L8.90953 1.66644H2.09047Z" fill="#323C47" />
                        </svg>
                    </div>
                    </div>
                    @php
                        // Create an array to keep track of encountered names
                        $encounteredNames = [];
                    @endphp

                    <select name="" class="form-select aside-select" id="statusSelect" style="border-left: none; font-size: 13px;">
                        <option value="">
                            <!-- @lang('lang.filter_by_client') -->
                            Filter by {{($user->role == 'Admin') ? 'Clients' : 'Drivers'}}
                        </option>
                        @foreach($activeRoutes as $key => $value)
                            @php
                                $name = $value['driver']['name'] ?? $value['user']['name'];

                                if (!in_array($name, $encounteredNames)) {
                                    $encounteredNames[] = $name;
                            @endphp
                                    <option value="{{ $name }}">{{ $name }}</option>
                            @php
                                }
                            @endphp
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-4 pt-2">
                <span>
                    <a class="show-more" style="font-size: small; color: #ACADAE;" href="/routes">@lang('lang.show_more')..</a>
                </span>
            </div>
            <div class="col-lg-12">
                <h6 class="mb-0 mt-2">@lang('lang.ongoing_trips')</h6>
            </div>
        </div>
@endif
        @if(isset($activeRoutes) && count($activeRoutes) > 0)
        <div style="height: 700px; overflow: auto;">
            @foreach($activeRoutes as $key => $value)
            <div class="mb-2 trip-card "  role="tablist">
                <div class="card" style="background: #FFFFFF;box-shadow: 0px 20px 50px rgba(220, 224, 249, 0.5);border-radius: 12px;">
                    <div class="card-header aside_top" role="tab" id="heading{{$key}}">
                        <h5 class="mb-0">
                        <a data-toggle="collapse" href="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                            <div class="d-flex flex-column">
                                <span class="mb-1" style="font-style: normal;font-weight: 700;font-size: 14px;line-height: 17px;letter-spacing: 0.01em;color: #323C47;">{{$value['title'] ?? ''}}</span>
                                <span class="text-secondary text-small" style="font-style: normal;font-weight: 400;font-size: 14px;line-height: 17px;letter-spacing: 0.01em;color: #9FA2B4;">
                                    {{ date('d F, Y', strtotime($value['trip_date'])) ?? '' }}
                                </span>
                            </div>
                        </a>
                    </h5>
                </div>
                <div id="collapse{{$key}}" class="collapse{{ $key == 0 ? ' show' : '' }}" role="tabpanel" aria-labelledby="heading{{$key}}" data-parent="#accordion">
                    <div class="card-body p-2 aside_body">
                        {{$value['desc'] ?? ''}}
                    </div>
                </div>
                <div class="card-header aside_bottom" role="tab" id="">
                    <h5 class="mb-0">
                        <div data-toggle="" aria-expanded="true" aria-controls="collapse{{$key}}">
                            <div class="row">
                                <div class="col-8 col-sm-8 col-lg-8 col-xl-6">
                                    <div class="d-flex flex-column">
                                        <span class="mb-1 user-name" style="font-style: normal;font-weight: 700;font-size: 14px;line-height: 17px;letter-spacing: 0.01em;color: #323C47;">{{ $value['driver']['name'] ?? $value['user']['name'] }}</span>
                                        <span class="text-secondary text-small" style="font-style: normal;font-weight: 400;font-size: 14px;line-height: 17px;letter-spacing: 0.01em;color: #9FA2B4;">{{$tripStatus_trans[$value['status']] ?? ''}}</span>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-4 col-lg-4 col-xl-6 text-right">
                                                <div class="d-flex justify-content-end">
                                                    @if($user->role == user_roles('3') && $value['status'] != $tripStatus['Deleted'])
                                                    <form method="POST" action="/driver_map" class="mb-0">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$value['id']}}">
                                                        <button class="btn p-0">
                                                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <circle opacity="0.1" cx="18" cy="18" r="18" fill="#452C88"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.7941 24.7919C17.7943 24.7919 17.7944 24.792 18 24.5L17.7941 24.7919ZM18.2059 24.7919L18.2071 24.7909L18.2104 24.7886L18.2217 24.7805C18.2315 24.7735 18.2455 24.7634 18.2635 24.7501C18.2995 24.7237 18.3515 24.6849 18.4172 24.6345C18.5485 24.5335 18.7347 24.3855 18.9575 24.195C19.4028 23.8143 19.9967 23.2617 20.5916 22.5735C21.7728 21.2071 23 19.257 23 17.0275C23 15.6948 22.4737 14.4162 21.5363 13.4733C20.5988 12.5302 19.3268 12 18 12C16.6733 12 15.4013 12.5302 14.4637 13.4733C13.5263 14.4162 13 15.6948 13 17.0275C13 19.257 14.2272 21.2071 15.4084 22.5735C16.0033 23.2617 16.5972 23.8143 17.0425 24.195C17.2653 24.3855 17.4515 24.5335 17.5828 24.6345C17.6485 24.6849 17.7005 24.7237 17.7365 24.7501C17.7545 24.7634 17.7685 24.7735 17.7783 24.7805L17.7896 24.7886L17.7929 24.7909L17.7941 24.7919C17.9175 24.8787 18.0825 24.8787 18.2059 24.7919ZM18 24.5L18.2059 24.7919C18.2057 24.7919 18.2056 24.792 18 24.5ZM19.7857 17C19.7857 17.9862 18.9862 18.7857 18 18.7857C17.0138 18.7857 16.2143 17.9862 16.2143 17C16.2143 16.0138 17.0138 15.2143 18 15.2143C18.9862 15.2143 19.7857 16.0138 19.7857 17Z" fill="#452C88"/>
                                                            </svg>  
                                                        </button>
                                                    </form>
                                                    @endif
                                                    <button  data-id="{{ $value['id'] }}" id="tripDetail_btn" class="btn p-0 tripDetail_view" data-toggle="modal" data-target="#tripdetail">
                                                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle opacity="0.1" cx="18" cy="18" r="18" fill="#ACADAE" />
                                                            <path d="M17.7167 13C13.5 13 11 18 11 18C11 18 13.5 23 17.7167 23C21.8333 23 24.3333 18 24.3333 18C24.3333 18 21.8333 13 17.7167 13ZM17.6667 14.6667C19.5167 14.6667 21 16.1667 21 18C21 19.85 19.5167 21.3333 17.6667 21.3333C15.8333 21.3333 14.3333 19.85 14.3333 18C14.3333 16.1667 15.8333 14.6667 17.6667 14.6667ZM17.6667 16.3333C16.75 16.3333 16 17.0833 16 18C16 18.9167 16.75 19.6667 17.6667 19.6667C18.5833 19.6667 19.3333 18.9167 19.3333 18C19.3333 17.8333 19.2667 17.6833 19.2333 17.5333C19.1 17.8 18.8333 18 18.5 18C18.0333 18 17.6667 17.6333 17.6667 17.1667C17.6667 16.8333 17.8667 16.5667 18.1333 16.4333C17.9833 16.3833 17.8333 16.3333 17.6667 16.3333Z" fill="black" />
                                                        </svg>
                                                    </button>
                                                </div>
                                </div>
                            </div>
                        </div>
                    </h5>
                </div>
                <div id="collapse{{$key}}" class="collapse{{ $key == 0 ? ' show' : '' }}" role="tabpanel" aria-labelledby="" data-parent="">
                    </div>
                </div>
            </div>
            @endforeach


@else
    <div class="mb-2" id="noTrip" role="tablist">
        <div class="card" style="background: #FFFFFF;box-shadow: 0px 20px 50px rgba(220, 224, 249, 0.5);border-radius: 12px;">
            <div class="card-header aside_top" role="tab" id="headingNoData">
                <h5 class="mb-0">
                    <a data-toggle="collapse" href="#collapseNoData" aria-expanded="true" aria-controls="collapseNoData">
                        <div class="d-flex flex-column">
                            <span class="mb-1" style="font-style: normal;font-weight: 700;font-size: 14px;line-height: 17px;letter-spacing: 0.01em;color: #323C47;">@lang('lang.no_trip_available_yet')</span>
                        </div>
                    </a>
                </h5>
            </div>
            <div id="collapseNoData" class="collapse show" role="tabpanel" aria-labelledby="headingNoData" data-parent="#accordion">
                <div class="card-body aside_bottom p-2 aside_body">
                    <!-- Additional content for no data scenario if needed -->
                    <p>@lang('lang.you_dont_have_any_trips_yet')!</p>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="mb-2 noTripCard" id="noTripCard" role="tablist">
        <div class="card" style="background: #FFFFFF;box-shadow: 0px 20px 50px rgba(220, 224, 249, 0.5);border-radius: 12px;">
            <div class="card-header aside_top" role="tab" id="headingNoData">
                <h5 class="mb-0">
                    <a data-toggle="collapse" href="#collapseNoData" aria-expanded="true" aria-controls="collapseNoData">
                        <div class="d-flex flex-column">
                            <span class="mb-1" style="font-style: normal;font-weight: 700;font-size: 14px;line-height: 17px;letter-spacing: 0.01em;color: #323C47;">@lang('lang.no_trip_available_yet')</span>
                        </div>
                    </a>
                </h5>
            </div>
            <div id="collapseNoData" class="collapse show" role="tabpanel" aria-labelledby="headingNoData" data-parent="#accordion">
                <div class="card-body p-2 aside_body">
                    <!-- Additional content for no data scenario if needed -->
                    <p>@lang('lang.you_dont_have_any_trips_yet')!</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- ... Your existing HTML code ... -->
<script>
$(document).ready(function() {
    $('.noTripCard').hide();

    // Function to toggle the collapse state when the arrow button is clicked
    $('.trip-card .card-header a').click(function(event) {
        event.preventDefault(); // Prevent the default link behavior
        var targetCollapse = $(this).attr('href');
        $(targetCollapse).collapse('toggle');
    });

    // Function to filter trips based on selected driver name
    function filterTripsByDriver(driverName) {
        var matchingTripFound = false;
        var no_trip = $('.trip-card:first .user-name').text().trim();
        $('.trip-card').show();

        if (driverName != '' && no_trip != '') {
            $('.trip-card').each(function() {
                var tripDriverName = $(this).find('.user-name').text().trim();
                if (tripDriverName !== driverName) {
                    $(this).hide();
                } else {
                    matchingTripFound = true;
                }
            });
        } else {
            matchingTripFound = true;
        }

        if (matchingTripFound) {
            $('.noTripCard').hide();
        } else {
            $('.noTripCard').show();
        }
    }

    $('#statusSelect').change(function() {
        var selectedDriverName = $(this).val();
        filterTripsByDriver(selectedDriverName);
    });
});
</script>

@include('tripdetail_modal')