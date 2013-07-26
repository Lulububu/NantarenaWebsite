<?php

namespace Nantarena\EventBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class EntryTypesConstraintValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (count($value) == 0) {
            $this->context->addViolation($constraint->emptyMessage);
        } else {

            $types = array();

            foreach ($value as $type) {
                #FIXME: Low query performance...
                $types[] = $type->getEntryType()->getName();
            }

            if (count($types) != count(array_unique($types))) {
                $this->context->addViolation($constraint->sameMessage);
            }
        }
    }
}
