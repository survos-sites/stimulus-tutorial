<?php

namespace App\Twig;

use Symfony\Component\Serializer\SerializerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SerializeExtension extends AbstractExtension
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    public function getFilters()
    {
        return [
            new TwigFilter('serialize', $this->serialize(...)),
        ];
    }

    public function serialize($data, string $format = 'json', array $context = []): string
    {
        return $this->serializer->serialize($data, $format, $context);
    }
}
