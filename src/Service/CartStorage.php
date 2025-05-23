<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Repository\ColorRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartStorage
{
    public function __construct(
                                private readonly RequestStack $requestStack,
                                private readonly ProductRepository $productRepository, private readonly ColorRepository $colorRepository)
    {
    }

    public function getSession()
    {
        return $this->requestStack->getSession();
    }

    public function getCart(): ?Cart
    {
        $key = self::getKey();
        if (!$this->getSession()->has($key)) {
            return null;
        }
        $cart = $this->getSession()->get($key);

        if (!$cart instanceof Cart) {
            throw new \InvalidArgumentException('Wrong cart type');
        }

        // create new so if we modify it, but don't want to save back, it's
        // not automatically modified in the session
        $newCart = new Cart();
        // refresh the Products from the database
        foreach ($cart->getItems() as $item) {
            if ($product = $this->productRepository->find($item->getProduct())) {
                $newCart->addItem(new CartItem(
                    $product,
                    $item->getQuantity(),
                    $item->getColor() ? $this->colorRepository->find($item->getColor()) : null
                ));
            }
        }

        return $newCart;
    }

    public function getOrCreateCart(): Cart
    {
        return $this->getCart() ?: new Cart();
    }

    public function save(Cart $cart): void
    {
        $this->getSession()->set(self::getKey(), $cart);
    }

    public function clearCart(): void
    {
        $this->getSession()->remove(self::getKey());
    }

    private static function getKey(): string
    {
        return sprintf('_cart_storage');
    }
}
