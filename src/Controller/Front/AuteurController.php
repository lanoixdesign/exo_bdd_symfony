<?php

namespace App\Controller\Front;

use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuteurController extends AbstractController
{
    /**
     * @Route("auteurs", name="auteurs_list")
     */
    public function auteurs(AuteurRepository $auteurRepository)
    {
        $auteurs = $auteurRepository->findAll();

        return $this->render('front/auteurs/auteurs.html.twig', [
            'auteurs' => $auteurs
        ]);
    }


    /**
     * @Route("auteur/show/{id}", name="auteur_show")
     */
    public function auteur(AuteurRepository $auteurRepository, $id)
    {
        $auteur = $auteurRepository->find($id);

        return $this->render('front/auteurs/auteur.html.twig', [
            'auteur' => $auteur
        ]);
    }
}
