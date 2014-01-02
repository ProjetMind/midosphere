<?php

namespace Mind\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AvatarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file', 
                    array(
                            'label'             => "Modifier mon avatar",
                             'error_bubbling'   => true
                    ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mind\MediaBundle\Entity\Avatar'
        ));
    }

    public function getName()
    {
        return 'mind_mediabundle_avatartype';
    }
}
