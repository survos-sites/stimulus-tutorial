<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\AddItemToCartFormType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Meilisearch\Bundle\SearchService;
use Meilisearch\Endpoints\Indexes;
use Meilisearch\Meilisearch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    #[Route(path: '/', name: 'app_homepage')]
    #[Route(path: '/category/{id}', name: 'app_category')]
    public function index(Request $request, CategoryRepository $categoryRepository,
                          SearchService $searchService,
                          EntityManagerInterface $entityManager,
                          ProductRepository $productRepository, ?Category $category = null): Response
    {
        $searchTerm = $request->query->get('q');
        if ($searchTerm) {
            // @todo: set category as a facet and include it here.
            $products = $searchService->search($entityManager, Product::class, $searchTerm);
        } else {
            // with doctrine
            $products = $productRepository->search(
                $category,
                $searchTerm
            );
        }

        if ($request->query->get('preview')) {
            return $this->render('product/_searchPreview.html.twig', [
                'products' => $products,
            ]);
        }

        return $this->render('product/index.html.twig', [
            'currentCategory' => $category,
            'categories' => $categoryRepository->findAll(),
            'products' => $products,
            'searchTerm' => $searchTerm
        ]);
    }

    #[Route(path: '/product/{id}', name: 'app_product', methods: ['GET'])]
    public function showProduct(Request $request, Product $product, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager,
    #[MapQueryParameter] bool $buyNow=false
    ): Response
    {
        if ($buyNow) {
            $product->setStockQuantity($product->getStockQuantity()-1);
            $entityManager->flush();
            if ($referrrer =  $request->headers->get('referer')) {
                if ($referrrer <> $request->getRequestUri()) {
                    return $this->redirect($referrrer);
                }
            }
            $entityManager->refresh($product);
        }

        $addToCartForm = $this->createForm(AddItemToCartFormType::class, null, [
            'product' => $product
        ]);

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'currentCategory' => $product->getCategory(),
            'categories' => $categoryRepository->findAll(),
            'addToCartForm' => $addToCartForm->createView()
        ]);
    }

    #[Route(path: '/buy_now/{id}', name: 'app_product_buy', methods: ['GET'])]
    public function buyNowProduct(Request $request, Product $product, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $product->setStockQuantity($product->getStockQuantity()-1);
        $entityManager->flush();
        if ($referrrer =  $request->headers->get('referer')) {
            if ($referrrer <> $request->getRequestUri()) {
                return $this->redirect($referrrer);
            }
        }
        return $this->redirectToRoute('product_admin_show', ['id' => $product->getId()]);

    }
}
