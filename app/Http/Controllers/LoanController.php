<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanDetail;
use Illuminate\Support\Facades\DB;
use App\Services\LoanServiceInterface;

class LoanController extends Controller
{
    protected $loanService;

    public function __construct(LoanServiceInterface $loanService)
    {
        $this->loanService = $loanService;
    }

    public function index()
    {
        $loans = $this->loanService->getAllLoans();
        return view('loan-details', compact('loans'));
    }

    public function processData()
    {
        $this->loanService->processLoanData();
        return redirect()->route('loan-details')->with('success', 'Loan data processed successfully');
    }
}
