<?php

namespace Nantarena\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Entry
 *
 * @ORM\Table(name="event_entry")
 * @ORM\Entity()
 */
class Entry
{
    /**
    * @ORM\Id()
    * @ORM\ManyToOne(
    *   targetEntity="Nantarena\EventBundle\Entity\EntryType")
    * @ORM\JoinColumn(name="event_entry_type_id", referencedColumnName="id", nullable=false)
    */
    private $eventEntryType;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(
     *      targetEntity="Nantarena\UserBundle\Entity\User",
     *      inversedBy="entries")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registration_date", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $registrationDate;

    /**
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     * @return Entry
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;
    
        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime 
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Set eventEntryType
     *
     * @param \Nantarena\EventBundle\Entity\EntryType $eventEntryType
     * @return Entry
     */
    public function setEventEntryType(\Nantarena\EventBundle\Entity\EntryType $eventEntryType)
    {
        $this->eventEntryType = $eventEntryType;
    
        return $this;
    }

    /**
     * Get eventEntryType
     *
     * @return \Nantarena\EventBundle\Entity\EntryType
     */
    public function getEventEntryType()
    {
        return $this->eventEntryType;
    }

    /**
     * Set user
     *
     * @param \Nantarena\UserBundle\Entity\User $user
     * @return Entry
     */
    public function setUser(\Nantarena\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Nantarena\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
