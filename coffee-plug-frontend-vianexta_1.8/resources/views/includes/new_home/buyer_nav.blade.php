<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">

        <button type="button" id="sidebarCollapse" class="btn btn-secondary">
            <i class="fa fa-align-left"></i>

        </button>
        <h1 class="display-6 fw-bolder" style="color: #07382F;">Hi {{session('auth_user_name')}}!</h1>
        <a href="{{route('buyerAccountPage')}}">
            <img class="card-img-top img-fluid rounded"
                src="{{ asset('images/seller/male_farmer.jpg') }}" style="height:40px; width:40px" alt="farmer">
        </a>
    </div>
</nav>