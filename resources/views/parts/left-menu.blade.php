<div id="accordion">

 <div class="card">
   <div class="card-header">
     <a class="card-link" data-toggle="collapse" href="#collapseOne">
       Произвођачи
     </a>
   </div>
   <div id="collapseOne" class="collapse show" data-parent="#accordion">
     <div class="card-body">
       <ul class="list-group">
         <?php $brands = App\Http\Controllers\IndexController::brands_menu();
          foreach($brands as $brand) {
         ?>
         <li style="list-style-type:none; padding:5px;"><a href="#">{{ $brand->name }}</a></li>
         <?php
          }
         ?>
       </ul>
     </div>
   </div>
 </div>

 <div class="card">
   <div class="card-header">
     <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
       Collapsible Group Item #2
     </a>
   </div>
   <div id="collapseTwo" class="collapse" data-parent="#accordion">
     <div class="card-body">
       Lorem ipsum..
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
