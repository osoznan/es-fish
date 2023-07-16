<?php
/**
 * User: Zemlyansky Alexander <astrolog@online.ua>
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

trait AjaxController {
    private $_handlers = [];

    public function actionAjax(Request $request) {
        if ($request->ajax()) {
            $data = $request->post();

            $action = $data['action'];
            $method = "_ajax" . ucfirst($action);

            if (method_exists($this, $method)) {
                return response()->json(
                    call_user_func_array([$this, $method], [$request, json_decode($data['data'], 1)] ?? null)
                );
            } elseif (isset($this->_handlers[$action])) {
                return response()->json(
                    call_user_func_array([$this->_handlers[$action], ucfirst($action)], [$request, json_decode($data['data'], 1)] ?? null)
                );
            } else {
                die('method ' . $method . 'doesn\'t exist');
            }
        } else {
            throw new \Exception('access error');
        }
        die();
    }

    function registerAjaxHandler($handlerClass) {
        foreach ($handlerClass::getAjaxHandlers() as $method) {
            if (1 || $this->isHandlerMethodProcessable($handlerClass, $method)) {
                $this->_handlers[$method] = $handlerClass;
                //$handlerClass::init();
            } else {
                //если это уже зареганный метод, того же самого класса, просто нужно пропустить
                if (isset($this->_handlers[$method]) && $this->_handlers[$method] == $handlerClass) {
                    continue;
                } else {
                    throw new \Exception("Only one handler is possible on the action. Action: " . $method);
                }
            }
        }

        foreach ($handlerClass::getRegisteredAjaxClasses() as $class) {
            $this->registerAjaxHandler($class);
        }

    }
}
