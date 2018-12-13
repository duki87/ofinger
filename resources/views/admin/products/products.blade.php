@extends('layouts.admin')

@section('content')
<div class="container">
  <div id="page-wrapper">
      <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header">Производи</h1>
          </div>
          <!-- /.col-lg-12 -->
      </div>
      <!-- /.row -->
      <div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                  <div class="panel-heading">
                      Преглед свих производа на сајту
                  </div>
                  <!-- /.panel-heading -->
                  <div class="panel-body">
                    @if(Session::has('product_message'))
                    <input type="hidden" id="session_message" name="" value="{{ Session::get('product_message') }}">
                    @endif
                      <div class="" id="product_message"></div>
                      <table width="100%" class="table table-striped table-bordered table-hover" id="productsTable">
                          <thead>
                              <tr>
                                  <th style="width:10%;">Назив</th>
                                  <th style="width:10%">Категорија</th>
                                  <th style="width:10%">Произвођач</th>
                                  <th style="width:10%">Фотографија</th>
                                  <th style="width:10%">Статус</th>
                                  <th style="width:10%">УРЛ</th>
                                  <th style="width:10%">Варијанте</th>
                                  <th style="width:10%">Измени</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr class="odd gradeX">
                              </tr>
                          </tbody>
                      </table>
                      <!-- /.table-responsive -->
                      <div class="well">
                          <h4>DataTables Usage Information</h4>
                          <p>DataTables is a very flexible, advanced tables plugin for jQuery. In SB Admin, we are using a specialized version of DataTables built for Bootstrap 3. We have also customized the table headings to use Font Awesome icons in place of images. For complete documentation on DataTables, visit their website at <a target="_blank" href="https://datatables.net/">https://datatables.net/</a>.</p>
                          <a class="btn btn-default btn-lg btn-block" target="_blank" href="https://datatables.net/">View DataTables Documentation</a>
                      </div>
                  </div>
                  <!-- /.panel-body -->
              </div>
              <!-- /.panel -->
          </div>
          <!-- /.col-lg-12 -->
      </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  session_message();
  var get_data = true;
  var productsDataTable = $('#productsTable').DataTable({
    "processing"  : true,
    "responsive": true,
    "serverSide"  : true,
    "ajax"  : {
      url : "{{ route('admin.get-products-table') }}",
      type :  "POST",
      dataType: 'json',
      "data": { _token: "{{csrf_token()}}"}
    },
    "columns": [
      { data: 'name' },
      { data: 'category_id' },
      { data: 'brand_id' },
      { data: 'featured_image' },
      { data: 'status' },
      { data: 'url' },
      { data: 'id' },
      { data: 'active' }
    ],
    "columnDefs"  : [
      {
        "defaultContent": "-",
        "targets": "_all"
      },
      { "className": "text-center align-middle", "targets": [1,2,3,5] }
    ],
    "pageLength"  : 10
  });

  $(document).on('click', '.delete-product', function(e) {
    e.preventDefault();
    var product_id = $(this).attr('data-id');
    var delete_product = new FormData();
    delete_product.append('id', product_id);
    if(confirm('Да ли сте сигурни да желите да обришете овaј производ?')) {
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
         }
     });
      $.ajax({
         url: "remove-product",
         type: "POST",
         data: delete_product,
         contentType: false,
         cache: false,
         processData: false,
         success: function(result) {
           if(result.success == 'PRODUCT_DELETE') {
             $('#product_message').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Успешно сте обрисали производ <strong>'+result.name+'.</strong></div>');
             productsDataTable.ajax.reload();
           }
         }
       });
    } else {
      return false;
    }
  });

  function session_message() {
    var session_message = $('#session_message').val();
    if(session_message == '' || session_message == null) {
      return false;
    } else {
      $('#product_message').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> ' + session_message);
    }
  }
});
</script>

@endsection
