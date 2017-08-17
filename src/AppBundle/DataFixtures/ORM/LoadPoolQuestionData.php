<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\PoolQuestion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * class LoadPoolQuestionData
 */
class LoadPoolQuestionData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $poolQuestion = (new PoolQuestion())
            ->setTitle('Pool questions N°1')
            ->setRate(80)
            ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiu')
        ;
        $manager->persist($poolQuestion);
        $manager->flush();

        $this->addReference('poolQuestion', $poolQuestion);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 10;
    }
}
