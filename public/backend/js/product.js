$(document).ready(function() {
    var err = false;
    get_parent_categories();
    get_brands();

  function get_parent_categories() {
    var get_parent_categories = true;
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       }
   });
    $.ajax({
       url: "get-parent-categories",
       type: "GET",
       data: get_parent_categories,
       dataType: 'json',
       success: function(result) {
         $('#parent_id').append(result.categories);
       }
     });
  }

  function get_brands() {
    var get_parent_categories = true;
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       }
   });
    $.ajax({
       url: "get-brands-list",
       type: "GET",
       data: get_parent_categories,
       dataType: 'json',
       success: function(result) {
         $('#brand_id').append(result.brand_data);
       }
     });
  }

  $(document).on('change', '#parent_id', function(e) {
    e.preventDefault();
    var parent_id = $(this).val();
    if(parent_id == '') {
      var empty_parent_id = '<option value="">Изаберите подкатегорију (прво морате главу категорију)</option>';
      $('#child_id').html(empty_parent_id);
    } else {
      var form_data = new FormData();
      form_data.append('parent_id', parent_id);
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
         }
     });
      $.ajax({
         url: "get-child-categories",
         type: "POST",
         data: form_data,
         dataType: 'json',
         contentType: false,
         cache: false,
         processData: false,
         success: function(result) {
           $('#child_id').html(result.categories);
         }
       });
    }

  });

  $(document).on('focus', '.errClass', function(e) {
    e.preventDefault();
    var field = $(this).attr('id');
    $(this).removeClass('border-danger');
    $('#'+field+'_err').addClass('hidden');
    err = false;
  });

  $(document).on('blur', '.errClass', function(e) {
    e.preventDefault();
    var field = $(this).attr('id');
    if($(this).val() == '') {
      err = true;
      $(this).addClass('border-danger');
      $('#'+field+'_err').removeClass('hidden');
    } else {
      $(this).removeClass('errClass');
      err = false;
    }
  });

  $(document).on('blur', '#parent_id', function(e) {
    e.preventDefault();
    if($(this).val() !== '') {
      $(this).removeClass('border-danger');
      $('#parent_id_err').addClass('hidden');
    }
  });

  $(document).on('click', '#addProductAlt', function(event) {
    event.preventDefault();
    var productAlts = $('#productAlternates').children('.productAlt').last();
    var productAltNum = parseInt(productAlts.attr('data-productAlt')) + 1;
    var newProductAlt = '<div class="productAlt" id="" data-productAlt="'+productAltNum+'">'+
            '<h4 class="col-sm-12 text-info">Варијанта <span class="productAltNumText">'+productAltNum+' </span><span><a href="#" class="btn btn-danger btn-xs deleteProdAlt" data-deleteAlt="'+productAltNum+'"><i class="fa fa-minus" aria-hidden="true"></i></a></span></h4>'+
            '<div class="">'+
              '<label for="url" class="col-sm-2 control-label">Универзални код</label>'+
              '<div class="col-sm-4">'+
                '<input type="text" class="form-control isEmpty sku" name="sku[]" id="" data-sku="'+productAltNum+'" placeholder="Универзални код">'+
                '<small class="text-danger errText hidden" id="sku_err">Урл је обавезан!</small>'+
              '</div>'+
            '</div>'+
            '<div class="">'+
              '<label for="size" class="col-sm-2 control-label">Величина</label>'+
              '<div class="col-sm-4" >'+
                '<select class="form-control isEmpty size" name="size[]" id="" data-size="'+productAltNum+'">'+
                  '<option value="">Изаберите</option>'+
                  '<option value="XS">XS</option>'+
                  '<option value="S">S</option>'+
                  '<option value="M">M</option>'+
                  '<option value="L">L</option>'+
                  '<option value="XL">XL</option>'+
                  '<option value="XXL">XXL</option>'+
                '</select>'+
                '<small class="text-danger errText hidden" id="size_err">Ово поље је обавезно!</small>'+
              '</div>'+
            '</div>'+
            '<div class="">'+
              '<label for="color" class="col-sm-2 control-label">Боја</label>'+
              '<div class="col-sm-4">'+
                '<select class="form-control isEmpty color" name="color[]" id="" data-color="'+productAltNum+'">'+
                  '<option value="">Изаберите</option>'+
                  '<option value="црвена">црвена</option>'+
                  '<option value="зелена">зелена</option>'+
                  '<option value="плава">плава</option>'+
                  '<option value="бела">бела</option>'+
                  '<option value="црна">црна</option>'+
                  '<option value="сива">сива</option>'+
                  '<option value="љубичаста">љубичаста</option>'+
                  '<option value="жута">жута</option>'+
                  '<option value="наранџаста">наранџаста</option>'+
                  '<option value="крем">крем</option>'+
                  '<option value="комбинација боја">комбинација боја</option>'+
                '</select>'+
                '<small class="text-danger errText hidden" id="color_err">Ово поље је обавезно!</small>'+
              '</div>'+
            '</div>'+
            '<div class="">'+
              '<label for="stock" class="col-sm-2 control-label">Количина у складишту</label>'+
              '<div class="col-sm-4">'+
                '<input type="text" class="form-control isEmpty stock" name="stock[]" id="" data-stock="'+productAltNum+'" placeholder="Унесите број комада" onkeypress="return AllowNumbersOnly(event)">'+
                '<small class="text-danger errText hidden" id="stock_err">Ово поље је обавезно!</small>'+
              '</div>'+
            '</div>'+
          '</div>';
      $('#productAlternates').append(newProductAlt);
  });

  $(document).on('click', '.deleteProdAlt', function(event) {
    event.preventDefault();
    var deleteAlt = $(this).attr('data-deleteAlt');
    var productAltToDelete = $(".productAlt[data-productAlt='" + deleteAlt +"']");
    productAltToDelete.remove();
    reorderProdAlts();
  });

  function reorderProdAlts() {
    var productAlts = $('.productAlt');
    var productSku = $('.sku');
    var productSize = $('.size');
    var productColor = $('.color');
    var productStock = $('.stock');
    var deleteProdAlts = $('.deleteProdAlt');
    var alt = 2;
    for(let i=1; i<=productAlts.length; i++) {
      $('.productAltNumText').eq(i).text(' ' + alt + ' ');
      productAlts.eq(i).attr('data-productAlt', alt);
      productSku.eq(i).attr('data-sku', alt);
      productSize.eq(i).attr('data-size', alt);
      productColor.eq(i).attr('data-color', alt);
      productStock.eq(i).attr('data-stock', alt); //eq(i).
      deleteProdAlts.eq(i).attr('data-deleteAlt', alt);
      alt++;
    }
  }

  $(document).on('change', '#images', function(event) {
    event.preventDefault();
    if($('.productImage').length > 0) {
      var folder_name = $('#productImages').attr('data-folderName');
      var next_img = parseInt($('.productImage').last().attr('id')) + 1;
      add_more_images(folder_name, next_img);
    } else {
      var error_images = '';
      var property = $('#images')[0].files;
      var form_data = new FormData();
      for(var i=0; i<property.length; i++) {
        var name = document.getElementById('images').files[i].name;
        var ext = name.split('.').pop().toLowerCase();
        var allowed = ['gif', 'jpg', 'jpeg', 'png'];
        if(jQuery.inArray(ext, allowed) == -1) {
          error_images += 'Унели сте фајл који има недозвољену екстензију!';
        }
        var image_size = document.getElementById('images').files[i].size;
        if(image_size > 5242880) {
          error_images += 'Величина фотографија не сме бити већа од 5 MB!';
        }
        form_data.append('images[]', document.getElementById('images').files[i]);
      }
      if(error_images == '') {
        var images = '';
        $.ajaxSetup({
           headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
           }
       });
        $.ajax({
          url: "preview-product-img",
          type: "POST",
          data: form_data,
          dataType: 'json',
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            $('#error_images').html('<span class="text-primary">Учитавање фотографија...</span>');
          },
          success: function(result) {
            var remove_button = '<button type="button" class="btn btn-danger" id="removeImages" data-removeImages="'+result.folder_name+'">Обришите све фотографије</button>';
            images += '<div class="" id="productImages" data-folderName="'+result.folder_name+'">';
            for(let [index, image] of (result.images).entries()) {
              let last = index+1;
              images += '<div class="col-sm-2 productImage" data-image="'+image+'" style="position:relative" id="'+last+'">';
              images += '<img src="'+result.path+image+'" class="form-control" style="width:100%; height:auto" alt="">';
              images += '<button class="btn btn-danger btn-xs deleteImage" style="position:absolute;top:4px;right:20px" data-unlink="'+image+'">&times;</button>';
              images += '</div>';
            }
            images += '</div>';
            $('#images_folder').val(result.folder_name);
            $('#images_preview').append(images);
            $('#error_images').html('<span class="text-success">Фотографијe су учитане!</span>');
            $('#images').val('');
            $('#images_preview').after('<div class="form-group" id="removeButtonDiv"><div class="col-sm-offset-2 col-sm-10">'+remove_button+'</div>');
          }
        });
      } else {
        $('#images').val('');
        $('#error_images').html('<span class="text-danger">'+error_images+'</span>');
        return false;
      }
    }
  });

  function add_more_images(folder, next) {
    var img_data = new FormData();
    img_data.append('folder_name', folder);
    img_data.append('next_image', next);
    var error_images = '';
    var property = $('#images')[0].files;
    for(var i=0; i<property.length; i++) {
      var name = document.getElementById('images').files[i].name;
      var ext = name.split('.').pop().toLowerCase();
      var allowed = ['gif', 'jpg', 'jpeg', 'png'];
      if(jQuery.inArray(ext, allowed) == -1) {
        error_images += 'Унели сте фајл који има недозвољену екстензију!';
      }
      var image_size = document.getElementById('images').files[i].size;
      if(image_size > 5242880) {
        error_images += 'Величина фотографија не сме бити већа од 5 MB!';
      }
      img_data.append('images[]', document.getElementById('images').files[i]);
    }
    if(error_images == '') {
        $.ajaxSetup({
           headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
           }
       });
      $.ajax({
         url: "preview-product-img",
         type: "POST",
         data: img_data,
         contentType: false,
         cache: false,
         processData: false,
         success: function(result) {
           var images = '';
           for(let image of result.images) {
             images += '<div class="col-sm-2 productImage" data-image="'+image+'" style="position:relative" id="'+next+'">';
             images += '<img src="'+result.path+image+'" class="form-control" style="width:100%; height:auto" alt="">';
             images += '<button class="btn btn-danger btn-xs deleteImage" style="position:absolute;top:4px;right:20px" data-unlink="'+image+'">&times;</button>';
             images += '</div>';
             next++;
           }
           $('#productImages').append(images);
           $('#error_images').html('<span class="text-success">Додато је још фотографија!</span>');
           $('#images').val('');
         }
       });
     } else {
       $('#images').val('');
       $('#error_images').html('<span class="text-danger">'+error_images+'</span>');
       return false;
     }
  }

  $(document).on('click', '.deleteImage', function(event) {
    event.preventDefault();
    var imageToDelete = $(this).attr('data-unlink');
    var imageFolder = $(this).parent().parent().attr('data-folderName');
    var form_data = new FormData();
    form_data.append('image', imageToDelete);
    form_data.append('folder', imageFolder);
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       }
   });
    $.ajax({
       url: "remove-product-img",
       type: "POST",
       data: form_data,
       contentType: false,
       cache: false,
       processData: false,
       success: function(result) {
         $(".productImage[data-image='" + imageToDelete +"']").remove();
         if($('.productImage').length < 1) {
           delete_folder($('#productImages').attr('data-folderName'));
         }
         console.log($('.productImage').length);
         $('#error_images').html('<span class="text-danger">Фотографија је обрисана!</span>');
       }
     });
  });

  $(document).on('click', '#removeImages', function(event) {
    event.preventDefault();
    if(confirm('Да ли сте сигурни да желите да обришете све фотографије које сте учитали?')) {
      delete_folder($(this).attr('data-removeImages'));
    } else {
      return false;
    }
  });

  function delete_folder(folderName) {
    var folder = folderName;
    var folder_data = new FormData();
    folder_data.append('folder', folder);
     $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       }
     });
     $.ajax({
      url: "remove-folder-img",
      type: "POST",
      data: folder_data,
      contentType: false,
      cache: false,
      processData: false,
      success: function(result) {
        if(result.success == 'FOLDER_DELETE') {
          $('#images_preview').html('');
          $('#removeButtonDiv').remove();
          $('#error_images').html('<span class="text-danger">Све фотографије које сте унели су обрисане!</span>');
        }
      }
    });
  }

  $(document).on('click', '.productImage', function(event) {
    event.preventDefault();
    // $('#productImages .productImage').removeClass('.featured-image');
    if($(this).hasClass('featured-image')) {
      $(this).removeClass('featured-image');
      $('#error_featured_image').removeClass('hidden');
      err = true;
    } else {
      if($('.featured-image').length >= 1) {
        $('.productImage').removeClass('featured-image');
        $(this).addClass('featured-image');
        $('#featured_photo').val($(this).attr('data-image'));
        $('#error_featured_image').addClass('hidden');
        err = false;
        if($('#error_featured_image').hasClass('hidden')) {
          return false;
        } else {
          $('#error_featured_image').addClass('hidden');
          err = false;
        }
      } else {
        $(this).addClass('featured-image');
        $('#featured_photo').val($(this).attr('data-image'));
        $('#error_featured_image').addClass('hidden');
        err = false;
      }
    }
  });

  $(document).on('submit', '#add-product', function(event) {
    event.preventDefault();

    if($('.featured-image').length < 1) {
      $('#error_featured_image').removeClass('hidden');
      err = true;
    }

    if($('.productImage').length < 1) {
      $('#image_err').removeClass('hidden');
    } else {
      $('#image_err').addClass('hidden');
    }

    var fields = $('.isEmpty');
    var errText = $('.errText');
    for(let i=0; i<fields.length; i++) {
      if(fields.eq(i).val()  == '') {
        err = true;
        fields.eq(i).addClass('border-danger');
        fields.eq(i).addClass('errClass');
        errText.eq(i).removeClass('hidden');
      }
    }

    if(err) {
      return false;
    }
    else {
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
         }
     });
     var product_data = new FormData();
     var category_id = $('#child_id').val();
     var brand_id = $('#brand_id').val();
     var name = $('#name').val();
     var description = $('#description').val();
     var price = $('#price').val();
     var price_discount = $('#price_discount').val();
     if(price_discount == '') {
       price_discount = '0.0';
     }
     var featured_image = $('#featured_photo').val();
     var folder_name = $('#productImages').attr('data-foldername');
     var url = $('#url').val();
     var isActive = $('#active').is(":checked");
     var active = new Boolean();
     if(isActive == true) {
       active = 1;
     } else {
       active = 0;
     }

     var alts = {};
     var sku = $('.sku');
     var color = $('.color');
     var size = $('.size');
     var stock = $('.stock');

     for(let i=0; i<sku.length; i++) {
       alts[i] = {
         sku: sku.eq(i).val(),
         stock: stock.eq(i).val(),
         color: color.eq(i).val(),
         size: size.eq(i).val()
       }
     }
     var product_details = JSON.stringify(alts);

     product_data.append('name', name);
     product_data.append('category_id', category_id);
     product_data.append('brand_id', brand_id);
     product_data.append('description', description);
     product_data.append('price', price);
     product_data.append('price_discount', price_discount);
     product_data.append('featured_image', featured_image);
     product_data.append('folder_name', folder_name);
     product_data.append('url', url);
     product_data.append('active', active);
     product_data.append('product_details', product_details);
     console.log(product_data);
      $.ajax({
         url: "create-product",
         type: "POST",
         data: product_data,
         contentType: false,
         cache: false,
         processData: false,
         success: function(result) {
           if(result.success == 'PRODUCT_ADD') {
             $('#images_preview').html('');
             document.getElementById("add-product").reset();
             $('#product_message').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Успешно сте додали производ <strong>'+name+'.</strong></div>');
           }
         }
       });
    }
  });

