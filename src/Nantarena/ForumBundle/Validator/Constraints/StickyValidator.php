<?php

namespace Nantarena\ForumBundle\Validator\Constraints;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class StickyValidator extends ConstraintValidator
{
    /**
     * @var SecurityContext
     */
    private $securityContext;

    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @api
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$this->securityContext->isGranted('ROLE_FORUM_MODERATE') && true === $value) {
            $this->context->addViolation($constraint->message);
        }
    }
}
