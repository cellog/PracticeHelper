<?php
namespace PracticeHelper\Model;
class Base extends \Chiara\PodioItem
{
    function switchModel($appid)
    {
        $structure = $this->structure->duplicateForAnotherApp($appid);
        $this->setStructure($structure);
    }
}