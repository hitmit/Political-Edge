<script src="https://unpkg.com/feather-icons"></script>

<script>
    feather.replace()
</script>
<!-- core:js -->
<script src="{{ asset('js/app.js') }}"></script>
<!-- endinject -->
<!-- plugin js for this page -->
<script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>

<!-- plugin js for this page -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<!-- custom js for this page -->
<!-- choose one -->
    <script src="{{ asset('assets/js/template.js') }}"></script>
<!-- plugin js for this page -->
@stack("js")
