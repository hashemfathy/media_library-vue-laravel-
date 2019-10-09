<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{URL::to('fonts/backend_fonts/css/font-awesome.css')}}" rel="stylesheet" />
  <style>
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
  </style>
</head>

<body>

  @include('layouts.partials._nav')

  <div class="container-fluid">
    <div class="row">
      @include('layouts.partials._sidebar')
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <div id="app" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
          @yield('content')
        </div>
      </main>
    </div>
  </div>

  @include('layouts.partials._footer')

  <script src="{{URL::to('js/app.js')}}"></script>
</body>

</html>