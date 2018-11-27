@extends('layouts.admin')

@section('content')
<div class="container">
  <div id="page-wrapper">
      <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header">Категорије</h1>
          </div>
          <!-- /.col-lg-12 -->
      </div>
      <!-- /.row -->
      <div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                  <div class="panel-heading">
                      Преглед свих категорија на сајту
                  </div>
                  <!-- /.panel-heading -->
                  <div class="panel-body">
                    @if(Session::has('category_message'))
                    <input type="hidden" id="session_message" name="" value="{{ Session::get('category_message') }}">
                    @endif
                      <div class="" id="category_message"></div>
                      <table width="100%" class="table table-striped table-bordered table-hover" id="categoriesTable">
                          <thead>
                              <tr>
                                  <th style="width:20%;">Назив</th>
                                  <th style="width:25%">Хијерархија</th>
                                  <th style="width:20%">Фотографија</th>
                                  <th style="width:15%">Статус</th>
                                  <th style="width:5%">УРЛ</th>
                                  <th style="width:15%">Измени</th>
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
  var categoriesDataTable = $('#categoriesTable').DataTable({
    "processing"  : true,
    "responsive": true,
    "serverSide"  : true,
    "ajax"  : {
      url : "{{ route('admin.get-categories-table') }}",
      type :  "POST",
      dataType: 'json',
      "data": { _token: "{{csrf_token()}}"}
    },
    "columns": [
      { data: 'name' },
      { data: 'parent_id' },
      { data: 'image' },
      { data: 'status' },
      { data: 'url' },
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

  $(document).on('click', '.delete-category', function(e) {
    e.preventDefault();
    var category_id = $(this).attr('data-id');
    var delete_category = new FormData();
    delete_category.append('id', category_id);
    if(confirm('Да ли сте сигурни да желите да обришете ову категорију?')) {
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
         }
     });
      $.ajax({
         url: "remove-category",
         type: "POST",
         data: delete_category,
         contentType: false,
         cache: false,
         processData: false,
         success: function(result) {
           if(result.success == 'CATEGORY_DELETE') {
             $('#category_message').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Успешно сте обрисали категорију <strong>'+result.name+'.</strong></div>');
             categoriesDataTable.ajax.reload();
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
      $('#category_message').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> ' + session_message);
    }
  }
});
</script>
<script src="{{asset('backend/js/category.js')}}"></script>
@endsection
