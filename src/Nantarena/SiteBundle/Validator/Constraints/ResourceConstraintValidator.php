<?php

namespace Nantarena\SiteBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\FileValidator;


class ResourceConstraintValidator extends FileValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (null !== $value)
            parent::validate($value->getFile(), $constraint);
    }

}
