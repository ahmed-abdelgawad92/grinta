@extends('layouts.app')
@section('title', 'add new expense')
@section('content')
<div class="card-header">Add Expense</div>
<div class="card-body">
   @include('shared.success')
   @include('shared.error')
   <form action="{{route('createExpense')}}" method="post">
      <div class="form-group row">
         <label for="name" class="col-3 col-md-2 col-form-label">Name or description</label>
         <div class="col-9 col-md-10">
            <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{old('name')}}" placeholder="Enter name or description">
            @error('name')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
      </div>
      <div class="form-group row">
         <label for="amount" class="col-3 col-md-2 col-form-label">Amount</label>
         <div class="col-9 col-md-10">
            <input id="amount" class="form-control @error('amount') is-invalid @enderror" type="text" name="amount" value="{{old('amount')}}" placeholder="Enter amount">
            @error('amount')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
      </div>
      <div class="form-group row">
         <label for="datepicker" class="col-3 col-md-2 col-form-label">Date</label>
         <div class="col-9 col-md-10">
            <input class="form-control @error('date') is-invalid @enderror" type="text" id="datepicker" name="date" value="{{old('date')}}" placeholder="Default value is today's date">
            @error('date')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
      </div>
      <div class="row">
         <div class="col-3 col-md-2"></div>
         <div class="col-9 col-md-10">
            <input type="submit" value="add" class="btn btn-primary">
         </div>
      </div>
      @csrf
   </form>
</div>
@endsection