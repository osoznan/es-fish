<?php

namespace App\Admin\Sections;

use SleepingOwl\Admin\Form\FormElements;

trait TSectionValidator {

    private $_foundElementNames = [];

    private function getElementsRecursive(FormElements $form) {
        foreach ($form->getElements() as $element) {
            if (method_exists($element, 'getElements')) {
                $this->getElementsRecursive($element);
            } elseif (method_exists($element, 'getName')) {
                $this->_foundElementNames[] = $element->getName();
            }
        }
    }

    public function attachValidators(FormElements $form, $createRules, $updateRules = []) {
        $this->getElementsRecursive($form);
        foreach ($this->_foundElementNames as $name) {
            if (isset($createRules[$name])) {
                $form->getElement($name)->setValidationRules($createRules[$name]);
            }
        }
    }

}
