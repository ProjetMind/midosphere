<?php

namespace Mind\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InfosPersosLocalisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pays',   'country', array(
                                                'label' => "Pays :",
                                                'required' => true,
                                                'translation_domain' => 'FOSUserBundle',
                                                'empty_value'   => "Pays",
                                                
                                            )
                 )
                
            ->add('ville',   'text', 
                   array(
                            'label'         => "Ville :",
                            'required'      => false,
                            'attr'          => array(
                                                        'class' => 'input-xlarge'
                                                    ),
                           'label_attr'     => array(
                                                        'class'     => 'required control-label',
                                                    )
                        )
                    )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mind\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'mind_userbundle_infospersoslocalisationusertype';
    }
}
