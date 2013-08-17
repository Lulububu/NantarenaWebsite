<?php

namespace Nantarena\ForumBundle\Form\Type;

use Nantarena\ForumBundle\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('position', 'integer')
            ->add('category', 'entity', array(
                'class' => 'Nantarena\ForumBundle\Entity\Category',
                'property' => 'name',
                'query_builder' => function (CategoryRepository $e) {
                    return $e
                        ->createQueryBuilder('c')
                        ->addOrderBy('c.position', 'asc');
                },
            ))
            ->add('groups', 'entity', array(
                'class' => 'Nantarena\UserBundle\Entity\Group',
                'mapped' => false,
                'multiple' => true,
                'expanded' => true,
            ))
            ->add('submit', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nantarena\ForumBundle\Entity\Forum',
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'nantarena_forum_forumtype';
    }
}