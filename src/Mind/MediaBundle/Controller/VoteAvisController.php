<?php

namespace Mind\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

class VoteAvisController extends Controller
{
    /**
     * 
     * @param type $idAvis
     * @param type $typeOpinion
     * @return type
     * 
     * @Secure(roles="ROLE_USER")
     */
    public function jeVoteAvisAction($idAvis, $typeOpinion)
    { 
        $erreurs = "";
        $message = "<ul>";
        $voteEnregistre = false;
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
                $message .= "<li>Erreur lors de l'ajout</li>";
                
            }
            else{
                $message .= "Vote enregistré.";
                $em = $this->getDoctrine()->getManager();
                $em->persist($opinionAvis);
                $em->flush();
                
                //Acl 
                $serviceAcl = $this->container->get('mind_site.acl_security');
                $tabAcl     = array();
                $tabAcl[]   = $opinionAvis;
                $serviceAcl->updateAcl($tabAcl);
                
                $voteEnregistre = true;
            }
        }
        else{
            if(empty($avisExiste)){
                $message .= "<li>L'avis n'existe pas</li>";
            }
            if($aDejaVote == true){
                $message .= "<li>Vous avez déjà voté pour cet avis</li>"; 
            }
        }
        
        
        $slugAuteur = $manager->getRepository('MindUserBundle:User')->find($idAuteur)->getSlug();
        $urlAvis = $this->generateUrl('mind_site_avis_voir',
                                               array('slug'     => $avisExiste->getSlug(),
                                                     'auteur'   => $slugAuteur));
        $this->get('session')->getFlashBag()->add('success', $message.'</ul>');
        $this->get('session')->getFlashBag()->add('erreurs', $erreurs);
        $this->get('session')->getFlashBag()->add('ok', $voteEnregistre);
        return $this->redirect($urlAvis);
        
//        return $this->container->get('templating')->renderResponse('MindMediaBundle::message_vote.html.twig', 
//                array(
//                        'message' =>        $message.'</ul>',
//                        'erreurs'           => $erreurs,
//                        'avisAjoutOk'       => $voteEnregistre
//                    ));
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
    
    /**
     * 
     * @param type $idAvis
     * @return type
     * 
     * @Secure(roles="ROLE_USER")
     */
    public function SupprimerVoteAction($idAvis){
        
        $message = "<ul>";
        $manager = $this->getDoctrine()->getManager();
        $avisExiste = $manager->getRepository('MindSiteBundle:Avis')->find($idAvis);
        $auteurAvis = $manager->getRepository('MindUserBundle:User')->find($avisExiste->getAvisAuteur());
        $idAuteur = $auteurAvis->getId();
        
        if(!empty($avisExiste)){
            
            $opinionAvis = $manager->getRepository('MindMediaBundle:OpinionAvis')->getVoteAvis($idAvis, $idAuteur);
            
            //Acl 
            $serviceAcl = $this->container->get('mind_site.acl_security');
            $serviceAcl->checkPermission('DELETE', $opinionAvis);
            
            $manager->remove($opinionAvis);
            $manager->flush();
            
            $message .= "<li>Vote supprimé avec succès.</li>";
            
                    
        }
        else{
            $message .= "<li>L'avis n'existe pas.</li>";
        }
        
        $urlAvis = $this->generateUrl('mind_site_avis_voir',
                                               array('slug'     => $avisExiste->getSlug(),
                                                     'auteur'   => $auteurAvis->getSlug()));
        
        $this->get('session')->getFlashBag()->add('success', $message.'</ul>');
        return $this->redirect($urlAvis);
    }
}

