<?php

declare(strict_types=1);

namespace MRC\InventoryReservation\Domain\Exception;

use RuntimeException;

final class InsufficientStock extends RuntimeException
{
}
