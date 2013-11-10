<?php

namespace Mind\SiteBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Routing\Router;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Domaine extends NestedTreeRepository{ 
    
    protected $doctrine;
    protected $manager;
    protected $security;
    protected $router;
    protected $container;
    
    public $rootOpen        = '<ul>';
    public $rootClose       = '</ul>';
    public $childOpen       = '<li>';
    public $childClose      = '</li>';


    public function __construct(Registry $doctrine, Router $router, SecurityContextInterface $security,
                                ContainerInterface $container) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
        $this->security         = $security;
        $this->router           = $router;
        $this->container        = $container;
        
        parent::__construct($this->manager, $this->manager->getClassMetadata('MindSiteBundle:Domaine'));
      
    }
    
    /**
     * 
     * Permet de récupérer le domaine qui est séléctionné
     * 
     * @return int l'id du domaine selectionné
     */
    public function getDomaineWhoIsSelected(){
    
        $idDuDomaine = -1;
        $request = $this->container->get('request');
        if($request->getMethod() == "POST"){
            
            $dataForm       = $request->get('mind_sitebundle_avistype');
            $idDuDomaine    = $dataForm['avisDomaine'];
        }
        
        return $idDuDomaine;
    }
    
    /**
     * 
     * ////Cette fonction n'est pas utilisée////
     * 
     * Permet de construire un élément de tableau td avec un décalage sur la gauche pour 
     * les sous domaines
     * 
     * @param int $nbParent 
     * @param string $typeHtml
     * @return string
     */
    public function getHtmlForm($nbParent, $typeHtml){
         

        $htmlTd = '';
        if($nbParent > 0){
                            $nbParent = $nbParent + 1;
                            
                            for ($initStart = 1; $initStart <= $nbParent; $initStart++ ){
                                $htmlTd = $htmlTd.'<td class="_children vide">';
                            }
                        }

        return $htmlTd;
    }
        
    /**
     * 
     * Permet de récupérer le formulaire domaine pour :
     * - l'ajout et la modification de domaine
     * - l'ajout et la modification de question
     * 
     * @param string $typeEntity il s'agit soit de question ou d'avis
     * @param int $idEntityToUpdate l'id de l'avis qu'on va modifer
     * 
     * @return string
     */
    public function getHtmlFormDomaineTree($typeEntity, $idEntityToUpdate = null){
        
        $childSort = array(
                            'field' => 'libelle',
                            'direction'   => 'asc'
        );
        $nbElmtDomaine = 0;
        
        $tree = $this->childrenHierarchy(
                                            null,
                                            false,
            array(
                    'decorate' => true,
                    'childSort' => $childSort,
                    'rootOpen' => function($tree){
                                                    return $this->rootOpen;
                                                 },
                    'rootClose' => function($child){ 
                                                    return $this->rootClose; 
                                                    },
                    'childOpen' => function($tree) {
                                                        return $this->childOpen;
                                                    },
                    'childClose' => $this->childClose,
                    'nodeDecorator' => function($node) use($typeEntity, &$nbElmtDomaine, $idEntityToUpdate){
                                                            //return '<a href="'.$this->router->generate("mind_site_homepage",array("id"=>$node['id'])).'">'.$node['libelle'].'</a>&nbsp;';
                                                            $htmlDomaine = $this->getHtmlFormImputAndLabel($typeEntity, $node['id'], $idEntityToUpdate);
                                                            $nbElmtDomaine++;
                                                            return $htmlDomaine['labelOpen'].$node['libelle'].$htmlDomaine['input'].$htmlDomaine['labelClose'];
                    }
                    
        ));
        
        return $tree;
    }
    
    /**
     * 
     * Permet de récupérer dans un tableau le label d'un élément de formulaire de domaine :
     * - Le label open : "labelOpen" 
     * - Le label close : "labelClose"
     * 
     * @param string $typeEntity il s'agit soit de question ou d'avis
     * @param int $idEntityDomaine L'id du domaine
     * @param boolean $isCourantElmt Indique si l'élément est actuellement l'élément courant
     * @param int $idEntityToUpdate l'id de l'avis qu'on va modifer
     * @return array les éléments formulaire en html d'un domaine
     */
    public function getHtmlFormImputAndLabel($typeEntity, $idEntityDomaine, $idEntityToUpdate = null){
    
        $idDuDomaine = $this->getDomaineWhoIsSelected();
       
        if($idDuDomaine == $idEntityDomaine or $idEntityDomaine == $idEntityToUpdate){
            $htmlIsCourantElmt = 'checked="checked"';
        }else{
            $htmlIsCourantElmt = null;
        }
        
        $htmlFormDomaine = 
                array(
                        'labelOpen'    => '<label style="display:inline-block;" for="mind_sitebundle_'.$typeEntity.'type_'.$typeEntity.'Domaine_%d" class="radio required">',
                        'input'         => '<input %s type="radio" id="mind_sitebundle_'.$typeEntity.'type_'.$typeEntity.'Domaine_%d" name="mind_sitebundle_'.$typeEntity.'type['.$typeEntity.'Domaine]" required="required" name="domaineParent" value="%d" /> ',
                        'labelClose'    => '</label>'        
            );
        
        $htmlFormDomaine['labelOpen']   = sprintf($htmlFormDomaine['labelOpen'], $idEntityDomaine);
        $htmlFormDomaine['input']       = sprintf($htmlFormDomaine['input'], $htmlIsCourantElmt, $idEntityDomaine, $idEntityDomaine);
        
        return $htmlFormDomaine;
    }
    
}

?>
