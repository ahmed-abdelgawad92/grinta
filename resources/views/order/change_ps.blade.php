<div id="change-ps-modal" class="modal fade" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">PS Reservation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <p id="msg_txt"></p>
         </div>
         <div class="modal-footer">
            <form action="" id="change_ps" method="POST">
               @csrf
               <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
               <button class="btn btn-primary">ok</button>
            </form>
         </div>
      </div>
   </div>
</div>