<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <meta name="_token" content="{{ csrf_token() }}"> -->

    <title>Офингер | ДОБРОДОШЛИ</title>
    <link rel="icon" href="{{asset('backend/logo.jpg')}}" type="image/x-icon">
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

    <!-- MetisMenu CSS -->
    <link href="{{asset('backend/metisMenu/metisMenu.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('frontend/css/navbar.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/card.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/accordion.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/slider.css')}}" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="{{asset('backend/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{asset('backend/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{asset('backend/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('backend/css/custom.css')}}" rel="stylesheet">
    <script src="{{asset('backend/jquery/jquery.min.js')}}"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
  <header class="custom-header">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner custom-carousel-inner">
        <div class="carousel-item active custom-carousel-item">
          <img class="d-block w-100 custom-carousel-img" src="{{asset('images/carousel/1.jpg')}}" alt="First slide">
        </div>
        <div class="carousel-item custom-carousel-item">
          <img class="d-block w-100 custom-carousel-img" src="{{asset('images/carousel/2.jpg')}}" alt="Second slide">
        </div>
        <div class="carousel-item custom-carousel-item">
          <img class="d-block w-100 custom-carousel-img" src="{{asset('images/carousel/3.jpg')}}" alt="Third slide">
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
      <!-- <a class="navbar-brand" href="#">Navbar</a> -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav custom-navbar-nav mx-auto">
          <li class="custom-nav-item-active ml-2">
            <a class="custom-nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="custom-nav-item ml-2">
            <a class="custom-nav-link" href="#">Features</a>
          </li>
          <li class="custom-nav-item ml-2">
            <a class="custom-nav-link" href="#">Pricing</a>
          </li>
          <li class="custom-nav-item ml-2">
            <a class="custom-nav-link" href="#">Disabled</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <div class="container mt-2">
    <div class="row" style="width:100%">
      <div class="col-md-3" id="left-menu">
        @include('parts.left-menu')
      </div>
      <div class="col-md-9" id="main-content">
        @yield('content')
      </div>
    </div>
  </div>

    <!-- jQuery -->
    <script src="{{asset('backend/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{asset('backend/metisMenu/metisMenu.min.js')}}"></script>

    <!-- Morris Charts JavaScript -->
    <script src="{{asset('backend/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('backend/morrisjs/morris.min.js')}}"></script>
    <script src="{{asset('backend/data/morris-data.js')}}"></script>
    <!-- DataTables JavaScript -->
    <script src="{{asset('backend/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/datatables-plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('backend/datatables-responsive/dataTables.responsive.js')}}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{asset('backend/dist/js/sb-admin-2.js')}}"></script>

</body>

</html>
