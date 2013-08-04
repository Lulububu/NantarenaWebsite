<?php

namespace Nantarena\SiteBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;

class ImageTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return $value;
    }

    public function reverseTransform($value)
    {
        if (null === $value)
            return null;

        $url = $value->getUrl();

        if (empty($url))
            return null;

        return $value;
    }

}
