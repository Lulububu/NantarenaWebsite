<?php

namespace Nantarena\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nantarena\UserBundle\Entity\User;

/**
 * Post
 *
 * @ORM\Table(name="forum_post")
 * @ORM\Entity(repositoryClass="Nantarena\ForumBundle\Repository\PostRepository")
 */
class Post
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Nantarena\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var Thread
     *
     * @ORM\ManyToOne(targetEntity="Nantarena\ForumBundle\Entity\Thread", inversedBy="posts")
     */
    private $thread;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updateDate", type="datetime")
     */
    private $updateDate;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    public function __construct()
    {
        $this->creationDate = new \DateTime();
        $this->updateDate = new \DateTime();
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
     * Set user
     *
     * @param string $user
     * @return Post
     */
    public function setUser($user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set thread
     *
     * @param string $thread
     * @return Post
     */
    public function setThread($thread)
    {
        $this->thread = $thread;
    
        return $this;
    }

    /**
     * Get thread
     *
     * @return string 
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Post
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    
        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     * @return Post
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
     * Set content
     *
     * @param string $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }
}
