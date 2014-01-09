<?php

namespace Yepsua\MenuBundle\Menu;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use Yepsua\MenuBundle\Menu\Manager\MenuManager;

/**
 * Description of Menu
 *
 * @author oyepez
 */
abstract class MenuTree {
    
    /**
     *
     * @var type MenuManager
     */
    private $menuManager;
    
    /**
     * 
     * @return MenuManager
     */
    public function getMenuManager($event = null) {
        if($event != null){
           $this->menuManager = new \Yepsua\MenuBundle\Menu\Manager\MenuManager($event);
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
}