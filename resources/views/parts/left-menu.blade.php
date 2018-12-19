<?php
  $brands = App\Http\Controllers\IndexController::brands_menu();
  $categories = App\Http\Controllers\IndexController::categories_menu();
?>
<div id="accordion">

 <div class="accordion">
   <div class="list-group">
     <a class="list-group-item list-group-item-action acc-link-item" data-toggle="collapse" href="#brands">
       Произвођачи
     </a>
   </div>
   <div id="brands" class="collapse" data-parent="#accordion">
     <div class="list-group">
       @foreach($brands as $brand)
       <a class="list-group-item list-group-item-action" href="{{route('front.brand', $brand->url)}}">{{ $brand->name }}</a>
       @endforeach
     </div>
   </div>
 </div>

 <div class="accordion">
   <div class="list-group">
     <a class="list-group-item list-group-item-action acc-link-item" data-toggle="collapse" href="#categories">
       Категорије
     </a>
   </div>
   <div id="categories" class="collapse" data-parent="#accordion">
     <div class="" id="catAccordion">
       <?=$categories;?>
     </div>
   </div>
 </div>

 <div class="card">
   <div class="card-header">
     <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
       Collapsible Group Item #3
     </a>
   </div>
   <div id="collapseThree" class="collapse" data-parent="#accordion">
     <div class="card-body">
       Lorem ipsum..
     </div>
   </div>
 </div>

</div>
