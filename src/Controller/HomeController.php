<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FicheRepository;
use App\Entity\Fiche;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(FicheRepository $fiche)
    {
        $fiche = $fiche->findOneBy([
            'id' =>1]);
        dump($fiche);
        

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'fiche' => $fiche
        ]);
    }
}
