<?php

namespace Nantarena\SiteBundle\Form\Field;

use Nantarena\SiteBundle\Form\Transformer\TypeaheadTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class TypeaheadField extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $transformer = new TypeaheadTransformer($options);
        $builder->addViewTransformer($transformer);
    }

    public function getParent()
    {
        return 'entity';
    }

    public function getName()
    {
        return 'typeahead';
    }
}
