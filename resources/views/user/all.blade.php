@extends('layouts.app')
@section('title', 'All users')
@section('content')
<div class="card-header">All Users</div>
<div class="card-body">
   @include('shared.success')
   @include('shared.error')
   @if($users->count()>0)
   <table class="table">
      <thead>
         <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Type</th>
            <th>Created at</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         @foreach ($users as $user)
             <tr>
                <td>{{$user->username}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->getType()}}</td>
                <td>{{$user->created_at->format('d/m/Y')}}</td>
                <td>
                   <a href="{{route('editUser', $user)}}" class="btn btn-secondary">edit</a>
                   <button class="btn btn-danger" data-toggle="modal" data-target="#delete-{{$user->id}}">delete</button>
                   <div id="delete-{{$user->id}}" class="modal fade" tabindex="-1" role="dialog">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title">Delete</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <div class="modal-body">
                              <p>Are you sure that you want to delete this user "{{$user->name}}"?</p>
                           </div>
                           <div class="modal-footer">
                              <form action="{{route('deleteUser', $user)}}" method="post">
                                 @csrf 
                                 @method('DELETE')
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">no</button>
                                 <button type="submit" class="btn btn-danger">yes</button>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
                </td>
             </tr>
         @endforeach
      </tbody>
   </user>
   @else 
   <div class="alert alert-warning">
      There is no users in the database
      <a href="{{route('createUser')}}" class="btn btn-warning">create user</a>
   </div>

   @endif
</div>
@endsection