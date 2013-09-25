<?php

namespace Mind\MpBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConversationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tabParticipants', 'collection',
                    array(
                        'type'          => 'text',
                        'allow_add'     => true,
                        'allow_delete'  => true,
                        'prototype'     => true,
                        'label'         => 'Destinataire(s) :', 
                        'required'      => true,
                        'attr'          => array(
                                                    'class'         => 'input-large hide',
                                                    'placeholder'   => 'Destinataire'
                                            ),
                        'label_attr'    => array(
                                                    'for'           => 'tabDestinataires',
                                                    'class'         => 'hide'
                                                )
                        ))
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mind\MpBundle\Entity\Conversation'
        ));
    }

    public function getName()
    {
        return 'mind_mpbundle_conversationtype';
    }
}
