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
      <div class="jumbotron">
         <div class="row">
            <div class="col-sm-6 col-md-4">
               <h5 class="display-4 text-center">Total In<br>{{$totalIn ?? 0}} LE</h5>
            </div>
            <div class="col-sm-6 col-md-4">
               <h5 class="display-4 text-center">Total Out<br>{{$totalOut}} LE</h5>
            </div>
            <div class="col-sm-6 col-md-4">
               <h5 class="display-4 text-center">Total Profit<br>{{$totalIn - $totalOut}} LE</h5>
            </div>
         </div>
      </div>
      <ul class="nav nav-tabs" id="myTab" role="tablist">
         <li class="nav-item">
            <a class="nav-link active" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="true">orders</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" id="expenses-tab" data-toggle="tab" href="#expenses" role="tab" aria-controls="expenses" aria-selected="false">expenses</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" id="sales-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="sales" aria-selected="false">sales</a>
         </li>
      </ul>
      <div class="tab-content" id="myTabContent">
         <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
            @if(count($orders) > 0)
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
                     <td>{{$order->total}} LE</td>
                     <td>{{$order->total - $order->discount}} LE</td>
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
            @else 
               <div class="alert alert-warning my-3">There are no Sales</div>
            @endif
         </div>
         <div class="tab-pane fade" id="expenses" role="tabpanel" aria-labelledby="expenses-tab">
            @if(count($expenses) > 0)
            <table class="table table-striped">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>name</th>
                     <th>amount</th>
                     <th>date</th>
                     <th>user</th>
                     <th>action</th>
                  </tr>
               </thead>
               <tbody>
                  @php $count = 1; @endphp
                  @foreach($expenses as $expense)
                  <tr>
                     <td>{{$count++}}</td>
                     <td>{{$expense->name}}</td>
                     <td>{{$expense->amount}} LE</td>
                     <td>{{date('d/m/Y', strtotime($expense->date))}}</td>
                     <td>{{$expense->user->name??'N/A'}}</td>
                     <td>
                        <button class="btn btn-danger delete-expense-entry" data-id="{{$expense->id}}" data-toggle="modal" data-target="#delete-expense-modal">&#9003;</button>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
            <div id="delete-expense-modal" class="modal fade" tabindex="-1" role="dialog">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Are you sure you want to delete this expense?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-footer">
                        <form action="" method="POST" id="delete-expense-form">
                           @csrf 
                           @method('DELETE')
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                           <button type="submit" class="btn btn-danger">delete</button>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            @else 
               <div class="alert alert-warning my-3">There are no Expenses</div>
            @endif
         </div>
         <div class="tab-pane fade" id="sales" role="tabpanel" aria-labelledby="sales-tab">
            @if(count($orderItems) > 0)
            <table class="table table-striped">
               <thead>
                  <tr>
                     <th>name</th>
                     <th>amount</th>
                     <th>price</th>
                     <th>total</th>
                     <th>action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($orderItems as $orderItem)
                  <tr>
                     <td>{{$orderItem->name}}</td>
                     <td>{{$orderItem->amount}}</td>
                     <td>{{$orderItem->price}}</td>
                     <td>{{$orderItem->total}}</td>
                     <td>
                        <button type="button" class="btn btn-danger delete-order-item" data-id="{{$order->id}}" data-toggle="modal" data-target="#delete-order-item">&#9003;</button>
                     </td>
                  </tr>    
                  @endforeach
               </tbody>
            </table>  
            <div id="delete-order-item" class="modal fade" tabindex="-1" role="dialog">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Are you sure you want to remove this item?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-footer">
                        <form action="" method="POST" id="delete-order-item-form">
                           @csrf 
                           @method('DELETE')
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                           <button type="submit" class="btn btn-danger">delete</button>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            @else 
               <div class="alert alert-warning my-3">There are no Sales</div>
            @endif
         </div>
      </div>
</div>
@endsection