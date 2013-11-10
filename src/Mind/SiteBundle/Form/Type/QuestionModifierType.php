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
                                            'class' => 'input-xlarge'
                                        ),
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
                                                'class' => 'input-xlarge'
                                            ),
                            ))
                
            ->add('questionDomaine', 'entity', array(
                                                'class' => "MindSiteBundle:Domaine",
                                                'property'  => 'libelle',
                                                'required'      => true,
                                                'expanded'  => true,
                                                'multiple'  => false,
                                                'label' => "Domaine",
                                                'attr'      => array(
                                                                        'name'  => 'domaineParent'
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
