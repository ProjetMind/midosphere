<?php

namespace Mind\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

class VoteQuestionController extends Controller
{
    /**
     * 
     * @param type $idQuestion
     * @param type $typeOpinion
     * @return type
     * 
     * @Secure(roles="ROLE_USER")
     */
    public function jeVoteQuestionAction($idQuestion, $typeOpinion)
    {
        $erreurs = "";
        $message = "<ul>";
        $voteEnregistre = false;
        $manager = $this->getDoctrine()
                        ->getManager();
        $questionExiste = $manager->getRepository('MindSiteBundle:Question')
                              ->find($idQuestion);
        
        $idAuteur = $questionExiste->getQuestionAuteur();
        $aDejaVote = $this->aDejaVote($idQuestion, $idAuteur, $manager);
        
        if(!empty($questionExiste) and $aDejaVote == false){
            
            $validateur = $this->get('validator');
            $opinionQuestion = new \Mind\MediaBundle\Entity\OpinionQuestion;
            
            $opinionQuestion->setIdQuestion($idQuestion);
            $opinionQuestion->setIdAuteur($idAuteur);
            $opinionQuestion->setTypeOpinion($typeOpinion);
            
            $erreursListe = $validateur->validate($opinionQuestion);
            
            if(count($erreursListe) > 0){
                
                $erreurs = $erreursListe;
                $message .= "<li>Erreur lors de l'ajout</li>";
                
            }
            else{
                $message .= "Vote enregistré.";
                $em = $this->getDoctrine()->getManager();
                $em->persist($opinionQuestion);
                $em->flush();
                
                //Acl 
                $serviceAcl = $this->container->get('mind_site.acl_security');
                $tabAcl     = array();
                $tabAcl[]   = $opinionQuestion;
                $serviceAcl->updateAcl($tabAcl);
                
                $voteEnregistre = true;
            }
        }
        else{
            if(empty($questionExiste)){
                $message .= "<li>L'question n'existe pas</li>";
            }
            if($aDejaVote == true){
                $message .= "<li>Vous avez déjà voté pour cet question</li>"; 
            }
        }
        
        
        $slugAuteur = $manager->getRepository('MindUserBundle:User')->find($idAuteur)->getSlug();
        $urlQuestion = $this->generateUrl('mind_site_question_voir',
                                               array('slug'     => $questionExiste->getSlug(),
                                                     'auteur'   => $slugAuteur));
        $this->get('session')->getFlashBag()->add('success', $message.'</ul>');
        $this->get('session')->getFlashBag()->add('erreurs', $erreurs);
        $this->get('session')->getFlashBag()->add('ok', $voteEnregistre);
        
        return $this->redirect($urlQuestion);
    }
    
    public function aDejaVote($idQuestion, $idAuteur, $manager = null){
        
        $aDejaVote = $manager->getRepository('MindMediaBundle:OpinionQuestion')
                             ->aDejaVote($idQuestion, $idAuteur);
        
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
     * @param type $idQuestion
     * @return type
     * 
     * @Secure(roles="ROLE_USER")
     */
    public function SupprimerVoteAction($idQuestion){
        
        $message = "<ul>";
        $manager = $this->getDoctrine()->getManager();
        $questionExiste = $manager->getRepository('MindSiteBundle:Question')->find($idQuestion);
        $auteurQuestion = $manager->getRepository('MindUserBundle:User')->find($questionExiste->getQuestionAuteur());
        $idAuteur = $auteurQuestion->getId();
        
        if(!empty($questionExiste)){
            
            $opinionQuestion = $manager->getRepository('MindMediaBundle:OpinionQuestion')->getVoteQuestion($idQuestion, $idAuteur);
            
            //Acl 
            $serviceAcl = $this->container->get('mind_site.acl_security');
            $serviceAcl->checkPermission('DELETE', $opinionQuestion);
            
            $manager->remove($opinionQuestion);
            $manager->flush();
            
            $message .= "<li>Vote supprimé avec succès.</li>";
            
                    
        }
        else{
            $message .= "<li>L'question n'existe pas.</li>";
        }
        
        $urlQuestion = $this->generateUrl('mind_site_question_voir',
                                               array('slug'     => $questionExiste->getSlug(),
                                                     'auteur'   => $auteurQuestion->getSlug()));
        
        $this->get('session')->getFlashBag()->add('success', $message.'</ul>');
        return $this->redirect($urlQuestion);
    }
}
