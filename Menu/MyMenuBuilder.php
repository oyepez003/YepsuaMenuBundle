<?php

/*
 * This file is part of the YepsuaMenuBundle.
 *
 * (c) Omar Yepez <omar.yepez@yepsua.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yepsua\MenuBundle\Menu;

use Yepsua\MenuBundle\Event\ConfigureMenuEvent;

class MyMenuBuilder
{
    /**
     * @param \Acme\DemoBundle\Event\ConfigureMenuEvent $event
     */
    public function configure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu(); // Get the root tree
        $factory = $event->getFactory(); // Get the MenuFactory
        
        //Creates the item to add childs
        $item = $factory->createItem('itemName', array('label'=> 'Menu','route' => '_welcome',));

        $item->addChild('Hello World Fabien', array(
            'route' => '_demo_hello',
            'routeParameters' => array('name' => 'Fabien')
        ));

        $menu->addChild($item);
        
        //Now you can get the item in others bundles and add more menu options:
        /*
         * $item = $event->getMenu()->getChild('itemName');
         * $item->addChild('The item label', array(
         *   'route' => 'your_route',
         *   'routeParameters' => array('foo' => 'bar')
         * ));
         */
    }
}