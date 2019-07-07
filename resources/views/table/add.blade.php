@extends('layouts.app')
@section('title', 'create new table')
@section('content')
<div class="card-header">Create Table</div>
<div class="card-body">
   @include('shared.success')
   @include('shared.error')
   <form action="{{route('createTable')}}" method="post">
      <div class="form-group row">
         <label for="name" class="col-2 col-form-label">Name</label>
         <div class="col-10">
            <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{old('name')}}" placeholder="Enter table name">
            @error('name')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
      </div>
      <div class="form-group row">
         <label for="type" class="col-2 col-form-label">Type</label>
         <div class="col-10">
            <select class="form-control @error('type') is-invalid @enderror" name="type">
               <option @if(old('type') == 'normal') selected @endif value="normal">Normal</option>
               <option @if(old('type') == 'ps') selected @endif value="ps">Playstation</option>
            </select>
            @error('type')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
      </div>
      <div id="ps_input"
      @if($errors->has('ps_price')||$errors->has('ps_multi_price'))
      style="display: block;"
      @endif
      >
         <div class="form-group row">
            <label for="ps_price" class="col-2 col-form-label">PS hour price</label>
            <div class="col-10">
               <input id="ps_price" class="form-control @error('ps_price') is-invalid @enderror" type="text" name="ps_price" value="{{old('ps_price')}}" placeholder="Enter PS hour price">
               @error('ps_price')
                  <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>
         </div>
         <div class="form-group row">
            <label for="ps_multi_price" class="col-2 col-form-label">PS multi hour price</label>
            <div class="col-10">
               <input id="ps_multi_price" class="form-control @error('ps_multi_price') is-invalid @enderror" type="text" name="ps_multi_price" value="{{old('ps_multi_price')}}" placeholder="Enter PS hour multi price">
               @error('ps_multi_price')
                  <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-2"></div>
         <div class="col-10">
            <input type="submit" value="create" class="btn btn-primary">
         </div>
      </div>
      @csrf
   </form>
</div>
@endsection