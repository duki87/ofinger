@extends('layouts.front')

@section('content')
  <div class="col-md-12">
    <h2>Препоручујемо за вас</h2>
  </div>
  <div class="row">
    @foreach($products as $product)
    <div class="col-md-4">
      <div class="card" style="width: 18rem;">
        <img class="card-img-top" src="{{$product->img_path}}" alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title">{{$product->name}}</h5>
          <p class="card-text">{{$product->description}}</p>
          <p class="card-text">Други производи из категорије
            <a href="{{ route('front.category', $product->cat_url) }}">{{$product->cat_name}}</a>
          </p>
          <button type="" class="custom-card-btn p-2" name="button">Сазнај више</button>
        </div>
      </div>
    </div>
    @endforeach
  </div>
@endsection
