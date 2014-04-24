<?php

/*
 * This file is part of the YepsuaMenuBundle.
 *
 * (c) Omar Yepez <omar.yepez@yepsua.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yepsua\MenuBundle\Menu\Manager;

use Yepsua\MenuBundle\Event\ConfigureMenuEvent;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class MenuManager extends ContainerAware implements MenuManagerInterface{
    /**
     *
     * @var \Yepsua\MenuBundle\Event\ConfigureMenuEvent 
     */
    protected $event;
    
    private $searchName;
    private $itemResults;
    
    /**
     * 
     * @param \Yepsua\MenuBundle\Event\ConfigureMenuEvent $event
     */
    public function __construct(ConfigureMenuEvent $event){
        $this->setEvent($event);
    }
    
    /**
     * 
     * @param \Yepsua\MenuBundle\Event\ConfigureMenuEvent $event
     */
    public function setEvent(ConfigureMenuEvent $event){
        $this->event = $event;
    }
    
    /**
     * Get a menu item by name.
     * Creates a menu item if not exists
     * @param string $name
     * @param array  $options
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function getItem($name, array $options = array(), $force = false){
        $menu = $this->event->getMenu();
        $item = null;
        
        if(!$force){
            $item = (is_array($name)) ? $this->searchCascade($name) : $menu->getChild($name);
        }
        
        if($item === null){
            if(isset($options['icon'])){
                if(isset($options['label'])){
                    $options['label'] = $this->getIcon($options['icon'],$this->__t($options['label']));
                }else{
                    $options['label'] = $this->getIcon($options['icon'],$this->__t($name));
                }
                $options['extras']['safe_label'] = true;
            }
            $item = $this->event->getFactory()->createItem($name, $options);
            if($item->getUri() === null){
                $item->setUri('#');
            }
            $item->setLabel($this->__t($item->getLabel()));
        }
        return $item;
    }
    
    /**
     * Get a menu item by name.
     * Creates a menu item if not exists
     * @param string $name
     * @param array  $options
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function newItem($name, array $options = array()){
        return $this->getItem($name,$options, true);
    }
    
    /**
     * 
     * @param args $names
     * @return \Knp\Menu\ItemInterface
     */
    public function searchCascade($names){
        $names = (is_array($names)) ? $names : func_get_args();
        $menu = $this->event->getMenu();
        
        foreach ($names as $key => $name){
            $_item = $menu->getChild($name);
            if($_item !== null){
                $menu = $_item;
            }else{
                throw new \InvalidArgumentException(sprintf("The menu item ['%s' => '%s'] was not found",$key,$name), E_USER_ERROR);
                break;
            }
        }
        
        return $menu;
    }
    
    /**
     * 
     * @param args $names
     * @return \Knp\Menu\ItemInterface
     */
    public function find($names){
        $returnOne = false;
        if(is_array($names)){
           $this->searchName = $names;
        }else{
           $returnOne = true;
           $this->searchName = array($names);
        }
        $this->itemResults = array();
        $this->findItem($this->event->getMenu());
        if(sizeof($this->itemResults) == 0){
            throw new \InvalidArgumentException(sprintf("No menu item was found with names: %s", implode($this->searchName),E_USER_ERROR));
        }
        if($returnOne){
            $this->itemResults = reset($this->itemResults);
        }
        return $this->itemResults;
    }
        
    /**
     * 
     * @param args $names
     * @return \Knp\Menu\ItemInterface
     */
    public function findItem(\Knp\Menu\ItemInterface $_item){
        if($_item->hasChildren()){
            foreach($_item->getChildren() as $item){
                if(in_array($item->getName(),$this->searchName)){
                    $this->itemResults[$item->getName()] = $item;
                }
                if($item->hasChildren()){
                    $this->findItem($item);
                }
            }
        }
    }
    
    /**
     * 
     * @param \Knp\Menu\ItemInterface $menu
     */
    public function append(ItemInterface $menu){
        if($menu !== null){
            if($menu->hasChildren()){
                $_menu = $this->getMenu()->getChild($menu->getName());
                if($_menu === null){
                    $this->getMenu()->addChild($menu);
                }
            }else{
                $this->getMenu()->addChild($menu);
            }
        }
    }
    
    public function getIcon($icon, $label = '',$tag = 'i'){
        return sprintf('<%s class="%s"></%s> %s',$tag,$icon,$tag, $label);
    }
    
    /**
     * @return \Knp\Menu\ItemInterface
     */
    public function getMenu(){
        return $this->event->getMenu();
    }
    
    /**
     * @return \Knp\Menu\FactoryInterface
     */
    public function getFactory(){
        return $this->event->getFactory();
    } 
    
    /**
     * The Symfony2 tranlator
     * @return \Symfony\Component\Translation\Translator 
     */
    protected function getTranslator(){
        return $this->container->get('translator');
    }
    
    public function __t($id){
        return $this->getTranslator()->trans($id,array(),'MenuLabels');
    }
}
