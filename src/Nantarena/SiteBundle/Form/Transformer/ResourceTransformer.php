<?php

namespace Nantarena\SiteBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;

class ResourceTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return $value;
    }

    public function reverseTransform($value)
    {
        if (null === $value)
            return null;

        $name = $value->getName();

        if (empty($name))
            return null;

        return $value;
    }

}
