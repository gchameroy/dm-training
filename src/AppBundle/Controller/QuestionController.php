<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use AppBundle\Form\QuestionType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class QuestionController extends Controller
{
    /**
     * @Route("/question/add", name="question_add")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        $poolQuestionId = $request->query->get('poolQuestionId');
        $poolQuestion = $this->getDoctrine()->getRepository('AppBundle:PoolQuestion')->find($poolQuestionId);

        $question = new Question();
        for ($i = 0;$i < 4; $i++) {
           $answer = new Answer();
           $question->addAnswer($answer);
        }
        $question->setPoolQuestion($poolQuestion);

        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($question->getImage()) {
                $file = md5(uniqid());
                $filePath = dirname(dirname(dirname(__DIR__))).'/uploads/images/';
                $form['image']->getData()->move($filePath, $file);
                $question->setImage($file);
            }

            /* @var EntityManager $em */
            $em = $this->get('doctrine')->getManager();
            $em->persist($question);
            $em->flush();

            $this->addFlash('success', 'Question ajoutée avec succès.');

            return $this->redirectToRoute('pool_question_view', [
                'id' => $poolQuestionId,
            ]);
        }
        return $this->render('question/add.html.twig', [
            'form' => $form->createView(),
            'poolQuestion' => $poolQuestion
        ]);
    }

    /**
     * @Route("/question/remove/{id}", name="question_remove", requirements={"id": "\d+"})
     * @param integer $id
     * @return RedirectResponse
     */
    public function removeAction($id)
    {
        $question = $this->getDoctrine()->getRepository('AppBundle:Question')->find($id);

        if (!$question) {
            throw $this->createNotFoundException('Question not found.');
        }

        $poolQuestionId = $question->getPoolQuestion()->getId();

        /* @var EntityManager $em */
        $em = $this->get('doctrine')->getManager();
        $em->remove($question);
        $em->flush();

        return $this->redirectToRoute('pool_question_view', ['id' => $poolQuestionId]);
    }
}
