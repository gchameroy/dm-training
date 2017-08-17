<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * PoolVideo
 *
 * @ORM\Table(name="pool_video")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PoolVideoRepository")
 */
class PoolVideo
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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var Video[]|Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Video", mappedBy="poolVideo", cascade={"persist", "remove"})
     */
    private $videos;

    /**
     * PoolVideo constructor.
     */
    public function __construct()
    {
        $this->videos = new ArrayCollection();
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
     * @return PoolVideo
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
     * Set description
     *
     * @param string $description
     *
     * @return PoolVideo
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
     * @return Video[]|Collection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param Video[]|Collection $videos
     * @return PoolVideo
     */
    public function setVideos(Collection $videos)
    {
        $this->videos = new ArrayCollection();

        foreach ($videos as $video) {
            $this->addVideo($video);
        }

        return $this;
    }

    /**
     * @param Video $video
     * @return PoolVideo
     */
    public function addVideo(Video $video)
    {
        if (!$this->videos->contains($video)) {
            $this->videos->add($video);
        }

        return $this;
    }
}

