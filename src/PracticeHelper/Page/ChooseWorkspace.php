<?php
namespace PracticeHelper\Page;
use Chiara\PodioOrganization as P;
class ChooseWorkspace
{
    protected $main;
    function __construct(P $main)
    {
        $this->main = $main;
    }

    function __toString()
    {
        try {
        foreach ($this->main->workspaces->matching('Lessons') as $space) {
            $ret .= new Button($space->title, $space->id, 'workspace');
        }
        } catch (\Exception $e) {
            echo $e;
        }
    }
}
