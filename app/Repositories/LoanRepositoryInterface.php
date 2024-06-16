<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class LoanRepositoryInterface.
 */
interface LoanRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function getAllLoans();
    public function getFirstPaymentDate();
    public function getLastPaymentDate();

}
