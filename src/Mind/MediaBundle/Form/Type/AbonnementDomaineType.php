<?php

namespace Mind\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AbonnementDomaineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idUser', 'hidden')
            ->add('idDomaine', 'hidden')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mind\MediaBundle\Entity\AbonnementDomaine'
        ));
    }

    public function getName()
    {
        return 'mind_mediabundle_abonnementdomainetype';
    }
}
