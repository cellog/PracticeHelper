<?php
namespace PracticeHelper\Templates;
use PracticeHelper\Template as T;
class Button extends T
{
    protected $data;
    protected $title;
    protected $name;
    protected $look;
    function __construct($title, $data, $name, $look = 'btn-primary')
    {
        $this->data = $data;
        $this->title = $title;
        $this->name = $name;
        $this->look = $look;
    }

    function render()
    {
        return '<form action="/PracticeHelper/web/index.php"><input type="hidden" name="' .
               htmlspecialchars($this->name) . '" value="' . htmlspecialchars($this->data) . '">' .
               '<input type="submit" class="btn ' . $this->look . '"><h1>' . htmlspecialchars($this->title) . '</h1></input></form>';
    }
}
