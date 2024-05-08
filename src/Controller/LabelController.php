<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LabelController extends AbstractController
{
    #[Route('/label', name: 'app_label')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/labels.html.twig', [
            'products' => $productRepository->findBy([], limit: 5)
        ]);
    }
}
