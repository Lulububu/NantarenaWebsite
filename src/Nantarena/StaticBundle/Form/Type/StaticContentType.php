<?php

namespace Nantarena\StaticBundle\Form\Type;

use Nantarena\StaticBundle\Entity\StaticContent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StaticContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'attr' => array(
                    'class' => 'input-block-level',
                )
            ))
            ->add('content', 'wysiwyg_area')
            ->add('state', 'choice', array(
                'choices' => array(
                    StaticContent::STATE_PUBLISHED => 'static.state.published',
                    StaticContent::STATE_UNPUBLISHED => 'static.state.unpublished',
                ),
            ))
            ->add('submit', 'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nantarena\StaticBundle\Entity\StaticContent'
        ));
    }

    public function getName()
    {
        return 'nantarena_staticbundle_staticcontenttype';
    }
}
