@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row"><br>
    <div class="col-md-10 col-md-offset-2">
      <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Измени произвођача: <span style="font-weight:bold; color:yellow">{{$brand->name}}</span></h3>
        </div>
        <div class="panel-body">
          <div class="" id="brand_message"></div>
          <form class="form-horizontal" id="edit-brand" role="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" id="brand_id" value="{{ $brand->id }}">
            <div class="form-group">
              <label for="name" class="col-sm-2 control-label">Назив произвођача</label>
              <div class="col-sm-10">
                <input type="text" class="form-control isEmpty" name="name" id="name" placeholder="Назив бренда">
                <small class="text-danger errText hidden" id="name_err">Назив је обавезaн!</small>
              </div>
            </div>

            <div class="form-group">
              <label for="description" class="col-sm-2 control-label">Опис произвођача</label>
              <div class="col-sm-10">
                <textarea class="form-control isEmpty" name="description" id="description" rows="8" cols="80"></textarea>
                <small class="text-danger errText hidden" id="description_err">Опис је обавезaн!</small>
              </div>
            </div>

            <div class="form-group">
              <label for="image" class="col-sm-2 control-label">Фотографија која репрезентује произвођача</label>
              <div class="col-sm-10">
                <input type="file" class="form-control isEmpty" name="image" id="image" value="">
                <small class="text-danger errText hidden" id="image_err">Фотографија је обавезна!</small>
                <small class="text-danger" id="error_images"></small>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-2" style="position:relative" id="image_preview">
                <img src="" class="" id="preview_image" alt="" style="position:relative;border:1px solid green; width:100%; height:auto">
                <button class="btn btn-danger btn-xs remove_image" id="remove_image" data-path="" style="position:absolute; right:20px; top:6px">x</button>
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
                    @if($brand->active == 1)
                    <input class="isEmpty isActive" type="checkbox" id="active" name="active" checked> <span id="isActive">Активaн произвођач</span>
                    @else
                    <input class="isEmpty isActive" type="checkbox" id="active" name="active"> <span id="isActive">Heaктивaн произвођач</span>
                    @endif
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Измени произвођача</button>
                <a href="{{ route('admin.brands') }}" class="btn btn-default">Назад на све произвођаче</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="{{asset('backend/js/edit-brand.js')}}"></script>

@endsection
