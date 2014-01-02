<?php

namespace Mind\SiteBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Routing\Router;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactory;
use Mind\SiteBundle\Acl\AclSecurity;

class Domaine extends NestedTreeRepository{ 
    
    protected $doctrine;
    protected $manager;
    protected $security;
    protected $router;
    protected $container;
    protected $templating;
    protected $form;
    protected $aclSecurity;


    public $rootOpen        = '<ul>';
    public $rootClose       = '</ul>';
    public $childOpen       = '<li>';
    public $childClose      = '</li>';


    public function __construct(Registry $doctrine, Router $router, SecurityContextInterface $security,
                                ContainerInterface $container, FormFactory $form, AclSecurity $aclSecurity) {
        
        $this->doctrine         = $doctrine;
        $this->manager          = $doctrine->getManager();
        $this->security         = $security;
        $this->router           = $router;
        $this->container        = $container;
        $this->templating       = $container->get('templating');
        $this->form             = $form;
        $this->aclSecurity      = $aclSecurity;
        
        parent::__construct($this->manager, $this->manager->getClassMetadata('MindSiteBundle:Domaine'));
      
    }
    
    /**
     * 
     * Retourne le message adéquat de confirmation
     * 
     * @param string $erreur
     * @return string
     */
    public function getErreurMessage($erreur){
    
        $htmlBtnClose = '<button type="button" class="close" data-dismiss="alert">×</button>';
        $htmlClose = '</div>';
        
        switch($erreur){
                
                case 'ok':
                    $htmlOpen = '<div class="alert alert-success">';
                    $message = "L'élément a été mis à jour avec succès.";
                    break;
                
                case 'erreur':
                    $htmlOpen = '<div class="alert alert-warning">';
                    $message = 'Une erreure inconnue est survenue lors de la mise à jour.';
                    break;
                    
            }
            
            return $htmlOpen.$htmlBtnClose.$message.$htmlClose;
    }
    
    /**
     * 
     * Met à jour le domaine : parent et position
     * 
     * @param type $idDomaine
     * @param type $idNewDomaineParent
     */
    public function updateDomaineParent($idDomaine, $idNewDomaineParent){
        
        $repo               = $this->manager->getRepository('MindSiteBundle:Domaine');
        $domaine            = $repo->find($idDomaine);
        $domaineParent      = $repo->find($idNewDomaineParent);
        
        if(!empty($domaine) and !empty($domaineParent)){
            
            $repo->persistAsLastChildOf($domaine, $domaineParent);
            echo "lol";
            
        }else{
            if($idNewDomaineParent == -1){
                $domaine->setParent();
                $this->manager->persist($domaine);
            }
        }
        
        $this->manager->flush();
        $this->clear();
    }

    /**
     * 
     * Met à jour un domaine
     * 
     * @param \Mind\SiteBundle\Entity\Domaine $domaine
     */
    public function updateDomaine(\Mind\SiteBundle\Entity\Domaine $domaine){
        
        $this->manager->persist($domaine);
        $this->manager->flush();
    }

    /**
     * 
     * Retourne un domaine
     * 
     * @param int $idDomaine
     * @return \Mind\SiteBundle\Entity\Domaine
     */
    public function getDomaineById($idDomaine){
        
        $domaine = $this->manager->getRepository('MindSiteBundle:Domaine')->find($idDomaine);
        
        return $domaine;
    }
    
    /**
     * 
     * fournit les radios bouton du formulaire pour ajouter des domaines
     * 
     * @param int $idDomaineWhoIsSelected
     * @param type $tree
     * @param type $tree
     * @return string
     */
    public function getHtmlFormForAdmin(){
        
        $childSort = array(
                            'field'         => 'libelle',
                            'direction'     => 'asc'
        );
        
        $tree = $this->childrenHierarchy(
                                            null,
                                            false,
            array(
                    'decorate' => true,
                    'childSort' => $childSort,
                    'rootOpen' => $this->rootOpen,
                    'rootClose' => $this->rootClose,
                    'childOpen' => $this->childOpen,
                    'childClose' => $this->childClose,
                    'nodeDecorator' => function($node){
                                        $htmlDomaine = $this->getHtmlFormInputAndLabelForAdmin($node['id'], $node['libelle']);
                                        return $htmlDomaine['labelOpen'].$htmlDomaine['input'].$htmlDomaine['libelle'].$htmlDomaine['labelClose'];
                    }
                    
        ));
        
        return $tree;
        
    }
    
