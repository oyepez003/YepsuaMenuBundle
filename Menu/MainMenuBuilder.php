<?php
/*
 * This file is part of the YepsuaMenu Bundle.
 *
 * (c) Omar Yepez <omar.yepez@yepsua.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yepsua\MenuBundle\Menu;

use Yepsua\MenuBundle\Event\ConfigureMenuEvent;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class MainMenuBuilder extends ContainerAware
{    
    /**
     * 
     * @param \Knp\Menu\FactoryInterface $factory
     * @return type
     */
    public function build(FactoryInterface $factory)
    {
        $menu = $factory->createItem('root');
         
        $this->container->get('event_dispatcher')->dispatch(ConfigureMenuEvent::CONFIGURE, new ConfigureMenuEvent($factory, $menu));

        return $menu;
    }
}