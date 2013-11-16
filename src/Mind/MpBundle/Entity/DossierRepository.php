<?php

namespace Mind\MpBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * DossierRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DossierRepository extends EntityRepository
{
    /**
     * 
     * Cette fonction retourne la liste des id des conversation qui se trouve dans un dossier précis bal|archive
     * 
     * @param type $dossierString
     * @return array
     */
    public function getTabConversationByDossier($idUserCourant, $dossierString){
        
        
        $query = $this->_em->createQuery('SELECT d 
                                          FROM MindMpBundle:Dossier d
                                          WHERE d.dossier = :dossier
                                          AND d.idUser = :idUser
                                         ');
        
        $query->setParameter('dossier', $dossierString);
        $query->setParameter('idUser', $idUserCourant);
        
        $result = $query->getResult();
        $tabConversation = array();
        
        foreach ($result as $dossier){
            
            $tabConversation[] = $dossier->getIdConversation();
        }
        
        return $tabConversation;
        
    }
}