    /**
     * 
     * Fournit la liste des domaines avec les différents boutons pour la partie admin
     * 
     * @return type
     */
    public function getHtmlDomaineForAdmin(){
        
        //$this->reorder(null, 'libelle', 'desc');
        $this->manager->getRepository('MindSiteBundle:Domaine')->reorder(null, 'libelle', 'asc');
        return $tree = $this->childrenHierarchy(
                                            null,
                                            false,
            array(
                    'decorate' => true,
                    'rootOpen' => $this->rootOpen,
                    'rootClose' => $this->rootClose,
                    'childOpen' => $this->childOpen,
                    'childClose' => $this->childClose,
                    'nodeDecorator' => function($node){
                            return $node['id'].' : '
                                     . '<a '
                                            . 'data-pk="'.$node['id'].'" '
                                            . 'data-type="text"'
                                            . 'data-name="libelle"'
                                            . 'data-url="'.$this->router->generate("mind_admin_domaine_modifier").'"'
                                            . 'data-id="'.$node['id'].'" '
                                            . 'class="libelle" '
                                            . 'href="#">'.$node['libelle'].
                                    '</a>'.$this->getBtnToSetParentDomaine($node).$this->getBtnToDelete($node);
                                    ;
                            
//                          return '<a data-toggle="popover" href="'.$this->router->generate("mind_site_domaine_voir",
//                            array("slug"=>$node['slug'])).'">'.$node['libelle'].'</a>&nbsp;';
                    }
                    
        ));
    }
    
    /**
     * 
     * Construit et retourne le bouton popov pour modifier le parent d'un domaine
     * 
     * @param type $node
     * @return string
     */
    public function getBtnToSetParentDomaine($node){
       
    
    $htmlBtn = '<a '
                        . 'data-pk="'.$node['id'].'" '
                        . 'data-type="number"'
                        . 'data-name="parent"'
                        . 'data-url="'.$this->router->generate("mind_admin_domaine_modifier").'"'
                        . 'data-id="'.$node['id'].'" '
                        . 'class="parent" '
                        . 'href="#">update parent<i class="icon-pencil"></i>'.
                '</a>';
    
    
    return $htmlBtn;
    
    }
    
    public function getBtnToDelete($node){
        
        $htmlBtn = '<a '
                        . 'href="'.$this->router->generate("mind_admin_domaine_supprimer", array('id'=>$node['id'])).'"'
                        . 'class="delete" '
                        . '>Supprimer<i class="icon-remove"></i>'.
                '</a>';
        
    return $htmlBtn;
    }

    /**
     * 
     * Permet de récupérer la liste des domaines sous forme de liste
     * pour la page domaine
     * 
     * @return string
     */
    public function getHtmlListeDomaine(){
    
        
        $tree = $this->childrenHierarchy(
                                            null,
                                            false,
            array(
                    'decorate' => true,
                    'rootOpen' => $this->rootOpen,
                    'rootClose' => $this->rootClose,
                    'childOpen' => $this->childOpen,
                    'childClose' => $this->childClose,
                    'nodeDecorator' => function($node){
                          return '<a href="'.$this->router->generate("mind_site_domaine_voir",
                                    array("slug"=>$node['slug'])).'">'.$node['libelle'].'</a>';
                    }
                    
        ));
        
        return $tree;
    }
    
    
    
