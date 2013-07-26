<?php

namespace Nantarena\EventBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class DatesConstraintValidator extends ConstraintValidator
{
    public function validate($event, Constraint $constraint)
    {
        if ($event->getStartDate() >= $event->getEndDate())
            $this->context->addViolationAt('startDate', $constraint->eventDates);

        if ($event->getStartRegistrationDate() >= $event->getEndRegistrationDate())
            $this->context->addViolationAt('startRegistrationDate', $constraint->registrationDates);

        if ($event->getEndRegistrationDate() >= $event->getStartDate())
            $this->context->addViolationAt('endRegistrationDate', $constraint->eventRegistrationDates);
    }
}
