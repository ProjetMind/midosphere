<?php

// src/Mind/UserBundle/Menu/Menu.php

namespace Mind\UserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Menu extends ContainerAware
{
    
    public function getMenuListener(FactoryInterface $factory, array $options){
        
        // en cours
        $menu = $factory->createItem('menu-gauche-historique');
        $menu->setChildrenAttribute('class', 'nav nav-list');
        $currentItem = $this->container->get('request')->getRequestUri();
        $menu->setCurrentUri($currentItem);
        $slug = $options['slug'];
        
        //Childrens
        $menu->addChild('Listener', array('uri'   => ''));
        $menu['Listener']->setAttribute('class', 'nav-header menuGDTitle');
        $menu->addChild('Abonnement',           array(
                                                        'route'           => 'mind_user_profile_voir',
                                                        'routeParameters' => array('slug'   => $slug)
                                                     ));
        
        $menu->addChild('Suivis',               array(
                                                        'route'           => 'mind_user_profile_voir',
                                                        'routeParameters'  => array('slug'  => $slug)
                                                     ));
        #$menu->addChild('Vote',                 array('route'           => 'mind_site_homepage'));
        #$menu->addChild('Commentaires',         array('route'           => 'mind_site_homepage'));
        
        //URI childrends 
        $uriAbonnement = $menu['Abonnement']->getUri();
        $uriSuivis     = $menu['Suivis']->getUri();
        
        //SET children attributes
        $menu['Abonnement']->setUri($uriAbonnement.'#les-abonnements');
        $menu['Suivis']->setUri($uriSuivis.'#les-suivis');
        return $menu;
        
    }
    
    public function getMenuMesPublications(FactoryInterface $factory, array $options){
        
        $chevronRight = '<i class="icon-chevron-right"></i>';
        $menu = $factory->createItem('menu-mes-publications');
        $menu->setChildrenAttribute('class', 'nav nav-list');
        $currentItem = $this->container->get('request')->getRequestUri();
        $menu->setCurrentUri($currentItem);
        $slug = $options['slug'];
        
        //Childrens
        $menu->addChild('mesPublications', array('uri'  => ''));
        
        $menu->addChild('avis',         array(
                                                'route'             => 'mind_user_profile_voir',
                                                'routeParameters'   => array('slug' => $slug)
                                              )
                       );
        
        $menu->addChild('questions',    array(
                                                'route'       => 'mind_user_profile_voir',
                                                'routeParameters'   => array('slug' => $slug)
                                             )
                       );
        
//        $menu->addChild('domaines',     array(
//                                                'route'       => 'mind_user_profile_voir',
//                                                'routeParameters'   => array('slug' => $slug)
//                                             )
//                       );
        
//        $menu->addChild('commentaire',    array(
//                                                'route'       => 'mind_user_profile_voir',
//                                                'routeParameters'   => array('slug' => $slug)
//                                             )
//                       );
        
        //Childrens attributes
        $menu['mesPublications']    ->setAttribute('class', 'nav-header menuGDTitle');
        
        //Childrens Label
        $menu['mesPublications']    ->setLabel('Mes publications');
        $menu['avis']               ->setLabel('Avis');
        $menu['questions']          ->setLabel('Questions');
        
        //URI children
        $uriQuestion = $menu['questions']->getUri();
        $uriAVis = $menu['avis']->getUri();
        
        $menu['questions']->setUri($uriQuestion.'#les-questions');
        $menu['avis']  ->setUri($uriAVis.'#les-avis');
        
        //$menu['domaines']           ->setLabel('Domaines'.$chevronRight);
        
        return $menu;
    }
    public function getHeaderMenuCompte(FactoryInterface $factory){
        
        $menu = $factory->createItem('root');
        $currentItem = $this->container->get('request')->getRequestUri();
        $menu->setCurrentUri($currentItem);
        
        //Attributes ul
        $menu->setChildrenAttribute('class', 'dropdown-menu pull-right');
        
        //Childrens
        $menu->addChild('informationsPersonnelles',    array('route'       => 'mind_user_compte_infos_persos'));
        $menu->addChild('parametresDuCompte',          array('route'       => 'mind_user_compte_parametres'));
        $menu->addChild('messagerie',                  array('route'       => 'mind_mp_homepage'));
        
        if($this->container->get('security.context')->isGranted('ROLE_ADMIN')){
            
            //Childrens Admin item
            $menu->addChild("dividerAdmin", array('uri' => ''))->setAttribute('class', 'divider');
            $menu->addChild('admin', array('route'  => 'mind_admin_index'));
            $menu->addChild('utilisateurs', array('route'   => 'mind_admin_user'));
            $menu->addChild('domaines', array('route'   => 'mind_admin_domaine'));
            $menu->addChild('avis', array('route'   => 'mind_admin_avis'));
            $menu->addChild('questions', array('route'  => 'mind_admin_question'));
            
        }
        
        //Children déconnexion 
        $menu->addChild("dividerDeconnexion", array('uri' => ''))->setAttribute('class', 'divider');
        $menu->addChild('deconnexion', array('route'    => 'fos_user_security_logout'));
        
        //Children name : ajout des icones 
        $menu['informationsPersonnelles']->setLabel('<i class="icon-user"></i> Informations personnelles');
        $menu['parametresDuCompte']->setLabel('<i class="icon-cog"></i> Paramètre du compte');
        $menu['messagerie']->setLabel('<i class="icon-envelope"></i> Méssagerie');
        
        if($this->container->get('security.context')->isGranted('ROLE_ADMIN')){
            
            $menu['admin']->setLabel('<i class="icon-wrench"></i> admin');
            $menu['utilisateurs']->setLabel('<i class="icon-user"></i>Utilisateurs');
            $menu['domaines']->setLabel('<i class="icon-list-alt"></i>Domaines');
            $menu['avis']->setLabel('Avis');
            $menu['questions']->setLabel('Question');
            $menu['deconnexion']->setLabel('<i class="icon-off"></i> Déconnexion');
            
        }
        
        return $menu;
    }
    
    public function getMenuCompte(FactoryInterface $factory)
    {
        $chevronRight = '<i class="icon-chevron-right"></i>';
        $menu = $factory->createItem('menu-compte');
        $menu->setChildrenAttribute('class', 'nav nav-list');
        $currentItem = $this->container->get('request')->getRequestUri();
        $baseUrl = $this->container->get('request')->getBaseUrl();
        $menu->setCurrentUri($currentItem);
        
        //Childrens
        $menu->addChild('informationsPersonelles', array('route' => 'mind_user_compte_infos_persos'));
        $menu->addChild('parametres', array('route' => 'mind_user_compte_parametres'));
        
        //Label children
        $menu['informationsPersonelles']->setLabel('Informations personnelles'.$chevronRight);
        $menu['parametres']->setLabel('Paramètres'.$chevronRight);
   
        return $menu;
    }
    
    public function getMenuAdmin(FactoryInterface $factory){
        
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute("class", "nav nav-list");
        $currentItem = $this->container->get('request')->getRequestUri();
        $menu->setCurrentUri($currentItem);
        
        
        $menu->addChild('Utilisateurs', array('route' => 'mind_admin_user'));
        $menu->addChild('Domaines', array('route' => 'mind_admin_domaine'));
        $menu->addChild('Avis', array('route' => 'mind_admin_avis'));
        $menu->addChild('Questions', array('route' => 'mind_admin_question'));
        
        return $menu;
        
    }
}

?>
