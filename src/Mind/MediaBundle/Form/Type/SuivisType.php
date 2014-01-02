<?php

namespace Mind\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SuivisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idUser',     'hidden')
            ->add('idEntity',   'hidden')
            ->add('typeEntity', 'hidden')
            ->add('disabled',   'hidden')    
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mind\MediaBundle\Entity\Suivis'
        ));
    }

    public function getName()
    {
        return 'mind_mediabundle_suivistype';
    }
}
