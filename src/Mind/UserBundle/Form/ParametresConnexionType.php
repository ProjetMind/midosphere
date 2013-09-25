<?php

namespace Mind\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ParametresConnexionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'repeated', array(
                                                'type' => 'email',
                                                'required'  => false,
                                                'options' => array(
                                                                    'translation_domain' => 'FOSUserBundle',
                                                                    'attr'  => array(
                                                                                        'class' => 'input-xlarge'
                                                                                    )
                                                                  ),
                                                'first_options' => array('label' => 'Email :'),
                                                'second_options' => array('label' => 'Confirmation email :'),
                                                'invalid_message' => 'fos_user.email.mismatch'
                                            )
                    )    
                
            ->add('plainPassword', 'repeated', array(
                                                        'type' => 'password',
                                                        'required'  => false,
                                                        'options' => array(
                                                                            'translation_domain' => 'FOSUserBundle',
                                                                            'attr'  => array(
                                                                                                'class' => 'input-xlarge'
                                                                                            )
                                                                            ),
                                                        'first_options' => array('label' => 'Mot de passe'),
                                                        'second_options' => array('label' => 'Confirmation mot de passe :'),
                                                        'invalid_message' => 'fos_user.password.mismatch'
                                                        
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
        return 'mind_userbundle_parametresconnexionusertype';
    }
}
