<?php

namespace Student\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Marks
 *
 * @ORM\Table(name="marks", indexes={@ORM\Index(name="fk_student_id", columns={"student_id"}), @ORM\Index(name="fk_subject_id", columns={"subject_id"})})
 * @ORM\Entity
 */
class Marks
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
     * @ORM\Column(name="marks", type="integer", nullable=true)
     */
    private $marks;

    /**
     * @var \Student\Entity\Student
     *
     * @ORM\ManyToOne(targetEntity="Student\Entity\Student")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     * })
     */
    private $student;

    /**
     * @var \Student\Entity\Subject
     *
     * @ORM\ManyToOne(targetEntity="Student\Entity\Subject")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     * })
     */
    private $subject;



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
     * Set marks
     *
     * @param integer $marks
     * @return Marks
     */
    public function setMarks($marks)
    {
        $this->marks = $marks;

        return $this;
    }

    /**
     * Get marks
     *
     * @return integer 
     */
    public function getMarks()
    {
        return $this->marks;
    }

    /**
     * Set student
     *
     * @param \Student\Entity\Student $student
     * @return Marks
     */
    public function setStudent(\Student\Entity\Student $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \Student\Entity\Student 
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set subject
     *
     * @param \Student\Entity\Subject $subject
     * @return Marks
     */
    public function setSubject(\Student\Entity\Subject $subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return \Student\Entity\Subject 
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
