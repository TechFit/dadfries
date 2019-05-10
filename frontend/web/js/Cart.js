/*global $*/

class Cart {

    constructor (cookie) {

        console.log(this);
        
        this.cookie = cookie;

        this.cart_button = $('.dp-button-cart__price-block');
        
        this.add_to_cart_button = $('.add-to-cart');

        this.product_plus = $(document).find('[data-attr="product-buttons"] [data-attr="plus"]');

        this.product_minus = $(document).find('[data-attr="product-buttons"] [data-attr="minus"]');

        this.load();

        this.events();

        let self = this;

        $(window).on('resize', function(){
            self.transferCart();
        });
    };

    increaseProductInCart (event) {

        let order_item_id = event.target.getAttribute('data-id');

        let order_count_div = $('#product-' + order_item_id).find('[data-attr="product-buttons"]').find('[data-attr="count"]');

        let order_count_top_div = $('.dc__cart-card-item[data-top-cart-id="' + order_item_id + '"]');

        let product_info = this.getInfoAboutProduct(order_item_id);

        let current_count = order_count_div.text();

        current_count = parseInt(current_count) + 1;

        order_count_div.text(current_count);

        order_count_top_div.find('.dp-circle-btn.mid').text(current_count);

        let price = parseInt(product_info.price) * current_count;

        order_count_top_div.find('.dc_cart-card-content__price-block-nums').text(price);

        this.updateTopTotalPrice(product_info.price, '+');

        this.cookie.updateOrderCookie(order_item_id, current_count, product_info.price, product_info.name, product_info.image);
    };

