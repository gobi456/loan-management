<?php

namespace App\Services;

use App\Repositories\LoanRepositoryInterface;
use Illuminate\Support\Facades\DB;

class LoanService implements LoanServiceInterface
{
    protected $loanRepository;

    public function __construct(LoanRepositoryInterface $loanRepository)
    {
        $this->loanRepository = $loanRepository;
    }

    public function getAllLoans()
    {
        return $this->loanRepository->getAllLoans();
    }

    public function processLoanData()
    {
        $this->createEmiDetailsTable();

        $loans = $this->loanRepository->getAllLoans();
        $this->populateEmiDetailsTable($loans);
    }

    private function createEmiDetailsTable()
    {
        DB::statement('DROP TABLE IF EXISTS emi_details');

        $firstPaymentDate = $this->loanRepository->getFirstPaymentDate();
        $lastPaymentDate = $this->loanRepository->getLastPaymentDate();

        $start = new \DateTime($firstPaymentDate);
        $end = new \DateTime($lastPaymentDate);

        $columns = [];
        while ($start <= $end) {
            $columns[] = $start->format('Y_M');
            $start->modify('first day of next month');
        }

        $columnsSql = implode(' DECIMAL(10, 2) DEFAULT 0.00, ', $columns) . ' DECIMAL(10, 2) DEFAULT 0.00';

        $sql = "CREATE TABLE emi_details (clientid BIGINT, $columnsSql)";
        DB::statement($sql);
    }

    private function populateEmiDetailsTable($loans)
    {
        foreach ($loans as $loan) {
            $emi = $loan->loan_amount / $loan->num_of_payment;
            $emi = round($emi, 2);
            $remaining = $loan->loan_amount;

            $start = new \DateTime($loan->first_payment_date);
            $end = new \DateTime($loan->last_payment_date);

            $columns = [];
            $values = [];
            $sno = 1;
            while ($start <= $end && $remaining > 0) {
                $month = $start->format('Y_M');
                $emi_value = ($sno == $loan->num_of_payment) ? $remaining : $emi;
                $remaining -= $emi_value;

                $columns[] = $month;
                $values[] = $emi_value;

                $start->modify('first day of next month');
                $sno++;
            }

            $columns = implode(', ', $columns);
            $values = implode(', ', $values);

            $sql = "INSERT INTO emi_details (clientid, $columns) VALUES ($loan->clientid, $values)";
            DB::statement($sql);
        }
    }
}
