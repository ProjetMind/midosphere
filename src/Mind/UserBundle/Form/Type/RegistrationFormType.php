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
        parent::buildForm($builder, $options);
        $builder
            ->add('username', 'text', 
                    array(
                        'label' => 'Pseudo :', 
                        'required'  => true,
                        'translation_domain' => 'FOSUserBundle', 
                        'attr' => array(
                                            'class' => 'input-xlarge'
                                        ),
                        'label_attr'    => array(
                                            'class' => 'control-label',
                                            'style' => 'text-align:left;'
                            )
                        )
                  )
            
                
            ->add('dateNaissance',  'birthday', array(
                                                        'label' => "Date de naissance :",
                                                        'translation_domain' => 'FOSUserBundle',
                                                        'required'  => true,
                                                        'widget'    => 'choice',
                                                        'format'    => 'dd-MM-yyyy',
                                                        'years'     => range(2013, 1902),
                                                        'empty_value'   => array(
                                                                                    'year'  => "Année :",
                                                                                    'month' => "Mois :", 
                                                                                    'day'   => "Jour :"
                                                                                ),
                                                        'label_attr'    => array(
                                                                'class' => 'control-label',
                                                                'style' => 'text-align:left;'
                                                                )
            ))
                
            ->add('email', 'repeated', array(
                                                'label' => 'Email :',
                                                'type' => 'email',
                                                'required'  => true,
                                                'options' => array(
                                                                    'translation_domain' => 'MindUserBundle',
                                                                    'attr'  => array(
                                                                                        'class' => 'input-xlarge'
                                                                                    )
                                                                  ),
                                                'first_options' => array('label' => 'Email :'),
                                                'second_options' => array('label' => 'Confirmation email :'),
                                                'invalid_message' => 'fos_user.email.mismatch',
                                                'label_attr'    => array(
                                                                            'class' => 'control-label',
                                                                            'style' => 'text-align:left;'
                                                            )
                                            )
                    )    
                
            ->add('plainPassword', 'repeated', array(
                                                        'label' => 'Mot de passe :',
                                                        'type' => 'password',
                                                        'required'  => true,
                                                        'options' => array(
                                                                            'translation_domain' => 'MindUserBundle',
                                                                            'attr'  => array(
                                                                                                'class' => 'input-xlarge'
                                                                                            )
                                                                            ),
                                                        'first_options' => array('label' => 'Mot de passe :'),
                                                        'second_options' => array('label' => 'Confirmation mot de passe :'),
                                                        'invalid_message' => 'fos_user.password.mismatch',
                                                        'label_attr'    => array(
                                                                                    'class' => 'control-label',
                                                                                    'style' => 'text-align:left;'
                                                                    )
                                                        
                                                    )
            )
            
            ->add('pays',   'country', array(
                                                'label' => "Pays :",
                                                'required' => true,
                                                'translation_domain' => 'FOSUserBundle',
                                                'empty_value'   => false,
                                                'preferred_choices' => array('FR'),
                                                'label_attr'    => array(
                                                                'class' => 'control-label',
                                                                'style' => 'text-align:left;'
                                                )
                                            )
                 )
                
            ->add('sexe',   'choice', array(
                                                'label' => 'Vous êtes :',
                                                'choices' => array(
                                                                      false => 'Un homme',
                                                                      true => 'Une femme'
                                                                        ),
                                                'multiple' => false,
                                                'expanded' => true,
                                                'required' => true,
                                                'label_attr'    => array(
                                                                    'class' => 'control-label',
                                                                    'style' => 'text-align:left;'
                                                    )
            ))    
                
            ->add('cdtGenerales', 'checkbox', array(
                                            'required'  => true,
                                            'label'     => 'J\'accepte les condtions générales d\'utilisation du site :',
                                            'value'     => true,
                                            'label_attr'    => array(
                                                                'class' => 'control-label',
                                                                'style' => 'text-align:left;'
                                                )
                                          )
                  )
            ;
    }

    public function getName()
    {
        return 'mind_user_registration';
    }
}
