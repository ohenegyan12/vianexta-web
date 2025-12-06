    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('home_page') }}">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('images/logo_new.png') }}" alt="logo" width="40" height="40">
                    <img src="{{ asset('images/logo_new.png') }}" alt="logo" width="40" height="40">
                </div>
            </a>

            <!-- <strong>BS</strong> -->
        </div>

        <form action="{{ route('filterMultiProduct') }}" method="POST">
            @csrf
            <div class="row list-unstyled components" style="margin-top:80px;">
                <div class="col-md-12">
                    <!-- <a href="{{ route('sellersDashboardHome') }}" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color:black">
                   
                    Origin country
                </a> -->

                    <select class="form-select multi-select" multiple name='country' aria-label="Default select example" data-placeholder="Origin Country" style="background-color:#DADADA;">
                        <!-- <option value="Kenya">Kenya</option> -->
                        @if(isset($stock_params->countryOptions))
                        @foreach($stock_params->countryOptions as $country)
                        <option value="{{$country}}" {{(isset($filter_params['originCountry']) && $filter_params['originCountry']=="$country") ? 'selected' : ""  }}>{{$country}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="{{in_array(Request::route()->getName(), [
                              'sellersDashboardHome'
                              ]) ? 'active' : ''}}">
                    <!-- <a href="{{ route('sellersDashboardHome') }}" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color:black">
                    Species
                </a> -->
                    <select class="form-select" name="species" aria-label="Default select example" style="background-color:#DADADA;">
                        <option value="">Type</option>
                        <option value="Arabica" {{(isset($filter_params['species']) && $filter_params['species']=="Arabica") ? 'selected' : ""  }}>Arabica</option>
                        <option value="Robusta" {{(isset($filter_params['species']) && $filter_params['species']=="Robusta") ? 'selected' : ""  }}>Robusta</option>
                    </select>
                </div>
                <div class="{{in_array(Request::route()->getName(), [
                              'sellersDashboardHome'
                              ]) ? 'active' : ''}}">
                    <!-- <a href="{{ route('sellersDashboardHome') }}" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color:black">
                    Variety
                </a> -->
                    <select class="form-select" name="variety" aria-label="Default select example" style="background-color:#DADADA;">
                        <option value="">Variety</option>
                        @if(isset($stock_params->varietyOptions))
                        @foreach($stock_params->varietyOptions as $variety)
                        <option value="{{$variety}}" {{(isset($filter_params['variety']) && $filter_params['variety']=="$variety") ? 'selected' : ""  }}>{{$variety}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="{{in_array(Request::route()->getName(), [
                              'sellersDashboardHome'
                              ]) ? 'active' : ''}}">
                    <!-- <a href="{{ route('sellersDashboardHome') }}" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color:black">
                    Type
                </a> -->
                    <select class="form-select" name="coffeeType" aria-label="Default select example" style="background-color:#DADADA;">
                        <option value="">Specialty/Commercial</option>
                        <option value="Commercial" {{(isset($filter_params['coffeeType']) && $filter_params['coffeeType']=="Commercial") ? 'selected' : ""  }}>Commercial</option>
                        <option value="Specialty" {{(isset($filter_params['coffeeType']) && $filter_params['coffeeType']=="Specialty") ? 'selected' : ""  }}>Specialty</option>
                    </select>
                </div>
                <div class="{{in_array(Request::route()->getName(), [
                              'sellersDashboardHome'
                              ]) ? 'active' : ''}}">
                    <!-- <a href="{{ route('sellersDashboardHome') }}" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color:black">
                    Process
                </a> -->
                    <select class="form-select" name="process" aria-label="Default select example" style="background-color:#DADADA;">
                        <option value="">Process</option>
                        @if(isset($stock_params->processOptions))
                        @foreach($stock_params->processOptions as $process)
                        <option value="{{$process}}" {{(isset($filter_params['process']) && $filter_params['process']=="$process") ? 'selected' : ""  }}>{{$process}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="{{in_array(Request::route()->getName(), [
                              'sellersDashboardHome'
                              ]) ? 'active' : ''}}">
                    <!-- <a href="{{ route('sellersDashboardHome') }}" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="color:black">
                    SCA Quality Score
                </a> -->
                    <select class="form-select" name="quality" aria-label="Default select example" style="background-color:#DADADA;">
                        <option value="">SCA Quality Score</option>
                        <option value="90-100" {{(isset($filter_params['quality']) && $filter_params['quality']=="90-100") ? 'selected' : ""  }}>90-100</option>
                        <option value="85-89" {{(isset($filter_params['quality']) && $filter_params['quality']=="85-89") ? 'selected' : ""  }}>85-89</option>
                        <option value="80-84" {{(isset($filter_params['quality']) && $filter_params['quality']=="80-84") ? 'selected' : ""  }}>80-84</option>
                        <option value="0" {{(isset($filter_params['quality']) && $filter_params['quality']=="0") ? 'selected' : ""  }}>
                            < 80</option>
                    </select>
                </div>
                <div>
                    <select class="form-select multi-select" multiple name="certification" data-placeholder="Certification" aria-label="Default select example" style="background-color:#DADADA;">
                        @if(isset($cirtifications))
                        @foreach($cirtifications as $cirtification)
                        <option value="{{$cirtification->name}}" {{(isset($filter_params['cirtification']) && $filter_params['cirtification']=="$cirtification->name") ? 'selected' : ""  }}>{{$cirtification->name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>

            </div>
            <div class="text-center mt-2">
                <div class="text-center mt-2">
                    @if(empty($filter_params) && empty($product_filter))
                    <button type="submit" class="btn btn-primary">Filter</button>
                    @else
                    <a href="{{route('buyer_market_place')}}" class="btn btn-primary">Reset</a>
                    <button type="submit" class="btn btn-secondary">Filter</button>
                    @endif
                </div>
        </form>
    </nav>