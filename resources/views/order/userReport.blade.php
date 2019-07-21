@extends('layouts.app')
@section('title', 'User Report')
@section('content')
<div class="card-header">
   <div class="row">
      <div class="col-3">
         {{ucwords($currentUser->name ?? '')}} User Report
      </div>
      <div class="col-9">
         <form action="{{route('userReport')}}" method="GET" class="form-inline" style="flex-flow: row-reverse">
            <div class="input-group mr-3">
               <input class="form-control datetimepicker" name="date_to" value="{{$to}}" placeholder="enter date & time to">
               <div class="input-group-append">
                  <button type="submit" class="btn btn-primary">go</button>
               </div>
            </div>
            <div class="input-group mr-2">
               <input class="form-control datetimepicker" name="date_from" value="{{$from}}" placeholder="enter date & time from">
            </div>
            <div class="input-group mr-2">
               <select name="user" class="form-control">
                  @foreach ($users as $user)
                  <option value="{{$user->id}}">{{$user->name}}</option>    
                  @endforeach
               </select>
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
         <h3 class="text-center">Order reports from <b>"{{date('h:i a - d/m/Y', strtotime($from))}}"</b> to <b>"{{date('h:i a - d/m/Y', strtotime($to))}}"</b></h3>
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
               <td>{{$order->total}} LE</td>
               <td>{{$order->total - $order->discount}} LE</td>
               <td>{{date('h:i a - d/m/Y', strtotime($order->created_at))}}</td>
               <td>
                  <a href="{{route('showOrderItem', ['id' => $order->id])}}" class="btn btn-primary">details</a>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
      @else 
      <div class="alert alert-warning my-3">Either select a user, starting date and ending date or there are no orders for this user at the selected time range!</div>
      @endif
</div>
@endsection