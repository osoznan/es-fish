sendBigCartData = function(data) {
    const el = document.querySelector('.cart .container')
    const newEl = document.createElement('div')

    ajax('/ajax', {action: 'ajaxCartRefresh', data: data}, function(res) {
        const data = JSON.parse(res).original;
        el.innerHTML = data.content
        if (!data.totalCost) {
            document.querySelector('.cart__form').innerHTML = '';
        }

        triggerEvent(document, 'cart-changed', {totalCost: data.totalCost})
    })
}

sendBigCartOrder = function() {
    const el = document.querySelector('.cart__form')

    data = {
        name: el.querySelector('#user_name').value,
        phone: el.querySelector('#user_phone').value,
        delivery_type_id: el.querySelector('#delivery_type_id').value,
        payment_type_id: el.querySelector('#payment_type_id').value
    }

    ajax('order/order', data, function(res) {
        document.querySelector('.cart>.container').innerHTML = ''
        el.innerHTML = res

        landing.updateCartIndicators(0)
    }, function(res) {
        el.querySelectorAll('[id*="-error"]').forEach((f) => f.innerHTML = '')

        for (let [fld, err] of Object.entries(JSON.parse(res.responseText).errors)) {
            el.querySelector('#' + fld + '-error').innerHTML = err
        }
    })
}
