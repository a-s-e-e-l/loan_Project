<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Transaction;
use Illuminate\Http\Request;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function pay(Request $request)
    {
        $fields = $request->validate([
            'recipient_phone' => 'Required',
            'payer_phone' => 'Required',
            'amount_paid' => 'Required',
        ]);
        $debt = Debt::where('creditor_phone',$fields['recipient_phone'])
            ->where('lender_phone', $fields['payer_phone'])
            ->first();
        if(empty($debt)) {
            $debt_opposite = Debt::where('creditor_phone',$fields['payer_phone'])
                ->where('lender_phone', $fields['recipient_phone'])
                ->first();
            $old_amount_debt=$debt_opposite->value('amount_debt');
            $new_amount_paid=$request->input('amount_paid');
            if ($old_amount_debt > 0) {
                $debt_opposite->amount_debt = $old_amount_debt-$new_amount_paid;
                $debt_opposite->update();
                $form_data_transaction = array(
                    'recipient_phone' => $request->input('recipient_phone'),
                    'payer_phone' => $request->input('payer_phone'),
                    'amount_paid' => $request->input('amount_paid'),
                );
                $transaction = Transaction::create($form_data_transaction);
                $response = [
                    'debt' => $debt_opposite,
                    'transaction' => $transaction,
                ];
                return response($response, 200);
            }else{
                $response = [
                    'Error' => "There is no loan to pay off",
                ];
                return response($response, 200);
            }
        }else {
            $old_amount_debt=$debt->value('amount_debt');
            $new_amount_paid=$request->input('amount_paid');
            if ($old_amount_debt <0) {
                $debt->amount_debt = $old_amount_debt+$new_amount_paid;
                $debt->update();
                $form_data_transaction = array(
                    'recipient_phone' => $request->input('recipient_phone'),
                    'payer_phone' => $request->input('payer_phone'),
                    'amount_paid' => $request->input('amount_paid'),
                );
                $transaction = Transaction::create($form_data_transaction);
                $response = [
                    'debt' => $debt,
                    'transaction' => $transaction,
                ];
                return response($response, 200);
            }else{
                $response = [
                    'Error' => "There is no loan to pay off",
                ];
                return response($response, 200);
            }
        }
    }
}
