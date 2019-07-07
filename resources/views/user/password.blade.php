@extends('layouts.app')
@section('title', 'change password')
@section('content')
<div class="card-header">Change Password</div>
<div class="card-body">
   @include('shared.success')
   @include('shared.error')
   <form action="{{route('changePassword')}}" method="post">
      <div class="form-group row">
         <label for="old_password" class="col-2 col-form-label">Old Password</label>
         <div class="col-10">
            <input id="old_password" class="form-control @error('old_password') is-invalid @enderror" type="password" name="old_password" value="{{old('old_password')}}" placeholder="Enter old password">
            @error('old_password')
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
            <input id="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" type="password" name="confirm_password" value="{{old('confirm_password')}}" placeholder="confirm password">
            @error('confirm_password')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
      </div>
      <div class="row">
         <div class="col-2"></div>
         <div class="col-10">
            <input type="submit" value="change" class="btn btn-primary">
         </div>
      </div>
      @csrf
      @method('PUT')
   </form>
</div>
@endsection