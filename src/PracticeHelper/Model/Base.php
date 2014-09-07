<?php
namespace PracticeHelper\Model;
class Base extends \Chiara\PodioItem
{
    function switchModel($appid)
    {
        $this->MYAPPID = $appid;
        $this->structure = $this->structure->duplicateForAnotherApp($appid);
    }
}