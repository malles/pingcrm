

export function orderProductsTotals(orderProducts) {
    let cost_price = 0;
    let selling_price = 0;
    let vat = 0;
    orderProducts.forEach(orderProduct => {
        cost_price += orderProduct.quantity * orderProduct.cost_price;
        selling_price += orderProduct.quantity * orderProduct.selling_price;
        vat += orderProduct.vat;
    });
    return {cost_price, selling_price, vat,};
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
