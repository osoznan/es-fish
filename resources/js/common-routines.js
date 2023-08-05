Landing = function() {
    const self = this,
        ajaxHolder = document.querySelector('#ajax-holder'),
        jLoading = document.querySelector('#loading-indicator');


    const cats = getAll('.mainmenu__categories a.nav-link')
    const subCats = getAll('.mainmenu__subcategories div[id*="toggle"]')
    const catsNavItems = getAll('.mainmenu__categories .nav-item a')

    this.showMainMenu = function() {
        get('#leftMenu').classList.add('main-menu_visible')
        get('.main-menu__close').style.opacity = 1
    }

    this.hideMainMenu = function() {
        get('#leftMenu').classList.remove('main-menu_visible')
        get('.main-menu__close').style.opacity = 0
    }

    this.hideSubcatMenu = function() {
        subCats.forEach((curr) => {
            curr.classList.remove('show')
        });
    }

    this.updateCartIndicators = function(v) {
        get('.float-cart__price').innerHTML = get('.top-cart__price').innerHTML = v
        v > 0 ? get('.float-cart').classList.remove('d-none') : get('.float-cart').classList.add('d-none')
    }

    cats.forEach(el => {
        el.addEventListener('click', e => {
            catsNavItems.forEach((curr) => {
                curr.classList.remove('show')
            });

            self.hideSubcatMenu();

            if (el.getAttribute('aria-expanded') == 'true') {
                el.classList.add('show')
            }
        })
    })

    document.addEventListener('click', function(e) {
        const doClickIgnores = getAll('.ignore-on-doc-click.show')

        doClickIgnores.forEach(el => {
            if (!isChildOf(e.target, el)) {
                console.log('убираем ', el)
                el.classList.remove('show')
                for (el of getAll('.mainmenu__categories__anchor')) {
                    el.classList.remove('show')
                }
            }
        });
        console.log(doClickIgnores)
    })

    document.addEventListener('cart-changed', function(data) {
        self.updateCartIndicators(data.data.totalCost)
    })

//     let activateModal = function(url, params, funcOK) {
//         ajax(url, isDefined(params) ? params : {}, function(data) {
//             ajaxHolder.html(data);
//             $('#modal-window').modal();
//             funcOK && funcOK(data);
//         })
//     };
//
//     this.showNotify = function(s) {
//         let notify = $.notify(s, { allow_dismiss: true });
//         notify.update({ type: 'success'}, s);
//         return notify
//     };
//
//     this.showModal = function(url, data, funcOK) {
//         $('.modal-backdrop').remove();
//         activateModal(url, data, funcOK)
//     };
//
//     this.closeModal = function() {
//         $('#modal-window').modal('hide');
//     };
//
//     this.refreshModal = function(url, data, func) {
//         activateModal(url, data, func)
//     };
//
//     this.showBasket = function(data) {
//         if (!isDefined(data)) {
//             data = {ids: JSON.stringify(basket.ids)}
//         }
//         this.showModal('/site/order/basket', data)
//         triggerEvent(document, 'basket_open', data)
//     };
//
//     this.order = function(name, phone) {
//         activateModal('/site/order/order', {ids: JSON.stringify(basket.ids), name: name, phone: phone}, function(data) {
//
//         })
//     };
//
//     this.showGallery = function(data) {
//         this.showModal('/site/site/element_view', {
//             id: data, amount_in_basket: isDefined(basket.ids[data]) ? basket.ids[data] : 0
//         })
//     };
//
//     this.subscribe = function(email) {
//         ajax("/site/site/subscribe", {email: email}, function(data) {
//             $('#block-subscribe-form').html('<span class="display-4">Подписка удачно оформлена</span>')
//         }, function(s) {
//             s = JSON.parse(s.responseText);
//             alert(s[Object.keys(s)[0]])
//         })
//     };
//
};

LazyLoader = function(imgs, containers) {
    this.imgs = imgs, self = this;

    function visible(target) {
        let rect = target.getBoundingClientRect();
        let targetPosition = {
                top: window.pageYOffset + rect.top - 120,
                left: window.pageXOffset + rect.left - 120,
                right: window.pageXOffset + rect.right + 120,
                bottom: window.pageYOffset + rect.bottom + 120
            },
            winPos = {
                top: window.pageYOffset,
                left: window.pageXOffset,
                right: window.pageXOffset + document.documentElement.clientWidth,
                bottom: window.pageYOffset + document.documentElement.clientHeight
            };

        return (targetPosition.bottom > winPos.top && targetPosition.top < winPos.bottom) && (targetPosition.right > winPos.left && targetPosition.left < winPos.right) ? true : false
    }

    this.lazyLoadCheck = function() {
        for (let img of this.imgs) {
            let delay = 11500;

            if (!img.src && visible(img)) {
                if (img.tagName === 'IMG') {
                    setTimeout(function() { img.src = img.getAttribute('data-src') }, Math.random()*1000);
                    img.style.animation = 'fadein ' + delay + 'ms ease-in';
                } else {
                    img.style.backgroundImage = 'url(' + img.getAttribute('data-src') + ')'
                    img.style.animation = 'fadein ' + delay + 'ms ease-in'
                }
            }
        }
    };

    this.addImages = function(images) {

    }

    onScroll = function (e) {
        self.lazyLoadCheck();
    };

    for (let cont of containers) {
        if (cont.addEventListener) {
            cont.addEventListener('scroll', onScroll);
        }
    }

    onScroll();

};

// $("a.navigation-link").on("click", function(e){
//     var anchor = $(this);
//     $('html, body').stop().animate({
//         scrollTop: $(anchor.attr('href')).offset().top - 70
//     }, {
//         duration: 777,
//         easing: 'linear',
//         complete: function() {
//         $('html, body').stop().animate({
//             scrollTop: $(anchor.attr('href')).offset().top - 70
//         }, 200)
//     }});
//     e.preventDefault();
//     return false;
// });
document.addEventListener('DOMContentLoaded', function() {
    lazyLoader = new LazyLoader(
        document.querySelectorAll('img[data-src], div[data-src]'),
        [window]
    );

    document.querySelectorAll('a[href^="#"].scroll-link').forEach(elem => {
        elem.addEventListener('click', e => {
            e.preventDefault();

            document.querySelector(elem.getAttribute('href')).scrollIntoView({
                behavior: 'smooth',
                offsetTop: 20
            });
        });
    });

    landing = new Landing()

    const progress = get('.progress-indicator');

    document.addEventListener('ajax_start', function(e) {
        progress.style.display = ''
    });

    document.addEventListener('ajax_stop', function(e) {
        progress.style.display = 'none'
    });
})
