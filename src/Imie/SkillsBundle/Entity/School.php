<?php

namespace Imie\SkillsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * school
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Imie\SkillsBundle\Entity\SchoolRepository")
 */
class School
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
     * @ORM\Column(name="schoolName", type="string", length=255)
     */
    private $schoolName;
    /**
     * @var \Courses
     * @ORM\OneToMany(targetEntity="Course", mappedBy="school", cascade={"remove"})
     */
    private $courses;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
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
     * Set schoolName
     *
     * @param string $schoolName
     * @return school
     */
    public function setSchoolName($schoolName)
    {
        $this->schoolName = $schoolName;

        return $this;
    }

    /**
     * Get schoolName
     *
     * @return string
     */
    public function getSchoolName()
    {
        return $this->schoolName;
    }



    /**
     * Add courses
     *
     * @param \Imie\SkillsBundle\Entity\Course $courses
     * @return School
     */
    public function setCourses(\Imie\SkillsBundle\Entity\Course $courses)
    {
        $this->courses[] = $courses;

        return $this;
    }

    /**
     * Remove courses
     *
     * @param \Imie\SkillsBundle\Entity\Course $courses
     */
    public function removeCourses(\Imie\SkillsBundle\Entity\Course $courses)
    {
        $this->courses->removeElement($courses);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Add courses
     *
     * @param \Imie\SkillsBundle\Entity\Course $courses
     * @return School
     */
    public function addCourse(\Imie\SkillsBundle\Entity\Course $courses)
    {
        $this->courses[] = $courses;

        return $this;
    }

    /**
     * Remove courses
     *
     * @param \Imie\SkillsBundle\Entity\Course $courses
     */
    public function removeCourse(\Imie\SkillsBundle\Entity\Course $courses)
    {
        $this->courses->removeElement($courses);
    }
}
