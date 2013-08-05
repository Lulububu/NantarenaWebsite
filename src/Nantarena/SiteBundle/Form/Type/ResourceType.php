<?php

namespace Nantarena\SiteBundle\Form\Type;

use Nantarena\SiteBundle\Form\Field\ImgurField;
use Nantarena\SiteBundle\Form\Field\UploadField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'hidden', array(
                'required' => false
            ));

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($options) {
            $form = $event->getForm();
            $resource = $event->getData();

            $resource_id = '';

            if (null !== $resource && null !== $resource->getId())
                $resource_id = $resource->getId();

            $form->add('file', new UploadField(), array(
                'empty_message' => $options['empty_message'],
                'resource_id' => $resource_id
            ));
        });
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nantarena\SiteBundle\Entity\Resource',
            'empty_message' => ''
        ));
    }

    public function getName()
    {
        return 'nantarena_sitebundle_resourcetype';
    }
}
