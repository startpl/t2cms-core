$(document).ready(function(){
    $('#change_langauge').change(function(){
        $.ajax({
            url: $(this).val(),
            type: "GET",
            success: function(response){
                if(response.success) {
                    document.location.reload(true);
                }
            }
        })
    });
});