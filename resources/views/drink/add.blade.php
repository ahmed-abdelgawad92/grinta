@extends('layouts.app')
@section('title', 'create new drink')
@section('content')
<div class="card-header">Create drink</div>
<div class="card-body">
   @include('shared.success')
   @include('shared.error')
   <form action="{{route('createDrink')}}" method="post">
      <div class="form-group row">
         <label for="name" class="col-3 col-md-2 col-form-label">Name</label>
         <div class="col-9 col-md-10">
            <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{old('name')}}" placeholder="Enter drink name">
            @error('name')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
      </div>
      <div class="form-group row">
         <label for="category" class="col-3 col-md-2 col-form-label">Category</label>
         <div class="col-9 col-md-10">
            <input id="category" class="form-control @error('category') is-invalid @enderror" type="text" name="category" value="{{old('category')}}" placeholder="Enter drink category">
            @error('category')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
      </div>
      <div class="form-group row">
         <label for="ingredients" class="col-3 col-md-2 col-form-label">Ingredients</label>
         <div class="col-9 col-md-10">
            <input id="ingredients" class="form-control @error('ingredients') is-invalid @enderror" type="text" name="ingredients" value="{{old('ingredients')}}" placeholder="Enter drink ingredients">
            @error('ingredients')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
      </div>
      <div class="form-group row">
         <label for="price" class="col-3 col-md-2 col-form-label">Price</label>
         <div class="col-9 col-md-10">
            <input id="price" class="form-control @error('price') is-invalid @enderror" type="text" name="price" value="{{old('price')}}" placeholder="Enter drink price">
            @error('price')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
      </div>
      <div class="row">
         <div class="col-3 col-md-2"></div>
         <div class="col-9 col-md-10">
            <input type="submit" value="create" class="btn btn-primary">
         </div>
      </div>
      @csrf
   </form>
</div>
@endsection