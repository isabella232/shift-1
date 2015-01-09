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
    private $link;

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
        $this->link = $link;
    }

    /**
     * Returns the link that is used for the click event.
     *
     * @return string
     */
    public function link()
    {
        return $this->link;
    }

    /**
     * When the parent is set for a menu item, we want to check to see if this particular
     * item is currently active. If it is, we need to set the parent menu as active as well.
     *
     * @param Menu $menu
     */
    public function setParent(Menu $menu)
    {
        parent::setParent($menu);

        if (strpos(Request::url(), $this->link) !== false) {
            $this->setActive();
        }
    }
}
