@extends('layouts.app')
@section('title', 'Order #' . $currentOrder->id)
@section('content')
<div class="card-header">Order #{{$currentOrder->id}}</div>
<div class="card-body">
    @include('shared.success')
    @include('shared.error')
    <div class="row">
      <table class="table table-striped">
            @if(count($orders) > 0)
            <thead>
               <tr class="bg-dark text-white">
                  <th>name</th>
                  <th>amount</th>
                  <th>price</th>
                  <th>total</th>
               </tr>
            </thead>
            <tbody>
               @foreach($orders as $order)
               <tr>
                  <td>{{$order->drink->name ?? $order->meal->name}}</td>
                  <td>{{$order->amount}}</td>
                  <td>{{$order->price}}</td>
                  <td>{{$order->price * $order->amount}}</td>
               </tr>    
               @endforeach
            </tbody>
            @endif
            @if($table->type == 'ps')
            <thead>
               <tr class="bg-dark text-white">
                  <th>multi</th>
                  <th>from</th>
                  <th>to</th>
                  <th>price</th>
               </tr>
            </thead>
            <tbody>
               @foreach($reservations as $reservation)
               <tr>
                  <td>{{$reservation->multi ? 'yes' : 'no'}}</td>
                  <td>
                     {{date('h:i a - d/m/Y', strtotime($reservation->time_from))}}
                  </td>
                  <td>
                     {{date('h:i a - d/m/Y', strtotime($reservation->time_to))}}
                  </td>
                  <td>
                     @php
                        $hour_price = ($reservation->multi == 1) ? $table->ps_multi_price : $table->ps_price;
                        $price = round(((strtotime($reservation->time_to) - strtotime($reservation->time_from)) / 3600) * ($hour_price));
                     @endphp
                     {{$price}} LE
                  </td>
               </tr>    
               @endforeach
            </tbody>
            @endif
            <tfoot>
               @if($currentOrder->discount)
               <tr>
                  <th colspan="3">Total before discount</th>
                  <th colspan="1">{{$currentOrder->total_before}} LE</th>
               </tr>
               @endif
               <tr>
                  <th colspan="3">Total paid</th>
                  <th colspan="1">{{$currentOrder->total}} LE</th>
               </tr>
            </tfoot>
         </table>
    </div>
</div>
@endsection