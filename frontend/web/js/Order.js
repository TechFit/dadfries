class Order {
    constructor (cookie) {
        this.cookie = cookie;

        let products = [];

        for (let i in cookie.currentCookie()) {
            products.push(cookie.currentCookie()[i].item_id);
        }

        if (products.length > 0) {
            $('#orderform-products').val(cookie);
        }
    }
}