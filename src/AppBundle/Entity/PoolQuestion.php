<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * PoolQuestion
 *
 * @ORM\Table(name="pool_question")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PoolQuestionRepository")
 */
class PoolQuestion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="rate", type="integer")
     */
    private $rate;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var Question[]|Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Question", mappedBy="poolQuestion", cascade={"persist", "remove"})
     */
    private $questions;

    /**
     * PoolQuestion constructor.
     */
    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return PoolQuestion
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set rate
     *
     * @param integer $rate
     *
     * @return PoolQuestion
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return int
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return PoolQuestion
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return Question[]|Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param Question[]|Collection $questions
     * @return PoolQuestion
     */
    public function setQuestions(Collection $questions)
    {
        $this->questions = new ArrayCollection();

        foreach ($questions as $question) {
            $this->addQuestion($question);
        }

        return $this;
    }

    /**
     * @param Question $question
     * @return PoolQuestion
     */
    public function addQuestion(Question $question)
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $this;
    }
}

