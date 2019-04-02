/*global $*/

class Cart {

    constructor (cookie) {

        this.cookie = cookie;

        this.add_to_cart_button = $('.add-to-cart');

        this.product_plus = $(document).find('[data-attr="product-buttons"] [data-attr="plus"]');

        this.product_minus = $(document).find('[data-attr="product-buttons"] [data-attr="minus"]');

        this.load();

        this.events();
    }

    increaseProductInCart = (event) => {

        let order_item_id = event.target.getAttribute('data-id');

        let order_count_div = $('#product-' + order_item_id).find('[data-attr="product-buttons"]').find('[data-attr="count"]');

        let order_count_top_div = $('.dp-cart__items-list').find('[data-id="' + order_item_id + '"]');

        let product_info = this.getInfoAboutProduct(order_item_id);

        let current_count = order_count_div.text();

        current_count = parseInt(current_count) + 1;

        order_count_div.text(current_count);

        order_count_top_div.find('.dp-circle-btn.red.mid').text(current_count);

        console.log(order_count_top_div.find('.dp-circle-btn.red.mid'));

        let price = parseInt(product_info.price) * current_count;

        this.updateTopTotalPrice(product_info.price, '+');

        this.cookie.updateOrderCookie(order_item_id, current_count, product_info.price, product_info.name, product_info.image);
    };

    decreaseProductInCart = (event) => {

        let order_item_id = event.target.getAttribute('data-id');

        let current_count = $('#product-' + order_item_id).find('[data-attr="product-buttons"]').find('[data-attr="count"]').text();

        let product_info = this.getInfoAboutProduct(order_item_id);

        current_count = parseInt(current_count) - 1;

        $('#product-' + order_item_id).find('[data-attr="product-buttons"]').find('[data-attr="count"]').text(current_count);

        this.updateTopTotalPrice(product_info.price, '-');

        if (current_count === 0) {

            this.cookie.removeFromCookie(order_item_id);

            $('#product-' + order_item_id).find('[data-attr="product-buttons"]').hide();

            $("[data-top-cart-id='" + order_item_id + "']").closest('.dc__cart-card-item').remove();

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

        this.insertItemToTopCart(product_id, product_info.name, product_info.price, 1);

        this.cookie.updateOrderCookie(product_id, 1, product_info.price, product_info.name, product_info.image);

    };

    removeItemFromTopCart = (id) => {

        this.cookie.removeFromCookie(id);

        $("[data-top-cart-id='" + id + "']").closest('.dc__cart-card-item').remove();
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

        let current_total_price = parseInt($('.dp-button-cart__price-block .total').text());

        price = parseInt(price);

        if (price) {
            if (command === '+') {
                current_total_price += price;
            } else if (command === '-') {
                current_total_price -= price;
                if (current_total_price < 0) {
                    current_total_price = 0;
                }
            }
        }

        $('.dp-button-cart__price-block .total').text(current_total_price);

        $('.dp-cart__items-total-price span').text(current_total_price);

    };

    insertItemToTopCart = (id, name, price, count) => {
        let item = "" +
            "<div class=\"dc__cart-card-item\">\n" +
            " <div class=\"dc__cart-card-close\" data-top-cart-id="+id+"></div>\n" +
            "  <div class=\"dc__cart-card-content\">\n" +
            "  <p class=\"dc_cart-card-content__title\">" + name + "</p>\n" +
            "   <div class=\"dc_cart-card-content__qty-price\">\n" +
            "   <div class=\"dc_cart-card-content__qty-block\">\n" +
            "    <div class=\"dp-product-details__count-switcher dp-count-switcher\">\n" +
            "       <button class=\"dp-circle-btn minus\" data-id="+id+">\n" +
            "         <svg xmlns=\"http://www.w3.org/2000/svg\" x=\"0px\" y=\"0px\" viewBox=\"0 0 491.858 491.858\">\n" +
            "            <path d=\"M465.167,211.613H240.21H26.69c-8.424,0-26.69,11.439-26.69,34.316s18.267,34.316,26.69,34.316h213.52h224.959 c8.421,0,26.689-11.439,26.689-34.316S473.59,211.613,465.167,211.613z\"></path>\n" +
            "         </svg>\n" +
            "       </button>\n" +
            "    <span class=\"dp-circle-btn red mid\">" + count +"</span>\n" +
            "     <button class=\"dp-circle-btn plus\" data-id="+id+">\n" +
            "     <svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\">\n" +
            "        <path d=\"m23,10h-8.5c-0.3,0-0.5-0.2-0.5-0.5v-8.5c0-0.6-0.4-1-1-1h-2c-0.6,0-1,0.4-1,1v8.5c0,0.3-0.2,0.5-0.5,0.5h-8.5c-0.6,0-1,0.4-1,1v2c0,0.6 0.4,1 1,1h8.5c0.3,0 0.5,0.2 0.5,0.5v8.5c0,0.6 0.4,1 1,1h2c0.6,0 1-0.4 1-1v-8.5c0-0.3 0.2-0.5 0.5-0.5h8.5c0.6,0 1-0.4 1-1v-2c0-0.6-0.4-1-1-1z\"></path>\n" +
            "     </svg>\n" +
            "    </button>\n" +
            "    </div>\n" +
            "   </div>\n" +
            "  <div class=\"dc_cart-card-content__price-block\">\n" +
            " <span class=\"dc_cart-card-content__price-block-nums\">" + price + "</span>\n" +
            "  <span> .p</span>\n" +
            "  </div>\n" +
            "   </div>\n" +
            "   </div>\n" +
            "</div>";

        $('.dp-cart__items-list').prepend(item);
    };

    load = () => {
        let selected_items = this.cookie.currentCookie();

        let current_total_price = 0;

        if (selected_items.length > 0) {

            for (let i in selected_items) {

                if (!selected_items[i].item_id || selected_items[i].item_id === "" || selected_items[i].item_id === null) {
                    continue;
                }

                let item_id = selected_items[i].item_id;

                let count = selected_items[i].count;

                let name = selected_items[i].name;

                let price = parseInt(selected_items[i].price);

                current_total_price += (price * count);

                let product = $('#product-' + item_id);

                product.find('#add-to-cart-' + item_id).hide();

                product.find('[data-attr="product-buttons"]').show();

                product.find('[data-attr="product-buttons"] [data-attr="count"]').text(count);

                this.insertItemToTopCart(item_id, name, price, count);

            }
        }

        $('.dp-button-cart__price-block .total').text(current_total_price);

        $('.dp-cart__items-total-price span').text(current_total_price);
    };

    events () {

        this.add_to_cart_button.on('click', this.addToCart);

        this.product_plus.on('click', this.increaseProductInCart);

        $('.dp-circle-btn.plus').on('click', this.increaseProductInCart);

        this.product_minus.on('click', this.decreaseProductInCart);

        $('.dp-circle-btn.minus').on('click', this.decreaseProductInCart);

        let self = this;

        $('.dc__cart-card-close').on('click', function (element) {
            self.removeItemFromTopCart($(this).attr('data-top-cart-id'));
        })

    }
}

