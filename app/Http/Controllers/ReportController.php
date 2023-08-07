<?php

namespace App\Http\Controllers;

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

    public function filterByMonth($month)
    {
        $salary = Transaction::whereHas('coa', function ($query) {
            $query->whereHas('category', function ($query) {
                $query->where('name', 'salary');
            });
        })
        ->whereMonth('date', $month)
        ->get();

        $otherIncome = Transaction::whereHas('coa', function ($query) {
            $query->whereHas('category', function ($query) {
                $query->where('name', 'other income');
            });
        })
        ->whereMonth('date', $month)
        ->get();

        $familyExpanse = Transaction::whereHas('coa', function ($query) {
            $query->whereHas('category', function ($query) {
                $query->where('name', 'Family Expense');
            });
        })
        ->whereMonth('date', $month)
        ->get();

        $transportExpense = Transaction::whereHas('coa', function ($query) {
            $query->whereHas('category', function ($query) {
                $query->where('name', 'Transport Expense');
            });
        })
        ->whereMonth('date', $month)
        ->get();

        $mealExpense = Transaction::whereHas('coa', function ($query) {
            $query->whereHas('category', function ($query) {
                $query->where('name', 'Meal Expense');
            });
        })
        ->whereMonth('date', $month)
        ->get();
        
        return response()->json([
            'salary' => $salary,
            'otherIncome' => $otherIncome,
            'familyExpanse' => $familyExpanse,
            'transportExpense' => $transportExpense,
            'mealExpense' => $mealExpense,
        ]);
    }
}
