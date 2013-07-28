<?php

namespace Nantarena\EventBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TournamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('game', 'entity', array(
                'class' => 'NantarenaEventBundle:Game',
                'property' => 'name',
            ))
            ->add('admin', 'entity', array(
                'class' => 'NantarenaUserBundle:User',
                'property' => 'username',
            ))
            ->add('maxTeams', 'integer', array(
                'attr' => array('min' => 2)
            ))
            ->add('startDate', 'datetime', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy HH:mm'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nantarena\EventBundle\Entity\Tournament',
        ));
    }

    public function getName()
    {
        return 'nantarena_eventbundle_tournamenttype';
    }
}
