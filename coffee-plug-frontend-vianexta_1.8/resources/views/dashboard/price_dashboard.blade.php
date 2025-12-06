<!DOCTYPE html>
<html lang="en">

<head>
    <title>Coffee Plug</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('images/logo_new.png')}}" type="image/x-icon">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset('abel_assets/css/style.css')}}">
    
    

</head>
<body class="">
	<!-- [ Pre-loader ] start -->
	<div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div>
	<!-- [ Pre-loader ] End -->
	<!-- [ navigation menu ] start -->
	<nav class="pcoded-navbar menu-light" >
		<div class="navbar-wrapper  ">
			<div class="navbar-content scroll-div " >
				
				<div class="">
					<div class="main-menu-header">
						<img class="img-radius" src="{{asset('abel_assets/images/user/avatar-2.jpg')}}" alt="User-Profile-Image">
						<div class="user-details">
							<div id="more-details">Matt<i class="fa fa-caret-down"></i></div>
						</div>
					</div>
					<div class="collapse" id="nav-user-link">
						<ul class="list-inline">
							<li class="list-inline-item"><a href="user-profile.html" data-toggle="tooltip" title="View Profile"><i class="feather icon-user"></i></a></li>
							<li class="list-inline-item"><a href="email_inbox.html"><i class="feather icon-mail" data-toggle="tooltip" title="Messages"></i><small class="badge badge-pill badge-primary">5</small></a></li>
							<li class="list-inline-item"><a href="auth-signin.html" data-toggle="tooltip" title="Logout" class="text-danger"><i class="feather icon-power"></i></a></li>
						</ul>
					</div>
				</div>
				
				<ul class="nav pcoded-inner-navbar ">
					<li class="nav-item pcoded-menu-caption">
						<label style="color:#07382E;">Navigation</label>
					</li>
					<li class="nav-item ">
						<a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
					</li>
				</ul>
				
			</div>
		</div>
	</nav>
	<!-- [ navigation menu ] end -->
	<!-- [ Header ] start -->
	<header class="navbar pcoded-header navbar-expand-lg navbar-light header-purple" >
			
				<div class="m-header">
					<a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
					<a href="#!" class="b-brand">
						<!-- ========   change your logo hear   ============ -->
						<img src="{{asset('images/logo_new.png')}}" height="60" alt="" class="logo">CoffeePlug
						<img src="{{asset('images/logo_new.png')}}" alt="" class="logo-thumb">
					</a>
					<a href="#!" class="mob-toggler">
						<i class="feather icon-more-vertical"></i>
					</a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a href="#!" class="pop-search"><i class="feather icon-search"></i></a>
							<div class="search-bar">
								<input type="text" class="form-control border-0 shadow-none" placeholder="Search hear">
								<button type="button" class="close" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						</li>
					</ul>
					<ul class="navbar-nav ml-auto">
						<li>
							<div class="dropdown">
								<a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon feather icon-bell"></i></a>
								<div class="dropdown-menu dropdown-menu-right notification">
									<div class="noti-head">
										<h6 class="d-inline-block m-b-0">Notifications</h6>
										<div class="float-right">
											<a href="#!" class="m-r-10">mark as read</a>
											<a href="#!">clear all</a>
										</div>
									</div>
									<ul class="noti-body">
										<li class="n-title">
											<p class="m-b-0">NEW</p>
										</li>
										<li class="notification">
											<div class="media">
												<img class="img-radius" src="{{asset('abel_assets/images/user/avatar-1.jpg')}}" alt="Generic placeholder image">
												<div class="media-body">
													<p><strong>Matt</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>5 min</span></p>
													<p>New ticket Added</p>
												</div>
											</div>
										</li>
										<li class="n-title">
											<p class="m-b-0">EARLIER</p>
										</li>
										<li class="notification">
											<div class="media">
												<img class="img-radius" src="{{asset('abel_assets/images/user/avatar-2.jpg')}}" alt="Generic placeholder image">
												<div class="media-body">
													<p><strong>Joseph William</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>10 min</span></p>
													<p>Prchace New Theme and make payment</p>
												</div>
											</div>
										</li>
										<li class="notification">
											<div class="media">
												<img class="img-radius" src="{{asset('abel_assets/images/user/avatar-1.jpg')}}" alt="Generic placeholder image">
												<div class="media-body">
													<p><strong>Sara Soudein</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>12 min</span></p>
													<p>currently login</p>
												</div>
											</div>
										</li>
										<li class="notification">
											<div class="media">
												<img class="img-radius" src="{{asset('abel_assets/images/user/avatar-2.jpg')}}" alt="Generic placeholder image">
												<div class="media-body">
													<p><strong>Joseph William</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>30 min</span></p>
													<p>Prchace New Theme and make payment</p>
												</div>
											</div>
										</li>
									</ul>
									<div class="noti-footer">
										<a href="#!">show all</a>
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="dropdown drp-user">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="feather icon-user"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right profile-notification">
									<div class="pro-head">
										<img src="{{asset('abel_assets/images/user/avatar-1.jpg')}}" class="img-radius" alt="User-Profile-Image">
										<span>John Doe</span>
										<a href="#" class="dud-logout" title="Logout">
											<i class="feather icon-log-out"></i>
										</a>
									</div>
									<ul class="pro-body">
										<li><a href="#" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>
										<li><a href="#" class="dropdown-item"><i class="feather icon-mail"></i> My Messages</a></li>
										<li><a href="#" class="dropdown-item"><i class="feather icon-lock"></i> Lock Screen</a></li>
									</ul>
								</div>
							</div>
						</li>
					</ul>
				</div>
				
			
	</header>
	<!-- [ Header ] end -->
	
	

