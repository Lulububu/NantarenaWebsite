<?php

namespace Nantarena\EventBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class TournamentsConstraintValidator extends ConstraintValidator
{
    public function validate($event, Constraint $constraint)
    {
        $tournaments = $event->getTournaments();
        $error = false;

        foreach($tournaments as $tournament) {
            $startDate = $tournament->getStartDate();

            if ($startDate < $event->getStartDate() || $startDate > $event->getEndDate())
                $error = true;
        }

        if ($error)
            $this->context->addViolationAt('tournaments', $constraint->message);
    }
}
