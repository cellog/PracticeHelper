<?php
namespace PracticeHelper\Page;
use Chiara\PodioOrganization as P;
class ChooseWorkspace
{
    protected $main;
    function __construct(P $main)
    {
        var_dump($main);
        $this->main = $main;
    }

    function __toString()
    {
        var_dump($this->main->workspaces);
        foreach ($this->main->workspaces->matching('Lessons') as $space) {
            $ret .= new Button($space->title, $space->id, 'workspace');
        }
    }
}