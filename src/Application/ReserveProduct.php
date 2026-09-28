<?php

declare(strict_types=1);

namespace MRC\InventoryReservation\Application;

use MRC\InventoryReservation\Domain\Exception\InsufficientStock;
use MRC\InventoryReservation\Domain\Exception\InvalidQuantity;
use MRC\InventoryReservation\Infrastructure\Repository\ReservationRepository;
use MRC\InventoryReservation\Infrastructure\Repository\StockRepository;

final class ReserveProduct
{
    public function __construct(
        private StockRepository $stock,
        private ReservationRepository $reservations,
    ) {
    }

    public function execute(string $productId, int $quantity): void
    {
        if ($quantity <= 0) {
            throw new InvalidQuantity(
                'Quantity must be greater than zero'
            );
        }

        $stockAvailable = $this->stock->getAvailableStock($productId);

        if ($stockAvailable < $quantity) {
            throw new InsufficientStock(
                'Not enough stock available'
            );
        }

        $this->reservations->reserve($productId, $quantity);
    }
}
