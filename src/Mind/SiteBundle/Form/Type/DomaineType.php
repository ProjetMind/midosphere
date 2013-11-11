<?php

namespace Mind\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Mind\SiteBundle\Entity\DomaineRepository;

class DomaineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', 'text',
                    array(
                        'label' => 'Libéllé :', 
                        'required'  => true,
                        'attr' => array(
                                            'class' => 'input-medium',
                                            'placeholder'   => 'Libéllé'
                                        ),
                        )
                 )
            
                
            ->add('etat', 'choice',
                            array(
                                'label' => 'Etat :', 
                                'required'  => true,
                                'multiple' => false,
                                'expanded' => true,
                                'attr'      => array('name' => 'etat'),
                                'choices' => array(
                                                      false => 'Ne pas publié',
                                                      true => 'Publié'
                                                        )
                                )
                )
                
            
                
            ->add('parent',   'entity', array(
                                                'class' => "MindSiteBundle:Domaine",
                                                'property'  => 'libelle',
                                                'required'      => false,
                                                'query_builder' =>  function(DomaineRepository $er) {
                                                                                                return $er->createQueryBuilder('d')
                                                                                                    ->WHERE('d.etat = true')
                                                                                                    ->orderBy('d.libelle', 'DESC');
                                                                                            },
                                                'expanded'  => true,
                                                'multiple'  => false,
                                                'label' => "Domaine",
                                                'attr'      => array(
                                                                        'name'  => 'domaineParent'
                                                                    )
                                                
                                            )
                 )

            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mind\SiteBundle\Entity\Domaine'
        ));
    }

    public function getName()
    {
        return 'mind_sitebundle_domainetype';
    }
}
