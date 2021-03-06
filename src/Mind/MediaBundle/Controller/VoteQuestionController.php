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
        $serviceBootstrapFlash = $this->container->get('bc_bootstrap.flash');
        $serviceQuestion = $this->container->get('mind_site.questions');
        $manager = $this->getDoctrine()
                        ->getManager();
        $questionExiste = $manager->getRepository('MindSiteBundle:Question')
                              ->find($idQuestion);
        
        $idAuteur = $questionExiste->getQuestionAuteur();
        $idUserCourant = $this->getUser()->getId();
        $aDejaVote = $serviceQuestion->aDejaVote($idQuestion);
        
        if(!empty($questionExiste) and $aDejaVote == false){
            
            $validateur = $this->get('validator'); 
            $opinionQuestion = new \Mind\MediaBundle\Entity\OpinionQuestion; 
            
            $opinionQuestion->setIdQuestion($idQuestion);
            $opinionQuestion->setIdAuteur($idUserCourant);
            $opinionQuestion->setTypeOpinion($typeOpinion);
            
            $erreursListe = $validateur->validate($opinionQuestion);
            
            if(count($erreursListe) > 0){
                
                $erreurs = $erreursListe;
                $message = "Erreur lors de lors de l'enregistrement de votre vote.";
                $serviceBootstrapFlash->error($message);
                
                
            }
            else{
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($opinionQuestion);
                $em->flush();
                
                $message = "Votre vote a été enregistré.";
                $serviceBootstrapFlash->success($message);
                
                //Acl 
                $serviceAcl = $this->container->get('mind_site.acl_security');
                $tabAcl     = array();
                $tabAcl[]   = $opinionQuestion;
                $serviceAcl->updateAcl($tabAcl);
                
            }
        }
        else{
            if(empty($questionExiste)){
                $message = "La question pour laquelle vous voulez voter n'existe pas.";
                $serviceBootstrapFlash->info($message);
                return $this->redirect($this->generateUrl('mind_site_homepage'));
            }
            if($aDejaVote == true){
                $message = "Vous avez déjà voté pour cette question."; 
                $serviceBootstrapFlash->info($message);
            }
        }
        
        
        $slugAuteur = $manager->getRepository('MindUserBundle:User')->find($idAuteur)->getSlug();
        $urlQuestion = $this->generateUrl('mind_site_question_voir',
                                               array('slug'     => $questionExiste->getSlug(),
                                                     'auteur'   => $slugAuteur));
        
        //$this->get('session')->getFlashBag()->add('ok', $voteEnregistre);
        
        return $this->redirect($urlQuestion);
    }
    
    /**
     * 
     * @param type $idQuestion
     * @return type
     * 
     * @Secure(roles="ROLE_USER")
     */
    public function SupprimerVoteAction($idQuestion){
        
        $manager = $this->getDoctrine()->getManager();
        $questionExiste = $manager->getRepository('MindSiteBundle:Question')->find($idQuestion);
        $auteurQuestion = $manager->getRepository('MindUserBundle:User')->find($questionExiste->getQuestionAuteur());
        $idAuteur = $auteurQuestion->getId();
        $serviceBootstrapFlash = $this->container->get('bc_bootstrap.flash');
        
        if(!empty($questionExiste)){
            
            $opinionQuestion = $manager->getRepository('MindMediaBundle:OpinionQuestion')->getVoteQuestion($idQuestion, $idAuteur);
            
            //Acl 
            $serviceAcl = $this->container->get('mind_site.acl_security');
            $serviceAcl->checkPermission('DELETE', $opinionQuestion);
            
            $serviceAcl->deleteAcl($opinionQuestion);
            $manager->remove($opinionQuestion);
            $manager->flush();
            
            $message = "Vote supprimé avec succès.";
            $serviceBootstrapFlash->success($message);
            
                    
        }
        else{
            $message .= "La question n'existe pas.";
            $serviceBootstrapFlash->info($message);
            return $this->redirect($this->generateUrl('mind_site_homepage'));
        }
        
        $urlQuestion = $this->generateUrl('mind_site_question_voir',
                                               array('slug'     => $questionExiste->getSlug(),
                                                     'auteur'   => $auteurQuestion->getSlug()));
        
        return $this->redirect($urlQuestion);
    }
}
