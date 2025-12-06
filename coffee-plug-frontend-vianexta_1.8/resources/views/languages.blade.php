@extends('layouts.auth_layout ')
@section('title', 'Account Type ')

@section('content')
<section class="py-4 sm:py-8 pb-40 h-5/6">
    <div class="mx-auto max-w-screen-2xl p-3 p-lg-5 pt-5">
        <h1 class="text-2xl md:text-4xl font-semibold text-secondary text-start mb-8 md:mb-10 "> Choose Language
        </h1>
        <form action="{{ route('saveLanguage') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6 px-xl-5">
                    <img class="w-100 px-xl-5 img-fluid" src="{{asset('images/languages.png')}}" alt="" />
                </div>
                <div class="col-lg-6 px-lg-5">
                    <form action="{{ route('saveLanguage') }}" method="POST" class="px-xl-5">
                        @csrf
                        <div class="relative mt-2 me-0">
                            <div class="w-full">
                                <ul class="p-4">
                                    <li class="flex justify-between items-center hover:bg-slate-300 p-4 rounded-lg">
                                        <div class="flex gap-x-4">
                                            <span class="flag-icon flag-icon-us pr-5"></span>English
                                        </div>
                                        <input type="radio" name="language" class="radio radio-primary radio-sm" checked />

                                    </li>
                                    <!-- <li class=" flex justify-between items-center hover:bg-slate-300 p-4 rounded-lg">
                                <div class="flex gap-x-4"><span class="flag-icon flag-icon-es"></span>Español</div>
                                <input type="radio" name="language" value="español" class="radio radio-primary" />

                            </li>
                            <li class=" flex justify-between items-center hover:bg-slate-300 p-4 rounded-lg">
                                <div class="flex gap-x-4"><span class="flag-icon flag-icon-fr pr-5"></span>Français</div>
                                <input type="radio" name="language" value="français" class="radio radio-primary" />

                            </li>
                            <li class=" flex justify-between items-center hover:bg-slate-300 p-4 rounded-lg">
                                <div class="flex gap-x-4"><span class="flag-icon flag-icon-de pr-5"></span>Deutsch</div>
                                <input type="radio" name="language" value="deutsch" class="radio radio-primary" />

                            </li>
                            <li class=" flex justify-between items-center hover:bg-slate-300 p-4 rounded-lg">
                                <div class="flex gap-x-4"><span class="flag-icon flag-icon-it pr-5"></span>Italiano</div>
                                <input type="radio" name="language" value="italiano" class="radio radio-primary" />

                            </li>
                            <li class=" flex justify-between items-center hover:bg-slate-300 p-4 rounded-lg">
                                <div class="flex gap-x-4"><span class="flag-icon flag-icon-cn pr-5"></span>Chinese</div>
                                <input type="radio" name="language" value="chinese" class="radio radio-primary" />

                            </li> -->



                                </ul>
                                {{-- <select id="language" name="language"
                            class="mt-2 block w-full  rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2  sm:text-sm sm:leading-6">
                            <option value="en"><span class="flag-icon flag-icon-us"></span>English</option>
                            <option value="es"><span class="flag-icon flag-icon-es"></span>Español</option>
                            <option value="fr"><span class="flag-icon flag-icon-fr"></span>Français</option>
                            <option value="de"><span class="flag-icon flag-icon-de"></span>Deutsch</option>
                            <option value="it"><span class="flag-icon flag-icon-it"></span>Italiano</option>
                            <option value="it"><span class="flag-icon flag-icon-cn"></span>Chinese</option>
                            <option value="it"><span class="flag-icon flag-icon-ua"></span>Українська</option>
                        </select> --}}
                            </div>
                        </div>

                </div>
            </div>

            <div class="mt-20">
                <div class="flex items-center justify-between">
                    <a href="{{ route('login_page') }}"
                        class="btn btn-outline-secondary mb-md-3 text-primary capitalize" style="border-width: medium;">
                        <i class="fa fa-angle-left" style="margin-right:15px;margin-left:15px;"></i> Back to Login
                    </a>
                    <button type="submit"
                        class="btn btn-primary mb-md-3 text-white capitalize ">
                        Next Step
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>



@endsection