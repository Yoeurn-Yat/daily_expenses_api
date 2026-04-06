<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('category')->get();

        return response()->json([
            'data' => $expenses,
            'message' => 'Expenses retrieved successfully',
            'status' => 200
        ], 200);
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric'],
            'icon' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'payment_method' => ['nullable', 'string', 'max:100'],
        ]);

        $input['created_by'] = auth()->id();
        $input['updated_by'] = auth()->id();

        $expense = Expense::create($input);

        return response()->json([
            'data' => $expense->load('category'),
            'message' => 'Expense created successfully',
            'status' => 201
        ], 201);
    }

    public function show(Expense $expense)
    {
        return response()->json([
            'data' => $expense->load('category'),
            'message' => 'Expense retrieved successfully',
            'status' => 200
        ], 200);
    }

    public function update(Request $request, Expense $expense)
    {
        $input = $request->validate([
            'category_id' => ['sometimes', 'required', 'integer', 'exists:categories,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'amount' => ['sometimes', 'required', 'numeric'],
            'icon' => ['sometimes', 'nullable', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'payment_method' => ['sometimes', 'nullable', 'string', 'max:100'],
        ]);

        $input['updated_by'] = auth()->id();
        $expense->update($input);

        return response()->json([
            'data' => $expense->load('category'),
            'message' => 'Expense updated successfully',
            'status' => 200
        ], 200);
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return response()->json([
            'message' => 'Expense deleted successfully',
            'status' => 200
        ], 200);
    }
}
