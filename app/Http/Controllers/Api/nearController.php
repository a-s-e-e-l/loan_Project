<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Debt;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class nearController extends Controller
{
    public function near_debt()
    {
        $user = Auth::user();
//        $t_debitor = Transaction::where('recipient_phone', $user->phone_number)
//            ->where('type', "debt")
//            ->orderBy('deadline')
//            ->where('deadline', '>', Carbon::now())
//            ->latest()->first();
//        $deadline_debitor = (empty($t_debitor)) ? null : $t_debitor->deadline;
//
//        $t_creditor = Transaction::where('payer_phone', $user->phone_number)
//            ->where('type', "debt")
//            ->orderBy('deadline')
//            ->where('deadline', '>', Carbon::now())
//            ->latest()->first();
//        $deadline_creditor = (empty($t_creditor)) ? null : $t_creditor->deadline;
//        $near_creditor = null;
//        if (!empty($t_creditor)) {
//            $debt_creditor = Debt::where('creditor_phone', $t_creditor->recipient_phone)
//                ->where('debitor_phone', $user->phone_number)
//                ->where('amount_debt', '>', 0)
//                ->orWhere('debitor_phone', $t_creditor->recipient_phone)
//                ->where('creditor_phone', $user->phone_number)
//                ->where('amount_debt', '<', 0)
//                ->first();
//            $near_creditor = (empty($debt_creditor)) ? null :
//                (($debt_creditor->debitor_phone == $user->phone_number) ? collect($debt_creditor)->only('creditor_phone', 'amount_debt') :
//                    collect($debt_creditor)->only('debitor_phone', 'amount_debt'));
//        }
//        $near_debitor = null;
//        if (!empty($t_debitor)) {
//            $debt_debitor = Debt::
//            where('debitor_phone', $t_debitor->payer_phone)
//                ->where('creditor_phone', $user->phone_number)
//                ->where('amount_debt', '>', 0)
//                ->orWhere('creditor_phone', $t_debitor->payer_phone)
//                ->where('debitor_phone', $user->phone_number)
//                ->where('amount_debt', '<', 0)
//                ->first();
//            $near_debitor = (empty($debt_debitor)) ? null :
//                (($debt_debitor->debitor_phone == $user->phone_number) ? collect($debt_debitor)->only('creditor_phone', 'amount_debt') :
//                    collect($debt_debitor)->only('debitor_phone', 'amount_debt'));
//        }
//        $dead_creditor = (empty($near_creditor)) ? null : $deadline_creditor;
//        $dead_debitor = (empty($near_debitor)) ? null : $deadline_debitor;

        $getalltotalRed = Debt::select('amount_debt')
            ->where('creditor_phone', $user->phone_number)
            ->where('amount_debt', '>', 0)
            ->orWhere('debitor_phone', $user->phone_number)
            ->where('amount_debt', '<', 0)
            ->get()
            ->toArray();
        $negative = 0;
        $positive = 0;
        foreach ($getalltotalRed as $value) {
            $amount = $value['amount_debt'];
            if ($amount < 0) {
                $negative += -$amount;
            } else {
                $positive += $amount;
            }
        }
        $total = $positive + $negative;
        $dataRed = array(
            'amount_debt' => $total,
        );

        $getalltotalGreen = Debt::select('amount_debt')
            ->where('debitor_phone', $user->phone_number)
            ->where('amount_debt', '>', 0)
            ->orWhere('creditor_phone', $user->phone_number)
            ->where('amount_debt', '<', 0)
            ->get()
            ->toArray();
        $negative = 0;
        $positive = 0;
        foreach ($getalltotalGreen as $value) {
            $amount = $value['amount_debt'];
            if ($amount < 0) {
                $negative += -$amount;
            } else {
                $positive += $amount;
            }
        }
        $total = $positive + $negative;
        $dataGreen = array(
//            'positive' => $positive,
//            'negative' => $negative,
            'amount_debt' => $total,
        );

        $response = [
            'message' => 'Near Creditor & Near Debitor',
            'data' => [
//                'near creditor' => $near_creditor,
                'near creditor' => $dataGreen,
//                'deadline creditor' => $dead_creditor,
//                'near debitor' => $near_debitor,
                'near debitor' => $dataRed,
//                'deadline debitor' => $dead_debitor,
//                'near debitor' => $near_creditor,
//                'deadline debitor' => $dead_creditor,
//                'near creditor' => $near_debitor,
//                'deadline creditor' => $dead_debitor,
            ],
            'success' => true,
        ];
        return response($response, 200);
    }

    public function transaction(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'select_phone' => 'Required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'page_size' => 'Required',
        ]);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        $debts = Debt::where('creditor_phone', $request->select_phone)
            ->where('debitor_phone', $user->phone_number)
            ->orWhere('debitor_phone', $request->select_phone)
            ->where('creditor_phone', $user->phone_number)
            ->first();
        $debt = (empty($debts)) ? null : $debts;
        if (empty($debt)) {
            $response = [
                'message' => 'Error User Select',
                'data' => $debt,
                'success' => false,
            ];
            return response($response, 200);
        }
        $transactions = Transaction::select('payer_phone', 'recipient_phone', 'amount', 'created_at', 'type')
            ->where('payer_phone', $debt->debitor_phone)
            ->where('recipient_phone', $debt->creditor_phone)
            ->orWhere('payer_phone', $debt->creditor_phone)
            ->where('recipient_phone', $debt->debitor_phone)
            ->orderBy('created_at', 'desc')
            ->paginate($request->page_size);
        $response = [
            'message' => 'Select User',
            'data' => $transactions,
            'success' => true,
        ];
        return response($response, 200);
    }

    public function select_user(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'select_phone' => 'Required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        $debts = Debt::where('creditor_phone', $request->select_phone)
            ->where('debitor_phone', $user->phone_number)
            ->orWhere('debitor_phone', $request->select_phone)
            ->where('creditor_phone', $user->phone_number)
            ->first();
        $debt = (empty($debts)) ? null : $debts;
        if (empty($debt)) {
            $response = [
                'message' => 'Error User Select',
                'data' => $debt,
                'success' => false,
            ];
            return response($response, 200);
        }
        $select_user = User::where('phone_number', $debt->debitor_phone)
            ->where('id', '!=', $user->id)
            ->orWhere('phone_number', $debt->creditor_phone)
            ->where('id', '!=', $user->id)
            ->first();
        $select_user = collect($select_user)->only(['phone_number', 'first_name', 'last_name', 'image']);
//        $transactions = Transaction::select('payer_phone', 'recipient_phone', 'amount', 'created_at')
//            ->where('payer_phone', $debt->debitor_phone)
//            ->where('recipient_phone', $debt->creditor_phone)
//            ->orWhere('payer_phone', $debt->creditor_phone)
//            ->where('recipient_phone', $debt->debitor_phone)
//            ->orderBy('created_at', 'desc')
//            ->paginate($request->page_size);
        $t_debt = Transaction::where('payer_phone', $debt->debitor_phone)
            ->where('recipient_phone', $debt->creditor_phone)
            ->where('type', "debt")
            ->where('created_at', '<', Carbon::now())
            ->orWhere('payer_phone', $debt->creditor_phone)
            ->where('recipient_phone', $debt->debitor_phone)
            ->where('type', "debt")
            ->where('created_at', '<', Carbon::now())
            ->latest()->first();
        $dead_line = ($debt->amount_debt == 0) ? null : $t_debt->deadline;
        $amount = (($debt->amount_debt > 0 && $debt->debitor_phone == $user->phone_number) || ($debt->amount_debt < 0 && $debt->debitor_phone == $user->phone_number))
            ? $debt->amount_debt *= -1 : $debt->amount_debt;
        $response = [
            'message' => 'Select User',
            'data' => [
                'amount ' => $debt->amount_debt,
//                $amount,
                'deadline' => $dead_line,
                'user' => $select_user,
//                'transactions' => $transactions,
            ],
            'success' => true,
        ];
        return response($response, 200);
    }
}
