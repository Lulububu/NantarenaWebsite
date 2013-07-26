<?php

namespace Nantarena\EventBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class EntryTypesConstraint
 * @package Nantarena\EventBundle\Validator\Constraints
 * @Annotation
 */
class EntryTypesConstraint extends Constraint
{
    public $emptyMessage = 'You have to add at least one entry type for this event.';
    public $sameMessage = 'You added the same entry type more than once.';
}
