<?php

namespace Mind\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('questionTitre', 'text',  
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
                
//            ->add('sujet', new \Mind\SiteBundle\Form\Type\SujetAvisType(),
//                            array(
//                                    'error_bubbling'    => true
//                            ))
                
            ->add('question', 'textarea',
                        array(
                            'label' => 'Votre question :', 
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
                
            ->add('questionDomaine', 'entity', array(
                                                'class' => "MindSiteBundle:Domaine",
                                                'property'  => 'libelle',
                                                'required'      => true,
                                                'expanded'  => true,
                                                'multiple'  => false,
                                                'label' => "Domaine :",
                                                'attr'      => array(
                                                                        'name'  => 'domaineParent'
                                                                    ),
                                                'label_attr'    => array(
                                                                            'class' => 'control-label',
                                                                            'style' => 'text-align:left;'
                                                    )
                                                
                                            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mind\SiteBundle\Entity\Question'
        ));
    }

    public function getName()
    {
        return 'mind_sitebundle_questionmodifiertype';
    }
}
