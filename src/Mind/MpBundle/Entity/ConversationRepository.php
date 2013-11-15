<?php

namespace Mind\MpBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ConversationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ConversationRepository extends EntityRepository
{
    /**
     * 
     * Fournit le user dont le username commence par le terme
     * 
     * @param type $terms
     * @return array
     */
    public function getAutocompleteResult($terms){
        
        $query = $this->_em->createQuery('SELECT u
                                          FROM MindUserBundle:User u
                                          WHERE u.username LIKE :terms
                                         ');
        
        $query->setParameter('terms', $terms.'%');
        
        return $query->getResult();
    }
    
    public function getConversationForConversationType($idUserAuteur){
        
        $tabIdConversation = $this->_em
                                  ->getRepository('MindMpBundle:Dossier')
                                  ->getTabConversationByDossier('bal');
       
        $query = $this->_em->createQuery('SELECT c
                                          FROM MindMpBundle:Conversation c
                                          where c.auteurConversation = :auteurConversation
                                          AND c.id IN (:tabId)
                                          ORDER BY c.dateDebutConversation DESC
                                         ');
        
        $query->setParameter('auteurConversation', $idUserAuteur);
        $query->setParameter('tabId', $tabIdConversation);
        
        return $query->getResult();
    }
    
    
    
}
