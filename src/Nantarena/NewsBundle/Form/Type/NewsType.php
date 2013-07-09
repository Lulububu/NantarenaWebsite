<?php

namespace Nantarena\NewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('category')
            ->add('content')
            ->add('state', 'choice', array(
                'choices' => array(
                    true => 'news.state.published',
                    false => 'news.state.unpublished'
                ),
            ))
            ->add('save', 'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nantarena\NewsBundle\Entity\News'
        ));
    }

    public function getName()
    {
        return 'nantarena_newsbundle_newstype';
    }
}
