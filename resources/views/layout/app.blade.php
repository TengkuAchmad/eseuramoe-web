<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dashboard &mdash; {{ env('APP_NAME') }}</title>

  @include('includes.styles')
  <style>
    /* Full-page loading overlay */
    .navbar-right .dropdown-menu {
        right: 0;
        left: auto;
        min-width: 200px;
        margin-top: 10px;
        border-radius: 3px;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
    }

    .dropdown-menu .dropdown-item {
        padding: 10px 20px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .dropdown-menu .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .dropdown-menu .dropdown-item i {
        margin-right: 10px;
        font-size: 16px;
    }

    .dropdown-divider {
        margin: 5px 0;
    }

    .nav-link-user {
        padding: 0 15px;
        display: flex;
        align-items: center;
    }


  </style>
</head>

<body>

  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      @include('includes.navbar')
      @include('includes.sidebar')

      <!-- Main Content -->
      <div class="main-content">
        @yield('content')
      </div>

      @include('includes.footer')
    </div>
  </div>

  @include('includes.scripts')
  <script>
    $(document).ready(function () {
  // Simulate a delay (e.g., for loading data)
//   setTimeout(function () {
//     // Hide the loading overlay
//     $('#loading-overlay').fadeOut('slow', function () {
//       // Show the main content after the overlay is hidden
//       $('#content').fadeIn('slow');
//     });
//   }, 3000); // Adjust delay as needed (e.g., 3000ms = 3 seconds)
});
  </script>
</body>
</html>
