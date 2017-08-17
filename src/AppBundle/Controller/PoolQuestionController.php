<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PoolQuestion;
use AppBundle\Form\PoolQuestionType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
* @Route("/pool_question")
*/
class PoolQuestionController extends Controller
{
    /**
     * @Route("/", name="pool_question")
     */
    public function indexAction(Request $request)
    {
        $poolQuestions = $this->getDoctrine()
            ->getRepository('AppBundle:PoolQuestion')
            ->findAll();

        return $this->render('pool_question/index.html.twig',[
            'poolQuestions' => $poolQuestions
        ]);
    }

    /**
     * @Route("/{id}", name="pool_question_view", requirements={"id": "\d+"})
     * @param integer $id
     * @return Response
     */
    public function viewAction($id)
    {
        $poolQuestion = $this->getDoctrine()->getRepository('AppBundle:PoolQuestion')->find($id);

        if (!$poolQuestion) {
            $this->PoolQuestionNotFound();
        }

        return $this->render('pool_question/view.html.twig',[
            'poolQuestion' => $poolQuestion
        ]);
    }

    public function PoolQuestionNotFound()
    {
        throw $this->createNotFoundException('Pool Question not found.');
    }

    /**
     * @Route("/add", name="pool_question_add")
     * @param Request $request
     * @param EntityManager $em
     * @return Response
     */
    public function addAction(Request $request, EntityManager $em)
    {
        $poolQuestion = new PoolQuestion();
        $form = $this->createForm(PoolQuestionType::class, $poolQuestion);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /* @var EntityManager $em */
            $em->persist($poolQuestion);
            $em->flush();

            $this->addFlash('success', 'Pool Questions ajouté avec succès.');

            return $this->redirectToRoute('pool_question_view', [
                'id' => $poolQuestion->getId(),
            ]);
        }
        return $this->render('pool_question/add.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/edit/{id}", name="pool_question_edit", requirements={"id": "\d+"})
     * @param Request $request, integer $id
     * @return Response
     */
    public function editAction(Request $request, $id)
    {
        $poolQuestion = $this->getDoctrine()->getRepository('AppBundle:PoolQuestion')->find($id);

        if (!$poolQuestion) {
            throw $this->createNotFoundException('Pool Question not found.');
        }

        $form = $this->createForm(PoolQuestionType::class, $poolQuestion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /* @var EntityManager $em */
            $em = $this->get('doctrine')->getManager();
            $em->persist($poolQuestion);
            $em->flush();

            $this->addFlash('success', 'Pool Questions ajouté avec succès.');

            return $this->redirectToRoute('pool_question_view', [
                'id' => $id,
            ]);
        }

        return $this->render('pool_question/edit.html.twig', [
            'form' => $form->createView(),
            'poolQuestion' => $poolQuestion,
        ]);
    }

    /**
     * @Route("/remove/{id}", name="pool_question_remove", requirements={"id": "\d+"})
     * @param integer $id
     * @return RedirectResponse
     */
    public function removeAction($id)
    {
        $poolQuestion = $this->getDoctrine()->getRepository('AppBundle:PoolQuestion')->find($id);

        if (!$poolQuestion) {
            throw $this->createNotFoundException('Pool Question not found.');
        }

        /* @var EntityManager $em */
        $em = $this->get('doctrine')->getManager();
        $em->remove($poolQuestion);
        $em->flush();

        return $this->redirectToRoute('pool_question');
    }
}
