<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReactiveCartController extends AbstractController
{
    #[Route('/reactive-cart', name: 'app_reactive_cart')]
    public function index(): Response
    {
        return $this->render('cart/reactive-cart.html.twig', [
            'controller_name' => 'ReactiveCartController',
        ]);
    }
}
