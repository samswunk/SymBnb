<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AdType;
use App\Repository\AdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ad")
 */
class AdController extends AbstractController
{
    /**
     * @Route("/", name="ad_index", methods={"GET"})
     */
    public function index(AdRepository $adRepository): Response
    {
        return $this->render('/ad/index.html.twig', [
            'title' => "Liste",
            'annonces' => $adRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ad_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ad = new Ad();

        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        IF ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($ad->getImages() as $image)
            {
                $image->setAd($ad);
                $entityManager->persist($image);
            }
            $entityManager->persist($ad);
            $entityManager->flush();

            $this->addFlash('success', "l'annonce <u>{$ad->getTitle()}</u> a bien été enregistrée");

            return $this->redirectToRoute('ad_show', [
                'slug' => $ad->getSlug(),
            ]);
        }

        return $this->render('/ad/new.html.twig', [
            'title' => "Création",
            'annonce' => $ad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="ad_show", methods={"GET"})
     */
    public function show(Ad $ad): Response
    {
        return $this->render('/ad/show.html.twig', [
            'title' => "Détail",
            'annonce' => $ad,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="ad_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ad $ad): Response
    {
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ad_index');
        }

        return $this->render('/ad/edit.html.twig', [
            'title' => "Edition",
            'annonce' => $ad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="ad_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ad $ad): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ad->getSlug(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ad_index');
    }
}
