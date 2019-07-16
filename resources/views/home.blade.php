@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="card-header">Tables</div>
<div class="card-body">
    @include('shared.success')
    @include('shared.error')
    <div class="alert alert-info alert-dismissible fade show" id="hint">
        <p id="info" style="font-size:16px;"></p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="row">
        @if(count($tables) > 0)
        @foreach ($tables as $table)
            <div class="col-6 col-md-4">
                <div class="card mb-3 
                    @if($table->state == 'busy' && $table->type == 'ps' && $table->reservations->last()->time_to != null && strtotime($table->reservations->last()->time_to) < strtotime(date('Y-m-d H:i:s'))) 
                    bg-secondary
                    @elseif($table->state == 'busy')
                    busy 
                    @endif" 
                    @if($table->state == 'busy' && $table->type == 'ps' && $table->reservations->last()->time_to != '0000-00-00 00:00:00')
                        data-busy-table="{{$table->name}}"
                        data-time-to="{{strtotime($table->reservations->last()->time_to)}}"
                        data-now="{{time()}}"
                    @endif>
                    <div class="card-body text-center">
                        @if($table->type == 'ps')
                        <img src="{{asset('images/ps.png')}}" alt="ps" class="table-logo">
                        @else 
                        <img src="{{asset('images/table.png')}}" alt="ps" class="table-logo">
                        @endif
                        <h5 class="card-title mt-2">
                            {{$table->name}}
                        </h5>
                        @if($table->state == 'busy')
                            @if($table->type == 'ps')
                                @php $reservation = $table->reservations->last(); @endphp
                                @if($reservation->multi)
                                    <button type="button" data-id="{{$reservation->id}}" class="change_multi btn btn-dark mb-2" data-url="{{route('changeMulti', $reservation)}}" data-toggle="modal" data-target="#change-ps-modal">change to single</button>
                                @else 
                                    <button type="button" data-id="{{$reservation->id}}" class="change_multi btn btn-dark mb-2" data-url="{{route('changeMulti', $reservation)}}" data-toggle="modal" data-target="#change-ps-modal">change to multi</button>
                                @endif
                            @endif    
                            <button class="btn btn-primary open_order_modal mb-2" data-toggle="modal" data-order-id="{{$table->currentOrder()->id ?? null}}" data-target="#add_to_order">order</button>
                            <a class="btn btn-success mb-2" href="{{route('checkout', $table->currentOrder()->id)}}">checkout</a>
                        @elseif($table->type == 'ps')
                            <button class="btn btn-primary open_ps mb-2" data-toggle="modal" data-url="/orders/create/{{$table->id}}" data-target="#add-ps-modal">New Order</button>
                        @else
                            <form action="{{route('createOrder', $table)}}" method="POST">
                                <button class="btn btn-primary">New Order</button>
                                @csrf
                            </form>
                        @endif 
                    </div>
                </div>
            </div>
        @endforeach
        @else 
            <div class="alert alert-warning col-12">There is no tables created</div>
        @endif
    </div>
    @include('order.add_to_order',['drinks' => $drinks, 'meals' => $meals])
    @include('order.add_ps')
    @include('order.change_ps')
</div>
@endsection
