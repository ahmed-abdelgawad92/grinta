<div id="add-ps-modal" class="modal fade" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">PS Reservation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="" method="POST" id="add_ps">
            <div class="modal-body">
               <div class="form-group">
                  <label class="col-4">Multi</label>
                  <label class="ml-3">
                     <input type="radio" name="multi" value="1">
                     Yes
                  </label>
                  <label class="ml-3">
                     <input type="radio" name="multi" value="0" checked>
                     No
                  </label>
               </div>
            </div>
            <div class="modal-footer">
               @csrf
               <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
               <button class="btn btn-primary">ok</button>
            </div>
         </form>
      </div>
   </div>
</div>