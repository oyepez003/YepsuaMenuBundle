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

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use Yepsua\MenuBundle\Menu\Manager\MenuManager;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Description of Menu
 *
 * @author oyepez
 */
abstract class MenuTree extends ContainerAware{
    
    /**
     *
     * @var type \Yepsua\MenuBundle\Menu\Manager\MenuManager
     */
    private $menuManager;
    
    
    /**
     * 
     * @return MenuManager
     */
    public function getMenuManager($event = null) {
        if($event != null){
           $this->menuManager = new \Yepsua\MenuBundle\Menu\Manager\MenuManager($event);
           $this->menuManager->setContainer($this->container);
        }
        return $this->menuManager;
    }
    
    /**
     * 
     * @param MenuManager $manager
     */
    public function setMenuManager(MenuManager $manager) {
        $this->menuManager = $manager;
    }
    
    abstract function configure(\Yepsua\MenuBundle\Event\ConfigureMenuEvent $event);
    
    /**
     * 
     * @return \Symfony\Component\Translation\Translator;
     */
    protected function getTranslator(){
        return $this->container->get('translator');
    }
    
}