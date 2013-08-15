<?php

namespace Nantarena\ContactBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use Nantarena\ContactBundle\Entity\Category;

class Contact
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="Nantarena\ContactBundle\Entity\Category")
     */
    protected $category;

    /**
     * @Assert\NotBlank()
     */
    protected $email;

    /**
     * @Assert\NotBlank()
     */
    protected $object;

    /**
     * @Assert\NotBlank()
     */
    protected $content;

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $object
     */
    public function setObject($object)
    {
        $this->object = $object;
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }
}