<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-content" >
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Buyer Dashboard</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Buyer Dashboard</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
        	
            <!-- amount start -->
            <div class="col-md-6 col-xl-4">
                <div class="card amount-card overflow-hidden">
                    <div class="card-body">
                       <div class="row">
                           <div class="col-8">
                             	<h2 class="f-w-400"><span class="text-c-green"></span>USD 23,567</h2>
                           	    <p class="text-muted f-w-600 f-16"><span class="text-c-green">Total purchases made</span> </p>
                           </div>
                           <div class="col-4">
                           	   <h3 class="f-w-400">50 bags</h3>
                               <p class="text-muted f-w-600 f-16">Quantity</p>
                           </div>
                       </div>
                    </div>
                     <div id="amount-spent"></div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card amount-card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                              	<h2 class="f-w-400"><span class="text-c-yellow"></span>USD 2,567</h2>
                            	    <p class="text-muted f-w-600 f-16"><span class="text-c-yellow">Total pending orders</span> </p>
                            </div>
                            <div class="col-4">
                            	   <h3 class="f-w-400">10 bags</h3>
                                <p class="text-muted f-w-600 f-16">Quantity</p>
                            </div>
                        </div>
                    </div>
                    <div id="profit-processed"></div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4">
                <div class="card amount-card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                              	<h2 class="f-w-400"><span class="text-c-blue"></span>USD 2,567</h2>
                            	<p class="text-muted f-w-600 f-16"><span class="text-c-blue">Last order made</span> (19-09-2023)</p>
                            </div>
                            <div class="col-4">
                            	   <h3 class="f-w-400">7 bags</h3>
                                <p class="text-muted f-w-600 f-16">Quantity</p>
                            </div>
                        </div>
                    </div>
                    <div id="amount-processed"></div>
                </div>
            </div>
            <!-- amount end -->

            <!-- Realtime Data of Visits end -->
            <div class="col-xl-8 col-md-12">
                <div class="card">
                    <div class="card-header">
                    	<div class="row">
                    		<div class="col-9">
                    			<h5>Realtime Price of Coffee Prices from the Commodities API</h5>
                    		</div>
                    		<div class="col-3">
                    			<div class="d-flex align-items-end"> <h3 id="timeClock"></h3></div>
                    			<h6 class="text-muted m-b-0">Current date<i class="fa fa-caret-down text-c-red m-l-10"></i></h6>
                    		</div>
                    	</div>
                    </div>
                    <div class="card-body">
                        <div class="row my-2">
                            <div class="col-auto">
                                <h4 class="m-0">Arabica<i class="feather icon-arrow-up text-c-green"></i></h4>
                                <span>{{$prices->arabica->currency}} {{$prices->arabica->price}} ({{$prices->arabica->unit}})</span>
                            </div>
                            <div class="col-auto">
                                <h4 class="m-0">Robusta<i class="feather icon-arrow-down text-c-red"></i></h4>
                                <span>{{$prices->robusta->currency}} {{$prices->robusta->price}} ({{$prices->robusta->unit}})</span>

                            </div>
                           
                        </div>
                        <div id="realtime-visit-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3>{{$prices->arabica->dateTime}}</h3>
                            <h6 class="text-muted m-b-0">Price update as at<i class="fa fa-caret-down text-c-red m-l-10"></i></h6>
                        </div>
                        <div class="col-4">
                          <div id="seo-chart1" class="d-flex align-items-end"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="m-0">Arabica<i class="feather icon-arrow-up text-c-green"></i></h4>
                            <span>{{$prices->arabica->currency}} {{$prices->arabica->price}} ({{$prices->arabica->unit}})</span>
                        </div>
                        <div class="col-4">
                        	 <img src="{{asset('images/arabica.avif')}}" alt="arabica" class="img-radius wid-120 align-top m-r-15">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="m-0">Robusta<i class="feather icon-arrow-down text-c-red"></i></h4>
                             <span>{{$prices->robusta->currency}} {{$prices->robusta->price}} ({{$prices->robusta->unit}})</span>
                        </div>
                        <div class="col-4">
                        	 <img src="{{asset('images/robusta.jpg')}}" alt="arabica" class="img-radius wid-80 align-top m-r-15">
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!-- Realtime Data of Visits end -->
         

        </div>
        <!-- [ Main Content ] end -->

    </div>
</div>

    <!-- Required Js -->
    <script src="{{asset('abel_assets/js/vendor-all.min.js')}}"></script>
    <script src="{{asset('abel_assets/js/plugins/bootstrap.min.js')}}"></script>
    <script src="{{asset('abel_assets/js/ripple.js')}}"></script>
    <script src="{{asset('abel_assets/js/pcoded.min.js')}}"></script>
	<script src="{{asset('abel_assets/js/menu-setting.min.js')}}"></script>

<!-- Apex Chart -->
<script src="{{asset('abel_assets/js/plugins/apexcharts.min.js')}}"></script>


<!-- custom-chart js -->
<script src="{{asset('abel_assets/js/pages/dashboard-analytics.js')}}"></script>

<script>
    var myVar = setInterval(myTimer, 1000);
    function myTimer() {
        var d = new Date();
        var t = d.toLocaleTimeString('en-US');
        $("#timeClock").html(t);
    }

</script>

</body>

</html>
