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
                                    '</a>'.$this->getBtnToSetParentDomaine($node);
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
                        . 'href="#"><i class="icon-move"></i>'.
                '</a>';
    
    
    return $htmlBtn;
    
    }
    
    public function getBtnToEtat(){
        
        $htmlBtn = '<span>Supprimer un domaine : </span><a '
                        . 'data-type="number"'
                        . 'data-name="etat"'
                        . 'data-url="'.$this->router->generate("mind_admin_domaine_modifier").'"'
                        . 'class="etat" '
                        . 'href="#"><i class="icon-remove-sign"></i>'.
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
        
        $childSort = array(
                            'field' => 'libelle',
                            'dir'   => 'asc'
        );
        
        $options = array(
                            'childSort' => $childSort,
                            'decorate' => true,
                            'rootOpen' => function($tree)use(&$tabLetterExiste){
                                if($tree[0]['niveau'] == 0){
                                    $premiereLettre = strtoupper($tree[0]['libelle'][0]);
                                    $idBadge = strtolower($tree[0]['libelle'][0]);
                                    $tabLetterExiste[] = $premiereLettre;
                                    return '<span id="'.$idBadge.'" class="badge">'.$premiereLettre.'</span><ul>';
                                }else{
                                    return '<ul>';
                                }
                            },
                            'rootClose' => '</ul>',
                            'childOpen' => '<li>',
                            'childClose' => '</li>',
                            'nodeDecorator' => function($node){
                                return '<a href="'.$this->router->generate("mind_site_domaine_voir",
                                    array("slug"=>$node['slug'])).'">'.$node['libelle'].'<sub> ('.
                                    $this->childCount($this->find($node['id']), true).')</sub></a>';
                            }
            );
        
            foreach ($tabDomaineNiveauUn as $domaine){
           
                $tabTree[] = $this->childrenHierarchy($domaine, false, $options, true);
                //$tabTree[] = $this->getChildren($domaine, FALSE, 'libelle', 'asc', true);
                
            
            }
            
            $data = array();
            $data[0] = $tabTree;
            $data[1] = $tabLetterExiste;
            
        return $data;
        
    }
    
}

?>
