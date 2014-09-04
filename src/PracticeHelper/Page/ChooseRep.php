<?php
namespace PracticeHelper\Page;
use Chiara\PodioApp as A;
class ChooseRep
{
    protected $rep;
    protected $etudes;
    protected $technique;
    function __construct(A $rep, A $etudes, A $technique)
    {
        $this->rep = $rep;
        $this->etudes = $etudes;
        $this->technique = $technique;
    }

    function __toString()
    {
        foreach ($rep->filter as $piece) {
            $ret .= new Button($piece->title, $space->id, 'rep');
        }
        foreach ($etudes->filter as $piece) {
            $ret .= new Button($piece->title, $space->id, 'etudes', 'btn-warning');
        }
        foreach ($technique->filter as $piece) {
            $ret .= new Button($piece->title, $space->id, 'technique', 'btn-info');
        }
    }
}
