$(document).ready(function(){
   $('select[name="type"]').change(function(){
      if($(this).val() == 'ps'){
         $('#ps_input').slideDown();
      }else{
         $('#ps_input').slideUp();
      }
   });
});