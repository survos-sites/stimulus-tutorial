<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Schranz\Search\SEAL\EngineInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SearchController extends AbstractController
{
    public function __construct(
        private readonly NormalizerInterface $normalizer,
        private readonly EngineInterface $engine
    ) {
    }

    #[Route('/index', name: 'product_index')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        $productObjects = $this->normalizer->normalize($products, null, ['groups' => ['searchable', 'product:read', 'product.read']]);
        foreach ($productObjects as $productObject) {
            $this->engine->saveDocument('product', $productObject);
        }
        dd($productObjects);

        $this->engine->saveDocument('blog', [
            'id' => 1,
            'title' => 'My first blog post',
            'description' => 'This is the description of my first blog post',
            'tags' => ['UI', 'UX'],
        ]);


        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }
}
