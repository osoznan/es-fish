<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

trait CrudActions {

    public function remove(Request $request) {
        return $this->modelClass::find($request->post('id'))->delete();
    }

    public function setColumnValue(Request $request) {
        $post = $request->post();
        $column = $post['column'];
        $id = $request->post('ids');

        $request = Request::create('/', 'POST', [$column => $post['value']]);
        $request->validate([
            $column => $this->getValidator('edit', $column),
        ]);

        $model = $this->modelClass::find($id);

        $result = $model->update([$column => $post['value']]);

        if (!$result) {
            return response()->json(['message' => 'Ошибка'], 404);
        }

        return $post['value'];
    }

    public function getValidators() {
        return [];
    }

    public function getValidator($type, $field) {
        try {
            $validators = $this->getValidators()[$type];
        } catch (\Exception $e) {
            return '';
        }

        if (isset($validators[$field])) {
            return $validators[$field];
        }

        return '';
    }

}
