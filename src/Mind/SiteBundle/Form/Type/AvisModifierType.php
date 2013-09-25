<?php

namespace Mind\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AvisModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden')
                
            ->add('avisTitre', 'text', 
                    array(
                        'label' => 'Titre :', 
                        'required'  => true,
                        'attr' => array(
                                            'class' => 'input-xlarge'
                                        ),
                        ))
                
                
            ->add('avis', 'textarea',
                        array(
                            'label' => 'Votre avis :', 
                            'required'  => true,
                            'attr' => array(
                                                'class' => 'input-xlarge'
                                            ),
                            ))
                
            ->add('typeOpinion', 'choice',
                            array(
                                'label'     => 'Type d\'opinion :', 
                                'required'  => true,
                                'multiple'  => false,
                                'expanded'  => true,
                                'choices'   => array(
                                                      1 => 'Positive',
                                                      2 => 'Mitigé',
                                                      3 => 'Négative'
                                                        )
                                ))
                
            ->add('avisDomaine', 'entity', array(
                                                'class'     => "MindSiteBundle:Domaine",
                                                'property'  => 'libelle',
                                                'required'  => false,
                                                'expanded'  => true,
                                                'multiple'  => false,
                                                'label'     => "Domaine",
//                                                'attr'      => array(
//                                                                        'name'  => 'domaineParent',
//                                                                        'class' => 'hide'
//                                                                    ),
//                                                'label_attr'    => array(
//                                                                            'class' => 'hide'
//                                                                        )                
                                                
                                            )
                    
                    )
                
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
        return 'mind_sitebundle_avismodifiertype';
    }
}
