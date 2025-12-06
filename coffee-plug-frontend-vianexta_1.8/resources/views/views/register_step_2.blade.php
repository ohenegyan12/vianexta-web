                    <label for="eula_agreement" class="ml-2 text-sm font-medium text-gray-900">
                        I have read and agree to the <button type="button" onclick="openEulaModal()" class="text-primary hover:text-primary-dark underline font-semibold cursor-pointer">ViaNexta EULA <i class="fas fa-external-link-alt ml-1"></i></button>
                    </label>
                </div>
                @if ($errors->has('eula_agreement'))
                    <span class="invalid-feedback" role="alert">
                        <strong style="color: red;">{{ $errors->first('eula_agreement') }}</strong>
                    </span>
                @endif
            </div>

            <!-- EULA Modal -->
            <div id="eulaModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-4 border w-11/12 md:w-1/3 lg:w-1/4 shadow-lg rounded-md bg-white">
                    <div class="mt-2">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-semibold text-primary">ViaNexta EULA</h3>
                            <button type="button" onclick="closeEulaModal()" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="max-h-[50vh] overflow-y-auto mb-3 text-sm text-gray-600 pr-2"> 