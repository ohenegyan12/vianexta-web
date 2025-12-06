<script>
    // Global flag to track if we should show alerts (for manual function calls)
    window.shouldShowAlerts = true;

    function showSuccess(title, message) {
        console.log('Debug: Showing success toast:', title, message);
        var toastElList = [].slice.call(document.querySelectorAll('.success_toast'))
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl)
        })
        toastList.forEach(toast => toast.show())
    }

    function showFailed(title, message) {
        console.log('Debug: Showing error toast:', title, message);
        var toastElList = [].slice.call(document.querySelectorAll('.error_toast'))
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl)
        })
        toastList.forEach(toast => toast.show())
    }

    // Debug function to check session state
    function debugSession() {
        console.log('Debug: Checking session state...');
        console.log('Error session:', '{{ session("error") }}');
        console.log('Success session:', '{{ session("success") }}');
        console.log('Should show alerts:', window.shouldShowAlerts);
        console.log('Is login page:', window.location.pathname.includes('login'));
    }

    // Function to clear sessions after they've been displayed
    function clearSessionsAfterDisplay() {
        // Use fetch to clear sessions via a route
        fetch('/clear-sessions', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Content-Type': 'application/json',
            },
        }).then(response => {
            if (response.ok) {
                console.log('Debug: Sessions cleared successfully');
            } else {
                console.log('Debug: Failed to clear sessions');
            }
        }).catch(error => {
            console.log('Debug: Error clearing sessions:', error);
        });
    }

    // Run debug on page load
    document.addEventListener('DOMContentLoaded', function() {
        debugSession();

        // Additional cleanup for login page without fresh messages
        var isLoginPage = window.location.pathname.includes('login');
        var hasFreshError = '{{ session("error") }}' !== '';
        var hasFreshSuccess = '{{ session("success") }}' !== '';

        if (isLoginPage && !hasFreshError && !hasFreshSuccess) {
            console.log('Debug: Login page without fresh messages - hiding any existing toasts');

            // Hide any existing toasts that might be from old sessions
            setTimeout(function() {
                var errorToasts = document.querySelectorAll('.error_toast');
                var successToasts = document.querySelectorAll('.success_toast');

                console.log('Debug: Found error toasts:', errorToasts.length);
                console.log('Debug: Found success toasts:', successToasts.length);

                errorToasts.forEach(function(toast, index) {
                    console.log('Debug: Error toast', index, 'display:', toast.style.display, 'classes:', toast.className);
                    if (toast.style.display !== 'none') {
                        toast.style.display = 'none';
                        console.log('Debug: Hidden error toast', index);
                    }
                });

                successToasts.forEach(function(toast, index) {
                    console.log('Debug: Success toast', index, 'display:', toast.style.display, 'classes:', toast.className);
                    if (toast.style.display !== 'none') {
                        toast.style.display = 'none';
                        console.log('Debug: Hidden success toast', index);
                    }
                });
            }, 100);
        }
    });
</script>

@if (!empty(session('error')))
@php
$errorMessage = session('error');
// Don't clear immediately - let it be displayed first
@endphp
<script>
    console.log('Debug: Error session found on page load:', '{{ $errorMessage }}');

    // Check if we're on login page and if this is a fresh message
    var isLoginPage = window.location.pathname.includes('login');
    var hasFreshError = '{{ session("error") }}' !== '';

    if (isLoginPage && hasFreshError) {
        console.log('Debug: Login page with fresh error - showing error toast');
        showFailed("Operation failed", "{{ $errorMessage }}");
        // Clear the session after displaying
        setTimeout(function() {
            clearSessionsAfterDisplay();
        }, 5000); // Clear after 5 seconds
    } else if (!isLoginPage) {
        console.log('Debug: Non-login page - showing error toast');
        showFailed("Operation failed", "{{ $errorMessage }}");
        // Clear the session after displaying
        setTimeout(function() {
            clearSessionsAfterDisplay();
        }, 5000); // Clear after 5 seconds
    } else {
        console.log('Debug: Login page without fresh error - not showing toast');
    }
</script>
@endif

@if (!empty(session('success')))
@php
$successMessage = session('success');
// Don't clear immediately - let it be displayed first
@endphp
<script>
    console.log('Debug: Success session found on page load:', '{{ $successMessage }}');

    // Check if we're on login page and if this is a fresh message
    var isLoginPage = window.location.pathname.includes('login');
    var hasFreshSuccess = '{{ session("success") }}' !== '';

    if (isLoginPage && hasFreshSuccess) {
        console.log('Debug: Login page with fresh success - showing success toast');
        showSuccess("Operation Successful", "{{ $successMessage }}");
        // Clear the session after displaying
        setTimeout(function() {
            clearSessionsAfterDisplay();
        }, 5000); // Clear after 5 seconds
    } else if (!isLoginPage) {
        console.log('Debug: Non-login page - showing success toast');
        showSuccess("Operation Successful", "{{ $successMessage }}");
        // Clear the session after displaying
        setTimeout(function() {
            clearSessionsAfterDisplay();
        }, 5000); // Clear after 5 seconds
    } else {
        console.log('Debug: Login page without fresh success - not showing toast');
    }
</script>
@endif