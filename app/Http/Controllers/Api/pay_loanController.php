<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Debt;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class pay_loanController extends Controller
{
    public function Payment(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'phone' => 'Required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'amount' => 'Required|regex:/^\d+(\.\d{1,2})?$/',
        ]);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        $payment = Transaction::where('recipient_phone', $user['phone_number'])
            ->where('payer_phone', $request['phone'])
            ->where('type', "debt")
            ->orWhere('payer_phone', $user['phone_number'])
            ->where('recipient_phone', $request['phone'])
            ->where('type', "debt")
            ->latest()->first();
        $transaction = (empty($payment)) ? null : $payment;
        if ($transaction == null) {
            $response = [
                'message' => "There is no loan to pay off",
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        $amount = $request['amount'];
        $debt_debitor = Debt::where('debitor_phone', $user->phone_number)
            ->where('creditor_phone', $request->phone)
            ->first();
        $debt_creditor = Debt::where('creditor_phone', $user->phone_number)
            ->where('debitor_phone', $request->phone)
            ->first();
        $debt = ((empty($debt_debitor) && empty($debt_creditor)) ? null : (empty($debt_creditor))) ? $debt_debitor : $debt_creditor;
        if ($debt->amount_debt == 0) {
            $response = [
                'message' => "There is no loan to pay off",
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        if ($transaction->payer_phone == $user->phone_number) {
            if ($debt->debitor_phone == $user->phone_number && $debt->amount_debt > 0) {
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
            if ($debt->creditor_phone == $user->phone_number && $debt->amount_debt > 0) {
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
            'message' => "added payment",
            'data' => $t,
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
                'message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        $debt = Transaction::where('id', $request['transaction_id'])->first;
        $debt->agree = true;
        $debt->save();
        $response = [
            'message' => "Accepted",
            'data' => null,
            'success' => true,
        ];
        return response($response, 200);
    }
}
