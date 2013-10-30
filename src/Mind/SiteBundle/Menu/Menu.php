<?php

// src/Mind/SiteBundle/Menu/Menu.php

namespace Mind\SiteBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Menu extends ContainerAware 
{
    
    public function getMenuMenu(FactoryInterface $factory){
    
        $menu = $factory->createItem('menu-menu');
        $menu->setChildrenAttribute('class', 'nav nav-list');
        $currentItem = $this->container->get('request')->getRequestUri();
        $menu->setCurrentUri($currentItem);
        
        //$routeName = $this->getRequest()->get('_route');
        //Childrens
        $menu->addChild('menu', array('uri'   => ''));
        $menu['menu']->setAttribute('class', 'nav-header menuGDTitle');
        
        $menu->addChild('Avis',         array('route'       => 'mind_site_avis_afficher'));
        $menu->addChild('Questions',    array('route'       => 'mind_site_question_afficher'));
        $menu->addChild('Domaines',     array('route'       => 'mind_site_domaine_afficher'));
        
        return $menu;
    }
    
    
    public function getMenuAffichageQuestion(FactoryInterface $factory){
    
        $menu = $factory->createItem('menu-affichage-question');
        $menu->setChildrenAttribute("class", 'nav nav-pills');
        $currentItem = $this->checkCurrentUri();
        $menu->setCurrentUri($currentItem);
        
        //Children 
        $menu->addChild('Toutes les question',  array('route'   => 'mind_site_question_afficher'));
        $menu->addChild('Les plus récentes',    array('route'   => 'mind_site_question_afficher_recent'));
        $menu->addChild('Les plus anciennes',   array('route'   => 'mind_site_question_afficher_anciens'));
        $menu->addChild('Les plus notées',      array('route'   => 'mind_site_question_afficher_plus_note'));
        $menu->addChild('Les plus commentées',  array('route'   => 'mind_site_question_afficher_plus_commente'));
        
        return $menu;
    }
    
    public function getMenuAffichageAvis(FactoryInterface $factory){
    
        $menu = $factory->createItem('menu-affichage-avis');
        $menu->setChildrenAttribute("class", 'nav nav-pills');
        $currentItem = $this->checkCurrentUri();
        $menu->setCurrentUri($currentItem);
        
        //Children 
        $menu->addChild('Tous les avis',        array('route'   => 'mind_site_avis_afficher'));
        $menu->addChild('Les plus récents',     array('route'   => 'mind_site_avis_afficher_recent'));
        $menu->addChild('Les plus anciens',     array('route'   => 'mind_site_avis_afficher_anciens'));
        $menu->addChild('Les plus notés',       array('route'   => 'mind_site_avis_afficher_plus_note'));
        $menu->addChild('Les plus commentés',   array('route'   => 'mind_site_avis_afficher_plus_commente'));
        
        return $menu;
    }
    
    public function checkCurrentUri(){
        
        $currentItem = $this->container->get('request')->getRequestUri();
        $currentArray = explode('/', $currentItem);
        
        end($currentArray);
        $key = key($currentArray);
        $value = $currentArray[$key];
        
        if(count($currentArray) > 6){
            unset($currentArray[$key]);
        }
        
        
        $currentItem = implode('/', $currentArray);
        
        return $currentItem;
    }
    
