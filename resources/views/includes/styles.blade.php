<!-- General CSS Files -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('vendor/flag-icon/css/flag-icon.min.css') }}">

<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('vendor/jqvmap/css/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/summernote/css/summernote-bs4.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">

<!-- Template CSS -->
<link rel="stylesheet" href="{{ asset('vendor/dashboard/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/dashboard/css/components.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

<style>
    .toast {
        opacity: 1 !important;
    }
</style>

@stack('addon-style')
