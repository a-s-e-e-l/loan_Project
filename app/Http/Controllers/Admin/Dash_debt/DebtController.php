<?php

namespace App\Http\Controllers\Admin\Dash_debt;

use App\Http\Controllers\Controller;
use App\Models\Debt;
use App\Models\User;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function index()
    {
        $debts = Debt::paginate(10);
        return view('Debts.index', compact('debts'));
    }

    public function create()
    {
        return view('Debts.create');
    }

    public function store(Request $request)
    {
        $form_data = array(
            'creditor_phone' => $request->creditor_phone,
            'debitor_phone' => $request->debitor_phone,
            'amount_debt' => $request->amount_debt,
            'note' => $request->note,
        );
        Debt::create($form_data);
        return redirect()->to('debts');
    }

    public function show($id)
    {
        $debt = Debt::where('id', $id)->first();
        return view('Debts.show', compact('debt'));
    }

    public function edit($id)
    {
        $debt = Debt::where('id', $id)->first();
        return view('Debts.edit', compact('debt'));
    }

    public function update(Request $request, $id)
    {
        Debt::where('id', $id)->update([
            'creditor_phone' => $request->creditor_phone,
            'debitor_phone' => $request->debitor_phone,
            'amount_debt' => $request->amount_debt,
            'note' => $request->note,
        ]);
        return redirect()->to('debts');
    }

    public function destroy($id)
    {
        Debt::destroy($id);
        return redirect()->to('debts');
    }
}
