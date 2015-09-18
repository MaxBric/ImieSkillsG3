<?php

namespace Imie\SkillsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Imie\SkillsBundle\Entity\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
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
    public $path;
    
    private $file;
    

    private $imageFileToDelete;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->id.'.'.$this->path;
    }

    public function getWebPath()
    {
        return $this->getUploadDir().'/'.$this->id.'.'.$this->path;
    }
    /**
     * Set imageAlt
     *
     * @param string $imageAlt
     * @return Image
     */
    public function setImageAlt($imageAlt)
    {
        $this->imageAlt = $imageAlt;
        $this->setImageName();
      

        return $this;
    }

    /**
     * Get imageAlt
     *
     * @return string 
     */
    public function getImageAlt()
    {
        return $this->imageAlt;
    }
    
    public function getUploadRootDir(){
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
        
    }
    
    public function getUploadDir(){
        return 'uploads/img';
    }
    
    /**
     * @ORM\Prepersist()
     * @ORM\PreUpdate()
     */
    public function preUpload(){
        if (null === $this->file) {
            return;
        }
        $this->path = $this->file->guessExtension();
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload(){
        if (null === $this->file) {
            return;
        }
        
        $this->file->move($this->getUploadRootDir(), $this->id.'.'.$this->file->guessExtension());
        
    }
    
    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload(){
        $this->imageFileToDelete = $this->getAbsolutePath();
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload(){
        if (file_exists($this->imageFileToDelete)) {
            unlink($this->imageFileToDelete);
        }
    }
    
    function getFile() {
        return $this->file;
    }

    function setFile($file) {
        $this->file = $file;
        return $this;
    }
    

    /**
     * Set imageName
     *
     * @param string $imageName
     * @return Image
     */
    public function setImageName()
    {
        $this->imageName = $this->imageAlt;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->imageName;
    }
}
