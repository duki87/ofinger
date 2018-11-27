@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row"><br>
    <div class="col-md-10 col-md-offset-2">
      <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Додај нову категорију</h3>
        </div>
        <div class="panel-body">
          <div class="" id="category_message"></div>
          <form class="form-horizontal" id="add-category" role="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="isMain" checked> Категорија ће бити једна од главних
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group hidden" id="mainCategory">
              <label for="parent_id" class="col-sm-2 control-label">Главна категорија</label>
              <div class="col-sm-10">
                <select class="form-control" name="parent_id" id="parent_id">
                  <option value="">Изаберите главну категорију</option>

                </select>
                <small class="text-danger errText hidden" id="parent_id_err">Морате одабрати главну категорију уколико ова категорија неће бити главна.</small>
              </div>
            </div>

            <div class="form-group">
              <label for="name" class="col-sm-2 control-label">Назив категорије</label>
              <div class="col-sm-10">
                <input type="text" class="form-control isEmpty" name="name" id="name" placeholder="Назив категорије">
                <small class="text-danger errText hidden" id="name_err">Назив је обавезaн!</small>
              </div>
            </div>

            <div class="form-group">
              <label for="description" class="col-sm-2 control-label">Опис категорије</label>
              <div class="col-sm-10">
                <textarea class="form-control isEmpty" name="description" id="description" rows="8" cols="80"></textarea>
                <small class="text-danger errText hidden" id="description_err">Опис је обавезaн!</small>
              </div>
            </div>

            <div class="form-group">
              <label for="image" class="col-sm-2 control-label">Фотографија која репрезентује категорију</label>
              <div class="col-sm-10">
                <input type="file" class="form-control isEmpty" name="image" id="image" value="">
                <small class="text-danger errText hidden" id="image_err">Фотографија је обавезна!</small>
                <small class="text-danger" id="error_images"></small>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-2" style="position:relative" id="image_preview">

              </div>
            </div>

            <div class="form-group">
              <label for="url" class="col-sm-2 control-label">УРЛ скраћеница</label>
              <div class="col-sm-10">
                <input type="text" class="form-control isEmpty" name="url" id="url" placeholder="УРЛ скраћеница">
                <small class="text-danger errText hidden" id="url_err">Урл је обавезан!</small>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                  <label>
                    <input class="isEmpty" type="checkbox" id="active" name="active"> Активна категорија
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Додај категорију</button>
                <button type="button" class="btn btn-default">Назад на категорије</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="{{asset('backend/js/category.js')}}"></script>

@endsection
