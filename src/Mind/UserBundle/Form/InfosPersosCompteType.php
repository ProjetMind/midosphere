<?php

namespace Mind\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InfosPersosCompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',   'text', 
                   array(
                            'label'         => "Pseudo :",
                            'required'      => true,
                            'attr'          => array(
                                                        'class' => 'input-xlarge'
                                                    ),
                           'label_attr'     => array(
                                                        'class'     => 'required control-label',
                                                    )
                        )
                    
                 )
                
            ->add('nom', 'text',
                  array(
                            'label'         => "Nom :",
                            'required'      => false,
                            'attr'          => array(
                                                        'class' => 'input-xlarge'
                                                    ),
                       
                        ) 
                 )
                
            ->add('prenom', 'text',
                  array(
                            'label'         => "Prénom :",
                            'required'      => false,
                            'attr'          => array(
                                                        'class' => 'input-xlarge'
                                                    ),
                       
                        )
                 )
                
            ->add('dateNaissance', 'birthday', array(
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
                                                       )
            );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mind\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'mind_user_infospersoscomptetype';
    }
}
