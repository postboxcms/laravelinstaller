<!DOCTYPE html>
<html lang="en">

<head>
  <base href="{{env('APP_URL')}}" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{env('APP_NAME','Laravel')}} by Digitalbit</title>

  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
  <!-- Custom styles for this template-->
  <link href="{{asset('vendor/postboxcms/laravelinstaller/css/base.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/postboxcms/laravelinstaller/css/package.css')}}" rel="stylesheet">


</head>

<body class="bg-gradient-white">
  <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
    <!-- <i class="fas fa-laugh-wink"></i> -->
    <div class="container justify-content-center">
      <a class="navbar-brand" href="#">{{env('APP_NAME','Laravel')}}</a>
    </div>
  </nav>

  <div class="container" id="box">
    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-8 col-lg-12 col-md-8">
        <form action="{{$formUrl}}" method="POST" class="">
            @csrf
            <div class="card o-hidden border-0 shadow-lg my-3">
            <div class="card-body p-0">
                <div class="row">
                <div class="col-lg-12">
                    <div class="p-4">
                        <div class="text-left">
                        <h1 class="h5 text-gray-900 mb-3 title">
                            {{$title}}
                        </h1>
                        </div>
                        <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0"
                        aria-valuemin="0" aria-valuemax="100" style="width:{{$progress}}%">
                            <span class="sr-only">70% Complete</span>
                        </div>
                        </div>
                        @yield('content')
                    </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    @if(isset($prevUrl))
                        <a href="{{$prevUrl}}" class="btn-primary btn"><i class="fas fa-arrow-left"></i> Go back to the previous step</a>
                    @endif
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 text-right">
                        <button type="submit" class="btn-primary btn btn-submit" {{$btnState}}>Proceed to the next step <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
            </div>
        </form>
      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js" integrity="sha512-8qmis31OQi6hIRgvkht0s6mCOittjMa9GMqtK9hes5iEQBQE/Ca6yGE5FsW36vyipGoWQswBj/QBm2JR086Rkw==" crossorigin="anonymous"></script>
  @yield('scripts')
</body>
</html>
