<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; Absensi</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/img/smk.png') }}" sizes="32x32">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/smk.png') }}">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

  <style>
  .form-control:focus {
    border-color: #028c9b !important;
  }
  body {
    font-family: 'Poppins', sans-serif;
    font-weight: 300;
    font-size: 14px;
  }
  .input-error {
    border-color: #dc3545 !important;
  }
  </style>
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-5">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4 style="font-size: 16px;">Login</h4>
                            </div>

                            @if (Session::has('success'))
                              <div class="alert alert-success alert-dismissible show fade ml-2 mr-2 alert-has-icon alert-sm" style="font-size: 11px;">
                                  <div class="alert-body">
                                      <button class="close" data-dismiss="alert">
                                          <span>×</span>
                                      </button>
                                      {{ Session::get('success') }}
                                  </div>
                              </div>
                            @endif

                            <div class="card-body">
                                <form method="POST" action="{{ route('postlogin') }}" enctype="multipart/form-data">
                                  @csrf
                                  <div class="form-group">
                                    <label for="email" style="font-size: 12px;">Email</label>
                                    <input id="email" type="email" class="form-control @error('email') input-error @enderror" name="email" placeholder="Email Address" required tabindex="1" value="{{ old('email') }}">
                                  </div>

                                  <div class="form-group">
                                      <label for="password" class="control-label" style="font-size: 12px;">Password</label>
                                      <input id="password" type="password" class="form-control @error('password') input-error @enderror" name="password" required tabindex="2">
                                  </div>

                                  <div class="form-group">
                                      <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="3">
                                          Login
                                      </button>
                                  </div>
                               </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{asset('assets/js/stisla.js')}}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js')}}"></script>
  <script src="{{ asset('assets/js/custom.js')}}"></script>

</body>
</html>
