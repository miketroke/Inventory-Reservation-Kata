<?php

declare(strict_types=1);

namespace MRC\InventoryReservation\Infrastructure\Repository;

interface StockRepository
{
    public function getAvailableStock(string $productId): int;
}
