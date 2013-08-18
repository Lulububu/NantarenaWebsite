<?php

namespace Nantarena\SiteBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TypeaheadTransformer implements DataTransformerInterface
{
    private $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function transform($value)
    {
        $property = $this->options['property'];
        $result = $value;

        foreach ($this->options['choice_list']->getChoices() as $choice) {
            if ($choice->getId() === intval($value)) {
                $result = $choice->{'get'.ucfirst($property)}();
                break;
            }
        }

        return $result;
    }

    public function reverseTransform($value)
    {
        $property = $this->options['property'];
        $result = null;

        foreach ($this->options['choice_list']->getChoices() as $choice) {
            if ($choice->{'get'.ucfirst($property)}() === $value) {
                $result = $choice->getId();
                break;
            }
        }

        if (null === $result)
            throw new TransformationFailedException("The entity doesn't exist.");

        return $result;
    }

}
