@extends('layouts.app')
@section('title', 'edit table')
@section('content')
<div class="card-header">Edit Table</div>
<div class="card-body">
   @include('shared.success')
   @include('shared.error')
   <form action="{{route('editTable', $table)}}" method="POST">
      <div class="form-group row">
         <label for="name" class="col-2 col-form-label">Name</label>
         <div class="col-10">
            <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{$table->name}}" placeholder="Enter table name">
            @error('name')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
      </div>
      <div class="form-group row">
         <label for="type" class="col-2 col-form-label">Type</label>
         <div class="col-10">
            <select class="form-control @error('type') is-invalid @enderror" name="type">
               <option @if($table->type == 'normal') selected @endif value="normal">Normal</option>
               <option @if($table->type == 'ps') selected @endif value="ps">Playstation</option>
            </select>
            @error('type')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
      </div>
      <div  @if($table->type == 'ps')
               style="display: block;"
            @else 
               style="display:none;"
            @endif
      >
         <div class="form-group row">
            <label for="ps_price" class="col-2 col-form-label">PS hour price</label>
            <div class="col-10">
               <input id="ps_price" class="form-control @error('ps_price') is-invalid @enderror" type="text" name="ps_price" value="{{$table->ps_price}}" placeholder="Enter PS hour price">
               @error('ps_price')
                  <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>
         </div>
         <div class="form-group row">
            <label for="ps_multi_price" class="col-2 col-form-label">PS multi hour price</label>
            <div class="col-10">
               <input id="ps_multi_price" class="form-control @error('ps_multi_price') is-invalid @enderror" type="text" name="ps_multi_price" value="{{$table->ps_multi_price}}" placeholder="Enter PS hour multi price">
               @error('ps_multi_price')
                  <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-2"></div>
         <div class="col-10">
            <input type="submit" value="edit" class="btn btn-secondary">
         </div>
      </div>
      @csrf
      @method('PUT')
   </form>
</div>
@endsection