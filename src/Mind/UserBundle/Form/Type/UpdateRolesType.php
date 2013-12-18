<?php

namespace Mind\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UpdateRolesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder   
            ->add('roles', 'choice', 
                    array(
                            'multiple'  => true,
                            'expanded'  => true,
                            'choices'   => array(
                                                    'ROLE_USER'                 => "ROLE_USER",
                                                    'ROLE_MODERATEUR'           => "ROLE_MODERATEUR",
                                                    'ROLE_ADMIN'                => "ROLE_ADMIN",
                                                    'ROLE_SUPER_ADMIN'          => "ROLE_SUPER_ADMIN",
                                                    'ROLE_ALLOWED_TO_SWITCH'    => "ROLE_ALLOWED_TO_SWITCH",
                                                    
                            )
                        ))
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
        return 'mind_userbundle_userupdaterolestype';
    }
}
