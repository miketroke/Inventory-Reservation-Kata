<?php

declare(strict_types=1);

namespace MRC\InventoryReservation\Tests;

use MRC\InventoryReservation\Application\ReserveProduct;
use MRC\InventoryReservation\Domain\Exception\InsufficientStock;
use MRC\InventoryReservation\Domain\Exception\InvalidQuantity;
use MRC\InventoryReservation\Domain\Exception\ProductNotFound;
use MRC\InventoryReservation\Infrastructure\Repository\ReservationRepository;
use MRC\InventoryReservation\Infrastructure\Repository\StockRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class ReserveProductTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private $stock;
    private $reserves;
    private ReserveProduct $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->stock = Mockery::mock(StockRepository::class);
        $this->reserves = Mockery::mock(ReservationRepository::class);

        $this->service = new ReserveProduct(
            $this->stock,
            $this->reserves
        );
    }

    public function test_it_reserves_product_when_enough_stock_is_available(): void
    {
        $this->stock
            ->shouldReceive('getAvailableStock')
            ->with('P001')
            ->andReturn(10);

        $this->reserves
            ->shouldReceive('reserve')
            ->once()
            ->with('P001', 3);

        $this->service->execute('P001', 3);
    }

    public function test_it_throws_exception_when_not_enough_stock_is_available(): void
    {
        $this->stock
            ->shouldReceive('getAvailableStock')
            ->with('P001')
            ->andReturn(2);

        $this->reserves->shouldNotReceive('reserve');

        $this->expectException(InsufficientStock::class);
        $this->expectExceptionMessage('Not enough stock available');

        $this->service->execute('P001', 3);
    }

    public function test_it_throws_exception_when_stock_is_zero(): void
    {
        $this->stock
            ->shouldReceive('getAvailableStock')
            ->with('P001')
            ->andReturn(0);

        $this->reserves->shouldNotReceive('reserve');

        $this->expectException(InsufficientStock::class);
        $this->expectExceptionMessage('Not enough stock available');

        $this->service->execute('P001', 1);
    }

    public function test_it_throws_when_product_does_not_exist(): void
    {
        $this->stock
            ->shouldReceive('getAvailableStock')
            ->once()
            ->with('P999')
            ->andThrow(new ProductNotFound('Product not found'));

        $this->reserves->shouldNotReceive('reserve');

        $this->expectException(ProductNotFound::class);
        $this->expectExceptionMessage('Product not found');

        $this->service->execute('P999', 1);
    }

    /**
     * @dataProvider invalidQuantities
     */
    public function test_it_throws_when_quantity_is_invalid(int $quantity): void
    {
        $this->stock->shouldNotReceive('getAvailableStock');
        $this->reserves->shouldNotReceive('reserve');

        $this->expectException(InvalidQuantity::class);
        $this->expectExceptionMessage('Quantity must be greater than zero');

        $this->service->execute('P001', $quantity);
    }

    public static function invalidQuantities(): array
    {
        return [
            [0],
            [-1],
            [-5],
        ];
    }
}
