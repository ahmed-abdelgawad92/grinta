//get the total price of all the items
function totalPrice() {
   var total = 0;
   $('.total-price').each(function () {
      var price = Number($(this).attr('data-price'));
      total += price;
   });
   $('#total-price').html(total + ' LE');
}
//increase the amount of an item if the same item is already ordered
function updateAmount(id){
   return order.map(item => {
      if(item.id == id){
         item.amount++;
      }
      return item;
   });
}
//remove the deleted item from the order
function filterOrders(id){
   return order.filter( item => item.id != id );
}
//define the order array to save the desired items in it 
var order = [];



$(document).ready(function () {
   $('.open_order_modal').click(function () {
      $('#submitOrder').attr('data-order-id', $(this).attr('data-order-id'));
   });

   $('#order').hide();

   //add item to the order
   $('.add-order-item').click(function(){
      if ($('#order').is(":hidden")){
         $('#order').show();
      }
      var name = $(this).html();
      var price = $(this).attr('data-price');
      var id = $(this).attr('data-id');
      var item = $('.order-item[data-id="' + id + '"]');
      if (item.length){
         var amountEL = item.children('.amount');
         var totalPriceEL = item.children('.total-price');
         var amount = Number(amountEL.html()) + 1;
         var price = Number(item.children('.price').attr('data-price'));
         totalPriceEL.attr('data-price', price * amount);
         totalPriceEL.html((price * amount)+ ' LE');
         amountEL.html(amount);
         updateAmount(id);
      }else{
         var item = {
            id: id,
            name: name,
            amount: 1,
            price: price
         };
         order.push(item);
         $('#order-tbody').append(`
            <tr class="order-item" data-id="${id}">
               <td>${name}</td>
               <td class="amount">1</td>
               <td class="price" data-price="${price}">${price} LE</td>
               <td class="total-price" data-price="${price}">${price} LE</td>
               <td class="delete-order" data-id="${id}">&#9003;</td>
            </tr>
         `);
      }
      totalPrice();
   });
   //delete an item from the order
   $('body').on('click', '.delete-order', function(){
      var id = $(this).attr('data-id');
      $('.order-item[data-id="' + id + '"]').remove();
      if(! $('.order-item').length){
         $('#order').hide();
      }
      order = filterOrders(id);
      totalPrice();
   });
   //empty the order array when the modal is closed
   $('#add_to_order').on('hidden.bs.modal', function (e) {
      $('.order-item').remove();
      $('#order').hide();
      $('#order-tbody').html('');
      order = [];
   });

   //submit order 
   $('#submitOrder').click(function(){
      var order_id = $(this).attr('data-order-id');
      $.ajax({
         url: '/orders/item/create',
         method: 'POST',
         data: { 
            order: order,
            '_token': $('input[name="_token"]').val(),
            orderId: order_id
         },
         beforeSend: function(){
            $('#order').hide();
            $('#success').hide();
            $('#error').hide();
            $('#loading').show();
         },
         success: function(data){
            console.log(data);
            
            if(data.status == 'OK'){
               $('#success').show();
               $('#order-tbody').html('');
               order = [];
            }else{
               $('#error').show();
               $('#error').text(data.msg);
               if(order.length > 0){
                  $('#order').show();
               }
            }
            setTimeout(()=>{
               $('#success').hide();
               $('#error').hide();
            }, 4000);
         },
         error: function(data){ 
            $('#error').show();  
            $('#order').show();
         },
         complete: function(){
            $('#loading').hide();
         }
      });
   });

   //delete order 
   $('.delete-order-entry').click(function(){
      $('#delete-order-form').attr('action', '/orders/delete/' + $(this).attr('data-id'));
   });
});