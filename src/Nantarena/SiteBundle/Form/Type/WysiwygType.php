<?php

namespace Nantarena\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WysiwygType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'attr' => array(
                'class' => 'ckeditor',
                'rows'  => 25,
            ),
            'required' => false,
        ));
    }

    public function getParent()
    {
        return 'textarea';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'wysiwyg_area';
    }
}