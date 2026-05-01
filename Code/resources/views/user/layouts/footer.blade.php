<footer class="dashboard-card dashboard-footer">
    <span>&copy; 2026 XyberaBoost. All Rights Reserved.</span>
</footer>

<script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>
<script src="{{ asset('backend/vendor/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('backend/js/demo/chart-pie-demo.js') }}"></script>

@stack('scripts')

<script>
    setTimeout(function() {
        $('.alert').slideUp();
    }, 4000);
</script>
