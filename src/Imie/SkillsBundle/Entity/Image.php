<?php

namespace Imie\SkillsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Imie\SkillsBundle\Entity\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 */
class Image {

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
     * @ORM\Column(name="imageAlt", type="string", length=255)
     */
    private $imageAlt;

    /**
     * @var string
     *
     * @ORM\Column(name="imageName", type="string", length=255)
     */
    private $imageName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;
    
    private $filenameForRemove;
    
    private $temp;

    public function getAbsolutePath() {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->id.'.'.$this->path;
    }

    public function getWebPath() {
        return null === $this->path ? null : $this->getUploadDir() . '/' .$this->id.'.'. $this->path;
    }

    protected function getUploadRootDir() {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        return 'uploads/img';
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null) {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
       if (null !== $this->file) {
            $this->path = $this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
       if (null === $this->file) {
            return;
        }

        $this->file->move($this->getUploadRootDir(), $this->id.'.'.$this->file->guessExtension());

        unset($this->file);
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove() {
        $this->filenameForRemove = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {
        if ($this->filenameForRemove) {
            unlink($this->filenameForRemove);
        }
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set imageAlt
     *
     * @param string $imageAlt
     * @return Image
     */
    public function setImageAlt($imageAlt) {
        $this->imageAlt = $imageAlt;
        $this->setImageName();

        return $this;
    }

    /**
     * Get imageAlt
     *
     * @return string 
     */
    public function getImageAlt() {
        return $this->imageAlt;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     * @return Image
     */
    public function setImageName() {
        $this->imageName = $this->imageAlt;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName() {
        return $this->imageName;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Image
     */
    public function setPath($path) {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath() {
        return $this->path;
    }

}
