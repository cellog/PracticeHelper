<?php
namespace PracticeHelper\Page;
use Chiara\PodioOrganization as P, PracticeHelper\Templates\Button;
class ChooseWorkspace
{
    protected $main;
    function __construct(P $main)
    {
        $this->main = $main;
    }

    function __toString()
    {
        $ret = '<div class="wide"><h1>Choose your practice space</h1></div><div class="btn-group-vertical">';
        foreach ($this->main->workspaces->matching('Practicing:') as $space) {
            $ret .= new Button($space->name, $space->id, 'workspace');
        }
        return $ret . '</div>';
    }
}