<?php

namespace Nantarena\NewsBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Nantarena\UserBundle\Entity\User;

/**
 * Class Comment
 *
 * @package Nantarena\NewsBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="news_comment")
 */
class Comment
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Nantarena\UserBundle\Entity\User")
     */
    protected $author;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    protected $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    protected $date;

    /**
     * @var News
     *
     * @ORM\ManyToOne(targetEntity="Nantarena\NewsBundle\Entity\News", inversedBy="comments")
     */
    protected $news;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * @param string $content
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
     * @param \DateTime $date
     * @return $this
     */
    public function setDate(\DateTime $date)
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
     * @param \Nantarena\UserBundle\Entity\User $user
     * @return $this
     */
    public function setAuthor(User $user)
    {
        $this->author = $user;

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
     * @param \Nantarena\NewsBundle\Entity\News $news $news
     * @return $this
     */
    public function setNews(News $news)
    {
        $this->news = $news;

        return $this;
    }

    /**
     * @return \Nantarena\NewsBundle\Entity\News
     */
    public function getNews()
    {
        return $this->news;
    }
}