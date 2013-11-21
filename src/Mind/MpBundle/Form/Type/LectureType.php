<?php

namespace Mind\MpBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LectureType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('contenuMessage', 'textarea',
                    array(
                            'label'         => "",
                            'required'       => TRUE,
                            'attr'          => array(
                                                        'class' => 'input-xlarge',
                                                        'rows'  => '7',
                                                        'cols'  => '7'
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
        return 'mind_mpbundle_lecturetype';
    }
}
