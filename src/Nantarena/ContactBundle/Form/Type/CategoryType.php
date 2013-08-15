<?php

namespace Nantarena\ContactBundle\Form\Type;

use Nantarena\ContactBundle\Entity\Category;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('tag', 'text')
            ->add('submit', 'submit')
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nantarena\ContactBundle\Entity\Category'
        ));
    }

    public function getName()
    {
        return 'nantarena_contactbundle_categorytype';
    }
}
