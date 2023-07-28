<?php

namespace App\Widgets;

use App\Facades\Telegram;
use App\Components\ViewInserter;
use App\Components\Widget;
use App\Http\Requests\ContactFormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactForm extends Widget {
    use AjaxWidget;

    const CAPTCHA_VAR = 'captcha-check-num';
    public $id;

    public static function getAjaxHandlers(): array {
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

    public static function contactFormSend(Request $request, $data): JsonResponse {
        $validationRequest = new ContactFormRequest();
        Validator::validate(
            json_decode($request->all()['data'], 1),
            $validationRequest->rules(),
            $validationRequest->messages(),
            $validationRequest->attributes()
        );

/*        Mail::sendMailToAdmin('Обратная связь',
            "Имя: {$data['name']}<P>Телефон: {$data['phone']}<P>Сoобщение: {$data['message']}<P>Дополнительно: {$data['context']}"
        );*/

        Telegram::sendToManager(
            "Новое обращение с контакт-формы\n" .
            "Имя: {$data['name']}\nТелефон: {$data['phone']}\nСoобщение: {$data['message']}\nДополнительно: {$data['context']}"
        );

        return response()->json(['hello' => '1']);
    }

    private function addScripts() {
        ViewInserter::insertJsFile('/js/widgets/contact-form.js', static::class);

        ViewInserter::insertJs('get("#' . $this->id . '").ContactForm = new ContactForm("#' . $this->id . '")', static::class . $this->id);
    }

}
