<?php

// src/Mind/MpBundle/Menu/Menu.php

namespace Mind\MpBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Menu extends ContainerAware 
{
    
    public function getMenuGaucheMp(FactoryInterface $factory){
        
        $menu = $factory->createItem('menu-mp');
        $menu->setChildrenAttribute('class', 'nav nav-list');
        $currentItem= $this->container->get('request')->getRequestUri();
        $menu->setCurrentUri($currentItem);
        
        //Childrens
        $menu->addChild('Boite de récéption',   array('route'         => 'mind_mp_homepage'));
        $menu->addChild('Archives',             array('route'       => 'mind_mp_archive'));
        
        
        //Childrens attributes
        //$menu['Nouveau message']->setLinkAttribute('class', 'btn btn-warning');
        
        return $menu;
    }
    
    public function getMenuAlertMp(FactoryInterface $factory){
        
        $menu = $factory->createItem('menu-alert-mp');
        
        //Ul attrilbutes
        $menu->setChildrenAttribute('class', 'dropdown-menu');
        $menu->setChildrenAttribute('role', 'menu');
        $menu->setChildrenAttribute('aria-labelledby', 'dLabel');
        $menu->setChildrenAttribute('styler','right: 0px');
        
        //Children
        $menu->addChild('notificationTop');
        $menu->addChild('divider');
    }
    
    

}

?>
