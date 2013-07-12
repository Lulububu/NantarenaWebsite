<?php

namespace Nantarena\UserBundle\Form\Type;

use Nantarena\NewsBundle\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddUserType extends BaseUserType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'fos_user.password.mismatch',
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nantarena\UserBundle\Entity\User',
            'validation_groups' => array('Registration', 'Default'),
        ));
    }

    public function getName()
    {
        return 'nantarena_userbundle_addusertype';
    }
}
