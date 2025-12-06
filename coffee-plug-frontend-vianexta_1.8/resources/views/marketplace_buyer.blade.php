@extends('layouts.account_layout ')
<!-- yeild title -->
@section('title', 'Marketplace Buyer')



@section('content')
    <div class="pb-40 bg-white h-5/6">
        <div x-data="{ open: false }" @keydown.window.escape="open = false">
            <!-- Mobile filter dialog -->

            <div x-show="open" class="relative z-40 lg:hidden"
                x-description="Off-canvas menu for mobile, show/hide based on off-canvas menu state." x-ref="dialog"
                aria-modal="true">

                <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-description="Off-canvas menu backdrop, show/hide based on off-canvas menu state."
                    class="fixed inset-0 bg-black bg-opacity-25"></div>


                <div class="fixed inset-0 z-40 flex">

                    <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transition ease-in-out duration-300 transform"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                        x-description="Off-canvas menu, show/hide based on off-canvas menu state."
                        class="relative flex flex-col w-full h-full max-w-xs py-4 pb-6 ml-auto overflow-y-auto bg-white shadow-xl"
                        @click.away="open = false">
                        <div class="flex items-center justify-between px-4">
                            <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                            <button type="button"
                                class="flex items-center justify-center w-10 h-10 p-2 -mr-2 text-gray-400 hover:text-gray-500"
                                @click="open = false">
                                <span class="sr-only">Close menu</span>
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12">
                                    </path>
                                </svg>
                            </button>
                        </div>

                        <!-- Filters -->
                        <form class="mt-4">
                            <div x-data="{ open: false }" class="pt-4 pb-4 border-t border-secondary">
                                <fieldset>
                                    <legend class="w-full px-2">
                                        <button type="button" x-description="Expand/collapse section button"
                                            class="flex items-center justify-between w-full p-2 text-gray-400 hover:text-gray-500"
                                            aria-controls="filter-section-0" @click="open = !open" aria-expanded="false"
                                            x-bind:aria-expanded="open.toString()">
                                            <span class="text-sm font-medium text-gray-900">Origin country</span>
                                            <span class="flex items-center ml-6 h-7">
                                                <svg class="w-5 h-5 transform rotate-0"
                                                    x-description="Expand/collapse icon, toggle classes based on section open state."
                                                    x-state:on="Open" x-state:off="Closed"
                                                    :class="{ '-rotate-180': open, 'rotate-0': !(open) }"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    </legend>
                                    <div class="px-4 pt-4 pb-2" id="filter-section-0" x-show="open">
                                        <div class="space-y-6">

                                            @foreach ($menus->countries as $country)
                                                <div class="flex items-center">
                                                    <input id="color-0" name="color[]" value="white" type="checkbox"
                                                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                    <label for="color-0" class="ml-3 text-sm text-gray-600"></label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div x-data="{ open: false }" class="pt-4 pb-4 border-t border-secondary">
                                <fieldset>
                                    <legend class="w-full px-2">
                                        <button type="button" x-description="Expand/collapse section button"
                                            class="flex items-center justify-between w-full p-2 text-gray-400 hover:text-gray-500"
                                            aria-controls="filter-section-1" @click="open = !open" aria-expanded="false"
                                            x-bind:aria-expanded="open.toString()">
                                            <span class="text-sm font-medium text-gray-900">Free Sample</span>
                                            <span class="flex items-center ml-6 h-7">
                                                <svg class="w-5 h-5 transform rotate-0"
                                                    x-description="Expand/collapse icon, toggle classes based on section open state."
                                                    x-state:on="Open" x-state:off="Closed"
                                                    :class="{ '-rotate-180': open, 'rotate-0': !(open) }"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    </legend>
                                    <div class="px-4 pt-4 pb-2" id="filter-section-1" x-show="open">
                                        <div class="space-y-6">
                                            <div class="flex items-center">
                                                <input id="category-0-mobile" name="category[]" value="new-arrivals"
                                                    type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="category-0-mobile"
                                                    class="ml-3 text-sm text-gray-500">Yes</label>
                                            </div>


                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div x-data="{ open: false }" class="pt-4 pb-4 border-t border-secondary">
                                <fieldset>
                                    <legend class="w-full px-2">
                                        <button type="button" x-description="Expand/collapse section button"
                                            class="flex items-center justify-between w-full p-2 text-gray-400 hover:text-gray-500"
                                            aria-controls="filter-section-2" @click="open = !open" aria-expanded="false"
                                            x-bind:aria-expanded="open.toString()">
                                            <span class="text-sm font-medium text-gray-900">Availability</span>
                                            <span class="flex items-center ml-6 h-7">
                                                <svg class="w-5 h-5 transform rotate-0"
                                                    x-description="Expand/collapse icon, toggle classes based on section open state."
                                                    x-state:on="Open" x-state:off="Closed"
                                                    :class="{ '-rotate-180': open, 'rotate-0': !(open) }"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    </legend>
                                    <div class="px-4 pt-4 pb-2" id="filter-section-2" x-show="open">
                                        <div class="space-y-6">
                                            <div class="flex items-center">
                                                <input id="category-0" name="category[]" value="new-arrivals"
                                                    type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="category-0"
                                                    class="ml-3 text-sm text-gray-600">Commercial</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="category-1" name="category[]" value="tees" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="category-1"
                                                    class="ml-3 text-sm text-gray-600">Specialty</label>
                                            </div>

                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div x-data="{ open: false }" class="pt-4 pb-4 border-t border-secondary">
                                <fieldset>
                                    <legend class="w-full px-2">
                                        <button type="button" x-description="Expand/collapse section button"
                                            class="flex items-center justify-between w-full p-2 text-gray-400 hover:text-gray-500"
                                            aria-controls="filter-section-2" @click="open = !open" aria-expanded="false"
                                            x-bind:aria-expanded="open.toString()">
                                            <span class="text-sm font-medium text-gray-900">Type</span>
                                            <span class="flex items-center ml-6 h-7">
                                                <svg class="w-5 h-5 transform rotate-0"
                                                    x-description="Expand/collapse icon, toggle classes based on section open state."
                                                    x-state:on="Open" x-state:off="Closed"
                                                    :class="{ '-rotate-180': open, 'rotate-0': !(open) }"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    </legend>
                                    <div class="px-4 pt-4 pb-2" id="filter-section-2" x-show="open">
                                        <div class="space-y-6">
                                            <div class="flex items-center">
                                                <input id="sizes-0-mobile" name="sizes[]" value="xs" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-0-mobile"
                                                    class="ml-3 text-sm text-gray-500">Commercial</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-1-mobile" name="sizes[]" value="s" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-1-mobile"
                                                    class="ml-3 text-sm text-gray-500">Specialty</label>
                                            </div>


                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div x-data="{ open: false }" class="pt-4 pb-4 border-t border-secondary">
                                <fieldset>
                                    <legend class="w-full px-2">
                                        <button type="button" x-description="Expand/collapse section button"
                                            class="flex items-center justify-between w-full p-2 text-gray-400 hover:text-gray-500"
                                            aria-controls="filter-section-2" @click="open = !open" aria-expanded="false"
                                            x-bind:aria-expanded="open.toString()">
                                            <span class="text-sm font-medium text-gray-900">Process</span>
                                            <span class="flex items-center ml-6 h-7">
                                                <svg class="w-5 h-5 transform rotate-0"
                                                    x-description="Expand/collapse icon, toggle classes based on section open state."
                                                    x-state:on="Open" x-state:off="Closed"
                                                    :class="{ '-rotate-180': open, 'rotate-0': !(open) }"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    </legend>
                                    <div class="px-4 pt-4 pb-2" id="filter-section-2" x-show="open">
                                        <div class="space-y-6">
                                            <div class="flex items-center">
                                                <input id="sizes-0" name="sizes[]" value="xs" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-0" class="ml-3 text-sm text-gray-600">Fully
                                                    Washed</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-1" name="sizes[]" value="s" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-1" class="ml-3 text-sm text-gray-600">Natural</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-2" name="sizes[]" value="m" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-2" class="ml-3 text-sm text-gray-600">Semi
                                                    Washed</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-3" name="sizes[]" value="l" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-3" class="ml-3 text-sm text-gray-600">Washed</label>
                                            </div>

                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div x-data="{ open: false }" class="pt-4 pb-4 border-t border-secondary">
                                <fieldset>
                                    <legend class="w-full px-2">
                                        <button type="button" x-description="Expand/collapse section button"
                                            class="flex items-center justify-between w-full p-2 text-gray-400 hover:text-gray-500"
                                            aria-controls="filter-section-2" @click="open = !open" aria-expanded="false"
                                            x-bind:aria-expanded="open.toString()">
                                            <span class="text-sm font-medium text-gray-900">Quality</span>
                                            <span class="flex items-center ml-6 h-7">
                                                <svg class="w-5 h-5 transform rotate-0"
                                                    x-description="Expand/collapse icon, toggle classes based on section open state."
                                                    x-state:on="Open" x-state:off="Closed"
                                                    :class="{ '-rotate-180': open, 'rotate-0': !(open) }"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    </legend>
                                    <div class="px-4 pt-4 pb-2" id="filter-section-2" x-show="open">
                                        <div class="space-y-6">
                                            <div class="flex items-center">
                                                <input id="sizes-0" name="sizes[]" value="xs" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-0" class="ml-3 text-sm text-gray-600">A1</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-1" name="sizes[]" value="s" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-1" class="ml-3 text-sm text-gray-600">AA</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-2" name="sizes[]" value="m" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-2" class="ml-3 text-sm text-gray-600">AA/AB</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-3" name="sizes[]" value="l" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-3" class="ml-3 text-sm text-gray-600">Arabica
                                                    COmmercial Grade</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-4" name="sizes[]" value="xl" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-4" class="ml-3 text-sm text-gray-600">Grade
                                                    1</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-5" name="sizes[]" value="2xl" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-5" class="ml-3 text-sm text-gray-600">Grade
                                                    2</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-5" name="sizes[]" value="2xl" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-5" class="ml-3 text-sm text-gray-600">Grade
                                                    3</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-5" name="sizes[]" value="2xl" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-5" class="ml-3 text-sm text-gray-600">Grade
                                                    4</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-5" name="sizes[]" value="2xl" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-5" class="ml-3 text-sm text-gray-600">Grade
                                                    5</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-5" name="sizes[]" value="2xl" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-5" class="ml-3 text-sm text-gray-600">Grade
                                                    6</label>
                                            </div>

                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                        </form>
                    </div>

                </div>
            </div>


            <main class="max-w-2xl px-4 py-2 mx-auto sm:px-6 sm:py-5 lg:max-w-9xl lg:px-8">


                <div class="pt-12 lg:grid lg:grid-cols-3 lg:gap-x-8 xl:grid-cols-4">
                    <aside>
                        <h2 class="sr-only">Filters</h2>

                        <button type="button"
                            x-description="Mobile filter dialog toggle, controls the 'mobileFilterDialogOpen' state."
                            class="inline-flex items-center lg:hidden" @click="open = true">
                            <span class="text-sm font-medium text-gray-700">Filters</span>
                            <svg class="flex-shrink-0 w-5 h-5 ml-1 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path
                                    d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z">
                                </path>
                            </svg>
                        </button>

                        <div class="hidden lg:block">
                            <form class="space-y-10 divide-y divide-primborder-secondary">
                                <div>
                                    <fieldset>
                                        <legend class="block text-sm font-medium text-secondary">Origin country</legend>
                                        <div class="pt-6 space-y-3">

                                            @foreach ($menus->countries as $country)
                                                <div class="flex items-center">
                                                    <input id="{{ $country->id }}" name="color[]" value="white"
                                                        type="checkbox"
                                                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                    <label for="color-0"
                                                        class="ml-3 text-sm text-gray-600">{{ $country->name }}</label>
                                                </div>
                                            @endforeach

                                        </div>
                                    </fieldset>
                                </div>
                                <div class="pt-5">
                                    <fieldset>
                                        <legend class="block text-sm font-semibold text-gray-900">Free Sample</legend>
                                        <div class="pt-6 space-y-3">
                                            <div class="flex items-center">
                                                <input id="category-0" name="category[]" value="new-arrivals"
                                                    type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="category-0" class="ml-3 text-sm text-gray-600">Yes</label>
                                            </div>


                                        </div>
                                    </fieldset>
                                </div>
                                <div class="pt-5">
                                    <fieldset>
                                        <legend class="block text-sm font-semibold text-gray-900">Type</legend>
                                        <div class="pt-6 space-y-3">
                                            <div class="flex items-center">
                                                <input id="category-0" name="category[]" value="new-arrivals"
                                                    type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="category-0"
                                                    class="ml-3 text-sm text-gray-600">Commercial</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="category-1" name="category[]" value="tees" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="category-1"
                                                    class="ml-3 text-sm text-gray-600">Specialty</label>
                                            </div>

                                        </div>
                                    </fieldset>
                                </div>
                                <div class="pt-5">
                                    <fieldset>
                                        <legend class="block text-sm font-medium text-gray-900">Process</legend>
                                        <div class="pt-6 space-y-3">
                                            <div class="flex items-center">
                                                <input id="sizes-0" name="sizes[]" value="xs" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-0" class="ml-3 text-sm text-gray-600">Fully
                                                    Washed</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-1" name="sizes[]" value="s" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-1" class="ml-3 text-sm text-gray-600">Natural</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-2" name="sizes[]" value="m" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-2" class="ml-3 text-sm text-gray-600">Semi
                                                    Washed</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-3" name="sizes[]" value="l" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-3" class="ml-3 text-sm text-gray-600">Washed</label>
                                            </div>


                                        </div>
                                    </fieldset>
                                </div>
                                <div class="pt-5">
                                    <fieldset>
                                        <legend class="block text-sm font-medium text-gray-900">Quality</legend>
                                        <div class="pt-6 space-y-3">
                                            <div class="flex items-center">
                                                <input id="sizes-0" name="sizes[]" value="xs" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-0" class="ml-3 text-sm text-gray-600">A1</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-1" name="sizes[]" value="s" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-1" class="ml-3 text-sm text-gray-600">AA</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-2" name="sizes[]" value="m" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-2" class="ml-3 text-sm text-gray-600">AA/AB</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-3" name="sizes[]" value="l" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-3" class="ml-3 text-sm text-gray-600">Arabica
                                                    COmmercial Grade</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-4" name="sizes[]" value="xl" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-4" class="ml-3 text-sm text-gray-600">Grade
                                                    1</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-5" name="sizes[]" value="2xl" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-5" class="ml-3 text-sm text-gray-600">Grade
                                                    2</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-5" name="sizes[]" value="2xl" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-5" class="ml-3 text-sm text-gray-600">Grade
                                                    3</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-5" name="sizes[]" value="2xl" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-5" class="ml-3 text-sm text-gray-600">Grade
                                                    4</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-5" name="sizes[]" value="2xl" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-5" class="ml-3 text-sm text-gray-600">Grade
                                                    5</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="sizes-5" name="sizes[]" value="2xl" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <label for="sizes-5" class="ml-3 text-sm text-gray-600">Grade
                                                    6</label>
                                            </div>

                                        </div>
                                    </fieldset>
                                </div>

                            </form>
                        </div>
                    </aside>

                    <!-- Product grid -->
                    <div class="mt-6 lg:col-span-2 lg:mt-0 xl:col-span-3">
                        <div>
                            <div class="">
                                <h1 class="text-4xl font-bold text-secondary">Marketplace</h1>

                            </div>
                            {{-- * * search bar --}}
                            <form action="{{ route('filterProduct') }}" method="POST">
                                @csrf
                                <div class="flex mt-2 rounded-md shadow-sm">
                                        <div class="relative flex items-stretch flex-grow focus-within:z-10">
                                            <input type="text" placeholder="Search by coffee type(eg:Arabica)" value="{{empty($product_filter) ? old('product_filter') : $product_filter}}" name="product_filter" id="product_filter"
                                                class="block w-full px-6 py-3 text-sm text-gray-900 border rounded-none rounded-l-xl border-secondary sm:py-4 sm:text-base ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:outline-none focus:border-secondary focus:ring-secondary ">
                                        </div>
                                        <button type="submit"
                                            class="relative -ml-px inline-flex border border-secondary items-center gap-x-1.5 rounded-r-xl px-8 py-2 text-sm font-semibold text-secondary ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                            Search
                                        </button>
                                </div>
                            </form>
                            <div class="flex items-center justify-between my-4 md:my-6">
                                <div class="flex">
                                    <a href="{{ route('home_page') }}">
                                        <span class="text-xs font-semibold text-secondary sm:text-base">Return to
                                            homepage</span>
                                    </a>
                                </div>

                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:mx-0 md:grid-cols-2 xl:grid-cols-3 md:gap-6">

                                @foreach ($data as $datum)
                             
                                    <div x-data="{ showInfo: false }"
                                        class="p-0 border-2 shadow-sm border-secondary card w-96 ">
                                        @php $datum->id == 2 ? $datum->imageUrl = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTCybt8SG0nIFDraah1JZOfrk9uuZ6wW_5BSQ&usqp=CAU' : ''; @endphp
                                        <!-- <a href="{{ route('product_details',$helper->encode($datum->id)) }}"> -->

                                        <a href="{{ route('get_product',$helper->encode($datum->id)) }}">
                                            <img class="object-cover object-center w-full h-56"
                                                src="{{ $datum->imageUrl !=null ? $datum->imageUrl : asset('images/green_beans.jpg') }}" alt="product" />
                                        </a>
                                        <div class="absolute bottom-0 left-0 right-0 bg-white card" x-show="showInfo"
                                            x-transition:enter="transform transition-transform ease-out duration-300"
                                            x-transition:enter-start="translate-y-full"
                                            x-transition:leave="transform transition-transform ease-in duration-300"
                                            x-transition:leave-start="translate-y-0" @mouseleave="showInfo = false">
                                            <div>
                                                <div class="flex items-center justify-between px-4 py-2 ">
                                                    <div>
                                                        <h3 class="text-sm font-medium text-gray-900">
                                                            <!-- <a href="#"> -->
                                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                                           {{$datum->supplierInfo->country != null? $datum->supplierInfo->country:'Location'}}
                                                            <!-- </a> -->
                                                        </h3>

                                                        <p class="text-sm text-gray-500 ">{{$datum->supplierInfo->firstName != null? $datum->supplierInfo->firstName:'Vendor name not availbale'}}</p>
                                                    </div>

                                                    <p class="text-sm font-medium md:text-base text-primary">$
                                                        <span>1.722(per lb)</span>
                                                    </p>
                                                    <div @click="showInfo = !showInfo">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                        </svg>

                                                    </div>
                                                </div>

                                                {{-- <hr class="w-full my-1 border md:my-2 border-secondary"> --}}
                                                <div class="overflow-x-auto">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                
                                                                <td class="border-2 border-secondary">
                                                                    <p class="text-sm font-semibold text-secondary">
                                                                     Type</p>
                                                                    <p class="text-xs text-secondary">{{$datum->coffeeType}}</p>
                                                                </td>
                                                                <td class="border-2 border-secondary">
                                                                    <p class="text-sm font-semibold text-secondary">
                                                                        Process</p>
                                                                    <p class="text-xs text-secondary">{{$datum->process}}</p>
                                                                </td>
                                                                <td class="border-2 border-secondary">
                                                                    <p class="text-sm font-semibold text-secondary">
                                                                        Quality</p>
                                                                    <p class="text-xs text-secondary">{{$datum->quality}}</p>
                                                                </td>
                                                                <td class="border-2 border-secondary">
                                                                    <p class="text-sm font-semibold text-secondary">
                                                                        Aroma</p>
                                                                    <p class="text-xs text-secondary">{{$datum->aroma}}</p>
                                                                </td>
                                                            </tr>
                                                            <tr>

                                                                <td class="border-2 border-secondary">
                                                                    <p class="text-sm font-semibold text-secondary">
                                                                        Harvest</p>
                                                                    <p class="text-xs text-secondary">Apr-Jun</p>
                                                                </td>
                                                                <td class="border-2 border-secondary">
                                                                    <p class="text-sm font-semibold text-secondary">
                                                                        Fermentation</p>
                                                                    <p class="text-xs text-secondary">Dry, 36 hours</p>
                                                                </td>
                                                                <td class="border-2 border-secondary">
                                                                    <p class="text-sm font-semibold text-secondary">
                                                                        Country</p>
                                                                    <p class="text-xs text-secondary">Colombia</p>
                                                                </td>
                                                                <td class="border-2 border-secondary">
                                                                    <p class="text-sm font-semibold text-secondary">
                                                                        Weight</p>
                                                                    <p class="text-xs text-secondary">{{$datum->bagWeight}} Kg</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="px-4 py-2">
                                                        <p class="text-sm font-semibold text-secondary">
                                                            Notes</p>
                                                        <p class="text-xs text-secondary">{{$datum->description}}</p>
                                                    </div>

                                                </div>

                                                {{-- <hr class="w-full my-1 border md:my-2 border-secondary"> --}}

                                            </div>
                                        </div>
                                        <div class="px-1 card-body">
                                            <div class="flex items-center justify-between">
                                                <div class="mr-10">
                                                    <h2><b>South Kivu K3 FW 15+</b></h2>
                                                    <p>Vendor: {{$datum->supplierInfo->firstName != null? $datum->supplierInfo->firstName:''}}</p>
                                                </div>
                                                <p class="text-primary">$
                                                    <span>1.722(per lb)</span>
                                                </p>
                                                <div @click="showInfo = !showInfo">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                    </svg>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                    {{-- <div x-data="{ showInfo: false }"
                                        class="relative border-2 group rounded-xl border-secondary ">
                                        <a @mouseenter="showInfo = true" @mouseleave="showInfo = false"
                                            href="{{ route('get_product',$helper->encode($datum->id)) }}">
                                            <div
                                                class="overflow-hidden aspect-h-1 aspect-w-1 bg-primborder-secondary group-hover:opacity-75">
                                                <img src="{{ asset('images/product_img.svg') }}" alt="image"
                                                    class="object-cover object-center w-full h-1/3">
                                            </div>
                                            <div class="absolute bottom-0 left-0 right-0 bg-white " x-show="showInfo"
                                                x-transition:enter="transform transition-transform ease-out duration-300"
                                                x-transition:enter-start="translate-y-full"
                                                x-transition:leave="transform transition-transform ease-in duration-300"
                                                x-transition:leave-start="translate-y-0">
                                                <div>
                                                    <div class="flex items-center justify-between px-2 ">
                                                        <div>
                                                            <h3 class="text-sm font-medium text-gray-900">
                                                                <!-- <a href="#"> -->
                                                                <span aria-hidden="true" class="absolute inset-0"><b>South Kivu K3 FW 15+</b></span>
                                                                
                                                                <!-- </a> -->
                                                            </h3>

                                                            <p class="text-sm text-gray-500 "></p>
                                                        </div>

                                                        <p class="text-base font-medium text-primary">$
                                                            <span>1.722(per lb)</span>
                                                        </p>
                                                        <p class="text-base font-medium text-primary">
                                                            <span>$0</span>
                                                        </p>
                                                        <div>
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                            </svg>

                                                        </div>
                                                    </div>
                                                    <hr class="w-full my-1 border md:my-2 border-secondary">
                                                    <div class="flex items-center justify-between px-2">
                                                        <div class="border-r">
                                                            <p class="text-sm font-semibold text-secondary">Aroma</p>
                                                            <p text-secondary text-sm>{{$datum->aroma}}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-semibold text-secondary">Quality</p>
                                                            <p text-secondary text-sm>{{$datum->quality}}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-semibold text-secondary">Type</p>
                                                            <p text-secondary text-sm>{{$datum->coffeeType}}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-semibold text-secondary">Bag Weight</p>
                                                            <p text-secondary text-sm>{{$datum->bagWeight}} Kg</p>
                                                        </div>
                                                    </div>
                                                    <hr class="w-full my-1 border md:my-2 border-secondary">

                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between p-1">
                                                <div>
                                                    <h3 class="text-sm font-medium text-gray-900">
                                                        <!-- <a href="#"> -->
                                                        <span aria-hidden="true" class="absolute inset-0"></span>
                                                        Location
                                                        <!-- </a> -->
                                                    </h3>

                                                    <p class="text-sm text-gray-500 ">Vendor</p>
                                                </div>

                                                <p class="text-base font-medium text-primary">$
                                                    <span>$0</span>
                                                </p>
                                                <div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                    </svg>

                                                </div>
                                            </div>
                                        </a>
                                    </div> --}}
                              
                                @endforeach

                            </div>

                            {{-- pagination --}}
                            <div class="mt-20">
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('marketplace_buyer') }}">
                                        <button
                                            class="hidden px-20 mt-6 capitalize border-2 md:flex btn btn-outline btn-md outline-4 text-secondary ">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-secondary ">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 19.5L8.25 12l7.5-7.5" />
                                            </svg>
                                            Previous Step
                                        </button>
                                    </a>
                                    <button type="submit"
                                        class="w-full px-20 mt-6 text-white capitalize btn btn-primary btn-md md:w-max ">
                                        Next Step
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

    </div>

@endsection
