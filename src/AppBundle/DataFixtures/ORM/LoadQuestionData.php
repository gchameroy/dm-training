<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\PoolQuestion;
use AppBundle\Entity\Question;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadQuestionData
 */
class LoadQuestionData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        /** @var PoolQuestion $poolQuestion */
        $poolQuestion = $this->getReference('poolQuestion');

        $question1 = (new Question())
            ->setTitle("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor inc ?")
            ->setPoolQuestion($poolQuestion)
        ;
        $manager->persist($question1);
        $manager->flush();

        $this->addReference('question', $question1);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 20;
    }
}
