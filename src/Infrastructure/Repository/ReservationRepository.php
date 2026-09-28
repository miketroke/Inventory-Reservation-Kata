<?php

declare(strict_types=1);

namespace MRC\InventoryReservation\Infrastructure\Repository;

interface ReservationRepository
{
    public function reserve(string $productId, int $quantity): void;
}
