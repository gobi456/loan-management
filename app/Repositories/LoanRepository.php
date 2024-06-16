<?php

namespace App\Repositories;

use App\Models\LoanDetail;

class LoanRepository implements LoanRepositoryInterface
{
    public function getAllLoans()
    {
        return LoanDetail::all();
    }

    public function getFirstPaymentDate()
    {
        return LoanDetail::min('first_payment_date');
    }

    public function getLastPaymentDate()
    {
        return LoanDetail::max('last_payment_date');
    }
}
