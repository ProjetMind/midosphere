<?php


namespace Mind\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mind\MediaBundle\Form\Type\AbonnementType;
use Mind\MediaBundle\Form\Type\AbonnementDomaineType;
use JMS\SecurityExtraBundle\Annotation\Secure;

class AbonnementController extends Controller
{
    
    /**
     * 
     * @param type $idUser
     * @param type $idDuDomaine
     * @return type
     * 
     * @Secure(roles="ROLE_USER")
     */
    public function abonnementDomaineAction($idUser, $idDuDomaine){
        
        $idUserCourant = $this->get('security.context')->getToken()->getUser()->getId();
        $abonnementDomaine = new \Mind\MediaBundle\Entity\AbonnementDomaine;
        
        $options = array(
                            'idUser'            => $idUserCourant,
                            'idDomaine'         => $idDuDomaine
                        );
        $estAbonner = $this->estAbonnerDomaineAction($options);
        
        $abonnementDomaine->setIdDomaine($idDuDomaine);
        $abonnementDomaine->setIdUser($idUser);
        
        $form = $this->createForm(new AbonnementDomaineType, $abonnementDomaine);
        $request = $this->getRequest();
        
        if($request->getMethod() == "POST" and $estAbonner == false){
            
            $form->bind($request);
            
            if($form->isValid()){
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($abonnementDomaine);
                $em->flush();
            }
        }else{
            
            if(isset($_POST['desabonner'])){
                
                $this->deleteAbonnementDomaineAction($options);
                $estAbonner = $this->estAbonnerDomaineAction($options);
                
            }
        }
        
        $template = sprintf('MindSiteBundle:Domaines:barre_domaine_btns.html.twig');
        return $this->container->get('templating')->renderResponse($template, 
                array(
                        'form'              => $form->createView(),
                        'idUser'            => $idUser,
                        'estAbonner'        => $estAbonner
                      ));
    }
    
    public function estAbonnerDomaineAction($options){
        
        $abonnement = $this->getDoctrine()
                           ->getManager()
                           ->getRepository('MindMediaBundle:AbonnementDomaine')
                           ->findBy($options);
        
        if(empty($abonnement)){
            $estAbonner = false;
        }else{
            $estAbonner = true;
        }
        
        return $estAbonner;
        
    }

    public function deleteAbonnementDomaineAction($options){
        
        $manager = $this->getDoctrine()
                        ->getManager();
        
        $abonnement = $manager
                           ->getRepository('MindMediaBundle:AbonnementDomaine')
                           ->findOneBy($options);
        
        $manager->remove($abonnement);
        $manager->flush();
        
    }

    public function abonnementAction($idUser){
        
        $idUserCourant = $this->get('security.context')->getToken()->getUser()->getId();
        $abonnement = new \Mind\MediaBundle\Entity\Abonnement;
        
        $options = array(
                            'idUser'            => $idUser,
                            'idSouscripteur'    => $idUserCourant
                        );
        
        $estAbonner = $this->estAbonnerAction($options);
        
        $abonnement->setIdSouscripteur($idUserCourant);
        $abonnement->setIdUser($idUser);
        
        $form = $this->createForm(new AbonnementType(), $abonnement);
        
        $request = $this->getRequest();
        
        if($request->getMethod() == "POST" and $estAbonner == false){
            
            $form->bind($request);
            
            if($form->isValid()){
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($abonnement);
                $em->flush();
            }
        }else{
            
            if(isset($_POST['desabonner'])){
                
                $this->deleteAbonnementAction($options);
                $estAbonner = $this->estAbonnerAction($options);
                
            }
        }
        
        $template = sprintf('MindUserBundle:Profile:barre_user_profile.html.twig');
        return $this->container->get('templating')->renderResponse($template, 
                array(
                        'form'              => $form->createView(),
                        'idUser'            => $idUser,
                        'estAbonner'   => $estAbonner
                      ));
    }
    
    public function estAbonnerAction($options){
        
        $abonnement = $this->getDoctrine()
                           ->getManager()
                           ->getRepository('MindMediaBundle:Abonnement')
                           ->findBy($options);
        
        if(empty($abonnement)){
            $estAbonner = false;
        }else{
            $estAbonner = true;
        }
        
        return $estAbonner;
    }
    
    public function deleteAbonnementAction($options){
        
        $manager = $this->getDoctrine()
                        ->getManager();
        
        $abonnement = $manager
                           ->getRepository('MindMediaBundle:Abonnement')
                           ->findOneBy($options);
        
        $manager->remove($abonnement);
        $manager->flush();
        
    }
}

?>
