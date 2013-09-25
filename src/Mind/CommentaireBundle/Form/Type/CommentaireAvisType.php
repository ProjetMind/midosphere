<?php

namespace Mind\CommentaireBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentaireAvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commentaire', 'textarea',
                    array(
                            'label'         => 'Commentaire',
                            'required'  => true,
                            'attr' => array(
                                                'class' => '',
                                                'id'    => 'formTextareaCom'
                                            )
                        )
                  )
                
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mind\CommentaireBundle\Entity\CommentaireAvis'
        ));
    }

    public function getName()
    {
        return 'mind_commentairebundle_commentaireavistype';
    }
}
