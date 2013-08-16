<?php

namespace Nantarena\BannerBundle\Form\Type;

use Nantarena\BannerBundle\Entity\HeaderNews;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HeaderNewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', 'wysiwyg_area')
            ->add('submit', 'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nantarena\BannerBundle\Entity\HeaderNews'
        ));
    }

    public function getName()
    {
        return 'nantarena_bannerbundle_headernewstype';
    }
}
