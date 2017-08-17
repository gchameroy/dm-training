<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\PoolVideo;
use AppBundle\Entity\Video;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadVideoData
 */
class LoadVideoData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        /** @var PoolVideo $poolVideo */
        $poolVideo = $this->getReference('poolVideo');

        $video1 = (new Video())
            ->setTitle("Vidéo N°1")
            ->setFile('video1.mp4')
            ->setPoolVideo($poolVideo)
        ;
        $manager->persist($video1);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 20;
    }
}
