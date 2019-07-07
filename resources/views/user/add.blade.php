@extends('layouts.app')
@section('title', 'create new user')
@section('content')
<div class="card-header">Create User</div>
<div class="card-body">
   @include('shared.success')
   @include('shared.error')
   <form action="{{route('createUser')}}" method="post">
      <div class="form-group row">
         <label for="name" class="col-2 col-form-label">Name</label>
         <div class="col-10">
            <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{old('name')}}" placeholder="Enter name">
            @error('name')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
      </div>
      <div class="form-group row">
         <label for="username" class="col-2 col-form-label">Username</label>
         <div class="col-10">
            <input id="username" class="form-control @error('username') is-invalid @enderror" type="text" name="username" value="{{old('username')}}" placeholder="Enter username">
            @error('username')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
      </div>
      <div class="form-group row">
         <label for="password" class="col-2 col-form-label">Password</label>
         <div class="col-10">
            <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" value="{{old('password')}}" placeholder="Enter password">
            @error('password')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
      </div>
      <div class="form-group row">
         <label for="confirm_password" class="col-2 col-form-label">Confirm password</label>
         <div class="col-10">
            <input id="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" type="password" name="confirm_password" value="{{old('confirm_password')}}" placeholder="Confirm password">
            @error('confirm_password')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
      </div>
      <div class="form-group row">
         <label for="admin" class="col-2 col-form-label">Type</label>
         <div class="col-10">
            <select class="form-control @error('admin') is-invalid @enderror" name="admin">
               <option @if(old('admin') == 0) selected @endif value="0">User</option>
               <option @if(old('admin') == 1) selected @endif value="1">Admin</option>
            </select>
            @error('admin')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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