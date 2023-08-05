function isDefined(v) {
    return typeof v !== "undefined" && v !== null;
}

function triggerEvent(el, name, params) {
    let event = new CustomEvent(name);
    event.data = params;

    el.dispatchEvent(event)
}


function strip_tags(s) {
    return s.replace(/(<([^>]+)>)/ig,"");
}

function ajax(url, data, onOK, onError) {
    let xhr = new XMLHttpRequest();

    let queryStr = []
    for (let [key, value] of Object.entries(data)) {
        if (isDefined(value)) {
            if (typeof value == "object") {
                value = JSON.stringify(value)
            }
            queryStr.push(key + '=' + value)
        }
    }

    triggerEvent(document, 'ajax_start', queryStr);

    let resultQueryStr = queryStr.join('&'),
        status

    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content)

    xhr.onload = function () {
        if (xhr.status === 200) {
            if (onOK) {
                triggerEvent(document, 'ajax_success', queryStr);
                onOK(xhr.response);
            }
        } else {
            if (onError) {
                triggerEvent(document, 'ajax_error', queryStr);
                onError(xhr)
            }
        }
        triggerEvent(document, 'ajax_stop', queryStr);
    };
    xhr.send(encodeURI(resultQueryStr));
}

function ajaxLoad(elem, url, action, data, ok) {
    return ajax(url, {action: action, data: data}, function(res) {
        let json
        try {
            json = JSON.parse(res);
        } catch (e) {}
        elem.innerHTML = isDefined(json) ? json.original.content : res

        ok && ok(json.original)
    })
}

function coalesce(v, v1) {
    return isDefined(v) ? v : v1
}

function get(sel, start) {
    if (sel && sel.querySelector) {
        return sel
    }

    if (start) {
        if (!start.querySelector) {
            start = document.querySelector(start)
        }
    } else {
        start = document
    }

    return start.querySelector(sel)
}

function getAll(sel, start) {
    if (sel.querySelector) {
        return sel
    }

    start = start ? start : document
    return start.querySelectorAll(sel)
}

function isChildOf(/*child node*/c, /*parent node*/p){
    while((c=c.parentNode)&&c!==p);
    return !!c;
}

function switchContent(showEl) {
    showEl.classList.remove('d-none');
    document.querySelector(showEl.getAttribute('data-hide')).classList.add('d-none')
}

function attachEvent(el, ev, f) {
    let elems = getAll(el)
    let array = Array.from(elems)

    console.log(elems, array)

    if (array.length) {
        getAll('.star-rating__off').forEach(function (el) {
            el.addEventListener(ev, f)
        })
    } else {
        elems.addEventListener(ev, f)
    }

    get(el).addEventListener(ev, f)
}

function importJs(uri, onload) {
    for (let el of document.querySelectorAll('script')) {
        let src = el.src.replace(location.origin, '')
        if (src == uri) {
            onload && onload()
            return false;
        }
    }
    // создаем новый тег script
    let script = document.createElement('script');
    // устанавливаем тип и uri
    script.src  = uri;
    script.onload = onload
    // загружаем скрипт в тег head
    document.body.appendChild(script)
 }

 function setLocale(lang) {
    ajax('/site/site/set-locale', {lang: lang}, function() {
        window.location.reload();
     })
 }

 function t(s) {
     return siteData.translates[s]
 }

function shortenWithDots(s, maxLen) {
    if (!s) { return }
    if (s.length <= maxLen) {
        return s
    }
    return s.substring(0, maxLen - 1) + '...'
}
