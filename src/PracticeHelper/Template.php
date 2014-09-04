<?php
namespace PracticeHelper;
abstract class Template
{
    abstract function render();
    function __toString()
    {
        return $this->render();
    }
}
