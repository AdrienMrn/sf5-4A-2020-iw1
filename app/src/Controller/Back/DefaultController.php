<?php

namespace App\Controller\Back;

use App\Services\IPLocationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default_index", methods={"GET"})
     */
    public function index(Request $request, IPLocationService $IPLocationService)
    {
        dump($request);
        dump($IPLocationService->getLocationByIP('134.201.250.155'));
        return $this->render('back/default/index.html.twig');
    }
}
