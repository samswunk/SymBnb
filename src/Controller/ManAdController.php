<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Ad;

class ManAdController extends AbstractController
{

    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repository, Session $session)
    {
        $Annonces = $repository->findAll();
        return $this->render('ad/index.html.twig', [
            'title'=>"Liste",
            'annonces'=>$Annonces,
        ]);
    }

    /**
     * @Route("/ads/new", name="ads_create")
     * @return Response
     */
    public function create()
    {
        return $this->render('/ad/new.html.twig', [
            'title'=>"Création"
        ]);
    }

    /**
     * @Route("/ads/{slug}",name="ads_show")
     * @return Response
     */
    public function show(Ad $Annonce, Session $session )
    {
        return $this->render('/ad/show.html.twig', [
            'title'=>"Détail",
            'annonce'=>$Annonce,
        ]);
    }
}
