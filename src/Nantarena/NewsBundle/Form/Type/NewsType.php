<?php

namespace Nantarena\NewsBundle\Form\Type;

use Nantarena\NewsBundle\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'attr' => array(
                    'class' => 'input-block-level',
                )
            ))
            ->add('category')
            ->add('content', 'wysiwyg_area')
            ->add('state', 'choice', array(
                'choices' => array(
                    News::STATE_PUBLISHED => 'news.state.published',
                    News::STATE_UNPUBLISHED => 'news.state.unpublished',
                ),
            ))
            ->add('submit', 'submit')
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
