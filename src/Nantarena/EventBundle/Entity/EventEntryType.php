<?php

namespace Nantarena\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * EventEntryType
 *
 * @ORM\Table(name="event_event_entry_type")
 * @ORM\Entity()
 */
class EventEntryType
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
    * @ORM\ManyToOne(
    *   targetEntity="Nantarena\EventBundle\Entity\Event",
    *   inversedBy="entryTypes")
    * @ORM\JoinColumn(name="event_id", referencedColumnName="id", nullable=false)
    */
    private $event;

    /**
     * @ORM\Column(name="name", type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="decimal")
     * @Assert\GreaterThanOrEqual(value=0)
     */
    private $price;


    /**
     * Set price
     *
     * @param integer $price
     * @return EventEntryType
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set event
     *
     * @param \Nantarena\EventBundle\Entity\Event $event
     * @return EventEntryType
     */
    public function setEvent(\Nantarena\EventBundle\Entity\Event $event)
    {
        $this->event = $event;
    
        return $this;
    }

    /**
     * Get event
     *
     * @return \Nantarena\EventBundle\Entity\Event 
     */
    public function getEvent()
    {
        return $this->event;
    }

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
     * @return EventEntryType
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
}