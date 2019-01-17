@extends('layouts.front')
<?php
  $array = Session::get('cart');
  print_r($array); ?>
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
      <!-- Button trigger modal --> <br>
      <button type="button" class="btn btn-primary mt-2 d-inline" data-toggle="modal" data-target="#comments">
        Погледај коментаре за овај производ
      </button>
      @if(Session::has('user_id'))
      <button type="button" class="btn btn-info mt-2 d-inline" data-toggle="modal" data-target="#add_comment">
        Додај Коментар за производ
      </button>
      @endif

      <!-- comments Modal -->
      <div class="modal fade" id="comments" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Коментари за производ {{$product->name}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              @foreach($comments as $comment)
              <div class="media mt-2">
                <img class="mr-3" width="20%" src="{{asset('images/etc/user-image.png')}}" alt="Generic placeholder image">
                <div class="media-body">
                  <h5 class="mt-0">Корисник <b>{{$comment['user_name']}}</b></h5>
                  {{$comment['comment']}}
                </div>
              </div>
              @endforeach
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            </div>
          </div>
        </div>
      </div>

      <!-- add comment Modal -->
      <div class="modal fade" id="add_comment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form class="" id="comment_form" method="post">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Додај коментар за производ {{$product->name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <textarea id="comment" name="comment" rows="8" cols="80" class="form-control"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <input type="hidden" id="product_id_comment" name="product_id_comment" value="{{$product->id}}">
                <button type="submit" class="btn btn-success">Додај коментар</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
              </div>
            </form>
          </div>
        </div>
      </div>
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
          @foreach($details as $key => $array)
            <tr class="itemData" data-productId="{{ $product->id }}">
              <td class="text-center align-middle">{{$key}}</td>
              <td class="text-center align-middle">
                <select class="sizes form-control mx-auto" name="sizes" style="width:8em">
                  @foreach($array as $value)
                    <option value="{{$value['id']}}">{{$value['color']}}</option>
                  @endforeach
                </select>
              </td>
              <td class="text-center align-middle order">
                <button type="button" class="btn btn-danger btn-sm removeItem d-inline" name="button"><i class="fas fa-minus"></i></button>
                <input type="text" min="1" name="" class="orderItems form-control d-inline" style="width:3em" value="" data-sku="" onkeypress="return AllowNumbersOnly(event)">
                <button type="button" class="btn btn-success btn-sm addItem d-inline" name="button"><i class="fas fa-plus"></i></button>
              </td>
              <td>
                <button type="button" name="addToCart" title="Додај у корпу" class="addToCart btn btn-primary d-inline"><i class="fas fa-cart-plus"></i></button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

<script type="text/javascript">
  $(document).ready(function() {
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
      let quantity = $(this).closest('.order').find('.orderItems').val();
      if(quantity == '') {
        $(this).closest('.order').find('.orderItems').val(1);
      } else {
        $(this).closest('.order').find('.orderItems').val(parseInt(quantity)+1);
      }
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

    $(document).on('submit', '#comment_form', function(e) {
      e.preventDefault();
      let comment = $('#comment').val();
      let product_id = $('#product_id_comment').val();
      var comment_data = new FormData();
      comment_data.append('product_id', product_id);
      comment_data.append('comment', comment);
      if(comment == '') {
        $('#add_comment').modal('toggle');
        return false;
      } else {
        $.ajaxSetup({
           headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
           }
       });
        $.ajax({
           url: "add-comment",
           type: "POST",
           data: comment_data,
           contentType: false,
           cache: false,
           processData: false,
           success: function(result) {
             console.log(result.success);
             $('#add_comment').modal('toggle');
           }
         });
      }
    });

    // $(document).on('click', '.addToCart', function(e) {
    //   let sku_id = $(this).closest('.itemData').find('.sizes').val();
    //   let sku_qty = $(this).closest('.itemData').find('.orderItems').val();
    //   console.log(sku_id+'=>'+sku_qty);
    // });
  });
</script>
<script type="text/javascript" src="{{asset('frontend/js/cart.js')}}"></script>
@endsection
