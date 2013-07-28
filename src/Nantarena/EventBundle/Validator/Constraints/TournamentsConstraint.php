<?php

namespace Nantarena\EventBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class TournamentsConstraint
 * @package Nantarena\EventBundle\Validator\Constraints
 * @Annotation
 */
class TournamentsConstraint extends Constraint
{
    public $message = 'A tournament have to start during the event.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
