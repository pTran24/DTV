/* global $ */
$("#sub").click( function() {
    $.post( $("#tdmForm").attr("action"),
        $("#tdmForm :input").serializeArray(),
        function(info){
//            $("#result").html(info);
        }
   );
});