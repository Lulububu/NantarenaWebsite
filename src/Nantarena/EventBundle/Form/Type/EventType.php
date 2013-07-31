<?php

namespace Nantarena\EventBundle\Form\Type;

use Nantarena\SiteBundle\Form\Transformer\ImageTransformer;
use Nantarena\SiteBundle\Form\Type\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $imageTransformer = new ImageTransformer();

        $builder
            ->add('name', 'text')
            ->add('startDate', 'datetime', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy HH:mm'
            ))
            ->add('endDate', 'datetime', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy HH:mm'
            ))
            ->add('startRegistrationDate', 'datetime', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy HH:mm'
            ))
            ->add('endRegistrationDate', 'datetime', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy HH:mm'
            ))
            ->add('capacity', 'integer', array(
                'attr' => array('min' => 1)
            ))
            ->add('entryTypes', 'collection', array(
                'type' => new EventEntryTypeType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->add('tournaments', 'collection', array(
                'type' => new TournamentType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->add(
                $builder->create('cover', new ImageType(), array(
                    'required' => false,
                    'empty_message' => 'Aucune affiche n\'est liée'
                ))->addViewTransformer($imageTransformer)
            )
            ->add('submit', 'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nantarena\EventBundle\Entity\Event',
        ));
    }

    public function getName()
    {
        return 'nantarena_eventbundle_eventtype';
    }
}
