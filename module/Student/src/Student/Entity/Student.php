<?php

namespace Student\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Table(name="student", uniqueConstraints={@ORM\UniqueConstraint(name="student_id", columns={"student_id", "class_id"})}, indexes={@ORM\Index(name="class_id", columns={"class_id"})})
 * @ORM\Entity
 */
class Student
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="student_id", type="integer", nullable=true)
     */
    private $studentId;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=30, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=30, nullable=true)
     */
    private $lastName;

    /**
     * @var \Student\Entity\SchoolClass
     *
     * @ORM\ManyToOne(targetEntity="Student\Entity\SchoolClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="class_id", referencedColumnName="id")
     * })
     */
    private $class;



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
     * Set studentId
     *
     * @param integer $studentId
     * @return Student
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;

        return $this;
    }

    /**
     * Get studentId
     *
     * @return integer 
     */
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Student
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Student
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set class
     *
     * @param \Student\Entity\SchoolClass $class
     * @return Student
     */
    public function setClass(\Student\Entity\SchoolClass $class = null)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return \Student\Entity\SchoolClass 
     */
    public function getClass()
    {
        return $this->class;
    }
}
