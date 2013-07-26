<?php

namespace Nantarena\EventBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventEntryTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entryType', 'entity', array(
                'class' => 'NantarenaEventBundle:EntryType',
                'property' => 'name',
            ))
            ->add('price', 'money')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nantarena\EventBundle\Entity\EventEntryType',
        ));
    }

    public function getName()
    {
        return 'nantarena_eventbundle_evententrytypetype';
    }
}
