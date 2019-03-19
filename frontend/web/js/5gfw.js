let add_to_cart_button = $('.add-to-cart');

let product_plus = $('[data-attr="product-buttons"] [data-attr="plus"]');

// $.cookie("order", null, { path: '/' });
// $.cookie("order", [], {expires: 1, path: '/'});

add_to_cart_button.on('click', function () {

    $(this).hide();

    increaseOrder($(this).data('id'));

    $('#product-' + $(this).data('id')).find('[data-attr="product-buttons"]').show();

    console.log($.cookie("order"));
});

product_plus.on('click', function () {

    console.log($(this));

    increaseOrder($(this).parent('[data-attr="product-buttons"]').data('id'));

});


function increaseOrder(order_id) {

    let current_count = $('#product-' + order_id).find('[data-attr="product-buttons"]').find('[data-attr="count"]').text();

    current_count = parseInt(current_count) + 1;

    console.log(current_count);

    $('#product-' + order_id).find('[data-attr="product-buttons"]').find('[data-attr="count"]').text(current_count);

    let current_order = JSON.parse($.cookie('order'));

    $.cookie('order', JSON.stringify({'id' : order_id, 'count' : current_count}));

    console.log(JSON.parse($.cookie('order')));

}

console.log(JSON.parse($.cookie('order')));
