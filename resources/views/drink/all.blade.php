@extends('layouts.app')
@section('title', 'All drinks')
@section('content')
<div class="card-header">All Drinks</div>
<div class="card-body">
   @include('shared.success')
   @include('shared.error')
   @if($drinks->count()>0)
   <table class="table">
      <thead>
         <tr>
            <th>Name</th>
            <th>Ingredients</th>
            <th>Category</th>
            <th>Price</th>
            <th>Created at</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         @foreach ($drinks as $drink)
             <tr>
                <td>{{$drink->name}}</td>
                <td>{{$drink->ingredients ?? 'N/A'}}</td>
                <td>{{$drink->category}}</td>
                <td>{{$drink->price}} LE</td>
                <td>{{$drink->created_at->format('d/m/Y')}}</td>
                <td>
                   <a href="{{route('editDrink', $drink)}}" class="btn btn-secondary">edit</a>
                   <button class="btn btn-danger" data-toggle="modal" data-target="#delete-{{$drink->id}}">delete</button>
                   <div id="delete-{{$drink->id}}" class="modal fade" tabindex="-1" role="dialog">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title">Delete</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <div class="modal-body">
                              <p>Are you sure that you want to delete this drink "{{$drink->name}}"?</p>
                           </div>
                           <div class="modal-footer">
                              <form action="{{route('deleteDrink', $drink)}}" method="post">
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
      There is no drinks in the database
      <a href="{{route('createDrink')}}" class="btn btn-warning">create drink</a>
   </div>
   @endif
</div>
@endsection