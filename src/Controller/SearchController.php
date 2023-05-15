<?php

namespace App\Controller;

use App\Repository\SalleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'search')]
    public function index(): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function searchBar()
    {
        return $this->render('search/searchBar.html.twig', []);
    }

    /**
     * @Route("/handleSearch", name="handleSearch")
     * @param Request $request
     */
    public function handleSearch(Request $request, SalleRepository $salleRepository)
    {
        $query = $request->request->all('form')['query'];
        if ($query) {
            $salle = $salleRepository->findSalleByName($query);
        }
        return $this->render('search/index.html.twig', [
            'salle' => $salle
        ]);
    }
}
