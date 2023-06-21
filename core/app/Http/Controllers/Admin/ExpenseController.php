<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Expense;
use App\Models\ExpenseType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index($id = 0)
    {
        $pageTitle    = 'Expenses';
        $categories   = ExpenseType::orderBy('name')->get();
        $expenses     = Expense::dateFilter()->with('expenseType')->latest();

        if ($id) {
            $expenses->where('id', $id);
        }

        if (request()->print) {
            $expenses = $expenses->get();
            return downloadPDF('pdf.expense.list', compact('pageTitle', 'expenses'));
        }

        $expenses = $expenses->paginate(getPaginate());
        $pdfButton = true;
        return view('admin.expense.index', compact('pageTitle', 'expenses', 'categories', 'pdfButton'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'expense_type_id' => 'required|string|max:40|exists:expense_types,id',
            'date_of_expense' => 'required|date',
            'amount'          => 'required|numeric|gte:0',
            'note'            => 'nullable|string',
        ]);

        if ($request->id) {
            $expense      = Expense::findOrFail($id);
            $notification = 'Expense updated successfully';
        } else {
            $expense      = new Expense();
            $notification = 'Expense added successfully';
        }
        $expense->expense_type_id = $request->expense_type_id;
        $expense->date_of_expense     = Carbon::parse($request->date_of_expense);
        $expense->amount              = $request->amount;
        $expense->note                = $request->note;
        $expense->save();
        $notify[]                     = ['success', $notification];

        Action::newEntry($expense, $id ? 'UPDATED' : 'CREATED');
        return back()->withNotify($notify);
    }
}
