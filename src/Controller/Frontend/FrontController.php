<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TecnologiaRepository;

final class FrontController extends AbstractController
{
    #[Route('/', name: 'home_page')]
    public function index(TecnologiaRepository $tecnologiaRepository): Response
    {
       
        return $this->render('frontend/front/index.html.twig', [
            'controller_name' => 'Frontend/FrontController',
            'tecnologias' => $tecnologiaRepository->findAll()
        ]);
    }
}
