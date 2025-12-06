@extends('layouts.account_layout ')
<!-- yeild title -->
@section('title', 'Buy Dashboard')

@section('content')

    <section class="bg-white sm:min-h-[80vh]">
        <div class="mx-auto max-w-6xl lg:max-w-9xl py-10 px-4 sm:px-6 lg:px-8 sm:py-20 ">
            <h1 class="text-3xl md:text-4xl 2xl:text-5xl font-semibold text-primary  mb-6 text-start sm:mb-10"> Account
                Dashboard
            </h1>
            <ul role="list" class="mb-20 grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
                <li class="overflow-hidden rounded-xl border border-gray-200">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-primary p-2 sm:p-4">

                        <div class="text-md sm:text-xl text-center font-semibold  text-white">Total number of purchases</div>
                    </div>
                    <div class="flex flex-col gap-y-1 sm:gap-y-4 items-center justify-center p-5 sm:p-10">
                        <div class=" sm:text-xl text-primary font-semibold"> 40 bags Quantity</div>
                        <div class="text-md sm:text-2xl text-primary font-semibold"> USD $6,100 Amount</div>
                        <div class="secondary-btn w-full mt-2 text-md text-center">
                            <a href="">View Details</a>
                        </div>
                    </div>
                </li>
                <li class="overflow-hidden rounded-xl border border-gray-200">
                    <div class="flex items-center border-b border-gray-900/5 bg-primary p-2 sm:p-4">

                        <div class="text-md sm:text-xl text-center font-semibold text-white">Total number of purchases
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-1 sm:gap-y-4 items-center justify-center p-5 sm:p-10">
                        <div class=" sm:text-xl text-primary font-semibold"> 40 bags Quantity</div>
                        <div class="text-md sm:text-2xl text-primary font-semibold"> USD $6,100 Amount</div>
                        <div class="secondary-btn w-full mt-2 text-md text-center">
                            <a href="">View Details</a>
                        </div>
                    </div>
                </li>
                <li class="overflow-hidden rounded-xl border border-gray-200">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-primary p-2 sm:p-4">

                        <div class="text-md sm:text-xl text-center font-semibold  text-white">Total number of purchases
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-1 sm:gap-y-4 items-center justify-center p-5 sm:p-10">
                        <div class=" sm:text-xl text-primary font-semibold"> 40 bags Quantity</div>
                        <div class="text-md sm:text-2xl text-primary font-semibold"> USD $6,100 Amount</div>
                        <div class="secondary-btn w-full mt-2 text-md text-center">
                            <a href="">View Details</a>
                        </div>
                    </div>
                </li>

            </ul>

            <div class="grid grid-rows-3 grid-flow-col gap-4">
                <div class="col-span-2 bg-green-900">
                    <div class="row-span-2  col-span-2 bg-orange-900 ">
                        <div class="overflow-hidden rounded-xl border border-gray-200">
                            <div class="flex items-center border-b border-gray-900/5 bg-primary p-2 sm:p-4">

                                <div class="text-md sm:text-xl text-center font-semibold text-white">Total number of
                                    purchases
                                </div>
                            </div>
                            <div class="flex flex-col gap-y-1 sm:gap-y-4 items-center justify-center p-5 sm:p-10">
                                <div class=" sm:text-xl text-primary font-semibold"> 40 bags Quantity</div>
                                <div class="text-md sm:text-2xl text-primary font-semibold"> USD $6,100 Amount</div>
                                <div class="secondary-btn w-full mt-2 text-md text-center">
                                    <a href="">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-gray-200">
                        <div class="flex items-center border-b border-gray-900/5 bg-primary p-2 sm:p-4">

                            <div class="text-md sm:text-xl text-center font-semibold text-white">Total number of purchases
                            </div>
                        </div>
                        <div class="flex flex-col gap-y-1 sm:gap-y-4 items-center justify-center p-5 sm:p-10">
                            <div class=" sm:text-xl text-primary font-semibold"> 40 bags Quantity</div>
                            <div class="text-md sm:text-2xl text-primary font-semibold"> USD $6,100 Amount</div>
                            <div class="secondary-btn w-full mt-2 text-md text-center">
                                <a href="">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row-span-3">
                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                    Name</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Title</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Email</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Role</th>
                                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                    <span class="sr-only">Edit</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            <tr>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    Lindsay Walton</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Front-end
                                                    Developer</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    lindsay.walton@example.com</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Member
                                                </td>
                                                <td
                                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                    <a href="#"
                                                        class="text-indigo-600 hover:text-indigo-900">Edit<span
                                                            class="sr-only">, Lindsay Walton</span></a>
                                                </td>
                                            </tr>

                                            <!-- More people... -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
