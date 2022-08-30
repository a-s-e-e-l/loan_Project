<?php

namespace App\Http\Controllers\Admin\Dash_transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
//        $transactions = Transaction::where('type', $type)->paginate(10);
        $transactions = Transaction::paginate(10);
        return view('Transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('Transactions.create');
    }

    public function store(Request $request)
    {
        if ($request->type == 'debt') {
            $form_data = array(
                'payer_phone' => $request->payer_phone,
                'recipient_phone' => $request->recipient_phone,
                'amount' => $request->amount,
                'type' => 'debt',
                'note' => $request->note,
                'deadline' => $request->deadline,
            );
        } else {
            $form_data = array(
                'payer_phone' => $request->payer_phone,
                'recipient_phone' => $request->recipient_phone,
                'amount' => $request->amount,
                'type' => 'payment',
                'note' => $request->note,
            );
        }
        Transaction::create($form_data);
        return redirect()->to('transactions');
    }

    public function show($id)
    {
        $transaction = Transaction::where('id', $id)->first();
        return view('Transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = Transaction::where('id', $id)->first();
        return view('Transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        Transaction::where('id', $id)->update([
            'payer_phone' => $request->payer_phone,
            'recipient_phone' => $request->recipient_phone,
            'amount' => $request->amount,
            'type' => $request->type,
            'note' => $request->note,
            'deadline' => $request->deadline,
        ]);
        return redirect()->to('transactions');
    }

    public function destroy($id)
    {
        Transaction::destroy($id);
        return redirect()->to('transactions');
    }
}
