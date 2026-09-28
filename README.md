# Inventory Reservation Kata

Kata práctica para entrenar **TDD, Clean Code y Mockery** en PHP.

## Objetivo

Implementar un caso de uso que permita reservar stock de un producto:

```php
final class ReserveProduct
```

Debe trabajar contra abstracciones y poder probarse sin base de datos.

## Reglas iniciales

`ReserveProduct::execute(string $productId, int $quantity)` debe:

1. Rechazar cantidades `<= 0`.
2. Consultar el stock mediante `StockRepository`.
3. Si no hay stock suficiente, lanzar una excepción.
4. Si hay stock suficiente, reservar mediante `ReservationRepository`.
5. No devolver nada si la reserva funciona.
6. No conocer detalles de base de datos.
7. Poder probarse sin infraestructura real.

## Interfaces

```php
interface StockRepository
{
    public function getAvailableStock(string $productId): int;
}

interface ReservationRepository
{
    public function reserve(string $productId, int $quantity): void;
}
```

## TDD

Empieza solamente con este caso:

> Cuando existe stock suficiente, debe realizarse la reserva.

**No implementes primero el caso de uso.** Escribe primero el test.

Después:

1. Haz que pase con la implementación mínima.
2. Añade cantidad `0`.
3. Añade cantidad negativa.
4. Añade stock insuficiente.
5. Comprueba que con stock insuficiente no se realiza ninguna reserva.
6. Refactoriza buscando Clean Code.

## Mockery

Los tests deben aislar las dependencias:

```php
$stock = Mockery::mock(StockRepository::class);
$reservations = Mockery::mock(ReservationRepository::class);
```

No hagas mocks de la clase que estás probando.

## Restricciones

- Sin base de datos.
- Sin Eloquent.
- Sin framework.
- Sin acceso al filesystem.
- Sin singletons.
- Sin métodos estáticos para resolver dependencias.
- No implementar funcionalidad que todavía no esté exigida por un test.

## Segunda fase

Después añadiremos, por separado:

- reservas parciales;
- stock reservado;
- diferentes almacenes;
- concurrencia;
- transacciones;
- eventos;
- logging;
- errores del repositorio.

No implementes todavía la segunda fase.

## Comandos

```bash
composer install
vendor/bin/phpunit
vendor/bin/phpunit --testdox
```

### Regla de la kata

**Test → implementación mínima → test → refactor.**

Si te atascas, trae el test que estás escribiendo y lo revisamos sin saltarnos el proceso.