    /**
     * 
     * Inutilisé 
     * 
     * @param int $idDomaine 
     * @param string $libelle
     * @return array 
     */
    public function getHtmlFormInputAndLabelForAdmin($idDomaine, $libelle, $idDomaineWhoIsSelected = null){
        
//        if ($idDomaine == $idDomaineWhoIsSelected){
//            
//            $isSelected = 'checked = "checked"';
//            
//        }else{
//            $isSelected = null;
//        }
        
        $htmlFormDomaine = 
                array(
                        'labelOpen'     =>  '<label class="radio" for="mind_sitebundle_domainetype_parent_%d" style="display:inline-block;">',
                        'input'         =>  '<input id="mind_sitebundle_domainetype_parent_%d" type="radio" value="%d" name="mind_sitebundle_domainetype[parent]">',
                        'libelle'       =>  '%s',
                        'labelClose'    =>  '</label>'
                    );
        
        $htmlFormDomaine['labelOpen']   = sprintf($htmlFormDomaine['labelOpen'], $idDomaine);
        $htmlFormDomaine['input']       = sprintf($htmlFormDomaine['input'], $idDomaine, $idDomaine);
        $htmlFormDomaine['libelle']     = sprintf($htmlFormDomaine['libelle'], $libelle);
        
        return $htmlFormDomaine;
    }
    
    /**
     * 
     * La liste des domaines pour les formulaire add avis et question
     * 
     * @return array
     */
    public function getDomaineForForm(){
        
        $tabDomaine = array();
        $domaines = $this->manager->getRepository('MindSiteBundle:Domaine')->findAll();
        
        foreach ($domaines as $domaine){
            
            $tabDomaine[] = array(
                                    'id'    => $domaine->getId(),
                                    'text'  => $domaine->getLibelle()
                    );
        }
        
        return $tabDomaine;
    }
    
    public function getListeDomaine(){
        
        
        $tabDomaineNiveauUn = $this->manager->getRepository('MindSiteBundle:Domaine')->getDomaineByNiveau(0);
        $tabLetterExiste = array();
        $tabTree = array();
        $tabLettersDomaines = $this->getLettersDomaine($tabDomaineNiveauUn);
        
        $options = array(
                            'childSort' => array(
                                                    'field' => 'libelle',
                                                    'dir'   => 'asc'
                                                ),
                            'decorate' => true,
                            'rootOpen' => function($tree)use(&$tabLetterExiste){
                                $premiereLettre = strtoupper(ucfirst($tree[0]['libelle'][0]));
                                if($tree[0]['niveau'] == 0 and !in_array($premiereLettre, $tabLetterExiste)){
                                    
                                    $idBadge = strtolower(lcfirst($tree[0]['libelle'][0]));
                                    $tabLetterExiste[] = $premiereLettre;
                                    
                                    return '<span id="'.$idBadge.'" class="badge badge-warning">'.$premiereLettre.'</span><ul>';
                                }else{
                                    return '<ul>';
                                }
                            },
                            'rootClose' => function($child){
                        
//                                    $idDomaine = $child[0]['id'];
//                                    $parent = $this->getParentDomaine($idDomaine);
//                                    
//                                    if(!empty($parent)){
//                                        $parentBorneDroit = $parent->getBorneDroit();
//                                        $enfantBorneDroit = $child[0]['borneDroit'];
//                                        $isLastChildren = $this->isLastChildren($parentBorneDroit, $enfantBorneDroit);
//                                    }else{
//                                        $isLastChildren = true;
//                                    }
//                                $htmlForm = $this->getHtmlFormLastChildren($isLastChildren);    
                                return '</ul>';
                            },
                            'childOpen' => '<li>',
                            'childClose' => '</li>',
                            'nodeDecorator' => function($node){
                                
                                $premiereLettre = ucfirst($node['libelle']);
                                
                                return '<a href="'.$this->router->generate("mind_site_domaine_voir",
                                    array("slug"=>$node['slug'])).'">'.$premiereLettre.'<sub> ('.
                                    $this->childCount($this->find($node['id']), true).')</sub></a>';
                            }
            );
        
            //print_r($tabLettersDomaines['a']);
            $i = 0;
            foreach ($tabLettersDomaines as $lettre){
           
                if(!isset($tabTree[$i])){
                    $tabTree[$i] = "";
                }
                if(!empty($lettre)){
                    foreach ($lettre as $domaine){
                        if(!empty($domaine)){
                            $tabTree[$i] .= $this->childrenHierarchy($domaine, false, $options, true);
                        }
                    }
                    $i++;
                }
                
                //$tabTree[] = $this->childrenHierarchy($domaine, false, $options, true);
                //$tabTree[] = $this->getChildren($domaine, FALSE, 'libelle', 'asc', true);
                
            }
            
            $data = array();
            $data[0] = $tabTree;
            $data[1] = $tabLetterExiste;
            
        return $data;
        
    }
    
