<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class pay_loanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function Payment(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'phone' => 'Required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'amount' => 'Required|regex:/^\d+(\.\d{1,2})?$/',
        ]);
        if ($validator->fails()) {
            $response = [
                'Message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        $payment_debitor = Transaction::where('payer_phone', $user['phone_number'])
            ->where('recipient_phone', $request['phone'])
            ->where('type', "debt")
            ->where('agree', false)
            ->first();
        $payment_creditor = Transaction::where('recipient_phone', $user['phone_number'])
            ->where('payer_phone', $request['phone'])
            ->where('type', "debt")
            ->where('agree', false)
            ->first();
        $transaction = ((empty($payment_debitor) && empty($payment_creditor)) ? null : (empty($payment_debitor))) ? $payment_creditor : $payment_debitor;
        if ($transaction == null) {
            $response = [
                'Message' => "There is no loan to pay off",
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        $amount = $request['amount'];
        $debt_debitor = Debt::where('debitor_phone', $user->phone_number)
            ->where('creditor_phone', $request['phone'])
            ->first();
        $debt_creditor = Debt::where('creditor_phone', $user->phone_number)
            ->where('debitor_phone', $request['phone'])
            ->first();
        $debt = ((empty($debt_debitor) && empty($debt_creditor)) ? null : (empty($debt_creditor))) ? $debt_debitor : $debt_creditor;
        if ($transaction->payer_phone == $user->phone_number) {
            if ($debt->debitor_phone == $user->phone_number) {
                $amount *= -1;
            }
            $debt_data = array(
                'amount_debt' => $debt->amount_debt + $amount,
            );
            $debt->update($debt_data);
            $transaction_data = array(
                'recipient_phone' => $user['phone_number'],
                'payer_phone' => $request['phone'],
                'amount' => $request['amount'],
                'note' => $request['note'],
                'type' => "Payment",
            );
            $t = Transaction::create($transaction_data);
        } else {
            if ($debt->creditor_phone == $user->phone_number) {
                $amount *= -1;
            }
            $debt_data = array(
                'amount_debt' => $debt->amount_debt + $amount,
            );
            $debt->update($debt_data);
            $transaction_data = array(
                'recipient_phone' => $request['phone'],
                'payer_phone' => $user['phone_number'],
                'amount' => $request['amount'],
                'note' => $request['note'],
                'type' => "Payment",
            );
            $t = Transaction::create($transaction_data);
        }
        $response = [
            'Message' => "added payment",
            'data' => null,
            'success' => true,
        ];
        return response($response, 200);
    }


    public function accept(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_id' => 'Required',
        ]);
        if ($validator->fails()) {
            $response = [
                'Message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        $debt = Transaction::where('id', $request['transaction_id'])->first;
        $debt->agree = true;
        $debt->save();
        $response = [
            'Message' => "Accepted",
            'data' => null,
            'success' => true,
        ];
        return response($response, 200);
    }
}
