<?php

namespace Nantarena\ForumBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Nantarena\UserBundle\Entity\User;

/**
 * Thread
 *
 * @ORM\Table(name="forum_thread")
 * @ORM\Entity(repositoryClass="Nantarena\ForumBundle\Repository\ThreadRepository")
 */
class Thread
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
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="Nantarena\ForumBundle\Entity\Post", mappedBy="thread")
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $posts;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Nantarena\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updateDate", type="datetime")
     */
    private $updateDate;

    /**
     * @var Forum
     *
     * @ORM\ManyToOne(targetEntity="Nantarena\ForumBundle\Entity\Forum", inversedBy="threads")
     */
    private $forum;

    public function __construct()
    {
        $this->updateDate = new \DateTime();
        $this->posts = new ArrayCollection();
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
     * @return Thread
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
     * Set slug
     *
     * @param string $slug
     * @return Thread
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set posts
     *
     * @param string $posts
     * @return Thread
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    
        return $this;
    }

    /**
     * Get posts
     *
     * @return ArrayCollection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set creator
     *
     * @param string $creator
     * @return Thread
     */
    public function setUser($creator)
    {
        $this->user = $creator;
    
        return $this;
    }

    /**
     * Get creator
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     * @return Thread
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;
    
        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime 
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set forum
     *
     * @param Forum $forum
     * @return Thread
     */
    public function setForum($forum)
    {
        $this->forum = $forum;

        return $this;
    }

    /**
     * Get forum
     *
     * @return Forum
     */
    public function getForum()
    {
        return $this->forum;
    }

    public function getLastPage()
    {
        return ceil($this->posts->count() / 20);
    }

    /**
     * @param Post $post
     * @return Thread
     */
    public function addPost(Post $post)
    {
        $this->posts->add($post);

        return $this;
    }

    public function updateActivity()
    {
        $this->updateDate = new \DateTime();
    }
}
