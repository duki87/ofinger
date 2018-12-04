@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row"><br>
    <div class="col-md-10 col-md-offset-2">
      <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Додај нов производ</h3>
        </div>
        <div class="panel-body">
          <div class="" id="product_message"></div>
          <form class="form-horizontal" id="add-product" action="{{ route('admin.create-product') }}" role="form" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="form-group">
              <label for="name" class="col-sm-2 control-label">Назив производа</label>
              <div class="col-sm-10">
                <input type="text" class="form-control isEmpty" name="name" id="name" placeholder="Назив производа">
                <small class="text-danger errText hidden" id="name_err">Назив је обавезaн!</small>
              </div>
            </div>

            <div class="form-group" id="mainCategory">
              <label for="parent_id" class="col-sm-2 control-label">Главна категорија</label>
              <div class="col-sm-10">
                <select class="form-control" name="parent_id" id="parent_id">
                  <option value="">Изаберите главну категорију</option>

                </select>
                <small class="text-danger errText hidden" id="parent_id_err">Морате одабрати главну категорију.</small>
              </div>
            </div>

            <div class="form-group" id="childCategory">
              <label for="child_id" class="col-sm-2 control-label">Подкатегорија</label>
              <div class="col-sm-10">
                <select class="form-control" name="child_id" id="child_id">
                  <option value="">Изаберите подкатегорију (прво морате главу категорију)</option>

                </select>
                <small class="text-danger errText hidden" id="parent_id_err">Морате одабрати подкатегорију.</small>
              </div>
            </div>

            <div class="form-group" id="">
              <label for="brand_id" class="col-sm-2 control-label">Произвођач</label>
              <div class="col-sm-10">
                <select class="form-control" name="brand_id" id="brand_id">
                  <option value="">Изаберите произвођача</option>

                </select>
                <small class="text-danger errText hidden" id="brand_id_err">Морате одабрати произвођача одеће.</small>
              </div>
            </div>

            <div class="form-group">
              <label for="description" class="col-sm-2 control-label">Опис производа</label>
              <div class="col-sm-10">
                <textarea class="form-control isEmpty" name="description" id="description" rows="8" cols="80"></textarea>
                <small class="text-danger errText hidden" id="description_err">Опис је обавезaн!</small>
              </div>
            </div>

            <div class="form-group">
              <label for="image" class="col-sm-2 control-label">Фотографијe производa</label>
              <div class="col-sm-10">
                <input type="file" multiple class="form-control" name="images[]" id="images" value="">
                <input type="hidden" name="images_folder" id="images_folder" value="">
                <input type="hidden" name="featured_photo" id="featured_photo" value="">
                <small class="text-danger hidden" id="image_err">Фотографија је обавезна!</small>
                <br>
                <small class="text-danger" id="error_images"></small>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10" style="position:relative" id="images_preview">

              </div>
              <div class="col-sm-offset-2 col-sm-10">
                <small class="text-danger hidden" id="error_featured_image">Морате означити једну насловну фотографију!</small>
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
              <label for="price" class="col-sm-2 control-label">Цена производа</label>
              <div class="col-sm-4">
                <input type="text" class="form-control isEmpty" name="price" id="price" placeholder="Цена производа" onkeypress="return priceCheck(event)">
                <small class="text-danger errText hidden" id="price_err">Цена је обавезна!</small>
              </div>

              <label for="price_discount" class="col-sm-2 control-label">Цена на попусту</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="price_discount" id="price_discount" placeholder="Цена на попусту (није обавезно)">
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                  <label>
                    <input class="isEmpty" type="checkbox" id="active" name="active"> Активан производ
                  </label>
                </div>
              </div>
            </div>
            <div class="">
              <h3>Варијанте производа<span class="pull-right"><a href="#" class="btn btn-success btn-sm" id="addProductAlt"><i class="fa fa-plus" aria-hidden="true"></i></a></span></h3>
            </div><hr>
            <div class="row" id="productAlternates">

              <div class="productAlt" id="" data-productAlt="1">
                <h4 class="col-sm-12 text-info">Варијанта <span class="productAltNumText"> 1<a href="#" class="btn btn-danger hidden btn-xs deleteProdAlt" data-deleteAlt="1"><i class="fa fa-minus" aria-hidden="true"></i></a></span></h4>
                <div class="">
                  <label for="sku" class="col-sm-2 control-label">Универзални код</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control isEmpty sku" name="sku[]" id="" data-sku="1" placeholder="Универзални код">
                    <small class="text-danger errText hidden" id="sku_err">Kод је обавезан!</small>
                  </div>
                </div>

                <div class="">
                  <label for="size" class="col-sm-2 control-label">Величина</label>
                  <div class="col-sm-4" >
                    <select class="form-control isEmpty size" name="size[]" id="" data-size="1">
                      <option value="">Изаберите</option>
                      <option value="XS">XS</option>
                      <option value="S">S</option>
                      <option value="M">M</option>
                      <option value="L">L</option>
                      <option value="XL">XL</option>
                      <option value="XXL">XXL</option>
                    </select>
                    <small class="text-danger errText hidden" id="size_err">Ово поље је обавезно!</small>
                  </div>
                </div>

                <div class="">
                  <label for="color" class="col-sm-2 control-label">Боја</label>
                  <div class="col-sm-4">
                    <select class="form-control isEmpty color" name="color[]" id="" data-color="1">
                      <option value="">Изаберите</option>
                      <option value="црвена">црвена</option>
                      <option value="зелена">зелена</option>
                      <option value="плава">плава</option>
                      <option value="бела">бела</option>
                      <option value="црна">црна</option>
                      <option value="сива">сива</option>
                      <option value="љубичаста">љубичаста</option>
                      <option value="жута">жута</option>
                      <option value="наранџаста">наранџаста</option>
                      <option value="крем">крем</option>
                      <option value="комбинација боја">комбинација боја</option>
                    </select>
                    <small class="text-danger errText hidden" id="color_err">Ово поље је обавезно!</small>
                  </div>
                </div>

                <div class="">
                  <label for="stock" class="col-sm-2 control-label">Количина у складишту</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control isEmpty stock" min="1" name="stock[]" id="" data-stock="1" placeholder="Унесите број комада" onkeypress="return AllowNumbersOnly(event)">
                    <small class="text-danger errText hidden" id="stock_err">Ово поље је обавезно!</small>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10" style="margin-top:10px">
                <button type="submit" class="btn btn-primary">Додај производ</button>
                <a href="" class="btn btn-default">Назад на све производе</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function AllowNumbersOnly(e) {
    var code = (e.which) ? e.which : e.keyCode;
    if (code > 31 && (code < 48 || code > 57)) {
      e.preventDefault();
    }
  }

  function priceCheck(e) {
    //console.log(e);
    var code = (e.key) ? e.key : e.key;
    var rgx = /^[0-9]*\.?[0-9]*$/;
    if(!code.match(rgx)) {
      e.preventDefault();
    }
  }
</script>
<script src="{{asset('backend/js/product.js')}}"></script>

@endsection
