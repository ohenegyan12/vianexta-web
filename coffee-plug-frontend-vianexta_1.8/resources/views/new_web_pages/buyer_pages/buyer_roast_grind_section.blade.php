<div class="row justify-content-center position-relative">

    <div class="col-12 col-md-5">
        <h4 class="mb-4">Select your roast type</h4>
        <button class="coffee-option w-100 d-flex align-items-center light_roast_type" id="roast_type" onclick="setPressedOption('roast_type','light','light_roast_type')">
            <img src="{{asset('images/buyer/wizard/1.png')}}" alt="Light roast" class="coffee-icon rounded-circle">
            <span>Light</span>
            <a href="#" data-bs-toggle="modal" data-bs-target="#infoModal1" class="card-icon">
                <img src="{{ asset('images/buyer/info.png') }}" class="" alt="...">
            </a>
        </button>
        <button class="coffee-option w-100 d-flex align-items-center medium_roast_type" data-modal-target="infoModal2" id="roast_type" onclick="setPressedOption('roast_type','medium','medium_roast_type')">
            <img src="{{asset('images/buyer/wizard/2.png')}}" alt="Medium roast" class="coffee-icon rounded-circle">
            <span>Medium</span>
            <a href="#" data-bs-toggle="modal" data-bs-target="#infoModal2" class="card-icon">
                <img src="{{ asset('images/buyer/info.png') }}" class="" alt="...">
            </a>
        </button>
        <button class="coffee-option w-100 d-flex align-items-center medium_dark_roast_type" data-modal-target="infoModal3" id="roast_type" onclick="setPressedOption('roast_type','medium_dark','medium_dark_roast_type')">
            <img src="{{asset('images/buyer/wizard/3.png')}}" alt="Medium-Dark roast" class="coffee-icon rounded-circle">
            <span>Medium-Dark</span>
            <a href="#" data-bs-toggle="modal" data-bs-target="#infoModal3" class="card-icon">
                <img src="{{ asset('images/buyer/info.png') }}" class="" alt="...">
            </a>
        </button>
        <button class="coffee-option w-100 d-flex align-items-center dark_roast_type" data-bs-toggle="modal" data-bs-target="#infoModal4" id="roast_type" onclick="setPressedOption('roast_type','dark','dark_roast_type')">
            <img src="{{asset('images/buyer/wizard/4.png')}}" alt="Dark roast" class="coffee-icon rounded-circle">
            <span>Dark</span>
            <a href="#" data-bs-toggle="modal" data-bs-target="#infoModal4" class="card-icon">
                <img src="{{ asset('images/buyer/info.png') }}" class="" alt="...">
            </a>
        </button>
    </div>
    <div class="col-md-2 d-none d-md-block">
        <div class="vertical-divider"></div>
    </div>

    <div class="col-md-5">
        <h4 class="mb-4">Select your grind type</h4>
        <button class="coffee-option w-100 d-flex align-items-center whole_grain_grind_type" data-bs-target="#grindModal1" id="grind_type" onclick="setPressedOption('grind_type','whole_grain','whole_grain_grind_type')">
            <img src="{{asset('images/buyer/wizard/1a.png')}}" alt="Whole Bean" class="coffee-icon rounded-circle">
            <span>Whole Bean</span>
            <a href="#" data-bs-toggle="modal" data-bs-target="#grindModal1" class="card-icon">
                <img src="{{ asset('images/buyer/info.png') }}" class="" alt="...">
            </a>
        </button>
        <button class="coffee-option w-100 d-flex align-items-center coarse_grind_type" data-bs-target="#grindModal2" id="grind_type" onclick="setPressedOption('grind_type','coarse','coarse_grind_type')">
            <img src="{{asset('images/buyer/wizard/2a.png')}}" alt="Coarse grind" class="coffee-icon rounded-circle">
            <span>Coarse</span>
            <a href="#" data-bs-toggle="modal" data-bs-target="#grindModal2" class="card-icon">
                <img src="{{ asset('images/buyer/info.png') }}" class="" alt="...">
            </a>
        </button>
        <button class="coffee-option w-100 d-flex align-items-center medium_grind_type" data-bs-target="#grindModal3" id="grind_type" onclick="setPressedOption('grind_type','medium','medium_grind_type')">
            <img src="{{asset('images/buyer/wizard/3a.png')}}" alt="Medium grind" class="coffee-icon rounded-circle">
            <span>Medium</span>
            <a href="#" data-bs-toggle="modal" data-bs-target="#grindModal3" class="card-icon">
                <img src="{{ asset('images/buyer/info.png') }}" class="" alt="...">
            </a>
        </button>
        <button class="coffee-option w-100 d-flex align-items-center fine_grind_type" data-bs-target="#grindModal4" id="grind_type" onclick="setPressedOption('grind_type','fine','fine_grind_type')">
            <img src="{{asset('images/buyer/wizard/4a.png')}}" alt="Fine grind" class="coffee-icon rounded-circle">
            <span>Fine</span>
            <a href="#" data-bs-toggle="modal" data-bs-target="#grindModal4" class="card-icon">
                <img src="{{ asset('images/buyer/info.png') }}" class="" alt="...">
            </a>
        </button>
        <button class="coffee-option w-100 d-flex align-items-center extra_fine_grind_type" data-bs-target="#grindModal5" id="grind_type" onclick="setPressedOption('grind_type','extra_fine','extra_fine_grind_type')">
            <img src="{{asset('images/buyer/wizard/5a.png')}}" alt="Extra Fine grind" class="coffee-icon rounded-circle">
            <span>Extra Fine</span>
            <a href="#" data-bs-toggle="modal" data-bs-target="#grindModal5" class="card-icon">
                <img src="{{ asset('images/buyer/info.png') }}" class="" alt="...">
            </a>
        </button>
    </div>
</div>

<input type="hidden" name="session_grind_type" id="session_grind_type" value="{{session('grind_type') ?? ''}}">
<input type="hidden" name="session_roast_type" id="session_roast_type" value="{{session('roast_type') ?? ''}}">

<!-- <div class="row mt-4">
    <div class="col-12 text-end">
        <button class="btn btn-primary next-btn">Next</button>
    </div>
</div> -->