@extends('layout.default')
@section('content')
@include('header')
<!--Main layout-->
<?php
$admins=\App\Admin::where('user_type',2)->count();
$users=\App\Users::count();
$contact_centers=\App\Organizations::where('type',1)->count();


?>
<main class="">
   <div class="container-fluid" style="height: 500px" >
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0px;margin-top: 20px">
             <div class="row widget-row">
             <div class="col-md-4">
                 <!-- BEGIN WIDGET THUMB -->
                 <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                     <a href="{{URL('master-hub/organization')}}">
                         <h4 class="widget-thumb-heading">Contact Centers</h4>
                         <div class="widget-thumb-wrap">
                             <i class="widget-thumb-icon bg-red ion-ios-world"></i>
                             <div class="widget-thumb-body">
                                 <span class="widget-thumb-subtitle"></span>
                                 <span class="widget-thumb-body-stat" data-counter="counterup"><?php echo $contact_centers ; ?></span>
                             </div>
                         </div>
                     </a>
                 </div>
                 </div>
                 <div class="col-md-1"></div>
                 <!-- END WIDGET THUMB -->
                 <div class="col-md-4">
                     <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                         <a href="javascript:void(0)">
                             <h4 class="widget-thumb-heading">All Users</h4>
                             <div class="widget-thumb-wrap">
                                 <i class="widget-thumb-icon bg-blue ion-ios-people"></i>
                                 <div class="widget-thumb-body">
                                     <span class="widget-thumb-subtitle"></span>
                                     <span class="widget-thumb-body-stat" data-counter="counterup"><?php echo $users ; ?></span>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>
             </div>
         </div>
      </div>
   </div>
</main>
<!--/Main layout-->
@include('footer')
<script>
   $('.count').each(function () {
     $(this).prop('Counter',0).animate({
         Counter: $(this).text()
     }, {
         duration: 3000,
         easing: 'swing',
         step: function (now) {
             $(this).text(Math.ceil(now));
         }
     });
 });
</script>
@stop