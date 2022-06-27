<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Http;

use Brammm\TestingWorkshop\Provider\ProductProvider;
use Money\MoneyFormatter;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetProducts
{
    public function __construct(
        private readonly ProductProvider $productProvider,
        private readonly MoneyFormatter $formatter,
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $products = $this->productProvider->findAll();

        $data = array_map(fn ($product) => [
            'id' => $product->id->toString(),
            'name' => $product->name,
            'price' => $this->formatter->format($product->price),
        ], $products);

        $response->getBody()->write(json_encode($data));

        return $response->withAddedHeader('Content-type', 'application/json');
    }
}
