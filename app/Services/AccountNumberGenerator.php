<?php

namespace App\Services;

use App\Models\Account;

class AccountNumberGenerator
{
    private string $prefix;
    private int $length;
    private string $separator;
    private bool $includeYear;

    public function __construct(
        string $prefix = 'ACC',
        int $length = 10,
        string $separator = '',
        bool $includeYear = false,
    ) {
        $this->prefix = $prefix;
        $this->length = $length;
        $this->separator = $separator;
        $this->includeYear = $includeYear;
    }

    /**
     * Generate a unique account number.
     *
     * Formats:
     *  - No year, no separator: ACC0000001 (prefix + zero-padded sequence)
     *  - With year + separator:  ACC-2026-00001
     */
    public function generate(): string
    {
        $yearSegment = $this->includeYear ? $this->separator . date('Y') : '';
        $pattern = $this->prefix . $yearSegment . $this->separator;

        // Determine how many digits are left for the sequence
        $fixedLength = strlen($pattern);
        $sequenceLength = max($this->length - $fixedLength, 5);

        // Find the last account matching this pattern
        $lastAccount = Account::where('account_number', 'like', $pattern . '%')
            ->orderByDesc('id')
            ->value('account_number');

        $nextNumber = 1;
        if ($lastAccount) {
            $sequencePart = substr($lastAccount, $fixedLength);
            $nextNumber = (int) $sequencePart + 1;
        }

        return $pattern . str_pad($nextNumber, $sequenceLength, '0', STR_PAD_LEFT);
    }

    // ----- Fluent Configuration Methods -----

    public function prefix(string $prefix): static
    {
        $this->prefix = $prefix;
        return $this;
    }

    public function length(int $length): static
    {
        $this->length = $length;
        return $this;
    }

    public function separator(string $separator): static
    {
        $this->separator = $separator;
        return $this;
    }

    public function withYear(bool $includeYear = true): static
    {
        $this->includeYear = $includeYear;
        return $this;
    }
}