    /**
     * 
     * Permet de récupérer les domaines par lettre alphabétique
     * 
     * @param type $lesDomaines
     * @return array
     */
    public function getLettersDomaine($lesDomaines){
        
        $tabLetters = array('a'=>null,'b'=>null,'c'=>null,'d'=>null,'e'=>null,'f'=>null,'g'=>null,'h'=>null,'i'=>null,'j'=>null,'k'=>null,'l'=>null,'m'=>null,'n'=>null,'o'=>null,'p'=>null,'q'=>null,'r'=>null,'s'=>null,'t'=>null,'u'=>null,'v'=>null,'w'=>null,'x'=>null,'y'=>null,'z'=>null);
        
        foreach ($lesDomaines as $unDomaine){
            $premiereLettreDomaine = lcfirst($unDomaine->getLibelle()[0]);
            $tabLetters[$premiereLettreDomaine][] = $unDomaine;
        }
        
//        foreach ($tabLetters as $keyLettre => $value){
//           
//            foreach ($lesDomaines as $unDomaine){
//                $premiereLettreDomaine = lcfirst($unDomaine->getLibelle()[0]);
//                if($premiereLettreDomaine == $keyLettre){
//                    $tabLetters[$keyLettre][] = $unDomaine;
//                }else{
//                    $tabLetters[$keyLettre][] = array();
//                }
//            }
//        }
        return $tabLetters;
    }
    
    public function getParentDomaine($idDomaine){
        
        return $this->manager->getRepository('MindSiteBundle:Domaine')->getParentDomaine($idDomaine);
    }
    
    /**
     * 
     * Permet de savoir si un domaine enfant est le dernier enfant
     * 
     * @param type $parentBorneDroit
     * @param type $enfantBorneDroit
     * @return boolean
     */
    public function isLastChildren($parentBorneDroit, $enfantBorneDroit){
        
        $result = $parentBorneDroit - $enfantBorneDroit; 
        if($result === 1){
            return true;
        }else{
            return false;
        }
    }
    
    public function getHtmlFormLastChildren($isLastChildren){
        
        if($isLastChildren === true){
            return '<ul>'
                                        . '<li>'
                                            . '<form class="form-inline" style="padding:0px;">'
                                                . '<input name="libelle" type="text" style="padding:4px 6px;">'
                                                . '<input name="parentId" type="hidden" value="0" />'
                                            . '</form>'
                                        . '</li>'
                                 . '</ul>';
        }else{
            return "";
        }
    }
    
    public function supprimer($domaine){
        
        if(!empty($domaine)){
            
            $this->removeFromTree($domaine);
            $this->clear();
            
            $this->supprimerEntityByDomaine($domaine);
            
            return true;
        }else{
            return false;
        }
    }
    
    public function supprimerEntityByDomaine($domaine){
        
        $idDomaine = $domaine->getId();
        //Avis
        $avis = $this->manager->getRepository('MindSiteBundle:Avis')->findBy(array('avisDomaine' => $idDomaine));
        foreach ($avis as $unAvis){
            $this->manager->remove($unAvis);
        }
        
        $this->manager->flush();
    }
}
