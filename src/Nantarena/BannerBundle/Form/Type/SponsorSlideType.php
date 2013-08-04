<?php

namespace Nantarena\BannerBundle\Form\Type;

use Nantarena\BannerBundle\Entity\SponsorSlide;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SponsorSlideType extends AbstractType
{
    protected $active;

    function __construct($active=true) {
        $this->active = $active;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', 'textarea', array(
                'label' => 'banner.admin.sponsorslide.form.label_content',
                'attr' => array(
                    'class' => 'input-block-level follow_content',
                    'rows' => 10,
                )
            ))
            ->add('active', 'checkbox', array(
                'label'     => 'banner.admin.sponsorslide.form.label_active',
                'required'  => false,
            ))
            ->add('save', 'submit')
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
