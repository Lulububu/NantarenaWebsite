<?php

namespace Nantarena\SiteBundle\Twig;

use Doctrine\ORM\PersistentCollection;

class CollectionExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            'min' => new \Twig_Filter_Method($this, 'getMin'),
            'max' => new \Twig_Filter_Method($this, 'getMax'),
        );
    }

    public function getMin(PersistentCollection $collection, $var)
    {
        if (0 === $collection->count())
            return $collection;

        $minObject = $collection[0];
        $minVar = $collection[0]->{'get'.ucfirst($var)}();

        foreach ($collection as $e) {
            $currentVar = $e->{'get'.ucfirst($var)}();
            if ($currentVar < $minVar) {
                $minObject = $e;
                $minVar = $currentVar;
            }
        }

        return $minObject;
    }

    public function getMax(PersistentCollection $collection, $var)
    {
        if (0 === $collection->count())
            return $collection;

        $maxObject = $collection[0];
        $maxVar = $collection[0]->{'get'.ucfirst($var)}();

        foreach ($collection as $e) {
            $currentVar = $e->{'get'.ucfirst($var)}();
            if ($currentVar > $maxVar) {
                $maxObject = $e;
                $maxVar = $currentVar;
            }
        }

        return $maxObject;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'collection_extension';
    }
}
