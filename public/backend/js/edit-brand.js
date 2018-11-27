$(document).ready(function() {
  var err = false;
  //get_parent_categories();
  get_brand_data();

  function get_brand_data() {
    var brand_id = $('#brand_id').val();
    var form_data = new FormData();
    form_data.append('id', brand_id);
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       }
   });
    $.ajax({
       url: "get-brand-data",
       type: "POST",
       data: form_data,
       dataType: 'json',
       contentType: false,
       cache: false,
       processData: false,
       success: function(result) {
         $('#name').val(result.name);
         $('#description').html(result.description);
         $('#url').val(result.url);
         $('#preview_image').attr('src', result.full_img_path);
         $('#remove_image').attr('data-path', result.image);
       }
     });
  }

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

  $(document).on('change', '#image', function(event) {
    event.preventDefault();
    var property = document.getElementById('image').files[0];
    var image_name = property.name;
    var image_extension = image_name.split('.').pop().toLowerCase();
    if(jQuery.inArray(image_extension, ["jpg","jpeg","png","gif"]) == -1) {
      error_images += 'Дозвољени формати фотографија су: gif, jpg, jpeg, png!';
      return false;
    }
    var image_size = property.size;
    if(image_size > 5000000) {
      error_images += 'Максимална величина фотографије је 5 MB!';
      return false;
    } else {
      var form_data = new FormData();
      var old_img = $('#remove_image').attr('data-path');
      if(old_img !== '') {
        remove_image(old_img);
      }
      form_data.append('image', property);
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
         }
     });
      $.ajax({
         url: "preview-brand-img",
         type: "POST",
         data: form_data,
         dataType: 'json',
         contentType: false,
         cache: false,
         processData: false,
         success: function(result) {
           var remove = '<button class="btn btn-danger btn-xs remove_image" id="remove_image" data-path="'+ result.image_src+'" style="position:absolute; right:20px; top:6px">x</button>';
           $('#image_preview').html('<img src="http://localhost/ofinger/public/images/brands/'+ result.image_src+'" class="" id="preview_image" alt="" style="position:relative;border:1px solid green; width:100%; height:auto">');
           $('#image_preview').append(remove);
           console.log(result.image_src);
         }
       });
    }
  });

$(document).on('click', '.remove_image', function(event) {
  event.preventDefault();
  var path = $(this).attr('data-path');
  remove_image(path);
});

function remove_image(path_to_img) {
  var form_data = new FormData();
  form_data.append('path', path_to_img);
  $.ajaxSetup({
     headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
     }
 });
  $.ajax({
     url: "remove-brand-img",
     type: "POST",
     data: form_data,
     contentType: false,
     cache: false,
     processData: false,
     success: function(result) {
       console.log(result.message);
       $('#image_preview').html('');
       $('#image').val('');
     }
   });
}

$(document).on('submit', '#edit-brand', function(e) {
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
     var brand_id = $('#brand_id').val();
     var brand_data = new FormData();
     brand_data.append('id', brand_id);
     brand_data.append('name', name);
     brand_data.append('description', description);
     brand_data.append('image', image);
     brand_data.append('url', url);
     brand_data.append('active', active);
      $.ajax({
         url: "update-brand",
         type: "POST",
         data: brand_data,
         contentType: false,
         cache: false,
         processData: false,
         success: function(result) {
           //var url = 'http://localhost/admin/public/admin/';
           window.location = result.public_path;
         }
       });
    }
  });

  $(document).on('change', '.isActive', function(e) {
    e.preventDefault();
    var isActive = $(this).is(":checked");
    if(isActive) {
      $('#isActive').html('Активaн произвођач');
    } else {
      $('#isActive').html('Heaктивaн произвођач');
    }
  });

});
