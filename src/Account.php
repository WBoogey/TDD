<?php

declare(strict_types=1);

namespace MyWeeklyAllowance;

use InvalidArgumentException;
use RuntimeException;

class Account
{
  private float $balance = 0.0;
  private float $weeklyAllowance = 0.0;

  public function __construct(
    private readonly string $id,
    private readonly string $name,
  ) {}

  public function getId(): string
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getBalance(): float
  {
    return $this->balance;
  }

  public function deposit(float $amount): void
  {
    if ($amount < 0) {
      throw new InvalidArgumentException("Amount cannot be negative.");
    }

    $this->balance += $amount;
  }

  public function spend(float $amount): void
  {
    if ($amount < 0) {
      throw new InvalidArgumentException("Amount cannot be negative.");
    }

    if ($amount > $this->balance) {
      throw new RuntimeException("Insufficient balance.");
    }

    $this->balance -= $amount;
  }

  public function getWeeklyAllowance(): float
  {
    return $this->weeklyAllowance;
  }

  public function setWeeklyAllowance(float $amount): void
  {
    if ($amount < 0) {
      throw new InvalidArgumentException(
        "Weekly allowance cannot be negative.",
      );
    }

    $this->weeklyAllowance = $amount;
  }

  public function applyWeeklyAllowance(): void
  {
    $this->balance += $this->weeklyAllowance;
  }
}
