<?php

namespace Nantarena\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table(name="resource")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Resource
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
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $extension;

    /** @var UploadedFile */
    private $file;

    private $temp;

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
     * @return Resource
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
     * Set extension
     *
     * @param string $extension
     * @return Resource
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set file
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        if (null !== $this->extension) {
            $this->temp = $this->extension;
            $this->extension = null;
        }
    }

    /**
     * Get file
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null === $this->file)
            return;

        $this->extension = $this->file->guessExtension();
        $this->name = $this->file->getClientOriginalName();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file)
            return;

        if (null !== $this->temp) {
            $oldFile = $this->getUploadRootDir() . '/' . sha1($this->id) . '.' . $this->temp;
            if (file_exists($oldFile))
                unlink($oldFile);
        }

        $this->file->move($this->getUploadRootDir(), sha1($this->id) . '.' . $this->extension);
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        $this->temp = $this->getUploadRootDir() . '/' . sha1($this->id) . '.' . $this->extension;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (file_exists($this->temp))
            unlink($this->temp);
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../Upload/resources';
    }
}
