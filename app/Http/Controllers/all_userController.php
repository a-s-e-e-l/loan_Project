<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class all_userController extends Controller
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
    public function all_user(Request $request)
    {
        $fields=$request->validate([
            'phone_number'=>'Required',
        ]);
        $debtor = Debt::where('lender_phone', $fields['phone_number'])->first();
        $creditor = Debt::where('creditor_phone',$fields['phone_number'])->first();

        $response = [
            'debtor' => $debtor,
            'creditor' => $creditor,
        ];
        return response($response, 200);
    }
    public function debtor_user(Request $request)
    {
        $fields=$request->validate([
            'phone_number'=>'Required',
        ]);
        $debtor = Debt::where('lender_phone', $fields['phone_number'])->first();
//        $creditor = Debt::where('creditor_phone',$fields['phone_number'])->first();

        $response = [
            'debtor' => $debtor,
//            'creditor' => $creditor,
        ];
        return response($response, 200);
    }
    public function creditor_user(Request $request)
    {
        $fields = $request->validate([
            'phone_number' => 'Required',
        ]);
//        $debtor = Debt::where('lender_phone', $fields['phone_number'])->first();
        $creditor = Debt::where('creditor_phone',$fields['phone_number'])->first();

        $response = [
//            'debtor' => $debtor,
            'creditor' => $creditor,
        ];
        return response($response, 200);
    }

}
