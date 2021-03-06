<?php

namespace Mind\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Mind\SiteBundle\Entity\DomaineRepository;

class AvisType extends AbstractType
{
    

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('avisTitre', 'text', 
                    array(
                        'label' => 'Titre :', 
                        'required'  => true,
                        'attr' => array(
                                            'class' => 'input-xxlarge',
                                        ),
                        'label_attr'    => array(
                                            'class' => 'control-label',
                                            'style' => 'text-align:left;'
                            )
                        ))
                
//            ->add('sujet', new \Mind\SiteBundle\Form\Type\SujetAvisType(),
//                            array(
//                                    'error_bubbling'    => true
//                            ))
                
            ->add('avis', 'textarea',
                        array(
                            'label' => 'Votre avis :', 
                            'required'  => true,
                            'attr' => array(
                                                'class' => 'input-xxlarge',
                                                'style' => 'height:250px;'
                                            ),
                            'label_attr'    => array(
                                            'class' => 'control-label',
                                            'style' => 'text-align:left;'
                            )
                            ))
                
            ->add('typeOpinion', 'choice',
                            array(
                                'label' => 'Type d\'opinion :', 
                                'required'  => true,
                                'multiple' => false,
                                'expanded' => true,
                                'choices' => array(
                                                      1 => 'Positif',
                                                      2 => 'Mitigée',
                                                      3 => 'Négative'
                                                        ),
                                'label_attr'    => array(
                                            'class' => 'control-label',
                                            'style' => 'text-align:left;'
                                    )
                                ))
                
            ->add('avisDomaine', 'text', array(
                                                //'class'     => 'MindSiteBundle:Domaine',
                                                //'property'  => 'libelle',
                                                //'multiple'  => false,
                                                //'expanded'  => false,
                                                'required'  => true,
                                                //'empty_value' => 'Choisissez un domaine',
                                                'label'     => "Domaines :",
                                                'label_attr'    => array(
                                                                            'class' => 'control-label',
                                                                            'style' => 'text-align:left;'
                                                            )
                                                //'query_builder' => function(DomaineRepository $er){
                                                //                        return $result = $er->getDomaineBuilder();
                                                //                    }            
                                                
                                            )
                    )
                
                #->add('file', new \Mind\MediaBundle\Form\Type\ImageAvisType())
                
                
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mind\SiteBundle\Entity\Avis',
            'cascade_validation'    => true
        ));
    }

    public function getName()
    {
        return 'mind_sitebundle_avistype';
    }
}