    public function getMenuCompte(FactoryInterface $factory){
    
        $menu = $factory->createItem('menu-header-compte');
        $menu->setChildrenAttribute('class', 'nav');
        $currentItem = $this->container->get('request')->getRequestUri();
        $menu->setCurrentUri($currentItem);
        $carret = '<b class="caret"></b>';
        
        //Childrens
        $menu->addChild('mp',           array('uri'         => '#'));
        $menu->addChild('alert',        array('uri'         => '#'));
        $menu->addChild('user',         array('uri'         => '#'));
        
        //Values
        $menu['mp']         ->setLabel('<i class="icon-envelope"></i>'.$carret);
        $menu['alert']      ->setLabel('<i class="icon-bell"></i>'.$carret);
        $menu['user']       ->setLabel('<i class="icon-user"></i>'.$carret);
        
        //Attributes MP
        $menu['mp']->setAttribute('class', 'dropdown');
        $menu['mp']->setLinkAttribute('class', 'dropdown-toggle pull-right');
        $menu['mp']->setLinkAttribute('data-toggle', "dropdown");
        
        //Attributes Alert
        $menu['alert']->setAttribute('class', 'dropdown');
        $menu['alert']->setLinkAttribute('class', 'dropdown-toggle pull-right');
        $menu['alert']->setLinkAttribute('data-toggle', "dropdown");
        
        //Attributes MP
        $menu['user']->setAttribute('class', 'dropdown');
        $menu['user']->setLinkAttribute('class', 'dropdown-toggle pull-right');
        $menu['user']->setLinkAttribute('data-toggle', "dropdown");
        
        //Sous menu Mp 
        $menu['mp']->addChild('test', array('uri'   => '#'));
        $menu['alert']->addChild('test', array('uri'   => '#'));
        
        //Sous menu User
        
        $menu['user']->addChild('informationsPersonnelles',    array('route'       => 'mind_user_compte_infos_persos'));
        $menu['user']->addChild('parametresDuCompte',          array('route'      => 'mind_user_compte_parametres'));
        $menu['user']->addChild('messagerie',                   array('route'       => 'mind_site_homepage'));
        
        //Childrens Admin item
        $menu['user']->addChild("dividerAdmin", array('uri' => ''))->setAttribute('class', 'divider');
        $menu['user']->addChild('admin', array('route'  => 'mind_admin_index'));
        $menu['user']->addChild('utilisateurs', array('route'   => 'mind_admin_user'));
        $menu['user']->addChild('domaines', array('route'   => 'mind_admin_domaine'));
        $menu['user']->addChild('avis', array('route'   => 'mind_admin_avis'));
        $menu['user']->addChild('questions', array('route'  => 'mind_admin_question'));
        
        //Children déconnexion 
        $menu['user']->addChild("dividerDeconnexion", array('uri' => ''))->setAttribute('class', 'divider');
        $menu['user']->addChild('deconnexion', array('route'    => 'fos_user_security_logout'));
        
        //Children name : ajout des icones 
        $menu['user']['informationsPersonnelles']->setLabel('<i class="icon-user"></i> Informations personnelles');
        $menu['user']['parametresDuCompte']->setLabel('<i class="icon-cog"></i> Paramètre du compte');
        $menu['user']['messagerie']->setLabel('<i class="icon-envelope"></i> Méssagerie');
        $menu['user']['admin']->setLabel('<i class="icon-wrench"></i> admin');
        $menu['user']['utilisateurs']->setLabel('<i class="icon-user"></i>Utilisateurs');
        $menu['user']['domaines']->setLabel('<i class="icon-list-alt"></i>Domaines');
        $menu['user']['avis']->setLabel('Avis');
        $menu['user']['questions']->setLabel('Question');
        $menu['user']['deconnexion']->setLabel('<i class="icon-off"></i> Déconnexion');
        
        //Attributes pour les sous menu publier
        
        return $menu;
    }
    
    public function getMenuHeader(FactoryInterface $factory){
        
        
        $menu = $factory->createItem('menu-header-gauche');
        $menu->setChildrenAttribute("class", 'nav');
        $currentItem = $this->container->get('request')->getRequestUri();
        $menu->setCurrentUri($currentItem);
        
        //Childrens
        $menu->addChild("Accueil",      array('route'       => 'mind_site_homepage'));
        $menu->addChild('Avis',         array('route'       => 'mind_site_avis_afficher'));
        $menu->addChild('Questions',    array('route'       => 'mind_site_question_afficher'));
        $menu->addChild('Les domaines', array('route'       => 'mind_site_domaine_afficher'));

        if($this->container->get('security.context')->isGranted('ROLE_USER')){
            
            $menu->addChild('Publier',      array('uri'         => '#'));
        
            //Attributes
            $menu['Publier']->setAttribute('class', 'dropdown');
            $menu['Publier']->setLinkAttribute('class', 'dropdown-toggle pull-right');
            $menu['Publier']->setLinkAttribute('data-toggle', "dropdown");

            //Sous menu pour "Publier"
            $menu['Publier']->addChild('Un avis',            array('route'      => 'mind_site_avis_ajouter'));
            $menu['Publier']->addChild('Une question',       array('route'      => 'mind_site_question_ajouter'));
            //$menu['Publier']->addChild('Un nouveau domaine', array('route'      => 'mind_site_domaine_ajouter'));

            //Attributes pour les sous menu publier
            $menu['Publier']->setChildrenAttribute('style', 'left:0 ');
            $menu['Publier']->setChildrenAttribute('class', 'dropdown-menu');
            $menu['Publier']->setName('Publier <span class="caret"></span>');
            
        }
        return $menu;
        
    }

}

?>
