<?php

declare(strict_types=1);

namespace MyWeeklyAllowance\Tests;

use PHPUnit\Framework\TestCase;
use MyWeeklyAllowance\Account;
use InvalidArgumentException;
use RuntimeException;

final class AccountTest extends TestCase
{
  public function testNewAccountStartsWithZeroBalance(): void
  {
    $account = new Account("id-1", "Alice");
    $this->assertSame(0.0, $account->getBalance());
  }

  public function testDepositIncreasesBalance(): void
  {
    $account = new Account("id-1", "Alice");
    $account->deposit(50.0);

    $this->assertSame(50.0, $account->getBalance());
  }

  public function testMultipleDepositsAccumulate(): void
  {
    $account = new Account("id-1", "Alice");
    $account->deposit(30.0);
    $account->deposit(20.0);

    $this->assertSame(50.0, $account->getBalance());
  }

  public function testSpendDecreasesBalance(): void
  {
    $account = new Account("id-1", "Alice");
    $account->deposit(100.0);
    $account->spend(30.0);

    $this->assertSame(70.0, $account->getBalance());
  }

  public function testSpendMoreThanBalanceThrowsRuntimeException(): void
  {
    $this->expectException(RuntimeException::class);
    $this->expectExceptionMessage("Insufficient balance.");

    $account = new Account("id-1", "Alice");
    $account->deposit(50.0);
    $account->spend(60.0);
  }

  public function testDepositNegativeAmountThrowsInvalidArgumentException(): void
  {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage("Amount cannot be negative.");

    $account = new Account("id-1", "Alice");
    $account->deposit(-10.0);
  }

  public function testSpendNegativeAmountThrowsInvalidArgumentException(): void
  {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage("Amount cannot be negative.");

    $account = new Account("id-1", "Alice");
    $account->spend(-5.0);
  }

  public function testGetIdReturnsCorrectId(): void
  {
    $account = new Account("teen-123", "Bob");
    $this->assertSame("teen-123", $account->getId());
  }

  public function testGetNameReturnsCorrectName(): void
  {
    $account = new Account("id-1", "Charlie");
    $this->assertSame("Charlie", $account->getName());
  }

  public function testSetWeeklyAllowanceSetsAmount(): void
  {
    $account = new Account("id-1", "Alice");
    $account->setWeeklyAllowance(25.0);

    $this->assertSame(25.0, $account->getWeeklyAllowance());
  }

  public function testSetWeeklyAllowanceNegativeThrowsInvalidArgumentException(): void
  {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage("Weekly allowance cannot be negative.");

    $account = new Account("id-1", "Alice");
    $account->setWeeklyAllowance(-10.0);
  }

  public function testApplyWeeklyAllowanceIncreasesBalance(): void
  {
    $account = new Account("id-1", "Alice");
    $account->setWeeklyAllowance(25.0);
    $account->applyWeeklyAllowance();

    $this->assertSame(25.0, $account->getBalance());
  }

  public function testApplyWeeklyAllowanceMultipleTimes(): void
  {
    $account = new Account("id-1", "Alice");
    $account->setWeeklyAllowance(10.0);
    $account->applyWeeklyAllowance();
    $account->applyWeeklyAllowance();

    $this->assertSame(20.0, $account->getBalance());
  }

  public function testDefaultWeeklyAllowanceIsZero(): void
  {
    $account = new Account("id-1", "Alice");
    $this->assertSame(0.0, $account->getWeeklyAllowance());
  }
}
