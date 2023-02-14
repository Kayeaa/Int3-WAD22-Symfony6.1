<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(): Response
    {
        $user = $this->getUser();
        $produitsFavoris = $user->getProduitsFavoris();
        
        // dump ($produitsFavoris);
        // dump ($produitsFavoris[0]);
        // dump (count ($produitsFavoris));
        // dd();
        $vars = ['produitsFavoris' => $produitsFavoris];

        return $this->render('home/index.html.twig', $vars);
    }
}
