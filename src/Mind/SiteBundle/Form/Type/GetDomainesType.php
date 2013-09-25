<?php

namespace Mind\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GetDomainesType extends AbstractType
{
    
    private $idDuDomaineParent;
    
    public function __construct($idDuDomaineParent) {
        
        $this->idDuDomaineParent = $idDuDomaineParent;
        
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       
        $builder
                
            ->add('avisDomaine', 'entity', array(
                                                'class' => "MindSiteBundle:Domaine",
                                                'property'  => 'libelle',
                                                'required'      => true,
                                                'query_builder' =>  function( \Mind\SiteBundle\Entity\DomaineRepository $er) {
                                                                                                return $er->createQueryBuilder('d')
                                                                                                    ->WHERE('d.etat = true
                                                                                                        AND d.parent = '.$this->idDuDomaineParent)
                                                                                                    ->orderBy('d.libelle', 'DESC');
                                                                                            },
                                                'expanded'  => true,
                                                'multiple'  => false,
                                                'label' => "Domaine",
                                                'attr'      => array(
                                                                        'name'  => 'domaineParent'
                                                                    )
                                                
                                            )
                    
                    )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mind\SiteBundle\Entity\Avis'
        ));
    }

    public function getName()
    {
        return 'mind_sitebundle_getdomainestype';
    }
}
