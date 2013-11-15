<?php

namespace Mind\MpBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConversationType extends AbstractType
{
    protected $tabConversation;
    
    public function __construct($tabConversation) {
    
        $this->tabConversation      = $tabConversation;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'choice',
                    array(
                            'multiple'      => true,
                            'expanded'      => true,
                            'required'      => true,
                            'choices'       => $this->tabConversation
                                                        
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
