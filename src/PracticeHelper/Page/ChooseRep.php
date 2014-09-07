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
        $ret = '<div class="wide"><h1>Choose what you will practice</h1></div>';
        $ret .= '<h1>Rep/Etudes/Technique</h1><div class="btn-group-vertical">';
        foreach ($this->rep->filter as $piece) {
            $ret .= new Button($piece->title, $piece->id, 'rep');
        }
        foreach ($this->etudes->filter as $piece) {
            $ret .= new Button($piece->title, $piece->id, 'etudes', 'btn-warning');
        }
        foreach ($this->technique->filter as $piece) {
            $ret .= new Button($piece->title, $piece->id, 'technique', 'btn-info');
        }
        $ret .= '</div>';
        return $ret;
    }
}
