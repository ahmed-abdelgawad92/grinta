@extends('layouts.app')
@section('title', 'Order Report')
@section('content')
<div class="card-header">
   <div class="row">
      <div class="col-9">
         Order Report at {{date('d/m/Y', strtotime($date))}}
      </div>
      <div class="col-3">
         <form action="{{route('dailyReport')}}" method="GET">
            <div class="input-group">
               <input class="form-control" name="date" id="datepicker" type="date" placeholder="enter date">
               <div class="input-group-append">
                  <button type="submit" class="btn btn-primary">go</button>
               </div>
            </div>
            @csrf
         </form>
      </div>
   </div>
</div>
<div class="card-body">
    @include('shared.success')
    @include('shared.error')
      @if(count($orders) > 0)
      <div class="jumbotron">
         <h1 class="display-4 text-center">Total: {{$total}} LE</h1>
      </div>
      <table class="table table-striped">
         <thead>
            <tr>
               <th>#</th>
               <th>table</th>
               <th>discount</th>
               <th>before discount</th>
               <th>total paid</th>
               <th>created at</th>
               <th>User</th>
               <th>action</th>
            </tr>
         </thead>
         <tbody>
            @php $count = 1; @endphp
            @foreach($orders as $order)
            <tr>
               <td>{{$count++}}</td>
               <td>{{$order->table->name}}</td>
               <td>
                  {{$order->discount??'N/A'}}
                  @if($order->discount)
                  LE
                  @endif
               </td>
               <td>
                  @if($order->discount)
                     {{$order->total - $order->discount}} LE
                  @else 
                     N/A
                  @endif
               </td>
               <td>{{$order->total}} LE</td>
               <td>{{date('H:i a - d/m/Y', strtotime($order->created_at))}}</td>
               <td>{{$order->user->name??'N/A'}}</td>
               <td>
                  <a href="{{route('showOrderItem', ['id' => $order->id])}}" class="btn btn-primary">details</a>
                  <button class="btn btn-danger delete-order-entry" data-id="{{$order->id}}" data-toggle="modal" data-target="#delete-order-modal">&#9003;</button>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
      @else 
      <div class="alert alert-warning">There are no Sales</div>
      @endif
      <div id="delete-order-modal" class="modal fade" tabindex="-1" role="dialog">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Are you sure you want to delete this order?</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-footer">
                  <form action="" method="POST" id="delete-order-form">
                     @csrf 
                     @method('DELETE')
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                     <button type="submit" class="btn btn-danger">delete</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
</div>
@endsection