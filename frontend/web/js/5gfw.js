/*global $*/



// $.cookie("order", null, { path: '/' });
// $.cookie("order", [], {expires: 1, path: '/'});
//
// add_to_cart_button.on('click', function () {
//
//     $(this).hide();
//
//     increaseOrder($(this).data('id'));
//
//     $('#product-' + $(this).data('id')).find('[data-attr="product-buttons"]').show();
//
//     console.log($.cookie("order"));
// });
//
// product_plus.on('click', function () {
//
//     console.log($(this));
//
//     increaseOrder($(this).parent('[data-attr="product-buttons"]').data('id'));
//
// });
//
//
// function increaseOrder(order_id) {
//
//     let current_count = $('#product-' + order_id).find('[data-attr="product-buttons"]').find('[data-attr="count"]').text();
//
//     current_count = parseInt(current_count) + 1;
//
//     console.log(current_count);
//
//     $('#product-' + order_id).find('[data-attr="product-buttons"]').find('[data-attr="count"]').text(current_count);
//
//     let current_order = JSON.parse($.cookie('order'));
//
//     current_order.order_id = current_count;
//
//     $.cookie('order', JSON.stringify(current_order));
//
//     console.log(JSON.parse($.cookie('order')));
//
// }
//
// console.log(JSON.parse($.cookie('order')));


class Cart {

    constructor () {

        this.add_to_cart_button = $('.add-to-cart');

        this.product_plus = $('[data-attr="product-buttons"] [data-attr="plus"]');

        this.product_minus = $('[data-attr="product-buttons"] [data-attr="minus"]');

        this.events();
    }

    increaseProductInCart(event) {
        console.log(event.target.getAttribute('data-id'));
        $(this).hide();
        $('#product-' + event.target.getAttribute('data-id')).find('[data-attr="product-buttons"]').show();
    }

    decreaseProductInCart(event) {
        console.log(event.target.getAttribute('data-id'));
    }

    events () {

        this.add_to_cart_button.on('click', this.increaseProductInCart);

        this.product_plus.on('click', this.increaseProductInCart);

        this.product_minus.on('click', this.decreaseProductInCart);

    }
}

let cart = new Cart();
