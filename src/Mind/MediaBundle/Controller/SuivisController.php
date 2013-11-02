<?php

namespace Mind\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mind\MediaBundle\Form\Type\SuivisType;

class SuivisController extends Controller {

    public function indexAction($stringOptions){
        
        $suivis         = new \Mind\MediaBundle\Entity\Suivis;
                
        $tabOptions = $this->initTabOptionsAction($stringOptions);
        $suivis->setIdUser($tabOptions['idUser']);
        $suivis->setIdEntity($tabOptions['idEntity']);
        $suivis->setTypeEntity($tabOptions['typeEntity']);
        
        $btnSubmit      = $this->getSubmitBtnAction($suivis);
            
        $form           = $this->createForm(new SuivisType(), $suivis);
        
        $request        = $this->getRequest();
        
        if($request->getMethod() == "POST"){
         
            $form->bindRequest($request);
            
            if($form->isValid() and $tabOptions['initTabIsOk'] == true){ 
                $this->createSuivisForUserAction($suivis);
                $route = $this->getUriAvisAction($suivis->getIdUser(), $suivis->getIdEntity());
                
                return $this->redirect($route);
            }
        }
        
        $template = sprintf('MindMediaBundle:Forms:form_suivis.html.twig');
        
        return $this->container->get('templating')->renderResponse($template,
                    array(
                            'form'          => $form->createView(),
                            'btnSubmit'     => $btnSubmit,
                            'stringOptions' => $stringOptions
                    ));
    }
    
    public function getUriAvisAction($idUser, $idAvis){
    
        $user = $this->getDoctrine()->getManager()->getRepository('MindUserBundle:User')->find($idUser);
        $avis = $this->getDoctrine()->getManager()->getRepository('MindSiteBundle:Avis')->find($idAvis);
        
        $route = $this->generateUrl('mind_site_avis_voir', array(
                                                            'auteur'    => $user->getSlug(),
                                                            'slug'      => $avis->getSlug()
                                                        ));
        
        return $route;
    }
    
    public function createSuivisForUserAction($suivis){
        
        $suivisService  = $this->container->get('mind_media.suivis');
        //Suivis 
        $options = array(
                            'idUser'        => $suivis->getIdUser(),
                            'idEntity'      => $suivis->getIdEntity(),
                            'typeEntity'    => $suivis->getTypeEntity()
                        );
       
        $suivisService->createSuivisForUser($options);
        
    }

    public function getSubmitBtnAction($suivis){
        
        $suivisService  = $this->container->get('mind_media.suivis');
        
        //Suivis 
        $options = array(
                            'idUser'        => $suivis->getIdUser(),
                            'idEntity'      => $suivis->getIdEntity(),
                            'typeEntity'    => $suivis->getTypeEntity()
                        );

        $SuivisExiste = $suivisService->checkSuivis($options);

        if($SuivisExiste){
            $btnSubmit = '<input type="submit" style="padding: 0" value="Ne plus suivre"/>';
        }else{
            $btnSubmit = '<input type="submit" style="padding: 0" value="Suivre"/>';
        }
        
        return $btnSubmit;
    }
    
    public function initTabOptionsAction($stringOptions){
        
        $initTabOptions = true;
        
        $serviceSuivis = $this->container->get('mind_media.suivis');
        $stringOptions = explode('-', $stringOptions);
        $tabOptions = array(
                                'idUser'        => $stringOptions[0],
                                'idEntity'      => $stringOptions[1],
                                'typeEntity'    => $stringOptions[2]
                            );
        
        //Vérification du user id
        $userExiste = $serviceSuivis->isValidUser($tabOptions['idUser']);
        
        //Vérification de l'id de l'entité
        $entityExiste = $serviceSuivis->isValidEntity($tabOptions['idEntity'], $tabOptions['typeEntity']);
        
        //Vérification du type entity
        $isValidTypeEntity = $serviceSuivis->isValidTypeEntity($tabOptions['typeEntity']);
        
        if($userExiste == false){
            $initTabOptions = false;
        }
        if($entityExiste == false){
            $initTabOptions = false;
        }
        if($isValidTypeEntity == false){
            $initTabOptions = false;
        }
        
        $tabOptions['initTabIsOk'] = $initTabOptions;
        
        return $tabOptions;
    }
}
