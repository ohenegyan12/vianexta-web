@extends('layouts.account_layout ')
@section('title', 'Proecess Types ')


@section('content')

    <main class="py-4 pb-40 sm:py-8 h-5/6">
        <div class="p-5 mx-auto max-w-screen-2xl">

            <div class="mb-30 md:mb-40">
                <h3 class="mb-6 font-semibold md:text-xl lg:text-3xl text-secondary">Type of process</h3>
                <p>Overall explanation of types of processes.</p>
            </div>
            <div class="grid grid-cols-1 gap-16 pt-10 pb-40">
                <div class="flex flex-col items-center gap-4 md:flex-row lg:gap-20">
                    <a href="#"
                        class="relative self-start block w-full h-56 overflow-hidden group shrink-0 md:h-24 md:w-24 lg:h-56 lg:w-96">
                        <img src="{{ asset('images/carbonica_maceration.png') }}" loading="lazy" alt="image"
                            class="inset-0 object-cover object-center w-full h-full transition duration-200 group-hover:scale-110" />
                    </a>

                    <div class="flex flex-col gap-2">


                        <h2 class="text-xl font-bold text-gray-800">
                            <a href="#"
                                class="text-lg transition duration-100 md:text-2xl lg:text-3xl hover:text-secondary">Carbonica
                                maceration</a>
                        </h2>

                        <p class="text-gray-500">Carbonic maceration is a winemaking technique, primarily used in the
                            production of certain styles of red wines, that involves fermenting whole grapes in a carbon
                            dioxide-rich environment before crushing them. It is known for its ability to produce wines with
                            distinctive characteristics, such as vibrant fruit flavors, lower tannins, and a fresh, fruity
                            aroma. see more...</p>

                        <div>
                            <a href="#"
                                class="font-semibold transition duration-100 text-primary hover:text-primary active:text-primary">Read
                                more</a>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-center gap-4 md:flex-row lg:gap-20">
                    <a href="#"
                        class="relative self-start block w-full h-56 overflow-hidden group shrink-0 md:h-24 md:w-24 lg:h-56 lg:w-96">
                        <img src="{{ asset('images/carbonica_maceration.png') }}" loading="lazy" alt="image"
                            class="inset-0 object-cover object-center w-full h-full transition duration-200 group-hover:scale-110" />
                    </a>

                    <div class="flex flex-col gap-2">


                        <h2 class="text-xl font-bold text-gray-800">
                            <a href="#"
                                class="text-lg transition duration-100 md:text-2xl lg:text-3xl hover:text-secondary">Carbonica
                                maceration</a>
                        </h2>

                        <p class="text-gray-500">Carbonic maceration is a winemaking technique, primarily used in the
                            production of certain styles of red wines, that involves fermenting whole grapes in a carbon
                            dioxide-rich environment before crushing them. It is known for its ability to produce wines with
                            distinctive characteristics, such as vibrant fruit flavors, lower tannins, and a fresh, fruity
                            aroma. see more...</p>

                        <div>
                            <a href="#"
                                class="font-semibold transition duration-100 text-primary hover:text-primary active:text-primary">Read
                                more</a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col items-center gap-4 md:flex-row lg:gap-20">
                    <a href="#"
                        class="relative self-start block w-full h-56 overflow-hidden group shrink-0 md:h-24 md:w-24 lg:h-56 lg:w-96">
                        <img src="{{ asset('images/carbonica_maceration.png') }}" loading="lazy" alt="image"
                            class="inset-0 object-cover object-center w-full h-full transition duration-200 group-hover:scale-110" />
                    </a>

                    <div class="flex flex-col gap-2">


                        <h2 class="text-xl font-bold text-gray-800">
                            <a href="#"
                                class="text-lg transition duration-100 md:text-2xl lg:text-3xl hover:text-secondary">Carbonica
                                maceration</a>
                        </h2>

                        <p class="text-gray-500">Carbonic maceration is a winemaking technique, primarily used in the
                            production of certain styles of red wines, that involves fermenting whole grapes in a carbon
                            dioxide-rich environment before crushing them. It is known for its ability to produce wines with
                            distinctive characteristics, such as vibrant fruit flavors, lower tannins, and a fresh, fruity
                            aroma. see more...</p>

                        <div>
                            <a href="#"
                                class="font-semibold transition duration-100 text-primary hover:text-primary active:text-primary">Read
                                more</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

@endsection
