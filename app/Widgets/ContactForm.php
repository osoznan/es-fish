<?php

namespace App\Widgets;

use App\Components\helpers\Form;
use App\Components\helpers\Mail;
use App\Components\helpers\Telegram;
use App\Components\ViewInserter;
use App\Components\Widget;
use Illuminate\Http\Request;

class ContactForm extends Widget {
    use AjaxWidget;

    const CAPTCHA_VAR = 'captcha-check-num';
    public $id;

    public static function getAjaxHandlers() {
        return ['contactFormSend'];
    }

    public function run() {
        $rand1 = random_int(0, 9);
        $rand2 = random_int(0, 9);

        $this->id = $this->id ?? 'contact-form';

        $_SESSION[static::CAPTCHA_VAR] = $rand1 + $rand2;

        echo view('widgets.contact-form', [
            'id' => $this->id,
            'captchaQuestion' => "$rand1 + $rand2 = ?"
        ])

        ?>

        <?php

        $this->addScripts();
    }

    public static function contactFormSend(Request $request, $data) {
        $request = Request::create('games/result', 'POST', $data);

        $validator = $request->validate([
            'name' => 'required|min:3|max:30',
            'phone' => 'required|min:10|max:16',
            'message' => 'required|min:10|max:3000',
            'description' => 'required'
        ]);

/*        Mail::sendMailToAdmin('Обратная связь',
            "Имя: {$data['name']}<P>Телефон: {$data['phone']}<P>Сoобщение: {$data['message']}<P>Дополнительно: {$data['context']}"
        );*/

        Telegram::send("Имя: {$data['name']}\nТелефон: {$data['phone']}\nСoобщение: {$data['message']}\nДополнительно: {$data['context']}");

        return response()->json(['hello' => 1]);
    }

    private function addScripts() {
        ViewInserter::insertJs(<<< JS
        ContactForm = function(id) {
            const form = get(id)
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
JS, static::class);

        ViewInserter::insertJs('get("#' . $this->id . '").ContactForm = new ContactForm("#' . $this->id . '")', static::class . $this->id);
    }

}
