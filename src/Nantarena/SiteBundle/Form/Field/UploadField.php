<?php

namespace Nantarena\SiteBundle\Form\Field;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class UploadField extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'empty_message' => 'No file',
            'resource_id' => null
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $view->vars['empty_message'] = $options['empty_message'];
        $view->vars['resource_id'] = $options['resource_id'];
    }

    public function getParent()
    {
        return 'file';
    }

    public function getName()
    {
        return 'upload';
    }
}
