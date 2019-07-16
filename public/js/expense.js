$(document).ready(function(){
   //delete expense 
   $('.delete-expense-entry').click(function () {
      $('#delete-expense-form').attr('action', '/expenses/delete/' + $(this).attr('data-id'));
   });
});