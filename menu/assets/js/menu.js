$(document).ready(function(){
    if($('.menu-list-type').length > 0) {
        itemTypes = Object.values(itemTypes);
        $('.menu-list-type a').click(function(){
            const data     = $(this).data('id');
            const type   = $(this).data('type');
            const anchor = $(this).text();

            $('.menu-list-type > .active').removeClass('active');
            $(this).parent().addClass('active');

            changeItemMenu(data, type, anchor);
        });

        $('#menuitemform-uri').change(function(){
            const data     = $(this).val();
            const type   = $(this).data('type');

            changeItemMenu(data, type, false);
        });

        configurateForm();
    }
    
    
    try{
        $("#menuItems-grid .categories, #menuItems-grid .categories_wr").sortable({
            placeholder: "ui-state-highlight",
            forcePlaceholderSize: true,
            forceHelperSize: true,
            axis: "y",
            scrollSensitivity: 10,
            update: function( event, ui ) {
                saveSortable($(this).sortable('toArray',{attribute: 'data-id'}));
            }
        });
        $("#menuItems-grid .categories, #menuItems-grid .categories_wr").disableSelection();

        $("#menuItems-grid .categories, #menuItems-grid .categories_wr").on( "sortstart", function( event, ui ) {
            ui.placeholder.height(ui.item.outerHeight());
        } );
    }
    catch(error){
        console.log(error);
    }
});
function saveSortable(sort){
    let data = new FormData();
    data.append('sort', JSON.stringify(sort));

    $.ajax({
        type: "POST",
        url: URL_SORT,
        data: data,
        dataType: 'json',
        cache: false,
        processData: false,
        contentType: false,
        success: function(response){
            console.log(response);
        },
        error: function(response){
            console.error(response);
        }
    });
}


function changeItemMenu(data, type, anchor){    
    $('#info-id').text(data);
    $('#info-type').text(itemTypes[type]);
    
    $('#menuitem-type').val(type);
    $('#menuitem-data').val(data);
    if(anchor){
        $('#menuitemcontent-name').val(anchor);
    }
}

function activateItemMenu(data, type){
    $('.menu-item-form .nav-item.active').removeClass('active');
    $('.menu-item-form .nav-item[data-type="'+type+'"]').addClass('active');
    
    $('.menu-item-form .tab-pane.active').removeClass(['in', 'active']);
   
    const tanPane = $('.menu-item-form .tab-pane[data-type="'+type+'"]');
    tanPane.addClass(['in', 'active']);
    
    if(type == itemTypes.indexOf('URI')){
        $('#menuitemform-uri').val(data);
    } else {
        tanPane.find('a[data-id="'+data+'"]').parent().addClass('active');
    }
}

function configurateForm(){
    let type = model.type === null? modelDefaultType : model.type;
    
    let data, anchor;
        
    $('.menu-item-form .nav-item[data-type="'+type+'"]').addClass('active');
    
    const tabPane = $('.menu-item-form .tab-pane[data-type="'+type+'"]');
    tabPane.addClass(['in', 'active']);
    
    if(model.type === null){
        let config = defaultConfig();
        data   = config.data;
        type   = config.type;
        anchor = config.anchor;
    } else {
        data   = model.data;
        anchor = model.name;
    }
    
    activateItemMenu(data, type);
    changeItemMenu(data, type, anchor);
}

function defaultConfig(){
    const defaultItem = $('.menu-item-form .tab-pane.active').find('a').eq(0);

    return {
        data: defaultItem.data('id'),
        type: defaultItem.data('type'),
        anchor: defaultItem.text()
    };
}