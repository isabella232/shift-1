<?php
namespace Tectonic\Shift\Library\Composers;

use Menufy;
use Tectonic\Shift\Library\Menu\Menu;
use Tectonic\Shift\Library\Menu\Item;

class MainMenuComposer
{
	public function compose()
    {
        $mainMenu = new Menu('main');
        $mainMenu->addChild(new Item('Home', route('home')));

        $configMenu =  new Menu('configuration', trans('shift::menu.configuration'));
        $configMenu->addChild(new Item(trans('shift::roles.titles.main'), route('roles.index')));
        $configMenu->addChild(new Item(trans('shift::accounts.titles.main'), route('accounts.index')));

        $mainMenu->addChild($configMenu);

        Menufy::register($mainMenu);
    }
}
