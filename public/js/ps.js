$(document).ready(function(){
   $('.open_ps').click(function(){
      $('form#add_ps').attr('action', $(this).attr('data-url'));
   });

   $('.change_multi').click(function(){
      $('#msg_txt').html('Are you sure you want to ' + $(this).html() + '?');
      $('form#change_ps').attr('action', $(this).attr('data-url'));
   });
   $("#datepicker").datepicker();
   $("#datepicker").datepicker("option", "dateFormat","yy-mm-dd");
});