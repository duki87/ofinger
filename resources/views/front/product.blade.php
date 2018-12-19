@extends('layouts.front')

@section('content')
<div class="col-md-12">
  <h3><img class="img-fluid" width="80" height="auto" src="{{ $brand_logo }}" alt=""> <b>{{ $brand_name }}</b> {{ $product->name }} </h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('index') }}">Почетна</a></li>
      <li class="breadcrumb-item active">Производи</li>
      <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
    </ol>
  </nav>

  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="d-block w-20" src="{{ $photos[0] }}" alt="First slide">
      </div>
      <?php
        $count = count($photos);
        for($i=1; $i<$count; $i++) {
      ?>
      <div class="carousel-item">
        <img class="d-block w-20" src="<?=$photos[$i];?>" alt="First slide">
      </div>
      <?php } ?>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
@endsection
