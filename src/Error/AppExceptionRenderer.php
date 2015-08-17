<?php

namespace App\Error;

use Cake\Error\ExceptionRenderer;

class AppExceptionRenderer extends ExceptionRenderer
{

    public function missingWidget($error)
    {
        return 'Oops that widget is missing!';
    }

    protected function _getController($exception)
    {
        return new SuperCustomErrorController();
    }

    protected function _outputMessage($template)
    {
        $this->layout = "Error";
        parent::_outputMessage($template);
    }
    public function render()
    {$this->layout = "Error";
        parent::render();
    }

}
