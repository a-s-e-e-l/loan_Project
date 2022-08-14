<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Debt;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class paymentController extends Controller
{
    public function add_creditor(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'phone' => 'Required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|not_in:' . $user->phone_number,
            'amount' => 'Required|regex:/^\d+(\.\d{1,2})?$/',
            'deadline' => 'Required',
        ]);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        // is account exist
        $debt = null;
        $creditor_phone = User::where('phone_number', $request->phone)->first();
        if (!empty($creditor_phone)) {
            $debt_debitor = Debt::where('debitor_phone', $user->phone_number)
                ->where('creditor_phone', $request->phone)
                ->first();
            $debt_creditor = Debt::where('creditor_phone', $user->phone_number)
                ->where('debitor_phone', $request->phone)
                ->first();
            $debt = ((empty($debt_debitor) && empty($debt_creditor)) ? null : (empty($debt_creditor))) ? $debt_debitor : $debt_creditor;
        } else {
            User::create(array(
                'phone_number' => $request['phone'],
            ));
        }
        // create user & create debt
        $transaction_data = array(
            'recipient_phone' => $request->phone,
            'payer_phone' => $user->phone_number,
            'amount' => $request['amount'],
            'note' => $request['note'],
            'deadline' => $request['deadline'],
            'type' => "debt",
        );
        $transaction = Transaction::create($transaction_data);
        $amount = $request['amount'];
        if ($debt == null) {
            $debt_data = array(
                'debitor_phone' => $user->phone_number,
                'creditor_phone' => $request->phone,
                'amount_debt' => $request->amount,
                'note' => $request->note,
            );
            Debt::create($debt_data);
        } else {
            if ($debt->creditor_phone == $user->phone_number) {
                $amount *= -1;
            }
            $debt_data = array(
                'amount_debt' => $debt->amount_debt + $amount,
            );
            $debt->update($debt_data);
        }
        $response = [
            'message' => "added creditor",
            'data' => null,
            'success' => true,
        ];
        return response($response, 200);
    }

    public function accept(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'debt_id' => 'Required',
        ]);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        $debt = Debt::where('id', $request['debt_id'])->first;
        $debt->agree = true;
        $debt->save();
        $response = [
            'message' => "Accepted",
            'data' => null,
            'success' => true,
        ];
        return response($response, 200);
    }

    public function add_debitor(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'phone' => 'Required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'amount' => 'Required|regex:/^\d+(\.\d{1,2})?$/',
            'deadline' => 'Required',
        ]);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        // is account exist
        $debt = null;
        $debit_phone = User::where('phone_number', $request->phone)->first();
        if (!empty($debit_phone)) {
            $debt_debitor = Debt::where('debitor_phone', $user->phone_number)
                ->where('creditor_phone', $request->phone)
                ->first();
            $debt_creditor = Debt::where('creditor_phone', $user->phone_number)
                ->where('debitor_phone', $request['phone'])
                ->first();
            $debt = ((empty($debt_debitor) && empty($debt_creditor)) ? null : (empty($debt_creditor))) ? $debt_debitor : $debt_creditor;
        } else {
            User::create(array(
                'phone_number' => $request->phone,
            ));
        }
        // create user & create credit
        $amount = $request['amount'];
        if ($debt == null) {
            $debt_data = array(
                'debitor_phone' => $request->phone,
                'creditor_phone' => $user->phone_number,
                'amount_debt' => $request['amount'],
                'note' => $request->note,
            );
            Debt::create($debt_data);
        } else {
            if ($debt->debitor_phone == $user->phone_number) {
                $amount *= -1;
            }
            $debt->amount_debt = $debt->amount_debt + $amount;
            $debt->save();
        }
        $transaction_data = array(
            'recipient_phone' => $user->phone_number,
            'payer_phone' => $request->phone,
            'amount' => $request['amount'],
            'note' => $request['note'],
            'deadline' => $request['deadline'],
            'type' => "debt",
        );
        $transaction = Transaction::create($transaction_data);
        $response = [
            'message' => "added debitor",
            'data' => null,
            'success' => true,
        ];
        return response($response, 200);
    }
}
