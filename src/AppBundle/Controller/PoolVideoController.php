<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PoolVideo;
use AppBundle\Form\PoolVideoType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
* @Route("/pool_video")
*/
class PoolVideoController extends Controller
{
    /**
     * @Route("/", name="pool_video")
     */
    public function indexAction(Request $request)
    {
        $poolVideos = $this->getDoctrine()
            ->getRepository('AppBundle:PoolVideo')
            ->findAll();

        return $this->render('pool_video/index.html.twig',[
            'poolVideos' => $poolVideos
        ]);
    }

    /**
     * @Route("/{id}", name="pool_video_view", requirements={"id": "\d+"})
     * @param integer $id
     * @return Response
     */
    public function viewAction($id)
    {

        $PoolVideo = $this->getDoctrine()->getRepository('AppBundle:PoolVideo')->find($id);
        dump($PoolVideo);
        if (!$PoolVideo) {
            $this->PoolVideoNotFound();
        }

        return $this->render('pool_video/view.html.twig',[
            'poolVideo' => $PoolVideo
        ]);
    }

    public function PoolVideoNotFound()
    {
        throw $this->createNotFoundException('Pool Video not found.');
    }

    /**
     * @Route("/add", name="pool_video_add")
     * @param Request $request
     * @param EntityManager $em
     * @return Response
     */
    public function addAction(Request $request, EntityManager $em)
    {
        $PoolVideo = new PoolVideo();
        $form = $this->createForm(PoolVideoType::class, $PoolVideo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /* @var EntityManager $em */
            $em->persist($PoolVideo);
            $em->flush();

            $this->addFlash('success', 'Pool Videos ajouté avec succès.');

            return $this->redirectToRoute('pool_video_view', [
                'id' => $PoolVideo->getId(),
            ]);
        }
        return $this->render('pool_video/add.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/edit/{id}", name="pool_video_edit", requirements={"id": "\d+"})
     * @param Request $request, integer $id
     * @return Response
     */
    public function editAction(Request $request, $id)
    {
        $poolVideo = $this->getDoctrine()->getRepository('AppBundle:PoolVideo')->find($id);

        if (!$poolVideo) {
            throw $this->createNotFoundException('Pool Video not found.');
        }

        $form = $this->createForm(PoolVideoType::class, $poolVideo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /* @var EntityManager $em */
            $em = $this->get('doctrine')->getManager();
            $em->persist($poolVideo);
            $em->flush();

            $this->addFlash('success', 'Pool Videos ajouté avec succès.');

            return $this->redirectToRoute('pool_video_view', [
                'id' => $id,
            ]);
        }

        return $this->render('pool_video/edit.html.twig', [
            'form' => $form->createView(),
            'poolVideo' => $poolVideo,
        ]);
    }

    /**
     * @Route("/remove/{id}", name="pool_video_remove", requirements={"id": "\d+"})
     * @param integer $id
     * @return RedirectResponse
     */
    public function removeAction($id)
    {
        $poolVideo = $this->getDoctrine()->getRepository('AppBundle:PoolVideo')->find($id);

        if (!$poolVideo) {
            throw $this->createNotFoundException('Pool Video not found.');
        }

        /* @var EntityManager $em */
        $em = $this->get('doctrine')->getManager();
        $em->remove($poolVideo);
        $em->flush();

        return $this->redirectToRoute('pool_video');
    }
}
