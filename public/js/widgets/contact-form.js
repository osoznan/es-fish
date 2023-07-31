ContactForm = function(id) {
    const form = get(id);
    const self = this

    this.sendContactForm = function(){
        const formData = new FormData(form);
        const data = {}

        for (let [k, v] of formData.entries()) {
            data[k] = v
        }

        getAll('.form__error-label', form).forEach((el) => {
            el.innerHTML = ''
        });

        ajax('/ajax', {action: 'contactFormSend', data: data}, function () {
            switchContent(get('.contact-form__success', form))
            triggerEvent(form, 'success')
        }, function (err) {
            for (let [k, v] of Object.entries(JSON.parse(err.responseText).errors)) {
                let fErr = get('.form__error-label[data-name="' + k + '"]', form)
                fErr.innerHTML = v
            }
        })
    }

    this.setContext = function(v) {
        get('input[name="context"]', form).value = v
    }

    this.addEventListener = function(e, f) {
        form.addEventListener(e, f)
    }

    attachEvent(get('.contact-form__send', form), 'click', function() {
        self.sendContactForm()
    })
}
