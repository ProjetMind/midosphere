<?php

namespace Mind\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SujetAvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', 'text', 
                    array(
                        'label' => 'Sujet :', 
                        'required'  => true,
                        'error_bubbling'    => true,
                        'attr' => array(
                                            'class' => 'input-xlarge'
                                        ),
                        ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mind\SiteBundle\Entity\SujetAvis'
        ));
    }

    public function getName()
    {
        return 'mind_sitebundle_sujetavistype';
    }
}
