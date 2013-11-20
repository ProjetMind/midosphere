<?php

namespace Mind\SiteBundle\Entity;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * DomaineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DomaineRepository extends NestedTreeRepository
{
    
    public function getSql($optionsFiltres, $termsDeRecherche){
        
        $sql            = "SELECT d
                           FROM MindSiteBundle:Domaine d
                           WHERE ";  
        
        $explodeString  = explode(" ", $termsDeRecherche);
        
        switch ($optionsFiltres){
            
            case 1: 
                foreach ($explodeString as $string){
                    $sql .= "d.libelle LIKE '%".$string."%' OR";
                }
                $sql = substr($sql, 0, -2);
                break;
            
            case 2: 
                foreach ($explodeString as $string){
                    $sql .= "d.libelle LIKE '%".$string."%' And ";
                }
                $sql = substr($sql, 0, -4);
                break;
            
            case 3: 
                $sql .= "d.libelle LIKE '%".$string."%'";
                break;
        }
        return $sql."  ORDER BY d.niveau, d.borneGauche ASC";
        
    }

    public function getDomainesByTermsRecherche($optionsFiltres, $termsDeRecherche, $router){
    
        $sql = $this->getSql($optionsFiltres, $termsDeRecherche);
        
        $query = $this->_em->createQuery($sql);
        $arrayResult = $query->getArrayResult();
        
        $options = array(
                            'decorate' => true,
                            'rootOpen' => '<ul>',
                            'rootClose' => '</ul>',
                            'childOpen' => '<li>',
                            'childClose' => '</li>',
                            'nodeDecorator' => function($node)use($router){
                                return '<a href="'.$router->generate("mind_site_domaine_voir",
                                            array("slug"=>$node['slug'])).'">'.$node['libelle'].'</a>';
                            }
            );
        $tree = $this->buildTree($arrayResult, $options);
        
        return $tree;
    }
    
    public function getDomainesPourAdministration(){
        
        
        $query = $this->_em
            ->createQueryBuilder()
            ->select('node')
            ->from('MindSiteBundle:Domaine', 'node')
            ->orderBy('node.root, node.borneGauche', 'ASC')
            ->where('node.etat = 1')
            ->getQuery()
        ;
        $options = array('decorate' => false);
        return $tree = $this->buildTree($query->getArrayResult(), $options); 
    }
    
    /**
     * returne la liste des domaines dans un tableau pour les formulaires 
     * 
     * @return type
     */
    public function getAllDomainesInArray(){
        
        $query = $this->_em->createQuery('SELECT d.id, d.libelle
                                          FROM MindSiteBundle:Domaine d
                                          ORDER BY d.libelle DESC
                                         ');
        
        $tabDomaines = array();
        
        foreach($query->getArrayResult() as $value){
            $tabDomaines[$value['id']] = $value['libelle'];
        }
        
        return $tabDomaines;
    }
 
    public function getDomaineBySlug($slug){
        
        $query = $this->_em->createQuery('SELECT d
                                          FROM MindSiteBundle:Domaine d
                                          WHERE d.slug = :slug ');
        
        $query->setParameter('slug', $slug);
        
        return $query->getSingleResult();
    }

   
    public function getDomaineById($idDomaine){
        
        $query = $this->_em->find('MindSiteBundle:Domaine', $idDomaine);
        
        //$query->setParameter('etat', 1);
        return $query;
        
    }
}
