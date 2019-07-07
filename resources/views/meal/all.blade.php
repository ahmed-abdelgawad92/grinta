@extends('layouts.app')
@section('title', 'All meals')
@section('content')
<div class="card-header">All Meals</div>
<div class="card-body">
   @include('shared.success')
   @include('shared.error')
   @if($meals->count()>0)
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
         @foreach ($meals as $meal)
             <tr>
                <td>{{$meal->name}}</td>
                <td>{{$meal->ingredients ?? 'N/A'}}</td>
                <td>{{$meal->category}}</td>
                <td>{{$meal->price}} LE</td>
                <td>{{$meal->created_at->format('d/m/Y')}}</td>
                <td>
                   <a href="{{route('editMeal', $meal)}}" class="btn btn-secondary">edit</a>
                   <button class="btn btn-danger" data-toggle="modal" data-target="#delete-{{$meal->id}}">delete</button>
                   <div id="delete-{{$meal->id}}" class="modal fade" tabindex="-1" role="dialog">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title">Delete</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <div class="modal-body">
                              <p>Are you sure that you want to delete this meal "{{$meal->name}}"?</p>
                           </div>
                           <div class="modal-footer">
                              <form action="{{route('deleteMeal', $meal)}}" method="post">
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
      There is no meals in the database
      <a href="{{route('createMeal')}}" class="btn btn-warning">create meal</a>
   </div>
   @endif
</div>
@endsection