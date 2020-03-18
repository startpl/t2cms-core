$(document).ready(function(){
    
    $('.menu-list-type a').click(function(){
        changeItemMenu($(this));
    }); 
    
    configurateForm();
});

function changeItemMenu(link){
    const id     = link.data('id');
    const type   = link.data('type');
    const anchor = link.text();
    
    $('#info-id').text(id);
    $('#info-type').text(itemTypes[type]);
    
    $('#menuitemform-type').val(type);
    $('#menuitemform-data').val(id);
    $('#menuitemform-name').val(anchor);
}

function configurateForm(){
    const type = model.type === null? modelDefaultType : model.type;
        
    $('.menu-item-form .nav-item[data-type="'+type+'"]').addClass('active');
    
    const tabPane = $('.menu-item-form .tab-pane[data-type="'+type+'"]');
    tabPane.addClass(['in', 'active']);
    
    const defaultItem = tabPane.find('a').eq(0);
    changeItemMenu(defaultItem);
}