productAmountSelectorChange = function(productId, delta) {
    let data = ajaxLoad(get('.product-thumb__holder').parentElement, '/product/ajax', 'productAmountSelectorRefresh', {product_id: productId, delta: delta}, function(res) {
        console.log(res)
        triggerEvent(document, 'cart-changed', {totalCost: res.totalCost})
    })

}
