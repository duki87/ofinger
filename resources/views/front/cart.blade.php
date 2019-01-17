@extends('layouts.front')
<?php
  $array = Session::get('cart');
  print_r($array); ?>
@section('content')
<div class="col-md-12">
  <h3><i class="fas fa-shopping-cart"></i> <b>Ваша корпа</b></h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('index') }}">Почетна</a></li>
      <li class="breadcrumb-item active" aria-current="page">Корпа</li>
    </ol>
  </nav>

  <div class="row">

    <div class="col-md-12">
      <h4>Производи</h4>
      <table class="table table-striped ">
        <thead style="background-color:orange; color:white">
          <tr>
            <th scope="col" class="text-center align-middle">Назив</th>
            <th scope="col" class="text-center align-middle">Слика</th>
            <th scope="col" class="text-center align-middle">Количина</th>
            <th scope="col" class="text-center align-middle">Цена</th>
            <th scope="col" class="text-center align-middle">Избаци</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $product)
            <tr class="itemData" data-sku_id="{{ $product['sku_id'] }}" data-product_id="{{ $product['product_id'] }}">
              <td class="text-center align-middle">{{ $product['name'] }} {{ $product['sku'] }}</td>
              <td class="text-center align-middle">
                <img src="{{ asset('images/products/'.$product['image']) }}" width="50" height="auto" alt="">
              </td>
              <td class="text-center align-middle order">
                <button type="button" class="btn btn-danger btn-sm removeItem d-inline" name="button"><i class="fas fa-minus"></i></button>
                <input type="text" min="1" name="" class="orderItems form-control d-inline" style="width:3em" value="{{$product['quantity']}}" data-sku="" onkeypress="return AllowNumbersOnly(event)">
                <button type="button" class="btn btn-success btn-sm addItem d-inline" name="button"><i class="fas fa-plus"></i></button>
              </td>
              <td class="text-center align-middle price">{{ $product['price'] }}</td>
              <td class="text-center align-middle">
                <button type="button" name="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
              </td>
            </tr>
            <tr scope="col" class="text-center align-middle itemData">
              <td></td>
              <td></td>
              <td class=""><b>Цена x количина</b></td>
              <td>
                <b class="sub_total"><?=$product['price']*$product['quantity'];?></b>
              </td>
            </tr>
          @endforeach
          <tr scope="col" class="text-center align-middle">
            <td></td>
            <td></td>
            <td><b>Укупно</b></td>
            <td><b class="text-danger" id="total"></b></td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {

      total();

      function AllowNumbersOnly(e) {
        var code = (e.which) ? e.which : e.keyCode;
        if (code > 31 && (code < 48 || code > 57)) {
          e.preventDefault();
        }
      }

      $(document).on('click', '.addItem', function(e) {
        e.preventDefault();
        let product_id = $(this).closest('.order').parent().attr('data-product_id');
        let sku_id = $(this).closest('.order').parent().attr('data-sku_id');
        let quantity = $(this).closest('.order').find('.orderItems').val();
        let price = $(this).closest('.order').parent().find('.price').html();
        let sub_total = $(this).closest('.order').parent().next().find('.sub_total').html();
        let new_quantity = parseInt(quantity)+1;
        let new_sub_total = (parseFloat(price) + parseFloat(sub_total)).toFixed(2);
        let total = $('#total').html();
        let new_total = (parseFloat(total) - parseFloat(sub_total) + parseFloat(new_sub_total)).toFixed(2);
        if(quantity == '') {
          $(this).closest('.order').find('.orderItems').val(1);
        } else {
          $(this).closest('.order').find('.orderItems').val(new_quantity);
          $(this).closest('.order').parent().next().find('.sub_total').html(new_sub_total);
          $('#total').html(new_total);
          update_cart(product_id, sku_id, new_quantity);
        }
      });

      $(document).on('click', '.removeItem', function(e) {
        e.preventDefault();
        let product_id = $(this).closest('.order').parent().attr('data-product_id');
        let sku_id = $(this).closest('.order').parent().attr('data-sku_id');
        let quantity = $(this).closest('.order').find('.orderItems').val();
        let price = $(this).closest('.order').parent().find('.price').html();
        let sub_total = $(this).closest('.order').parent().next().find('.sub_total').html();
        let new_quantity = parseInt(quantity)-1;
        let new_sub_total = (parseFloat(sub_total) - parseFloat(price)).toFixed(2);
        let total = $('#total').html();
        let new_total = (parseFloat(total) - parseFloat(sub_total) + parseFloat(new_sub_total)).toFixed(2);
        if(quantity == '') {
          return false;
        } else if(parseInt(quantity) == 1) {
          $(this).closest('.order').find('.orderItems').val('');
          $(this).closest('.order').parent().next().remove();
          $(this).closest('.order').parent().remove();
          $('#total').html(new_total);
          update_cart(product_id, sku_id, new_quantity);
          return false;
        } else {
          $(this).closest('.order').find('.orderItems').val(parseInt(quantity)-1);
          $(this).closest('.order').find('.orderItems').val(new_quantity);
          $(this).closest('.order').parent().next().find('.sub_total').html(new_sub_total);
          $('#total').html(new_total);
          update_cart(product_id, sku_id, new_quantity);
        }
      });

      function total() {
        let total = 0;
        $(".sub_total").each(function() {
          total += parseFloat($(this).html());
        });
        $('#total').html(total);
      }

      function update_cart(product_id, sku_id, quantity) {
        // console.log(product_id);
        // console.log(sku_id);
        // console.log(quantity);
        let update_data = new FormData();
        update_data.append('product_id', product_id);
        update_data.append('sku_id', sku_id);
        update_data.append('quantity', quantity);
        $.ajaxSetup({
           headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
           }
       });
        $.ajax({
           url: "update-cart",
           type: "POST",
           data: update_data,
           contentType: false,
           cache: false,
           processData: false,
           success: function(result) {
             if(result.success == 'CART_UPDATE') {
               console.log(result.success);
             }
           }
         });
      }

    });
  </script>
  <script type="text/javascript" src="{{asset('frontend/js/cart.js')}}"></script>
@endsection
