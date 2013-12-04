<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResettingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('new', 'repeated', array(
                                                'type' => 'password',
                                                'options' => array(
                                                                    'translation_domain' => 'FOSUserBundle',
                                                                    'attr' => array(
                                                                                        'class' => 'input-xlarge'
                                                                                    ),
                                                                   ),
                                                'first_options' => array('label' => 'form.new_password'),
                                                'second_options' => array('label' => 'form.new_password_confirmation'),
                                                'invalid_message' => 'fos_user.password.mismatch',
                                                
                                                'label_attr'    => array(
                                                                    'class' => 'control-label',
                                                                    'style' => 'text-align:left;'
                                                    ),
                                                'label' => 'Mot de passe :'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FOS\UserBundle\Form\Model\ChangePassword',
            'intention'  => 'resetting',
        ));
    }

    public function getName()
    {
        return 'fos_user_resetting';
    }
}
