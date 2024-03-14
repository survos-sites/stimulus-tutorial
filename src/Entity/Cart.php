<?php

namespace App\Entity;

class Cart
{
    /**
     * @var CartItem[]
     */
    private $items = [];

    /**
     * @return CartItem[]|array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(CartItem $cartItem): CartItem
    {
        foreach ($this->items as $item) {
            if ($cartItem->matches($item)) {
                $item->increaseQuantity($cartItem->getQuantity());

                return $item;
            }
        }

        $this->items[] = $cartItem;

        return $cartItem;
    }

    public function removeItem(CartItem $cartItem): void
    {
        foreach ($this->items as $key => $item) {
            if ($cartItem->matches($item)) {
                unset($this->items[$key]);
                $this->items = array_values($this->items);

                return;
            }
        }
    }

    public function getTotal(): int
    {
        return array_reduce($this->getItems(), fn($accumulator, CartItem $item) => $accumulator + $item->getTotal(), 0);
    }

    public function getTotalString(): string
    {
        return (string) ($this->getTotal() / 100);
    }

    public function countTotalItems(): int
    {
        return array_reduce($this->getItems(), fn($accumulator, CartItem $item) => $accumulator + $item->getQuantity(), 0);
    }

    public function findItem(Product $product, ?Color $color): ?CartItem
    {
        foreach ($this->items as $item) {
            if ($item->getProduct() === $product && $item->getColor() === $color) {
                return $item;
            }
        }

        return null;
    }

    public function hasItem(CartItem $cartItem)
    {
        return (bool) $this->findItem($cartItem->getProduct(), $cartItem->getColor());
    }
}
