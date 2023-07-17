<?php

namespace App\Admin\Sections;

use SleepingOwl\Admin\Form\FormElements;

trait TSectionValidator {

    private $_foundElementNames = [];

    private function walkElementsRecursive(FormElements $form): void {
        foreach ($form->getElements() as $element) {
            if (method_exists($element, 'getElements')) {
                $this->walkElementsRecursive($element);
            } elseif (method_exists($element, 'getName')) {
                $this->_foundElementNames[] = $element->getName();
            }
        }
    }

    public function attachValidators(FormElements $form, $createRules, $updateRules = []): void {
        $this->walkElementsRecursive($form);
        foreach ($this->_foundElementNames as $name) {
            if (isset($createRules[$name])) {
                $form->getElement($name)->setValidationRules($createRules[$name]);
            }
        }
    }

}
