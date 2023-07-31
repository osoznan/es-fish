productAmountSelectorChange = function(productId, delta, amount) {
    let data = ajaxLoad(get(
        '.product-thumb__holder').parentElement,
        '/product/ajax',
        'productAmountSelectorRefresh',
        {product_id: productId, delta: delta, amount: amount},
        function(res) {
            triggerEvent(document, 'cart-changed', {totalCost: res.totalCost})
        }
    )

}
