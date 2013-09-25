<?php

namespace Mind\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OpinionAvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeOpinion', 'choice',
                            array(
                                'label' => '', 
                                'multiple' => false,
                                'expanded' => true,
                                'choices' => array(
                                                      1 => 'Positive',
                                                      2 => 'Mitigé',
                                                      3 => 'Négative'
                                                        )
                                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mind\MediaBundle\Entity\OpinionAvis'
        ));
    }

    public function getName()
    {
        return 'mind_mediabundle_opinionavistype';
    }
}
