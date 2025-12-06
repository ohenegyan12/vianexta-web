<div id="success_alert" class="hidden fixed inset-0 z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Background overlay with backdrop blur -->
    <div class="fixed inset-0 bg-green-900/30 backdrop-blur-sm transition-opacity"></div>

    <!-- Modal panel -->
    <div class="fixed inset-0 z-50 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative w-full max-w-sm transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all duration-300 ease-out border-2 border-green-300">
                <!-- Header with enhanced green gradient background -->
                <div class="px-4 py-3 relative overflow-hidden" style="background: linear-gradient(to right, #059669, #047857) !important;">
                    <!-- Green accent pattern overlay -->
                    <div class="absolute inset-0" style="background-color: rgba(16, 185, 129, 0.2) !important;"></div>
                    <!-- Decorative green circles -->
                    <div class="absolute top-0 right-0 w-20 h-20 rounded-full -translate-y-10 translate-x-10" style="background-color: rgba(16, 185, 129, 0.5) !important;"></div>
                    <div class="absolute bottom-0 left-0 w-16 h-16 rounded-full translate-y-8 -translate-x-8" style="background-color: rgba(16, 185, 129, 0.4) !important;"></div>

                    <div class="flex items-center justify-center relative z-10">
                        <div class="backdrop-blur-sm rounded-full p-2 mr-3" style="background-color: rgba(16, 185, 129, 0.4) !important;">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white" id="modal-title" style="color: #ffffff !important;">Registration Successful!</h3>
                    </div>
                </div>

                <!-- Content area -->
                <div class="px-4 py-4" style="background: linear-gradient(to bottom, #f0fdf4, #ffffff) !important;">
                    <div class="text-center">
                        <!-- <p class="text-sm text-gray-800 mb-4" id="success-message" style="color: #1f2937 !important;">{{session('success')}}</p> -->

                        <!-- Green accent line -->
                        <div class="w-16 h-1 rounded-full mx-auto mb-4" style="background-color: #10b981 !important;"></div>

                        <!-- Success message -->
                        <div class="text-xs font-medium px-3 py-2 rounded-lg border" style="color: #059669 !important; background-color: #f0fdf4 !important; border-color: #86efac !important;">
                            {{session('success')}}
                        </div>
                    </div>
                </div>

                <!-- Footer with green button -->
                <div class="px-4 py-3 border-t" style="background: linear-gradient(to right, #f0fdf4, #dcfce7) !important; border-color: #86efac !important;">
                    <button type="button" onclick="proceedToLogin()"
                        class="w-full font-semibold py-2 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 hover:shadow-lg border"
                        style="background: linear-gradient(to right, #10b981, #059669) !important; color: #ffffff !important; border-color: #10b981 !important;">
                        Proceed to Login
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>