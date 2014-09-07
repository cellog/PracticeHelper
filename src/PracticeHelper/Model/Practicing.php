<?php
namespace PracticeHelper\Model;
class Practicing extends \PracticeHelper/Model/Base
{
    protected $MYAPPID=6624583;
    function __construct($info = null, $retrieve = true)
    {
        parent::__construct($info, new \PracticeHelper\Model\Structure\Practicing, $retrieve);
    }

    /**
     * handle an item.create hook in here
     * @param array $params any url-specific parameters passed in to
     *                       differentiate between hooks.  The item is already set up
     *                       and can be used immediately.
     */
    /*
    function onItemCreate($params)
    function onItemUpdate($params)
    function onItemDelete($params)
    function onCommentCreate($params)
    function onCommentDelete($params)
    function onFileChange($params)
    {
    }
    */
}
