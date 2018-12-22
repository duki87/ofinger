@extends('layouts.front')

@section('content')
<div class="col-md-12">
  <h3><img class="img-fluid" width="80" height="auto" src="{{ $brand_data['brand_logo'] }}" alt=""> <b>{{ $brand_data['brand_name'] }}</b> {{ $product->name }} </h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('index') }}">Почетна</a></li>
      <li class="breadcrumb-item"><a href="{{ route('front.category', $cat_data['cat_url']) }}">{{ $cat_data['cat_name'] }}</a></li>
      <li class="breadcrumb-item"><a href="{{ route('front.brand', $brand_data['brand_url']) }}">{{ $brand_data['brand_name'] }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-md-12">
    @foreach($photos as $photo)
      <img src="{{ $photo }}" style="cursor:pointer" class="img-preview img-fluid mt-2 d-inline" alt="" width="60em" height="auto">
    @endforeach
    </div>
    <div class="col-md-6">
      <img src="{{ $photos[0] }}" id="img-expand" alt="" class="img-fluid mx-auto d-block" alt="" width="60%" height="auto">
    </div>

    <div class="col-md-6">
      {{ $product->description }}
    </div>

    <div class="col-md-12">
      <h4>Доступне величине и боје</h4>
      <table class="table table-striped">
        <thead style="background-color:orange; color:white">
          <tr>
            <th scope="col" class="text-center align-middle">Величина</th>
            <th scope="col" class="text-center align-middle">Боја</th>
            <th scope="col" class="text-center align-middle">Поручи</th>
            <th scope="col" class="text-center align-middle"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($product->details as $detail)
          <tr>
            <td class="text-center align-middle">{{$detail->size}}</td>
            <td class="text-center align-middle">{{$detail->color}}</td>
            <td class="text-center align-middle order">
              <button type="button" class="btn btn-danger btn-sm removeItem d-inline" name="button"><i class="fas fa-minus"></i></button>
              <input type="text" min="1" name="" class="orderItems form-control d-inline" style="width:3em" value="" data-sku="{{$detail->id}}" onkeypress="return AllowNumbersOnly(event)">
              <button type="button" class="btn btn-success btn-sm addItem d-inline" name="button"><i class="fas fa-plus"></i></button>
            </td>
            <td>
              <button type="button" name="addToCart" class="addToCart btn btn-primary d-inline"><i class="fas fa-cart-plus"></i></button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

<script type="text/javascript">
  $(document).on('click', '.img-preview', function(e) {
    var src = $(this).attr('src');
    if($('.stroke').length >= 1) {
      $('.stroke').removeClass('border border-primary');
      $('.img-preview').removeClass('stroke');
    }
    $(this).addClass('stroke');
    $(this).addClass('border border-primary');
    $('#img-expand').attr('src', src);
  });

  function AllowNumbersOnly(e) {
    var code = (e.which) ? e.which : e.keyCode;
    if (code > 31 && (code < 48 || code > 57)) {
      e.preventDefault();
    }
  }

  $(document).on('click', '.addItem', function(e) {
    e.preventDefault();
    let quantity = parseInt($(this).closest('.order').find('.orderItems').val());
    $(this).closest('.order').find('.orderItems').val(quantity+1);
  });

  $(document).on('click', '.removeItem', function(e) {
    e.preventDefault();
    let quantity = $(this).closest('.order').find('.orderItems').val();
    if(quantity == '') {
      return false;
    } else if(parseInt(quantity) == 1) {
      $(this).closest('.order').find('.orderItems').val('');
      return false;
    } else {
      $(this).closest('.order').find('.orderItems').val(parseInt(quantity)-1);
    }
  });
</script>
@endsection
