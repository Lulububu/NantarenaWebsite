<?php

namespace Nantarena\ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use EWZ\Bundle\RecaptchaBundle\Validator\Constraints as Recaptcha;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', 'entity', array(
                'class' => 'NantarenaContactBundle:Category',
                'query_builder' => function($repository) { return $repository->createQueryBuilder('p')->orderBy('p.name', 'ASC'); },
                'property' => 'name',
            ))
            ->add('email', 'email')
            ->add('object', 'text')
            ->add('content', 'textarea', array(
                'attr' => array(
                    'class' => 'input-block-level follow_content',
                    'rows' => 10,
                )
            ))
            ->add('recaptcha', 'ewz_recaptcha', array(
                'attr' => array(
                    'options' => array(
                        'theme' => 'clean'
                    )
                ),
                'mapped' => false,
                'constraints'   => array(
                    new Recaptcha\True()
                )
            ))
            ->add('submit', 'submit')
        ;
    }

    public function getName()
    {
        return 'nantarena_contactbundle_contacttype';
    }
}