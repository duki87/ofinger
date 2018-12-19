@extends('layouts.front')

@section('content')
  <div class="col-md-12">
    <h2>Производи из категорије <b>{{ $cat_name }}</b></h2>
  </div>
  <div class="row">
    @foreach($products as $product)
    <div class="col-md-6 mt-2">
      <div class="card">
        <img class="card-img-top" src="{{$product->img_path}}" alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title">{{$product->name}}</h5>
          <p class="card-text">{{$product->description}}</p>
          <p class="card-text">Други производи из категорије
            <a href=""></a>
          </p>
          <a type="button" href="{{ route('front.product', $product->url) }}" class="custom-card-btn p-2 d-inline" name="button">Сазнај више</a>
          <button type="" class="custom-card-btn2 p-2 d-inline" name="button">Сазнај више</button>
        </div>
      </div>
    </div>
    @endforeach
  </div>
@endsection
