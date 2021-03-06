<?php

namespace Mind\MediaBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * OpinionAvisRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OpinionAvisRepository extends EntityRepository
{
    
    public function aDejaVote($idAvis, $idAuteur){
        
        $query = $this->_em->createQuery('SELECT o
                                          FROM MindMediaBundle:OpinionAvis o
                                          WHERE o.idAvis = :idAvis
                                          AND o.idAuteur = :idAuteur'
                                        );
       
        $query->setParameter('idAvis', $idAvis);
        $query->setParameter('idAuteur', $idAuteur);
        
        return $query->getResult();
    }
    
    public function getVoteAvis($idAvis, $avisAuteur){
        
        $query = $this->_em->createQuery('SELECT o
                                         FROM MindMediaBundle:OpinionAvis o
                                         WHERE o.idAvis = :idAvis
                                         AND o.idAuteur = :idAuteur ');
        
        $query->setParameter('idAvis', $idAvis);
        $query->setParameter('idAuteur', $avisAuteur);
        return $query->getOneOrNullResult();
    }
    
    public function deleteVoteAvis($idAvis, $avisAuteur){
        
        $query = $this->_em->createQuery('DELETE MindMediaBundle:OpinionAvis o
                                         WHERE o.idAvis = :idAvis
                                         AND o.idAuteur = :idAuteur ');
        
        $query->setParameter('idAvis', $idAvis);
        $query->setParameter('idAuteur', $avisAuteur);
        $query->execute();
    }
    
    public function getOpinionAvisByIdAvis($idAvis, $typeOpinion){
        
        $query = $this->_em->createQuery('SELECT COUNT(o.typeOpinion)
                                          FROM MindMediaBundle:OpinionAvis o
                                          WHERE o.idAvis = :idAvis
                                          AND o.typeOpinion = :typeOpinion');
        $query->setParameter('idAvis', $idAvis);
        $query->setParameter('typeOpinion', $typeOpinion);
        
        return $query->getSingleScalarResult();
    }
}
