<?php

namespace Nantarena\NewsBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Nantarena\UserBundle\Entity\User;

/**
 * Class News
 *
 * @package Nantarena\NewsBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="news_news")
 */
class News
{
    const STATE_PUBLISHED = true;
    const STATE_UNPUBLISHED = false;

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
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank()
     */
    protected $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    protected $date;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Nantarena\UserBundle\Entity\User")
     */
    protected $author;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Nantarena\NewsBundle\Entity\Category", inversedBy="relatedNews")
     * @Assert\NotNull()
     */
    protected $category;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    protected $content;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=64, unique=true)
     */
    protected $slug;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Nantarena\NewsBundle\Entity\Comment", mappedBy="news", cascade={"remove"})
     */
    protected $comments;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $state = false;

    /**
     * Constructeur par défaut
     */
    public function __construct()
    {
        $this->date = new \DateTime("now");
    }

    /**
     * @param User $author
     * @return $this
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return \Nantarena\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $comments
     * @return $this
     */
    public function setComments(ArrayCollection $comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getState()
    {
        return $this->state;
    }
}