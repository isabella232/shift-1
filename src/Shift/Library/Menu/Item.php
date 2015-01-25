<?php
namespace Tectonic\Shift\Library\Menu;

use Request;

class Item extends MenuItem
{
    /**
     * The link that when a user clicks, will be directed to.
     *
     * @var string
     */
    public $link;

    /**
     * Construct a new item to be appended to a menu.
     *
     * @param $text
     * @param $link
     * @param Menu $parent
     */
    public function __construct($text, $link)
    {
        $this->text = $text;
        $this->name = $text;
        $this->link = $link;
    }
}