$(document).on('submit', '#edit-category', function(e) {
  e.preventDefault();

    var name = $('#name').val();
    var description = $('#description').val();
    var image = $('#remove_image').attr('data-path');
    var url = $('#url').val();
    var isActive = $('#active').is(":checked");
    var active = new Boolean();
    if(isActive == true) {
      active = 1;
    } else {
      active = 0;
    }

    var isMain = $('#isMain').is(":checked");
    if(isMain === false) {
      var parent_id = $('#parent_id').val();
      if(parent_id == '') {
        $('#parent_id').addClass('border-danger');
        $('#parent_id').addClass('errClass');
        $('#parent_id_err').removeClass('hidden');
      }
    } else {
      var parent_id = 0;
    }

    var fields = $('.isEmpty');
    var errText = $('.errText');
    for(let i=0; i<fields.length; i++) {
      if(fields.eq(i).val()  == '') {
        err = true;
        fields.eq(i).addClass('border-danger');
        fields.eq(i).addClass('errClass');
        errText.eq(i).removeClass('hidden');
      }
    }

    if($('#preview_image').length > 0) {
      err = false;
      $('#image').removeClass('border-danger');
      $('#image').removeClass('errClass');
      $('#image_err').addClass('hidden');
    }

    if(err) {
      return false;
    } else {
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
         }
     });
     var category_data = new FormData();
     category_data.append('name', name);
     category_data.append('parent_id', parent_id);
     category_data.append('description', description);
     category_data.append('image', image);
     category_data.append('url', url);
     category_data.append('active', active);
      $.ajax({
         url: "create-category",
         type: "POST",
         data: category_data,
         contentType: false,
         cache: false,
         processData: false,
         success: function(result) {
           //console.log(result.success);
           if(result.success == 'CATEGORY_ADD') {
             $('#image_preview').html('');
             document.getElementById("add-category").reset();
             $('#category_message').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Успешно сте додали категорију <strong>'+name+'.</strong></div>');
           }
         }
       });
    }
  });

});
