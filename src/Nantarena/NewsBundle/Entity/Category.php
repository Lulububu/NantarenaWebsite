<?php

namespace Nantarena\NewsBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Category
 *
 * @package Nantarena\NewsBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="news_category")
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=128, unique=true)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Nantarena\NewsBundle\Entity\News", mappedBy="category")
     */
    protected $relatedNews;

    /**
     * Constructeur par défaut
     */
    public function __construct()
    {
        $this->relatedNews = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param array $relatedNews
     * @return $this
     */
    public function setRelatedNews(array $relatedNews)
    {
        $this->relatedNews = $relatedNews;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRelatedNews()
    {
        return $this->relatedNews;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}