<?php

namespace Mind\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AvisModifierType extends AbstractType
{
    
    protected $choicesDomaineArray = array();
    
    public function __construct($choicesDomaineArray) {
        $this->choicesDomaineArray = $choicesDomaineArray;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('avisTitre', 'text', 
                    array(
                        'label' => 'Titre :', 
                        'required'  => true,
                        'attr' => array(
                                            'class' => 'input-xxlarge'
                                        ),
                        'label_attr'    => array(
                                            'class' => 'control-label',
                                            'style' => 'text-align:left;'
                            )
                        ))
                
                
            ->add('avis', 'textarea',
                        array(
                            'label' => 'Votre avis :', 
                            'required'  => true,
                            'attr' => array(
                                                'class' => 'input-xxlarge',
                                                'style' => 'height:250px;'
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
                                                        ),
                                'label_attr'    => array(
                                                            'class' => 'control-label',
                                                            'style' => 'text-align:left;'
                                            )
                                ))
                
                
            ->add('avisDomaine', 'choice', array(
                                                'choices'     => $this->choicesDomaineArray,
                                                'required'  => true,
                                                'expanded'  => true,
                                                'multiple'  => false,
                                                'label'     => "Domaines",
                                                'label_attr'    => array(
                                                                            'class' => 'control-label',
                                                                            'style' => 'text-align:left;'
                                                            )
//                                                'attr'      => array(
//                                                                        'name'  => 'domaineParent',
//                                                                        'class' => 'hide'
//                                                                    ),
//                                                'label_attr'    => array(
//                                                                          'class' => 'hide'      
//                                                                       )
                                                
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
