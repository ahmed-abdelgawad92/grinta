$(document).ready(function(){
   $('#calc-rest').click(function(){
      var paid = $('#paid').val();
      var total = $('.total-price').attr('data-total-new');
      var rest = parseFloat(paid - total);

      if(Number(rest) && rest >= 0){
         $('#rest').html('The rest = ' + rest + ' LE');
      }else {
         $('#rest').html('');
      }
   });

   $('input[name="discount"]').blur(function(){
      var discount = $('input[name="discount"]').val();
      var total = $('.total-price').attr('data-total');

      if (discount) {
         total = total - discount;
      }

      $('.total-price').html(total + ' LE');
      $('.total-price').attr('data-total-new', total);
   });

   $('#payNow').click(function(){
      $('#checkout_form').submit();
   });

   //delete order 
   $('.delete-order-item').click(function () {
      $('#delete-order-item-form').attr('action', '/orders/item/delete/' + $(this).attr('data-id'));
   });
});