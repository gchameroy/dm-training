<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VideoRepository")
 */
class Video
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
     * @var string
     *
     * @ORM\Column(name="file", type="string", length=255)
     * @Assert\File(
     *     mimeTypes = { "video/mp4" },
     *     mimeTypesMessage = "Please upload a valid video"
     * )
     */
    private $file;

    /**
     * @var PoolVideo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PoolVideo", inversedBy="videos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poolVideo;

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
     * @return Video
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
     * @return Video
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
     * Set file
     *
     * @param string $file
     *
     * @return Video
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set PoolVideo
     *
     * @param PoolVideo $poolVideo
     *
     * @return Video
     */
    public function setPoolVideo($poolVideo)
    {
        $this->poolVideo = $poolVideo;

        return $this;
    }

    /**
     * Get Video
     *
     * @return PoolVideo
     */
    public function getPoolVideo()
    {
        return $this->poolVideo;
    }
}

