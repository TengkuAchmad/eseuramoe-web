<!-- General JS Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="{{ asset('vendor/dashboard/js/stisla.js') }}"></script>

<!-- JS Libraies -->
<script src="{{ asset('js/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('js/chart.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('vendor/summernote/js/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('vendor/chocolat/js/chocolat.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('vendor/dashboard/js/scripts.js') }}"></script>
<script src="{{ asset('vendor/dashboard/js/custom.js') }}"></script>

<!-- Page Specific JS File -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('js/custom.js') }}"></script>

<script>
    // @if(Session::has('message'))
    //     toastr.options =
    //     {
    //         "closeButton" : true,
    //         "progressBar" : true
    //     }
    //     toastr.success("{{ session('message') }}");
    // @endif

    // @if(Session::has('error'))
    //     toastr.options =
    //     {
    //         "closeButton" : true,
    //         "progressBar" : true
    //     }
    //     toastr.error("{{ session('error') }}");
    // @endif

    // @if(Session::has('info'))
    //     toastr.options =
    //     {
    //         "closeButton" : true,
    //         "progressBar" : true
    //     }
    //     toastr.info("{{ session('info') }}");
    // @endif

    // @if(Session::has('warning'))
    //     toastr.options =
    //     {
    //         "closeButton" : true,
    //         "progressBar" : true
    //     }
    //     toastr.warning("{{ session('warning') }}");
    // @endif
</script>

@stack('addon-script')
