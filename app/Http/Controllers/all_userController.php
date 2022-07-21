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

    public function all_user($id){
        $user = User::where('id', $id)->first();
        $lender = Debt::where('lender_phone', $user['phone_number'])->first();
        $creditor = Debt::where('creditor_phone', $user['phone_number'])->first();
        $lender_user = null;
        $creditor_user = null ;
        if (empty($lender)&&($creditor)){
            $response = [
                'msg'=> "No Users"
            ];
            return response($response, 200);
        }elseif (empty($lender)){
            $lender_user = User::where('phone_number',$creditor->lender_phone)->first();
        }elseif (empty($creditor)){
            $creditor_user = User::where('phone_number',$lender->creditor_phone)->first();
        } else{
            $creditor_user = User::where('phone_number',$lender->creditor_phone)->first();
            $lender_user = User::where('phone_number',$creditor->lender_phone)->first();
        }
        $response = [
            'lender' => $lender,
            'creditor' => $creditor,
            'Lender User' => $lender_user,
            'Creditor User' => $creditor_user
        ];
        return response($response, 200);
    }

    public function lender_user($id){
        $user = User::where('id', $id)->first();
        $creditor = Debt::where('creditor_phone', $user['phone_number'])->first();
        if (empty($lender)){
            $response = [
                'msg'=> "No Users lender"
            ];
            return response($response, 200);
        }else{
            $lender_user = User::where('phone_number',$creditor->lender_phone)->first();
            $response = [
                'lender' => $lender,
                'Lender User' => $lender_user
            ];
            return response($response, 200);
        }
    }

    public function creditor_user($id){
        $user = User::where('id', $id)->first();
        $lender = Debt::where('lender_phone', $user['phone_number'])->first();
        if (empty($creditor)){
            $response = [
                'msg'=> "No Users creditor"
            ];
            return response($response, 200);
        }else{
            $creditor_user = User::where('phone_number',$lender->creditor_phone)->first();
            $response = [
                'creditor' => $creditor,
                'Creditor User' => $creditor_user
            ];
            return response($response, 200);
        }
    }
    public function select_user(Request $request,$id)
    {
        $user = User::where('id', $id)->first();
        $fields = $request->validate([
            'select_phone' => 'Required',
        ]);
        $lender = Debt::where('lender_phone', $user['phone_number'])
            ->where('creditor_phone', $fields['select_phone'])
            ->first();
        $creditor = Debt::where('creditor_phone', $user['phone_number'])
            ->where('lender_phone', $fields['select_phone'])
            ->first();
        $user_lender_select = null;
        $user_creditor_select = null;
        $debt_creditor=null;
        $debt_lender=null;
        if (empty($lender)&&empty($creditor)) {
            $response = [
                'msg' => "An error in the selected user number",
            ];
            return response($response, 200);
        }elseif (empty($creditor)){
            $user_creditor_select = User::where('phone_number', $lender['creditor_phone'])->first();
            $debt_creditor = Debt::where('creditor_phone', $user_creditor_select['phone_number'])->first();
        }elseif (empty($lender)){
            $user_lender_select = User::where('phone_number', $creditor['lender_phone'])->first();
            $debt_lender = Debt::where('lender_phone', $user_lender_select['phone_number'])->first();
        } else{
            $user_creditor_select = User::where('phone_number', $lender['creditor_phone'])->first();
            $user_lender_select = User::where('phone_number', $creditor['lender_phone'])->first();
            $debt_creditor = Debt::where('creditor_phone', $user_lender_select['phone_number'])->first();
            $debt_lender = Debt::where('lender_phone', $user_creditor_select['phone_number'])->first();
        }
        $response = [
            'lender' => $lender,
            'creditor' => $creditor,
            'Lender Debt' => $debt_lender,
            'Creditor Debt' => $debt_creditor
        ];
        return response($response, 200);
    }


}
