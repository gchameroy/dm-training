<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Video;
use AppBundle\Form\VideoType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VideoController extends Controller
{
    /**
     * @Route("/video/add", name="video_add")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        $poolVideoId = $request->query->get('poolVideoId');
        $poolVideo = $this->getDoctrine()->getRepository('AppBundle:PoolVideo')->find($poolVideoId);

        $video = new Video();
        $video->setPoolVideo($poolVideo);

        $form = $this->createForm(VideoType::class, $video);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($video->getFile()) {
                $file = md5(uniqid());
                $filePath = dirname(dirname(dirname(__DIR__))).'/uploads/videos/';
                $form['file']->getData()->move($filePath, $file);
                $video->setFile($file);
            }

            /* @var EntityManager $em */
            $em = $this->get('doctrine')->getManager();
            $em->persist($video);
            $em->flush();

            $this->addFlash('success', 'Video ajoutée avec succès.');

            return $this->redirectToRoute('pool_video_view', [
                'id' => $poolVideoId,
            ]);
        }
        return $this->render('video/add.html.twig', [
            'form' => $form->createView(),
            'poolVideo' => $poolVideo
        ]);
    }

    /**
     * @Route("/video/remove/{id}", name="video_remove", requirements={"id": "\d+"})
     * @param integer $id
     * @return RedirectResponse
     */
    public function removeAction($id)
    {
        $video = $this->getDoctrine()->getRepository('AppBundle:Video')->find($id);

        if (!$video) {
            throw $this->createNotFoundException('Video not found.');
        }

        $poolVideoId = $video->getPoolVideo()->getId();

        /* @var EntityManager $em */
        $em = $this->get('doctrine')->getManager();
        $em->remove($video);
        $em->flush();

        return $this->redirectToRoute('pool_video_view', ['id' => $poolVideoId]);
    }
}
