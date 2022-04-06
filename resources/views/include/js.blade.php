<script src="https://unpkg.com/feather-icons"></script>

<script>
    feather.replace()
</script>
<!-- core:js -->
<script src="{{ asset('public/js/app.js') }}"></script>
<!-- endinject -->
<!-- plugin js for this page -->
<script src="{{ asset('public/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>

<!-- plugin js for this page -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<!-- custom js for this page -->
<!-- choose one -->
<script type="text/javascript">
    $(document).ready(function() {
        var body = $('body');
        var mainWrapper = $('.main-wrapper');
        var footer = $('footer');
        var sidebar = $('.sidebar');
        var navbar = $('.navbar').not('.top-navbar');
        // Sidebar toggle to sidebar-folded
        $('.sidebar-toggler').on('click', function(e) {
            $(this).toggleClass('active');
            $(this).toggleClass('not-active');
            if (window.matchMedia('(min-width: 992px)').matches) {
                e.preventDefault();
                body.toggleClass('sidebar-folded');
            } else if (window.matchMedia('(max-width: 991px)').matches) {
                e.preventDefault();
                body.toggleClass('sidebar-open');
            }
        });
    });
    $(document).on('click', '.btn-modal', function(e) {
        e.preventDefault();
        var container = $(this).data('container');

        $.ajax({
            url: $(this).data('href'),
            dataType: 'html',
            success: function(result) {
                $(container)
                    .html(result)
                    .modal('show');
            },
        });
    });
</script>
<!-- plugin js for this page -->
@stack("js")
