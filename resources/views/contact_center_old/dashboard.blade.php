@extends('contact_center.layout.default')
@include('contact_center.header')
@section('content')
<!--Main layout-->
@php 
if (Session::has('contact_center_admin')) {
    $user = Session::get('contact_center_admin');
    $organization_id=$user[0]['organization_id'];
}
$admins=\App\Organizations::where('organization_id',$organization_id)->where('type',2)->count();
$users = \App\Users::where('organization_id',$organization_id)->count();
$contact_centers=\App\Organizations::count();
$user_ids=\App\Users::where('organization_id',$organization_id)->pluck('user_id')->all();
$panic=\App\Videos::with('user')->where('archive_id','!=','')->where('type','=','panic')->whereIn('user_id',$user_ids)->where('created_at', '>=', \Carbon\Carbon::now()->subDays(30))->count();;
$anonymous=\App\Videos::with('user')->where('archive_id','!=','')->where('type','!=','panic')->whereIn('user_id',$user_ids)->where('created_at', '>=', \Carbon\Carbon::now()->subDays(30))->count();
@endphp
<main class="">
   <div class="container-fluid" style="height: 500px" >
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0px;margin-top: 20px">
             <div class="row widget-row">
                 <div class="col-md-4">
                     <!-- BEGIN WIDGET THUMB -->
                     <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                         <a href="{{url('/')}}/panic">
                             <h4 class="widget-thumb-heading">Panics In Last 30 Days</h4>
                             <div class="widget-thumb-wrap">
                                 <i class="widget-thumb-icon bg-red ion-ios-videocam"></i>
                                 <div class="widget-thumb-body">
                                     <span class="widget-thumb-subtitle"></span>
                                     <span class="widget-thumb-body-stat" data-counter="counterup"><?php echo $panic ; ?></span>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>
                 <!-- END WIDGET THUMB -->
                 <div class="col-md-4">
                     <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                         <a href="{{url('/')}}/anonymous_panic">
                             <h4 class="widget-thumb-heading">Anonymous Panic In Last 30 Days</h4>
                             <div class="widget-thumb-wrap">
                                 <i class="widget-thumb-icon bg-blue ion-ios-videocam"></i>
                                 <div class="widget-thumb-body">
                                     <span class="widget-thumb-subtitle"></span>
                                     <span class="widget-thumb-body-stat" data-counter="counterup"><?php echo $anonymous ; ?></span>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>
                 <div class="col-md-4">
                     <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                         <a href="{{url('/')}}/users">
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
            <!-- ./col -->
         </div>
      </div>
   </div>
</main>
<!--/Main layout-->
@include('footer')

@endsection