<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadAnswerData
 */
class LoadAnswerData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        /** @var Question $question */
        $question = $this->getReference('question');

        $answer1 = (new Answer())
            ->setTitle("Lorem ipsum dolor sit amet")
            ->setIsTrue(false)
            ->setQuestion($question)
        ;
        $manager->persist($answer1);

        $answer2 = (new Answer())
            ->setTitle("Lorem ipsum dolor sit amet")
            ->setIsTrue(true)
            ->setQuestion($question)
        ;
        $manager->persist($answer2);

        $answer3 = (new Answer())
            ->setTitle("Lorem ipsum dolor sit amet")
            ->setIsTrue(false)
            ->setQuestion($question)
        ;
        $manager->persist($answer3);

        $answer4 = (new Answer())
            ->setTitle("Lorem ipsum dolor sit amet")
            ->setIsTrue(false)
            ->setQuestion($question)
        ;
        $manager->persist($answer4);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 30;
    }
}
