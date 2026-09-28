<?php

declare(strict_types=1);

namespace MRC\InventoryReservation\Tests;

use MRC\InventoryReservation\Application\ReserveProduct;
use MRC\InventoryReservation\Infrastructure\Repository\ReservationRepository;
use MRC\InventoryReservation\Infrastructure\Repository\StockRepository;
use Mockery;
use PHPUnit\Framework\TestCase;

final class ReserveProductTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_it_reserves_product_when_enough_stock_is_available(): void
    {
        $stock = Mockery::mock(StockRepository::class);
        $reserves = Mockery::mock(ReservationRepository::class);

        $stock
            ->shouldReceive('getAvailableStock')
            ->with('P001')
            ->andReturn(10);

        $reserves
            ->shouldReceive('reserve')
            ->with('P001', 3);

        $service = new ReserveProduct(
            $stock,
            $reserves
        );

        $service->execute('P001', 3);
    }
}
