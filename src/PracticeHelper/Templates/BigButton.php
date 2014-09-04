<?php
namespace PracticeHelper\Templates;
class BigButton extends Button
{
    protected $data;
    protected $name;
    protected $look;
    function __construct($name = 'go', $text = "Start Practicing!", $look = 'btn-success')
    {
        $this->name = $name;
        $this->data = $text;
        $this->look = $look;
    }

    function render()
    {
        return '<form action="/PracticeHelper/web/index.php"><input type="hidden" name="' . $this->name . '" value="1">' .
               '<button type="submit" class="full btn ' . $this->look . '"><h1>' . $this->data . '</h1></button></form>';
    }
}
