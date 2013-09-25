<?php

namespace Mind\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageAvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file', 
                    array(
                            'label'             => "Images",
                             'error_bubbling'   => true,
                             'mapped'           => false
                    ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mind\MediaBundle\Entity\ImageAvis'
        ));
    }

    public function getName()
    {
        return 'mind_mediabundle_imageavistype';
    }
}
