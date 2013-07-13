<?php

namespace Nantarena\UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="group")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean", name="default_group")
     */
    protected $default;

    /**
     * Constructor
     */
    public function __construct($name, $roles = array())
    {
        parent::__construct($name, $roles);
        $this->default = false;
    }

    /**
     * @return bool
     */
    function isDefault()
    {
        return $this->default;
    }

    function __toString()
    {
        return $this->getName();
    }
}
