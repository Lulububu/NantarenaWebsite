<?php

namespace Nantarena\SiteBundle\Form\Type;

use Nantarena\SiteBundle\Form\Field\ImgurField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', new ImgurField(), array(
                'empty_message' => $options['empty_message']
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nantarena\SiteBundle\Entity\Image',
            'empty_message' => ''
        ));
    }

    public function getName()
    {
        return 'nantarena_sitebundle_imagetype';
    }
}
