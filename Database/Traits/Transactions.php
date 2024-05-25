<?php

declare(strict_types=1);

namespace Alms\Bundle\DatabaseSeederBundle\Database\Traits;

use Alms\Bundle\DatabaseSeederBundle\Database\Strategy\TransactionStrategy;
use Cycle\Database\DatabaseInterface;
use Cycle\Database\DatabaseProviderInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use PHPUnit\Framework\Attributes;

trait Transactions
{
    private ?TransactionStrategy $transactionStrategy = null;


    public function beginTransaction(): void
    {
        $this->beforeBeginTransaction();

        $this->getTransactionStrategy()->begin();

        $this->afterBeginTransaction();
    }

    public function rollbackTransaction(): void
    {
        $this->beforeRollbackTransaction();

        $this->getTransactionStrategy()->rollback();

        $this->afterRollbackTransaction();
    }

    #[Attributes\Before]
    protected function setUpTransactions(): void
    {
        $this->beginTransaction();
    }

    #[Attributes\After]
    protected function tearDownTransactions(): void
    {
        $this->rollbackTransaction();
    }

    protected function getTransactionStrategy(): TransactionStrategy
    {
        $container = self::$sharedKernel->getContainer();

        if ($this->transactionStrategy === null) {
            $this->transactionStrategy = new TransactionStrategy(
                provider: $container->get(DatabaseProviderInterface::class),
                kernel: self::$sharedKernel,
            );
        }

        return $this->transactionStrategy;
    }

    /**
     * Perform any work before the database transaction has started
     */
    protected function beforeBeginTransaction(): void
    {
        // ...
    }

    /**
     * Perform any work after the database transaction has started
     */
    protected function afterBeginTransaction(): void
    {
        // ...
    }

    /**
     * Perform any work before rolling back the transaction
     */
    protected function beforeRollbackTransaction(): void
    {
        // ...
    }

    /**
     * Perform any work after rolling back the transaction
     */
    protected function afterRollbackTransaction(): void
    {
        // ...
    }
}