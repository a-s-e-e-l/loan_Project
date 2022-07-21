<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class paymentController extends Controller
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

    public function payment(Request $request)
    {
        $fields=$request->validate([
            'creditor_phone'=>'Required',
            'lender_phone'=>'Required',
            'amount_debt'=>'Required',
            'deadline'=>'Required',
        ]);

        /** @noinspection PhpUndefinedMethodInspection */
        $debt = Debt::where('creditor_phone',$fields['creditor_phone'])
            ->where('lender_phone', $fields['lender_phone'])
            ->first();

        if (empty($debt)) {
            /** @noinspection PhpUndefinedMethodInspection */
            $creditor_phone =User::where('phone_number',$fields['creditor_phone'])->first();
            /** @noinspection PhpUndefinedMethodInspection */
            $lender_phone= User::where('phone_number', $fields['lender_phone'])->first();
            if (empty($creditor_phone)) {
                $form_data = array(
                    'phone_number' => $fields['creditor_phone'],
                );
                /** @noinspection PhpUndefinedMethodInspection */
                User::create($form_data);
                $response = [
                    'msg' => "The creditor not user in app ",
                ];
                return response($response, 200);
            }elseif (empty($lender_phone)){
                $form_data = array(
                    'phone_number'  =>  $request->input('lender_phone'),
                );
                /** @noinspection PhpUndefinedMethodInspection */
                User::create($form_data);
                $response = [
                    'msg' => "The lender not user in app ",
                ];
                return response($response, 200);
            }
            $form_data_debt = array(
                'creditor_phone' => $request->input('creditor_phone'),
                'lender_phone' => $request->input('lender_phone'),
                'amount_debt' => $request->input('amount_debt'),
                'deadline' => $request->input('deadline'),
            );
            /** @noinspection PhpUndefinedMethodInspection */
            $debt = Debt::create($form_data_debt);
            $form_data_transaction = array(
                'recipient_phone' => $request->input('creditor_phone'),
                'payer_phone' => $request->input('lender_phone'),
                'amount_paid' => $request->input('amount_debt'),
            );
            /** @noinspection PhpUndefinedMethodInspection */
            $transaction = Transaction::create($form_data_transaction);
            $response = [
                'debt' => $debt,
                'transaction' => $transaction,
            ];
            return response($response, 200);
        }else{
            $old_amount_debt=$debt->value('amount_debt');
            $new_amount_debt=$request->input('amount_debt');

            if ($old_amount_debt ==0) {
                $debt->amount_debt = $new_amount_debt;
                $debt->update();
                $form_data_transaction = array(
                    'recipient_phone' => $request->input('creditor_phone'),
                    'payer_phone' => $request->input('lender_phone'),
                    'amount_paid' => $request->input('amount_debt'),
                );
                /** @noinspection PhpUndefinedMethodInspection */
                $transaction = Transaction::create($form_data_transaction);
                $response = [
                    'debt' => $debt,
                    'transaction' => $transaction,
                ];
                return response($response, 200);
            }else{
                $response = [
                    'Error' => "There is already a loan that has not been paid",
                ];
                return response($response, 200);
            }
        }
    }
}
