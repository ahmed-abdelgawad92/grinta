@extends('layouts.app')
@section('title', 'All tables')
@section('content')
<div class="card-header">All Tables</div>
<div class="card-body">
   @include('shared.success')
   @include('shared.error')
   @if($tables->count()>0)
   <table class="table">
      <thead>
         <tr>
            <th>Name</th>
            <th>Type</th>
            <th>PS hour</th>
            <th>PS multi</th>
            <th>Created at</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         @foreach ($tables as $table)
             <tr>
                <td>{{$table->name}}</td>
                <td>{{$table->type}}</td>
                @if ($table->type == 'ps')
                <td>{{$table->ps_price}} LE</td>
                <td>{{$table->ps_multi_price}} LE</td>
                @else
                <td>N/A</td><td>N/A</td>
                @endif
                <td>{{$table->created_at->format('d/m/Y')}}</td>
                <td>
                   <a href="{{route('editTable', $table)}}" class="btn btn-secondary">edit</a>
                   <button class="btn btn-danger" data-toggle="modal" data-target="#delete-{{$table->id}}">delete</button>
                   <div id="delete-{{$table->id}}" class="modal fade" tabindex="-1" role="dialog">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title">Delete</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <div class="modal-body">
                              <p>Are you sure that you want to delete this table "{{$table->name}}"?</p>
                           </div>
                           <div class="modal-footer">
                              <form action="{{route('deleteTable', $table)}}" method="post">
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
   </table>
   @else 
   <div class="alert alert-warning">
      There is no tables in the database
      <a href="{{route('createTable')}}" class="btn btn-warning">create table</a>
   </div>

   @endif
</div>
@endsection