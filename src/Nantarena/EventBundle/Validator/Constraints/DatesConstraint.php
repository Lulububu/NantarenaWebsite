<?php

namespace Nantarena\EventBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class DatesConstraint
 * @package Nantarena\EventBundle\Validator\Constraints
 * @Annotation
 */
class DatesConstraint extends Constraint
{
    public $eventDates = 'The event have to start before it finishes.';
    public $registrationDates = 'The registration have to start before it finishes';
    public $eventRegistrationDates = 'The registration have to end before the event starts';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
