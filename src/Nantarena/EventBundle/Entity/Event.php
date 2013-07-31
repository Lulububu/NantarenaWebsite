<?php

namespace Nantarena\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Nantarena\EventBundle\Validator\Constraints\DatesConstraint;
use Nantarena\EventBundle\Validator\Constraints\EntryTypesConstraint;
use Nantarena\EventBundle\Validator\Constraints\TournamentsConstraint;

/**
 * Event
 *
 * @ORM\Table(name="event_event")
 * @ORM\Entity(repositoryClass="Nantarena\EventBundle\Repository\EventRepository")
 * @UniqueEntity("name")
 * @DatesConstraint(
 *      eventDates="event.dates.eventDates",
 *      registrationDates="event.dates.registrationDates",
 *      eventRegistrationDates="event.dates.eventRegistrationDates"
 * )
 * @TournamentsConstraint(
 *      message="event.tournaments.outDate"
 * )
 */
class Event
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     * @Assert\DateTime()
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime")
     * @Assert\DateTime()
     */
    private $endDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_registration_date", type="datetime")
     * @Assert\DateTime()
     */
    private $startRegistrationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_registration_date", type="datetime")
     * @Assert\DateTime()
     */
    private $endRegistrationDate;

    /**
     * @var int
     *
     * @ORM\Column(name="capacity", type="smallint")
     * @Assert\GreaterThan(value=0)
     */
    private $capacity;

    /**
     * @ORM\OneToOne(
     *      targetEntity="Nantarena\SiteBundle\Entity\Image",
     *      cascade={"persist", "remove"},
     *      orphanRemoval=true)
     */
    private $cover;

    /**
     * @ORM\OneToMany(
     *      targetEntity="Nantarena\EventBundle\Entity\EventEntryType",
     *      mappedBy="event",
     *      cascade={"persist", "remove"})
     * @EntryTypesConstraint(
     *      emptyMessage="event.entrytypes.empty",
     *      sameMessage="event.entrytypes.same"
     * )
     */
    private $entryTypes;

    /**
     * @ORM\OneToMany(
     *      targetEntity="Nantarena\EventBundle\Entity\Tournament",
     *      mappedBy="event",
     *      cascade={"persist", "remove"})
     */
    private $tournaments;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return EntryType
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Event
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    
        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Event
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    
        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set startRegistrationDate
     *
     * @param \DateTime $startRegistrationDate
     * @return Event
     */
    public function setStartRegistrationDate($startRegistrationDate)
    {
        $this->startRegistrationDate = $startRegistrationDate;
    
        return $this;
    }

    /**
     * Get startRegistrationDate
     *
     * @return \DateTime 
     */
    public function getStartRegistrationDate()
    {
        return $this->startRegistrationDate;
    }

    /**
     * Set endRegistrationDate
     *
     * @param \DateTime $endRegistrationDate
     * @return Event
     */
    public function setEndRegistrationDate($endRegistrationDate)
    {
        $this->endRegistrationDate = $endRegistrationDate;
    
        return $this;
    }

    /**
     * Get endRegistrationDate
     *
     * @return \DateTime 
     */
    public function getEndRegistrationDate()
    {
        return $this->endRegistrationDate;
    }

    /**
     * Set capacity
     *
     * @param integer $capacity
     * @return Event
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    
        return $this;
    }

    /**
     * Get capacity
     *
     * @return integer 
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entryTypes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add entryTypes
     *
     * @param \Nantarena\EventBundle\Entity\EventEntryType $entryType
     * @return Event
     */
    public function addEntryType(\Nantarena\EventBundle\Entity\EventEntryType $entryType)
    {
        $entryType->setEvent($this);
        $this->entryTypes->add($entryType);
    
        return $this;
    }

    /**
     * Remove entryTypes
     *
     * @param \Nantarena\EventBundle\Entity\EventEntryType $entryType
     */
    public function removeEntryType(\Nantarena\EventBundle\Entity\EventEntryType $entryType)
    {
        $this->entryTypes->removeElement($entryType);
    }

    /**
     * Get entryTypes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEntryTypes()
    {
        return $this->entryTypes;
    }

    /**
     * Add tournament
     *
     * @param \Nantarena\EventBundle\Entity\Tournament $tournament
     * @return Event
     */
    public function addTournament(\Nantarena\EventBundle\Entity\Tournament $tournament)
    {
        $tournament->setEvent($this);
        $this->tournaments[] = $tournament;
    
        return $this;
    }

    /**
     * Remove tournament
     *
     * @param \Nantarena\EventBundle\Entity\Tournament $tournament
     */
    public function removeTournament(\Nantarena\EventBundle\Entity\Tournament $tournament)
    {
        $this->tournaments->removeElement($tournament);
    }

    /**
     * Get tournaments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTournaments()
    {
        return $this->tournaments;
    }

    /**
     * Set cover
     *
     * @param \Nantarena\SiteBundle\Entity\Image $cover
     * @return Event
     */
    public function setCover(\Nantarena\SiteBundle\Entity\Image $cover = null)
    {
        $this->cover = $cover;
    
        return $this;
    }

    /**
     * Get cover
     *
     * @return \Nantarena\SiteBundle\Entity\Image 
     */
    public function getCover()
    {
        return $this->cover;
    }
}
