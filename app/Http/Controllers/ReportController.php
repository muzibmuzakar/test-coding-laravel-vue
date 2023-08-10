<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReportResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $salary = Transaction::whereHas('coa', function ($query) {
            $query->whereHas('category', function ($query) {
                $query->where('name', 'salary');
            });
        })->get();

        $otherIncome = Transaction::whereHas('coa', function ($query) {
            $query->whereHas('category', function ($query) {
                $query->where('name', 'other income');
            });
        })->get();

        $familyExpanse = Transaction::whereHas('coa', function ($query) {
            $query->whereHas('category', function ($query) {
                $query->where('name', 'Family Expense');
            });
        })->get();

        $transportExpense = Transaction::whereHas('coa', function ($query) {
            $query->whereHas('category', function ($query) {
                $query->where('name', 'Transport Expense');
            });
        })->get();

        $mealExpense = Transaction::whereHas('coa', function ($query) {
            $query->whereHas('category', function ($query) {
                $query->where('name', 'Meal Expense');
            });
        })->get();
        
        return response()->json([
            'salary' => $salary,
            'otherIncome' => $otherIncome,
            'familyExpanse' => $familyExpanse,
            'transportExpense' => $transportExpense,
            'mealExpense' => $mealExpense,
        ]);
    }

    public function filterByMonth($category,$month)
    {
        $salary = Transaction::leftJoin('coas', 'transactions.coa_id', '=', 'coas.id')
        ->leftJoin('categories', 'coas.category_id', '=', 'categories.id')
        ->where('categories.id', $category)
        ->whereMonth('transactions.date', $month)
        ->select(
            'transactions.id',
            'transactions.date',
            'transactions.desc',
            'transactions.debit',
            'transactions.credit',
            'coas.id as coa_id',
            'coas.code as coa_code',
            'coas.name as coa_name',
            'categories.id as category_id',
            'categories.name as category_name',
            'categories.type as category_type',
        )
        ->get();

    return ReportResource::collection($salary);
    }
}
