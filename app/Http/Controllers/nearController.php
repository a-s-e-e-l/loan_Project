<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class nearController extends Controller
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

    public function near_debitor()
    {
        $user = Auth::user();
        $debts = Debt::where('debitor_phone', $user['phone_number'])
            ->where('amount_debt', '>', 0)
            ->orWhere('creditor_phone', $user['phone_number'])
            ->where('amount_debt', '<', 0)
            ->get();
        $debt = (empty($debts)) ? null : $debts;
        if (empty($debt)) {
            $response = [
                'Message' => 'No Debitor',
                'data' => $debt,
                'success' => false,
            ];
            return response($response, 200);
        }
        $transactions = array();
        foreach ($debt as $res) {
            $transaction = Transaction::select('payer_phone', 'amount', 'deadline')
                ->where('payer_phone', '!=', $user->phone_number)
                ->where('recipient_phone', $user->phone_number)
                ->where('type', "debt")
                ->where('deadline', '>', Carbon::now())
                ->first();
            array_push($transactions, $transaction);
        }
        $transaction = collect($transactions)->sortByDesc('deadline',)->first();
        $response = ['Message' => 'Near Debitor',
            'data' => $transaction,
            'success' => true,];
        return response($response, 200);
    }

    public function near_creditor()
    {
        $user = Auth::user();
        $debts = Debt::where('creditor_phone', $user['phone_number'])
            ->where('amount_debt', '>', 0)
            ->orWhere('debitor_phone', $user['phone_number'])
            ->where('amount_debt', '<', 0)
            ->get();
        $debt = (empty($debts)) ? null : $debts;
        if (empty($debt)) {
            $response = [
                'Message' => 'No Creditor',
                'data' => $debt,
                'success' => false,
            ];
            return response($response, 200);
        }
        $transactions = array();
//        $amount = array();
        foreach ($debt as $res) {
            $transaction = Transaction::select('recipient_phone', 'amount', 'deadline')
                ->where('recipient_phone', '!=', $user->phone_number)
                ->where('payer_phone', $user->phone_number)
                ->where('type', "debt")
                ->where('deadline', '>', Carbon::now())
                ->first();
//            $t = Transaction::where('recipient_phone', '!=', $user->phone_number)
//                ->where('payer_phone', $user->phone_number)
//                ->where('type', "payment")
//                ->where('created_at', '>', $transaction->created_at)
//                ->get();
//            $a = 0;
//            $a += $t->options()->sum('amount');
            array_push($transactions, $transaction);
//            array_push($amount, $a);
        }
        $transaction = collect($transactions)->sortByDesc('deadline',)->first();

        $response = [
            'Message' => 'Near Debitor',
            'data' => $transaction,
//            $amount,
            'success' => true,
        ];
        return response($response, 200);
    }

    public function select_user(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'select_phone' => 'Required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
        ]);
        if ($validator->fails()) {
            $response = [
                'Message' => $validator->errors(),
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
                'Message' => 'Error User Select',
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
        $select_user = ' {"phone_number" : "' . $select_user['phone_number']
            . '","Full name" : "' . $select_user['first_name'] . ' ' . $select_user['last_name']
            . '","image" : "' . $select_user['image'] . '"}';
        $select_user = json_decode($select_user, true);
        $transactions = Transaction::select('payer_phone', 'recipient_phone', 'amount', 'created_at')
            ->where('payer_phone', $debt->debitor_phone)
            ->where('recipient_phone', $debt->creditor_phone)
            ->orWhere('payer_phone', $debt->creditor_phone)
            ->where('recipient_phone', $debt->debitor_phone)
            ->orderBy('created_at', 'desc')
            ->get();
        $t_debt = Transaction::where('payer_phone', $debt->debitor_phone)
            ->where('recipient_phone', $debt->creditor_phone)
            ->where('type', "debt")
            ->where('created_at', '<', Carbon::now())
            ->orWhere('payer_phone', $debt->creditor_phone)
            ->where('recipient_phone', $debt->debitor_phone)
            ->where('type', "debt")
            ->where('created_at', '<', Carbon::now())
            ->latest()->first();
        $response = [
            'Message' => 'Select User',
            'data' => [
                'amount ' => $debt->amount_debt,
                $t_debt->deadline,
                'user' => $select_user,
                'transactions' => $transactions,
            ],
            'success' => true,
        ];
        return response($response, 200);
    }
}
