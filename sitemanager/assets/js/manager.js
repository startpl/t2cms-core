(function() {
    'use strict';
    
    if($('.change-local-zone').length){
        $('.change-local-zone select').change(function(){
            window.location.href = $(this).val();
        });
    }
    
    if($('#_change_domain').length){
        $('#_change_domain').change(function(){
            changeZone('domain', $(this).val(), urlDomainChange);
        });
    }
    
    if($('#_change_langauge').length){
        $('#_change_langauge').change(function(){
            changeZone('language', $(this).val(), urlLanguageChange);
        });
    }

    if($('.setting-delete').length){
        $('.setting-delete').click(function(){
            if(confirm(i18n['confirm'])){
                deleteSetting($(this));
            }
        });
    }
    
    function changeZone(param, value, url){
        let zone = new FormData();
        
        zone.set(param, value);
        
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
            data: zone,
            success: function(response){
                console.log(response);
            },
            error: function(response){
                console.log(response);
            }
        });
    }
    
    function deleteSetting(element){
        $.ajax({
            url: element.data('href'),
            method: 'POST',
            dataType: 'json',
            cache: false,
            success: function(data, textStatus, jqXHR){
                if(data.result){
                    element.closest('.custom-setting-wr').remove();
                }
                else{
                    console.error('Something went wrong');
                }
            },
        });
    }
})();