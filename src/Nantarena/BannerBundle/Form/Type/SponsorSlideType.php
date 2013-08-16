<?php

namespace Nantarena\BannerBundle\Form\Type;

use Nantarena\BannerBundle\Entity\SponsorSlide;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SponsorSlideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', 'wysiwyg_area')
            ->add('active', 'checkbox', array(
                'required'  => false,
            ))
            ->add('submit', 'submit')
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nantarena\BannerBundle\Entity\SponsorSlide'
        ));
    }

    public function getName()
    {
        return 'nantarena_bannerbundle_sponsorslidetype';
    }
}
