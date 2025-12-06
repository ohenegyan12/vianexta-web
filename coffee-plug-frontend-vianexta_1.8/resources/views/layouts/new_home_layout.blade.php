<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSRF Token for AJAX requests -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'ViaNexta')</title>
  <!-- Load Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('css/custom_style.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- select2 css -->
  {{-- <link rel="stylesheet" href="{{ asset('abel_assets/css/plugins/select2.min.css')}}"> --}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/css/flag-icon.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <!-- fileupload-custom css -->
  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" rel="stylesheet"> -->
  @stack('css')

</head>

<body class="d-flex flex-column min-vh-100">

  @yield('content')


  @if(!isset($donnot_show_footer) || $donnot_show_footer==null || !$donnot_show_footer)
  @include('includes.footers.new_home_footer')
  @endif

  @include('includes.alerts.message_alerts')

  <!-- Load jQuery first - required by all other scripts -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  
  <!-- Store original jQuery before vendor scripts might override it -->
  <script>
    window.originalJQuery = window.jQuery;
    window.original$ = window.$;
  </script>

  <!-- Load Bootstrap 5 bundle with Popper.js included -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  
  <!-- Load Select2 after Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  
  <!-- Load other scripts after core libraries -->
  <script src="{{ asset('js/tabs.js') }}"></script>
  <!-- Add interact.js library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/interact.js/1.10.17/interact.min.js"></script>
  <script>
    // Global error handler for Select2
    window.addEventListener('error', function(e) {
      if (e.message && e.message.includes('select2')) {
        console.warn('Select2 error caught and handled:', e.message);
        e.preventDefault();
        return false;
      }
    });
  </script>

  <!-- Global error handler for Bootstrap tooltips -->
  <script>
    // Prevent Bootstrap tooltip errors from breaking the page
    window.addEventListener('error', function(e) {
      if (e.message && (e.message.includes('createPopper') || e.message.includes('tooltip'))) {
        console.warn('Bootstrap tooltip error caught and handled:', e.message);
        e.preventDefault();
        return false;
      }
    });

    // Override Bootstrap tooltip if it's causing issues
    if (typeof bootstrap !== 'undefined' && typeof bootstrap.Tooltip !== 'undefined') {
      var originalTooltip = bootstrap.Tooltip;
      bootstrap.Tooltip = function(element, options) {
        try {
          return new originalTooltip(element, options);
        } catch (error) {
          console.warn('Bootstrap tooltip error prevented:', error.message);
          // Return a dummy tooltip object
          return {
            show: function() {},
            hide: function() {},
            dispose: function() {}
          };
        }
      };
    }
  </script>
  <!-- sweet alert Js -->
  <script src="{{ asset('abel_assets/js/vendor-all.min.js')}}"></script>
  <script>
    // Restore jQuery if it was overridden by vendor-all.min.js
    if (typeof $ === 'undefined' || typeof jQuery === 'undefined') {
      console.warn('jQuery was overridden by vendor-all.min.js - restoring original jQuery');
      window.jQuery = window.originalJQuery;
      window.$ = window.original$;
      
      // If still undefined, reload jQuery
      if (typeof $ === 'undefined' || typeof jQuery === 'undefined') {
        console.error('Failed to restore jQuery - reloading jQuery');
        var script = document.createElement('script');
        script.src = 'https://code.jquery.com/jquery-3.7.0.min.js';
        script.integrity = 'sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=';
        script.crossOrigin = 'anonymous';
        document.head.appendChild(script);
      } else {
        console.log('jQuery restored successfully');
      }
    } else {
      console.log('jQuery is still available after loading vendor-all.min.js');
    }
  </script>
  <script src="{{ asset('abel_assets/js/plugins/sweetalert.min.js')}}"></script>
  <!-- <script src="{{ asset('abel_assets/js/pages/form-select-custom.js')}}"></script> -->
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
  <script>
    // Wait for DOM and jQuery to be ready
    $(document).ready(function() {
      console.log('Layout: DOM ready, jQuery version:', $.fn.jquery);
      
      // Check if we're on the checkout page - skip Select2 initialization but don't return early
      if (window.location.pathname.includes('checkout') || window.location.pathname.includes('buyer_checkout')) {
        console.log('Checkout page detected - skipping Select2 initialization');
        // Don't return early - let other scripts run
      } else {
        // Initialize Select2 only if available and elements exist (non-checkout pages)
        if (typeof $.fn.select2 !== 'undefined' && $('.form-select:not(.no-select2)').length > 0) {
          try {
            $('.form-select:not(.no-select2)').select2({
              placeholder: 'Select an option',
              allowClear: true,
              width: '100%'
            });
            console.log('Select2 initialized on', $('.form-select:not(.no-select2)').length, 'elements');
          } catch (error) {
            console.warn('Select2 initialization failed:', error.message);
          }
        } else {
          console.log('Select2 not available or no elements to initialize');
        }
      }
    });
  </script>
  @include('includes.alerts.sweet_alert_scripts')

  @yield('scripts')
</body>

</html>