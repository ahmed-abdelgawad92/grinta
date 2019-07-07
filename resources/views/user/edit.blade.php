@extends('layouts.app')
@section('title', 'edit user')
@section('content')
<div class="card-header">Edit User {{$user->name}}</div>
<div class="card-body">
   @include('shared.success')
   @include('shared.error')
   <form action="{{route('editUser', $user)}}" method="post">
      <div class="form-group row">
         <label for="name" class="col-2 col-form-label">Name</label>
         <div class="col-10">
            <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{$user->name}}" placeholder="Enter name">
            @error('name')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
         </div>
      </div>
      <div class="form-group row">
         <label for="admin" class="col-2 col-form-label">Type</label>
         <div class="col-10">
            <select class="form-control @error('admin') is-invalid @enderror" name="admin">
               <option @if($user->admin == 0) selected @endif value="0">User</option>
               <option @if($user->admin == 1) selected @endif value="1">Admin</option>
            </select>
            @error('admin')
               <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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