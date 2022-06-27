<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Provider;

use Brammm\TestingWorkshop\Model\Order;
use Brammm\TestingWorkshop\Model\OrderLine;
use Doctrine\DBAL\Connection;
use Money\Money;
use Ramsey\Uuid\Uuid;

class OrderProvider
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }

    /**
     * @return Order[]
     */
    public function findAll(): array
    {
        $data = $this->connection->fetchAllAssociative(
            'SELECT * FROM `order` o INNER JOIN order_line ol ON ol.order_id = o.id'
        );

        $orders = array_values(array_reduce(
            $data,
            function (array $orders, array $row) use ($data) {
                $orders[$row['id']] = [
                    'id' => $row['id'],
                    'customer_id'=> $row['customer_id'],
                    'refunded_at' => $row['refunded_at'],
                ];

                return $orders;
            },
            []
        ));

        foreach ($orders as $i => $order) {
            $orders[$i]['lines'] = $this->collectLines($order['id'], $data);
        }

        $objects = [];
        foreach ($orders as $order) {
            $lines = array_map(static fn (array $row) => new OrderLine(
                Uuid::fromString($row['product_id']),
                $row['amount'],
                Money::EUR($row['price'])
            ), $order['lines']);

            $objects[] = new Order(
                Uuid::fromString($order['id']),
                Uuid::fromString($order['customer_id']),
                $lines,
                $order['refunded_at'] ? new \DateTimeImmutable($order['refunded_at']) : null,
            );
        }

        return $objects;
    }

    private function collectLines(string $orderId, array $data)
    {
        return array_map(static fn (array $row) => [
            'product_id' => $row['product_id'],
            'amount' => $row['amount'],
            'price' => $row['price'],
        ], array_filter($data, static fn (array $row) => $row['id'] === $orderId));
    }
}
