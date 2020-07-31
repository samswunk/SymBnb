<?php
namespace App\Controller;
use App\Entity\Ad;
use App\Repository\AdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SymBnbController extends AbstractController
{
    /**
     * @Route("/",name="homepage")
     */
    public function home() {
        $Annonces = $this->getDoctrine()
                            ->getRepository(Ad::class)
                            ->findAll();

        return $this->render('home.html.twig', ['title'=>"Accueil",'annonces'=>$Annonces]);
    }
}