<?php

namespace Mind\MpBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Mind\MpBundle\Entity\ConversationRepository;

class ConversationSupprimerType extends AbstractType
{
    protected $idUser;
    
    public function __construct($idUser) {
    
        $this->idUser = $idUser;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $idUser = $this->idUser;
        
        $builder
            ->add('id', 'entity',
                    array(
                        'class'         => 'MindMpBundle:Conversation',
                        'property'      => 'id',
                        'multiple'      => true,
                        'expanded'      => true,
                        'query_builder' => function(ConversationRepository $em) use($idUser) {
                                                return $em->getConversationQueryBuilder($idUser);
                                            },
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
        return 'mind_mpbundle_conversationsupprimertype';
    }
}
