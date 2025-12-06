@if (!empty(session('error')))
<div class="position-fixed top-0 end-0 p-3 " style="z-index: 11;margin-top:50px;  width: 50vw;">
  <div id="liveToast" class="error_toast toast hide toast-top toast_margin text-white bg-primary" role="alert" aria-live="polite" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        {{session("error")}}
      </div>
      <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endif

@if (!empty(session('success')))
<div class="position-fixed top-0 end-0 p-3 " style="z-index: 11;margin-top:50px;">
  <div id="liveToast" class="success_toast toast toast-top toast_margin hide text-white bg-green" role="alert" aria-live="polite" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        {{session("success")}}
      </div>
      <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endif

<script>
  // Check for fresh messages immediately (same logic as sweet_alert_scripts.blade.php)
  var hasFreshError = '{{ session("error") }}' !== '';
  var hasFreshSuccess = '{{ session("success") }}' !== '';
  var isLoginPage = window.location.pathname.includes('login');

  // Only show toasts if we're not on the login page, OR if we have fresh messages
  if (isLoginPage) {
    if (hasFreshError || hasFreshSuccess) {
      console.log('Debug: Login page with fresh messages - toasts will be shown');
      // Don't hide toasts - let them show for legitimate login errors
    } else {
      console.log('Debug: Login page without fresh messages - hiding all toasts');
      // Hide any existing toasts that might be from old sessions
      var errorToasts = document.querySelectorAll('.error_toast');
      var successToasts = document.querySelectorAll('.success_toast');

      errorToasts.forEach(function(toast) {
        toast.style.display = 'none';
      });

      successToasts.forEach(function(toast) {
        toast.style.display = 'none';
      });
    }
  } else {
    console.log('Debug: Non-login page, toasts will be shown if session data exists');
  }
</script>