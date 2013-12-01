<?php

namespace Mind\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * class unitilisé je crois, à verifier
 */
class VoteController extends Controller
{
    public function jeVoteAvisAction($idAvis, $typeOpinion)
    {
        
        $erreurs = "";
        $message = "";
        $voteEnregistre = null;
        $manager = $this->getDoctrine()
                        ->getManager();
        $avisExiste = $manager->getRepository('MindSiteBundle:Avis')
                              ->find($idAvis);
        
        $idAuteur = $avisExiste->getAvisAuteur();
        $aDejaVote = $this->aDejaVote($idAvis, $idAuteur, $manager);
        
        if(!empty($avisExiste) and $aDejaVote == false){
            
            $validateur = $this->get('validator');
            $opinionAvis = new \Mind\MediaBundle\Entity\OpinionAvis;
            
            $opinionAvis->setIdAvis($idAvis);
            $opinionAvis->setIdAuteur($idAuteur);
            $opinionAvis->setTypeOpinion($typeOpinion);
            
            $erreursListe = $validateur->validate($opinionAvis);
            
            if(count($erreursListe) > 0){
                
                $erreurs = $erreursListe;
                $message .= "Erreur lors de l'ajout.";
                $voteEnregistre = false;
                
            }
            else{
                $message .= "Vote enregistré.";
                $em = $this->getDoctrine()->getManager();
                $em->persist($opinionAvis);
                $em->flush();
                $voteEnregistre = true;
            }
        }
        else{
            if(empty($avisExiste)){
                $message .= "L'avis n'existe pas.";
                $voteEnregistre = false;
            }
            if($aDejaVote == true){
                $message .= "Vous avez déjà voté pour cet avis."; 
                $voteEnregistre = false;
            }
        }
        
        
        $slugAuteur = $manager->getRepository('MindUserBundle:User')->find($idAuteur)->getSlug();
        $urlAvis = $this->generateUrl('mind_site_avis_voir',
                                               array('slug'     => $avisExiste->getSlug(),
                                                     'auteur'   => $slugAuteur));
        if($voteEnregistre == true){
            $this->get('session')->getFlashBag()->add('success', $message);
        }
        if($voteEnregistre == false){
            $this->get('session')->getFlashBag()->add('erreurs', $erreurs);
        }
       
        $this->get('session')->getFlashBag()->add('ok', $voteEnregistre);
        return $this->redirect($urlAvis);
        
    }
    
    public function aDejaVote($idAvis, $idAuteur, $manager = null){
        
        $aDejaVote = $manager->getRepository('MindMediaBundle:OpinionAvis')
                             ->aDejaVote($idAvis, $idAuteur);
        
        if(!empty($aDejaVote)){
            $aDejaVote = true;
        }
        else{
            $aDejaVote = false;
        }
        
        return $aDejaVote;
    }
    
    public function SupprimerVoteAction($idAvis){
        
        $message = "";
        $manager = $this->getDoctrine()->getManager();
        $ok = null;
        $avisExiste = $manager->getRepository('MindSiteBundle:Avis')->find($idAvis);
        $auteurAvis = $manager->getRepository('MindUserBundle:User')->find($avisExiste->getAvisAuteur());
        $idAuteur = $auteurAvis->getId();
        
        if(!empty($avisExiste)){
            
            $manager->getRepository('MindMediaBundle:OpinionAvis')->deleteVoteAvis($idAvis, $idAuteur);
            
            $message .= "Vote supprimé avec succès.";
            $ok = true;
            
                    
        }
        else{
            $message .= "L'avis n'existe pas.";
            $ok = false;
        }
        
        if($ok == true){
            $this->get('session')->getFlashBag()->add('success', $message);
        }
        if($ok == false){
            $this->get('session')->getFlashBag()->add('erreurs', $message);
        }
        
        $urlAvis = $this->generateUrl('mind_site_avis_voir',
                                               array('slug'     => $avisExiste->getSlug(),
                                                     'auteur'   => $auteurAvis->getSlug()));
        
        
        return $this->redirect($urlAvis);
    }
}
