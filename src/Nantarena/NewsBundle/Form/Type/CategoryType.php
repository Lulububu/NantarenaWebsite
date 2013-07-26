<?php

namespace Nantarena\NewsBundle\Form\Type;

use Nantarena\NewsBundle\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nantarena\NewsBundle\Entity\Category'
        ));
    }

    public function getName()
    {
        return 'nantarena_newsbundle_categorytype';
    }
}
