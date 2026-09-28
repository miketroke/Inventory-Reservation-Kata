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
        // TODO:
        //
        // Arrange:
        // - Create the StockRepository mock.
        // - Create the ReservationRepository mock.
        // - Define that the product has enough available stock.
        // - Define the expected reservation.
        //
        // Act:
        // - Execute the use case.
        //
        // Assert:
        // - Mockery expectations should verify that the reservation
        //   happened exactly as expected.

        self::markTestIncomplete('Start here: write the first test.');
    }
}