    decreaseProductInCart (event) {

        let order_item_id = event.target.getAttribute('data-id');

        let current_count = $('#product-' + order_item_id).find('[data-attr="product-buttons"]').find('[data-attr="count"]').text();

        let product_info = this.getInfoAboutProduct(order_item_id);

        let order_count_top_div = $('.dc__cart-card-item[data-top-cart-id="' + order_item_id + '"]');

        current_count = parseInt(current_count) - 1;

        order_count_top_div.find('.dp-circle-btn.mid').text(current_count);

        $('#product-' + order_item_id).find('[data-attr="product-buttons"]').find('[data-attr="count"]').text(current_count);

        let price = parseInt(product_info.price) * current_count;

        order_count_top_div.find('.dc_cart-card-content__price-block-nums').text(price);

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

    addToCart (event) {

        console.log(this);

        let product_id = event.target.getAttribute('data-id');

        let product_info = this.getInfoAboutProduct(product_id);

        $('#add-to-cart-' + product_id).hide();

        $('#product-' + event.target.getAttribute('data-id')).find('[data-attr="product-buttons"]').show();

        this.increaseProductInCart(event);

        this.insertItemToTopCart(product_id, product_info.name, product_info.price, 1);

        this.cookie.updateOrderCookie(product_id, 1, product_info.price, product_info.name, product_info.image);

    };

    removeItemFromTopCart (id) {

        this.cookie.removeFromCookie(id);

        $('#product-' + id).find('[data-attr="product-buttons"]').hide();

        $('#add-to-cart-' + id).show();

        let price = parseInt($("[data-top-cart-id='" + id + "']").find('.dc_cart-card-content__price-block-nums').text());

        let product = $(document.body).find('#product-' + id);

        product.find('[data-attr="product-buttons"] [data-attr="count"]').text(0);

        this.updateTopTotalPrice(price, '-');

        $("[data-top-cart-id='" + id + "']").closest('.dc__cart-card-item').remove();
    };

    getInfoAboutProduct (id) {
        let info = {};

        let product = $(document.body).find('#product-' + id);

        info.name = product.find('.text a').text();

        info.price = parseInt(product.find('.price span').text());

        info.image = product.find('.menu-img').data('img');

        return info;
    };

    updateTopTotalPrice (price, command) {

        let current_total_price = parseInt($('.dp-button-cart__price-block .total').text());

        console.log(current_total_price);

        price = parseInt(price);

        if (price) {
            if (command === '+') {
                current_total_price = current_total_price + price;
            } else if (command === '-') {
                current_total_price = current_total_price - price;
                if (current_total_price < 0) {
                    current_total_price = 0;
                }
            }
        }

        $('.dp-button-cart__price-block .total').text(current_total_price);

        $('.dp-cart__items-total-price span').text(current_total_price);

    };

    insertItemToTopCart (id, name, price, count) {

        let item = "" +
            "<div class=\"dc__cart-card-item\"  data-top-cart-id="+id+">\n" +
            " <div class=\"dc__cart-card-close\" data-top-cart-id="+id+"></div>\n" +
            "  <div class=\"dc__cart-card-content\">\n" +
            "  <p class=\"dc_cart-card-content__title\">" + name + "</p>\n" +
            "   <div class=\"dc_cart-card-content__qty-price\">\n" +
            "   <div class=\"dc_cart-card-content__qty-block\">\n" +
            "    <div class=\"dp-product-details__count-switcher dp-count-switcher\">\n" +
            "       <button class=\"dp-circle-btn minus\" data-id="+id+">\n" +
            "         -\n" +
            "       </button>\n" +
            "    <span class=\"dp-circle-btn own-color mid\">" + count +"</span>\n" +
            "     <button class=\"dp-circle-btn plus\" data-id="+id+">\n" +
            "     +\n" +
            "    </button>\n" +
            "    </div>\n" +
            "   </div>\n" +
            "  <div class=\"dc_cart-card-content__price-block\">\n" +
            " <span class=\"dc_cart-card-content__price-block-nums\">" + parseInt(price) * count + "</span>\n" +
            "  <span> .p</span>\n" +
            "  </div>\n" +
            "   </div>\n" +
            "   </div>\n" +
            "</div>";

        $('.dp-cart__items-list').prepend(item);
    };

    load () {
        
        console.log(this);
        
        let selected_items = this.cookie.currentCookie();

        let current_total_price = 0;

        if (selected_items !== 'undefined' || Object.entries(selected_items).length !== 0) {

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

        $('.dp-button-cart__price-block .total').html(current_total_price);

        $('.dp-cart__items-total-price span').html(current_total_price);

        this.transferCart();
    };

    transferCart () {

        if ($(window).width() < 1024) {
            $(".dp-header__item.no-ma").after("").insertAfter("#ftco-navbar > .container > .navbar-brand");
        }
        else {
            $(".dp-header__item.no-ma").after("").appendTo("#ftco-nav > .navbar-nav li.nav-item:nth-child(3)");
        }
    };

    events () {

        this.add_to_cart_button.on('click', this.addToCart.bind(this));

        this.product_plus.on('click', this.increaseProductInCart.bind(this));

        $(document.body).on('click', '.dp-product-details__count-switcher .plus',this.increaseProductInCart.bind(this));

        this.product_minus.on('click', this.decreaseProductInCart.bind(this));

        $(document.body).on('click', '.dp-product-details__count-switcher .minus', this.decreaseProductInCart.bind(this));

        let self = this;

        $(document.body).on('click', '.dc__cart-card-close', function (element) {
            self.removeItemFromTopCart($(this).attr('data-top-cart-id'));
        });

        $('.ftco-menu .tab-content a').click(false);

        // $(window).click(function(e) {
        //     console.log(e); // then e.srcElement.className has the class
        // });

        $(document).mouseup(function(e)
        {
            var container = $('.ReactCollapse--collapse');

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0)
            {
                $('.ReactCollapse--collapse').css("height", "");
                $('.ReactCollapse--collapse').slideUp('fast');
                $('.dp-cart-item').removeClass('dp-cart-item--opened');
            }
        });

        this.cart_button.on('click', function () {

            if ($('.ReactCollapse--collapse').is(':visible')) {
                $('.ReactCollapse--collapse').css("height", "");
                $('.ReactCollapse--collapse').slideUp('fast');
                $('.dp-cart-item').removeClass('dp-cart-item--opened');
            } else {

                if ($('.dc__cart-card-item').length > 4) {
                    $('.dp-cart__items-list').css("height", "400px");
                    $('.dp-cart__items-list').css("overflow-y", "scroll");
                } else {
                    $('.ReactCollapse--collapse').css("height", "auto");
                }

                $('.dp-cart-item').addClass('dp-cart-item--opened');
                $('.ReactCollapse--collapse').slideDown('fast');

            }
        });

    }
}

