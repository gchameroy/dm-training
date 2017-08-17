<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionRepository")
 */
class Question
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
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     * @Assert\File(
     *     mimeTypes = { "image/png", "image/jpeg" },
     *     mimeTypesMessage = "Please upload a valid image"
     * )
     */
    private $image;

    /**
     * @var PoolQuestion
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PoolQuestion", inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poolQuestion;

    /**
     * @var Answer[]|Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Answer", mappedBy="question", cascade={"persist", "remove"})
     */
    private $answers;

    /**
     * Question constructor.
     */
    public function __construct()
    {
        $this->answers = new ArrayCollection();
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
     * @return Question
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
     * Set image
     *
     * @param string $image
     *
     * @return Question
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return Answer[]|Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param Answer[]|Collection $answers
     * @return Question
     */
    public function setAnswers(Collection $answers)
    {
        $this->answers = new ArrayCollection();

        foreach ($answers as $answer) {
            $this->addAnswer($answer);
        }

        return $this;
    }

    /**
     * @param Answer $answer
     * @return Question
     */
    public function addAnswer(Answer $answer)
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setQuestion($this);
        }

        return $this;
    }

    /**
     * Set PoolQuestion
     *
     * @param PoolQuestion $poolQuestion
     *
     * @return Question
     */
    public function setPoolQuestion(PoolQuestion $poolQuestion)
    {
        $this->poolQuestion = $poolQuestion;

        return $this;
    }

    /**
     * Get Question
     *
     * @return PoolQuestion
     */
    public function getPoolQuestion()
    {
        return $this->poolQuestion;
    }
}

