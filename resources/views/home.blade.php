@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="card-header">Tables</div>
<div class="card-body">
    @include('shared.success')
    @include('shared.error')
    <div class="row">
        @if(count($tables) > 0)
        @foreach ($tables as $table)
            <div class="col-6 col-md-4">
                <div class="card @if($table->state == 'busy') busy @endif mb-3">
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
            <div class="alert alert-warning">There is no tables created</div>
        @endif
    </div>
    @include('order.add_to_order',['drinks' => $drinks, 'meals' => $meals])
    @include('order.add_ps')
    @include('order.change_ps')
</div>
@endsection
