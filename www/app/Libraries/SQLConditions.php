<?php

declare(strict_types=1);

namespace Com\Daw2\Libraries;

readonly class SQLConditions
{
  public function __construct(
    public string $whereSQL,
    public array $valores
  ) {}
}
