@extends('layouts.app')
@section('title', 'Order Report')
@section('content')
<div class="card-header">
   <div class="row">
      <div class="col-9">
         Expenses at {{date('d/m/Y', strtotime($date))}}
      </div>
      <div class="col-3">
         <form action="{{route('allExpense')}}" method="GET">
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
      @if(count($expenses) > 0)
      <div class="jumbotron">
         <h1 class="display-4 text-center">Total Expenses: {{$total}} LE</h1>
      </div>
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
      @else 
      <div class="alert alert-warning">There are no Expenses</div>
      @endif
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
</div>
@endsection