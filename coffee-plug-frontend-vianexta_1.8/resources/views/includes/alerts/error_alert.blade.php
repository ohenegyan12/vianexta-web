<div id="alert-modal" class="hidden fixed inset-0 z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Background overlay with backdrop blur -->
    <div class="fixed inset-0 bg-red-900/30 backdrop-blur-sm transition-opacity"></div>

    <!-- Modal panel -->
    <div class="fixed inset-0 z-50 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative w-full max-w-sm transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all duration-300 ease-out border-2 border-red-300">
                <!-- Header with enhanced red gradient background -->
                <div class="px-4 py-3 relative overflow-hidden" style="background: linear-gradient(to right, #b91c1c, #991b1b) !important;">
                    <!-- Red accent pattern overlay -->
                    <div class="absolute inset-0" style="background-color: rgba(220, 38, 38, 0.2) !important;"></div>
                    <!-- Decorative red circles -->
                    <div class="absolute top-0 right-0 w-20 h-20 rounded-full -translate-y-10 translate-x-10" style="background-color: rgba(220, 38, 38, 0.5) !important;"></div>
                    <div class="absolute bottom-0 left-0 w-16 h-16 rounded-full translate-y-8 -translate-x-8" style="background-color: rgba(220, 38, 38, 0.4) !important;"></div>

                    <div class="flex items-center justify-center relative z-10">
                        <div class="backdrop-blur-sm rounded-full p-2 mr-3" style="background-color: rgba(220, 38, 38, 0.4) !important;">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white" id="modal-title" style="color: #ffffff !important;">Registration Failed</h3>
                    </div>
                </div>

                <!-- Content area -->
                <div class="px-4 py-4" style="background: linear-gradient(to bottom, #fef2f2, #ffffff) !important;">
                    <div class="text-center">
                        <p class="text-sm text-gray-800 mb-4" id="modal-message" style="color: #1f2937 !important;">{{session('error')}}</p>

                        <!-- Red accent line -->
                        <div class="w-16 h-1 rounded-full mx-auto mb-4" style="background-color: #ef4444 !important;"></div>

                        <!-- Error message -->
                        <div class="text-xs font-medium px-3 py-2 rounded-lg border" style="color: #b91c1c !important; background-color: #fef2f2 !important; border-color: #fca5a5 !important;">
                            Please review your information and try again
                        </div>
                    </div>
                </div>

                <!-- Footer with red button -->
                <div class="px-4 py-3 border-t" style="background: linear-gradient(to right, #fef2f2, #fee2e2) !important; border-color: #fca5a5 !important;">
                    <button type="button" onclick="closeAlertModal()"
                        class="w-full font-semibold py-2 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 hover:shadow-lg border"
                        style="background: linear-gradient(to right, #dc2626, #b91c1c) !important; color: #ffffff !important; border-color: #ef4444 !important;">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>