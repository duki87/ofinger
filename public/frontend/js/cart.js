$(document).ready(function() {

  $(document).on('click', '.addToCart', function(e) {
    e.preventDefault();
    let sku_id = $(this).closest('.itemData').find('.sizes').val();
    let sku_qty = $(this).closest('.itemData').find('.orderItems').val();
    let product_id = $(this).closest('.itemData').attr('data-productId');
    //console.log(product_id);
    var item_data = new FormData();
    item_data.append('sku_id', sku_id);
    item_data.append('sku_qty', sku_qty);
    item_data.append('product_id', product_id);

    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       }
   });
    $.ajax({
       url: "add-to-cart",
       type: "POST",
       data: item_data,
       contentType: false,
       cache: false,
       processData: false,
       success: function(result) {
         if(result.cart_menu !== '') {
           $('#cart_menu').html(result.cart_menu);
           console.log()result.success;
         }
         // if(result.success == 'BRAND_ADD') {
         //   $('#image_preview').html('');
         //   document.getElementById("add-brand").reset();
         //   $('#brand_message').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Успешно сте додали произвођача <strong>'+name+'.</strong></div>');
         // }
       }
     });
  });
});
