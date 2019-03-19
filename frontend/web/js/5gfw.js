let add_to_cart_button = $('.add-to-cart');

// $.cookie("order", [], {expires: 1, path: '/'});

add_to_cart_button.on('click', function () {

    $(this).hide();

    console.log($(this).attr('data-id'));


    $('#product-' + $(this).attr('data-id') + ' [data-attr="product-buttons"]').show();

    $('#product-' + $(this).attr('data-id') + ' [data-attr="product-buttons"] ' + '[data-attr="count"]').val(1);

    let current_order = $.cookie('order').split(',');

    current_order.push({'id' : 3});

    // $.cookie("order", current_order, {expires: 1, path: '/'});

    console.log(current_order);

});