<?php

namespace Mind\MpBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('destinataires', 'collection',
                    array(
                        'label'         => 'Destinataires :',
                        'type'          => 'text',
                        'allow_add'     => true,
                        'allow_delete'  => true,
                        'prototype'     => true,
                        'options'  => array(
                                                'required'  => false
                                            ),
                        'attr' => array(
                                            'class' => 'input-xlarge',
                                        ),
                        'label_attr'    => array(
                                            'class' => 'control-label',
                                            'style' => 'text-align:left;'
                            )
                    ))
            ->add('contenuMessage', 'textarea',
                    array(
                            'label'         => "Message :",
                            'required'       => false,
                            'attr' => array(
                                            'class' => 'input-xlarge',
                                        ),
                            'label_attr'    => array(
                                            'class' => 'control-label',
                                            'style' => 'text-align:left;'
                            )
                    ))
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mind\MpBundle\Entity\Message'
        ));
    }

    public function getName()
    {
        return 'mind_mpbundle_messagetype';
    }
}
