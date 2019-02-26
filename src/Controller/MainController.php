<?php

namespace App\Controller;

use App\Entity\Resources;
use App\Entity\Settings;
use App\Service\BaseController;
use App\Twig\AppExtension;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends BaseController
{
    /**
     * @Route("/", name="main", methods={"GET","HEAD"})
     *
     */
    public function index()
    {
        $homePageId = $this->getDoctrine()->getRepository(Settings::class)->getHomePageId();

        if (($page = $this->getDoctrine()->getRepository(Resources::class)->find($homePageId)) == NULL) {
            throw $this->createNotFoundException('The resources does not exist');
        }
        AppExtension::setGlobals($page);
        return $this->render('landing/index.html.twig', [
            'controller_name' => 'LandingController',
            'page' => $page,
        ]);
    }

    /**
     * @Route("/{slug}", name="page", methods={"GET","HEAD"})
     *
     */
    public function page(string $slug)
    {
        if (($page = $this->getDoctrine()->getRepository(Resources::class)->getResourceBySlug($slug)) == NULL) {
            throw $this->createNotFoundException('The resources does not exist');
        }
        AppExtension::setGlobals($page);
        return $this->render('landing/index.html.twig', [
            'controller_name' => 'LandingController',
        ]);
    }

}
