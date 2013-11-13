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
            
            ->add('destinataire', 'text',
                    array(
                            'label'         => "Destinataires :",
                    ))    
            ->add('contenuMessage', 'textarea',
                    array(
                            'label'         => "Message",
                            'required'       => TRUE
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
