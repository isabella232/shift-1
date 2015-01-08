<?php
namespace Tectonic\Shift\Library\Menu;

abstract class MenuItem
{
    /**
     * The name or text of the menu item.
     *
     * @var string|null It is possible for top-level menus to not need any text.
     */
    protected $text;

    /**
     * Stores the parent Menu.
     *
     * @var Menu
     */
    protected $parent;

    /**
     * Defines whether or not the menu item is renderable.
     *
     * @var bool
     */
    protected $renderable = false;

    /**
     * Stores the children this menu item has.
     *
     * @var array
     */
    protected $children = [];

    /**
     * Determines whether the menu or item is active.
     *
     * @var bool
     */
    private $active = false;

    /**
     * Determines whether or not the menu item has a parent.
     *
     * @return bool
     */
    public function hasParent()
    {
        return (bool) $this->parent;
    }

    /**
     * Determines whether or not the item has children.
     *
     * @return boolean
     */
    public function hasChildren()
    {
        return (bool) count($this->children);
    }

    /**
     * Inverse check of hasChildren. Helper method.
     *
     * @return boolean
     */
    public function isParent()
    {
        return $this->hasChildren();
    }

    /**
     * Set the parent of the menu item.
     *
     * @param Menu $parent
     */
    public function setParent(Menu $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Returns the current parent for the menu item.
     *
     * @return null|Menu
     */
    public function parent()
    {
        return $this->parent;
    }

    /**
     * Return the text for the menu item.
     *
     * @return mixed
     */
    public function text()
    {
        return $this->text;
    }

    /**
     * Set the renderable property for the menu item.
     *
     * @param $renderable
     */
    public function setRenderable($renderable)
    {
        $this->renderable = $renderable;
    }

    /**
     * Return the renderable value.
     *
     * @return bool
     */
    public function renderable()
    {
        return $this->renderable;
    }

    /**
     * Returns the active state of the item.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Sets the active property on the item. This is useful for highlighting/activating menu items visually.
     */
    public function setActive()
    {
        $this->active = true;

        if ($this->hasParent()) {
            $this->parent->setActive();
        }
    }
}
