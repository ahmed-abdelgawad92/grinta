@extends('layouts.app')
@section('title', 'checkout')
@section('content')
<div class="card-content">
   <div class="card-header">
      <h5 class="card-title">Checkout</h5>
   </div>
   <form action="{{route('pay', $id)}}" method="POST" id="checkout_form" onkeydown="return event.key != 'Enter';">
   <div class="card-body">
      @include('shared.success')
      @include('shared.error')
      <div id="checkout">
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
                  <td>{{$order->name}}</td>
                  <td>{{$order->amount}}</td>
                  <td>{{$order->price}}</td>
                  <td>{{$order->total}}</td>
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
                  <td title="{{date('d/m/Y', strtotime($reservation->time_from))}}">
                     {{date('h:i a', strtotime($reservation->time_from))}}
                     @php
                        $from = strtotime($reservation->time_from);
                     @endphp
                  </td>
                  @if ($reservation->time_to)
                  <td title="{{date('d/m/Y', strtotime($reservation->time_to))}}">
                     {{date('h:i a', strtotime($reservation->time_to))}}
                     @php
                        $to = strtotime($reservation->time_to);
                     @endphp
                  </td>
                  @else
                  <td title="{{date('d/m/Y', strtotime(session('order'.$id)))}}">
                     {{date('h:i a', strtotime(session('order'.$id)))}}
                     @php
                        $to = strtotime(session('order'.$id));
                     @endphp
                  </td>
                  @endif
                  <td>
                     @php
                        $price = round((($to - $from) / 3600) * $reservation->price);
                        $total += $price;
                     @endphp
                     {{$price}}
                  </td>
               </tr>    
               @endforeach
            </tbody>
            @endif
            <tfoot>
               <tr>
                  <th colspan="3">Total</th>
                  <th class="total-price" data-total-new="{{$total}}" data-total="{{$total}}" colspan="1">{{$total}} LE</th>
               </tr>
            </tfoot>
         </table>
      </div>
      @if(auth()->user()->admin)
      <div class="form-group">
         <label>Discount</label>
         <div class="input-group">
            <input class="form-control" name="discount" type="text" placeholder="enter discount">
            <div class="input-group-append">
               <select name="discount_type" class="form-control">
                  <option value="percent">Percent %</option>
                  <option value="amount">Amount</option>
               </select>
            </div>
         </div>
      </div>
      @endif
      <div>
         <p>Calculate the rest</p>
         <input type="text" class="form-control" id="paid" placeholder="Enter amount the client has paid">
         <p class="p-2" id="rest"></p>
         <button type="button" class="btn btn-primary" id="calc-rest">calculate</button>
      </div>
   </div>
   <div class="card-footer">
      @csrf
      <a href="/" class="btn btn-secondary">cancel</a>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#pay-modal">pay</button>
   </div>
   </form>
</div>
<div id="pay-modal" class="modal fade" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Are you sure that the client has already paid?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
            <button type="button" id="payNow" class="btn btn-success">pay</button>
         </div>
      </div>
   </div>
</div>
@endsection