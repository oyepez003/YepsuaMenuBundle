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
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class MainMenuService extends ContainerAware
{
    private $factory;
    
    /**
     * 
     * @param \Knp\Menu\FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }
    
    /**
     * 
     * @param \Yepsua\MenuBundle\Menu\Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function configure(\Symfony\Component\HttpFoundation\Request $request)
    {
        $menu = $this->factory->createItem('root');
         
        $this->container->get('event_dispatcher')->dispatch(ConfigureMenuEvent::CONFIGURE, new ConfigureMenuEvent($this->factory, $menu));

        return $menu;
    }
}