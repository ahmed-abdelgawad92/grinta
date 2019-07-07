<div id="add_to_order" class="modal fade" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Add item to the order</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-5" style="border-right: 1px solid #eee;">
                  <div>
                     <h5 class="text-center">Drinks</h5>
                     @php $lastCategory = ''; @endphp
                     @foreach($drinks as $drink)
                     @if ($lastCategory != $drink->category)
                     @php $lastCategory = $drink->category; @endphp
                     <h5 class="mt-2">{{$lastCategory}}</h5>
                     @endif    
                     <div class="btn btn-outline-dark m-1 add-order-item"
                          data-id="drink_{{$drink->id}}"
                          data-price="{{$drink->price}}">{{$drink->name}}</div>
                     @endforeach
                  </div>
                  <hr>
                  <div>
                     <h5 class="text-center">Meals</h5>
                     @php $lastCategory = ''; @endphp
                     @foreach($meals as $meal)
                     @if ($lastCategory != $meal->category)
                     @php $lastCategory = $meal->category; @endphp
                     <h5 class="mt-2">{{$lastCategory}}</h5>
                     @endif    
                     <div class="btn btn-outline-dark m-1 add-order-item"
                          data-id="meal_{{$meal->id}}"
                          data-price="{{$meal->price}}">{{$meal->name}}</div>
                     @endforeach
                  </div>
               </div>
               <div class="col-7">
                  <h5 class="text-center">Order</h5>
                  <div class="alert alert-success" style="display: none;" id="success">
                     Order is successfully created!
                  </div>
                  <div class="alert alert-danger" style="display: none;" id="error">
                     Something went wrong on server please try again
                  </div>
                  <div id="loading"><img src="{{asset('images/loading.gif')}}" alt=""></div>
                  <div id="order">
                     <table class="table table-striped">
                        <thead>
                           <tr>
                              <th>name</th>
                              <th>amount</th>
                              <th>price</th>
                              <th>total price</th>
                              <th style="width: 10px;">*</th>
                           </tr>
                        </thead>
                        <tbody id="order-tbody">
                        </tbody>
                        <tfoot>
                           <tr>
                              <th colspan="3">Total</th>
                              <th id="total-price" colspan="2">0 LE</th>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            @csrf
            <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
            <button type="button" class="btn btn-primary" id="submitOrder">add</button>
         </div>
      </div>
   </div>
</div>