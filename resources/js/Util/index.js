function toCents(price) {
    return Math.round(price * 100);
}
function fromCents(price) {
    return Math.round(price) / 100;
}

export function orderProductsTotals(orderProducts) {
    let cost_price = 0;
    let selling_price = 0;
    let vat = 0;
    orderProducts.forEach(orderProduct => {
        cost_price += orderProduct.quantity * toCents(orderProduct.cost_price);
        selling_price += orderProduct.quantity * toCents(orderProduct.selling_price);
        vat += toCents(orderProduct.vat);
    });
    return {cost_price: fromCents(cost_price), selling_price: fromCents(selling_price), vat: fromCents(vat),};
}

export function arrayWithReplacedItem(array, index, item) {
    const copy = array.slice();
    copy.splice(index, 1, item);
    return copy;
}
export function arrayWithRemovedItem(array, index) {
    if (index === -1) { //allow passing in invalid index directly
        return array;
    }
    const copy = array.slice();
    copy.splice(index, 1);
    return copy;
}
