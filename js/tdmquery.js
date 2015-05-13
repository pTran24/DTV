/* global $ */
$("#run").click( function() {
    $.post( $("#tdmForm").attr("action"),
        $("#tdmForm :input").serializeArray(),
        function(info){
            $("#resultC").html(info);
        }
   );
   return false;
});