class Cookie {

    constructor() {
    }

    static get ORDER_TYPE() {
        return 'order';
    }

    currentCookie = () => {
        if ($.cookie(Cookie.ORDER_TYPE) && $.cookie(Cookie.ORDER_TYPE) !== "") {
            return JSON.parse($.cookie(Cookie.ORDER_TYPE));
        } else {
            return this.setCookie({});
        }
    };

    updateOrderCookie = (item_id, count, price, name, image)  => {

        let current_cookie_order = this.currentCookie();

        if (Object.entries(current_cookie_order).length === 0 || current_cookie_order === null || current_cookie_order === "") {

            current_cookie_order = [];

            current_cookie_order.push({'item_id': item_id, 'count': count, 'price': price, 'name': name, 'image': image});

            this.setCookie(current_cookie_order);

        } else {

            for (let i in current_cookie_order) {
                if (current_cookie_order[i].item_id === item_id) {
                    current_cookie_order[i].count = count;
                    $.cookie(Cookie.ORDER_TYPE, JSON.stringify(current_cookie_order));
                    return;
                }
            }

            current_cookie_order.push({'item_id': item_id, 'count': count, 'price': price, 'name': name, 'image': image});

            this.setCookie(current_cookie_order);
        }
    };

    removeFromCookie = (id) => {

        let current_cookie_order = this.currentCookie();

        for (let i in current_cookie_order) {

            if (current_cookie_order[i].item_id === id) {

                current_cookie_order.splice(i, 1);

                this.setCookie(current_cookie_order);

                return;
            }
        }
    };

    setCookie = (data) => {
        $.cookie(Cookie.ORDER_TYPE, JSON.stringify(data), {expires: 1, path: '/'});
    }
}

