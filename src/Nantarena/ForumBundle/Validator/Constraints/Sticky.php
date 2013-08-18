<?php

namespace Nantarena\ForumBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Sticky extends Constraint
{
    /**
     * Message de validation
     *
     * @var string
     */
    public $message = 'You don\'t have enough rights to create a sticky topic';

    /**
     * @return string
     */
    public function validatedBy()
    {
        return 'sticky_validator';
    }
}
