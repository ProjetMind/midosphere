<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mind\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;


class RegistrationFormType extends BaseType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', 
                    array(
                        'label' => 'Pseudo :', 
                        'required'  => true,
                        'translation_domain' => 'FOSUserBundle', 
                        'attr' => array(
                                            'class' => 'input-xlarge'
                                        ),
                        )
                  )
            
                
            ->add('dateNaissance',  'birthday', array(
                                                        'label' => "Date de naissance :",
                                                        'translation_domain' => 'FOSUserBundle',
                                                        'required'  => true,
                                                        'widget'    => 'choice',
                                                        'format'    => 'dd-MM-yyyy',
                                                        'years'     => range(1902, 2013),
                                                        'empty_value'   => array(
                                                                                    'year'  => "Année :",
                                                                                    'month' => "Mois :", 
                                                                                    'day'   => "Jour :"
                                                                                ),
            ))
                
            ->add('email', 'repeated', array(
                                                'type' => 'email',
                                                'required'  => true,
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
                                                        'required'  => true,
                                                        'options' => array(
                                                                            'translation_domain' => 'FOSUserBundle',
                                                                            'attr'  => array(
                                                                                                'class' => 'input-xlarge'
                                                                                            )
                                                                            ),
                                                        'first_options' => array('label' => 'form.password'),
                                                        'second_options' => array('label' => 'Confirmation mot de passe :'),
                                                        'invalid_message' => 'fos_user.password.mismatch',
                                                        
                                                    )
            )
            
            ->add('pays',   'country', array(
                                                'label' => "Pays :",
                                                'required' => true,
                                                'translation_domain' => 'FOSUserBundle',
                                                'empty_value'   => "Pays",
                                                
                                            )
                 )
                
            ->add('sexe',   'choice', array(
                                                'choices' => array(
                                                                      false => 'Masculin',
                                                                      true => 'Féminin'
                                                                        ),
                                                'multiple' => false,
                                                'expanded' => true,
                                                'required' => true,
            ))    
                
            ->add('cdtGenerales', 'checkbox', array(
                                            'required'  => true,
                                            'label'     => 'Condtions',
                                            'value'     => true,
                                          )
                  )
            ;
    }

    public function getName()
    {
        return 'mind_user_registration';
    }
}
