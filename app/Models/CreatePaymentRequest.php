<?php
// app/Models/CreatePaymentRequest.php

namespace App\Models;

use Square\Models\CreatePaymentRequest as SquareCreatePaymentRequest;
use Square\Models\Money;

class CreatePaymentRequest extends SquareCreatePaymentRequest
{
    public function __construct(array $data)
    {
        $data['source_id'] = $data['source_id'] ?? null;  // Ensure source_id is set

        parent::__construct([
            'idempotency_key' => $data['idempotency_key'] ?? null,
            'source_id' => $data['source_id'] ?? null,
            'amount_money' => isset($data['amount_money']) ? new Money($data['amount_money']) : null,
        ]);
    }
}

