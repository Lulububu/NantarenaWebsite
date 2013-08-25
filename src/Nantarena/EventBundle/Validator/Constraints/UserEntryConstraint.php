<?php

namespace Nantarena\EventBundle\Validator\Constraints;

use Nantarena\EventBundle\Entity\Event;
use Symfony\Component\Validator\Constraint;

/**
 * Class UserEntryConstraint
 * @package Nantarena\EventBundle\Validator\Constraints
 * @Annotation
 */
class UserEntryConstraint extends Constraint
{
    public $alreadyRegistered = 'event.user.already';

    /**
     * @var \Nantarena\EventBundle\Entity\Event
     */
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
        parent::__construct();
    }

    /**
     * @return \Nantarena\EventBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    public function validatedBy()
    {
        return 'user_entry_constraint';
    }
}
