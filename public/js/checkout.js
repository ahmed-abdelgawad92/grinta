$(document).ready(function(){
   
   function calc_discount(){
      var discount = $('input[name="discount"]').val();
      var discount_type = $('select[name="discount_type"] option:selected').val();
      var total = $('.total-price').attr('data-total');

      if (discount_type == 'amount') {
         total = total - discount;
      } else {
         total = total - (total * (discount / 100));
      }
      $('.total-price').html(total + ' LE');
      $('.total-price').attr('data-total-new', total);
   }

   $('#calc-rest').click(function(){
      var paid = $('#paid').val();
      var total = $('.total-price').attr('data-total-new');
      var rest = paid - total;

      if(Number(rest) && rest >= 0){
         $('#rest').html('The rest = ' + rest + ' LE');
      }else {
         $('#rest').html('');
      }
   });

   $('input[name="discount"]').blur(function(){
      calc_discount();
   });

   $('select[name="discount_type"]').change(function(){
      calc_discount();
   });

   $('#payNow').click(function(){
      $('#checkout_form').submit();
   });
});