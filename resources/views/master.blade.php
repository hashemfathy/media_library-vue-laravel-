<!DOCTYPE html>
<html lang="en">
<head>
<title>Code95 MediaLibrary</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="{{URL::to('css/backend_css/bootstrap.min.css')}}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{URL::to('css/backend_css/bootstrap-responsive.min.css')}}" />
<link rel="stylesheet" href="{{URL::to('css/backend_css/matrix-style.css')}}" />
<link rel="stylesheet" href="{{URL::to('css/backend_css/matrix-media.css')}}" />
<link href="{{URL::to('fonts/backend_fonts/css/font-awesome.css')}}" rel="stylesheet" />
</head>
<body>

<!--Header-part-->
<div id="header" style="margin-top:0px;">
</div>
<!--close-Header-part--> 


<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
</div>

</div>
<!--sidebar-menu-->
<div id="app" style="min-height:600px;">
    <Myside></Myside>
    <div class="container">
      <!--main-container-part-->
      @yield('content')
      <!--end-main-container-part-->
    </div>
</div>

<!--Footer-part-->

<div class="row-fluid">
  <div id="footer" class="span12"> 2019 &copy; Code95 School. made by <a href="http://code95.com">Code95</a> </div>
</div>

<!--end-Footer-part-->
<script src="{{URL::to('js/app.js')}}"></script>

</body>
</html>
