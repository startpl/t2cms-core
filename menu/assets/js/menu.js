$(document).ready(function(){
    
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
});

function changeItemMenu(data, type, anchor){    
    $('#info-id').text(data);
    $('#info-type').text(itemTypes[type]);
    
    $('#menuitem-type').val(type);
    $('#menuitem-data').val(data);
    $('#menuitemcontent-name').val(anchor);
}

function activateItemMenu(data, type, anchor){
    
}

function configurateForm(){
    let type = model.type === null? modelDefaultType : model.type;
        
    $('.menu-item-form .nav-item[data-type="'+type+'"]').addClass('active');
    
    const tabPane = $('.menu-item-form .tab-pane[data-type="'+type+'"]');
    tabPane.addClass(['in', 'active']);
    
    if(model.type === null){
        let {data, type, anchor} = defaultConfig();
    } else {
        let data   = model.data;
        let anchor = model.itemContent.name;
    }
    activateItemMenu(data, type, anchor);
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