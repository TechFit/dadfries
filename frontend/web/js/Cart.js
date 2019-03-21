/*global $*/

class Cart {

    constructor (cookie) {

        this.cookie = cookie;

        this.add_to_cart_button = $('.add-to-cart');

        this.product_plus = $('[data-attr="product-buttons"] [data-attr="plus"]');

        this.product_minus = $('[data-attr="product-buttons"] [data-attr="minus"]');

        this.load();

        this.events();
    }

    increaseProductInCart = (event) => {

        let order_item_id = event.target.getAttribute('data-id');

        let order_count_div = $('#product-' + order_item_id).find('[data-attr="product-buttons"]').find('[data-attr="count"]');

        let product_info = this.getInfoAboutProduct(order_item_id);

        let current_count = order_count_div.text();

        current_count = parseInt(current_count) + 1;

        order_count_div.text(current_count);

        this.cookie.updateOrderCookie(order_item_id, current_count, product_info.price, product_info.name, product_info.image);
    };

    decreaseProductInCart = (event) => {

        let order_item_id = event.target.getAttribute('data-id');

        let current_count = $('#product-' + order_item_id).find('[data-attr="product-buttons"]').find('[data-attr="count"]').text();

        let product_info = this.getInfoAboutProduct(order_item_id);

        current_count = parseInt(current_count) - 1;

        $('#product-' + order_item_id).find('[data-attr="product-buttons"]').find('[data-attr="count"]').text(current_count);

        if (current_count === 0) {

            this.cookie.removeFromCookie(order_item_id);

            $('#product-' + order_item_id).find('[data-attr="product-buttons"]').hide();

            $('#add-to-cart-' + order_item_id).show();

        } else {
            this.cookie.updateOrderCookie(order_item_id, current_count, product_info.price, product_info.name, product_info.image);
        }
    };

    addToCart = (event)  => {

        let product_id = event.target.getAttribute('data-id');

        let product_info = this.getInfoAboutProduct(product_id);

        $('#add-to-cart-' + product_id).hide();

        $('#product-' + event.target.getAttribute('data-id')).find('[data-attr="product-buttons"]').show();

        this.increaseProductInCart(event);

        this.cookie.updateOrderCookie(product_id, 1, product_info.price, product_info.name, product_info.image);

    };

    getInfoAboutProduct = (id) => {
        let info = {};

        let product = $('#product-' + id);

        info.name = product.find('.text a').text();

        info.price = product.find('.price span').text();

        info.image = product.find('.menu-img').data('img');

        return info;
    };

    updateTopTotalPrice = (price, command) => {
        if (price) {
            if (command === '+') {

            }
        }
    };

    load = () => {
        let selected_items = this.cookie.currentCookie();

        let current_total_price = 0;

        if (selected_items.length > 0) {
            for (let i in selected_items) {

                let item_id = selected_items[i].item_id;

                let count = selected_items[i].count;

                let price = parseInt(selected_items[i].price);

                current_total_price += price;

                let product = $('#product-' + item_id);

                product.find('#add-to-cart-' + item_id).hide();

                product.find('[data-attr="product-buttons"]').show();

                product.find('[data-attr="product-buttons"] [data-attr="count"]').text(count);
            }
        }

        $('.dp-button-cart__price-block').text(current_total_price + ' p.');
    };

    events () {

        this.add_to_cart_button.on('click', this.addToCart);

        this.product_plus.on('click', this.increaseProductInCart);

        this.product_minus.on('click', this.decreaseProductInCart);

    }
}

