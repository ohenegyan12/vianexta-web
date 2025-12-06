<script>
        function showAlertModal() {
            var modal = document.getElementById("alert-modal");
            modal.classList.remove("hidden");
            setTimeout(function() {
                modal.classList.add("hidden");
            }, 3000);
        }
        function showSuccessModal() {
            var modal = document.getElementById("success_alert");
            modal.classList.remove("hidden");
            setTimeout(function() {
                modal.classList.add("hidden");
            }, 4000);
        }
        document.addEventListener("DOMContentLoaded", function() {

        });
    </script>
    @if (!empty(session('error')))
        @php echo '<script>
            showAlertModal();
        </script>'@endphp
    @endif
    @if (!empty(session('success')))
        @php echo '<script>
            showSuccessModal();
        </script>'@endphp
    @endif