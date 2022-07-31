<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Array_;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function all_user()
    {
        $user = Auth::user();
        $users = array();
        $debts = Debt::where('debitor_phone', $user['phone_number'])
            ->orWhere('creditor_phone', $user['phone_number'])
            ->orderBy('updated_at', 'desc')
            ->get();
        $debt = (empty($debts)) ? null : $debts;
        if (empty($debt)) {
            $response = [
                'Message' => 'No Users',
                'data' => $debt,
                'success' => false,
            ];
            return response($response, 200);
        }
        foreach ($debt as $res) {
            $u = User::where('phone_number', $res->debitor_phone)
                ->where('id', '!=', $user->id)
                ->orWhere('phone_number', $res->creditor_phone)
                ->where('id', '!=', $user->id)
                ->first();
            $u = ' {"phone_number" : "' . $u['phone_number']
                . '","Full name" : "' . $u['first_name'] . ' ' . $u['last_name']
                . '","image" : "' . $u['image'] . '"}';
            $u = json_decode($u, true);
            array_push($users, $u);
        }
        $data = $this->paginate($users);
        $response = [
            'Message' => 'All Users',
            'data' => $data,
            'success' => true,
        ];
        return response($response, 200);
    }


    public function debitor_user()
    {
        $user = Auth::user();
        $users = array();
        $debts = Debt::where('creditor_phone', $user['phone_number'])
            ->where('amount_debt', '>', 0)
            ->orWhere('debitor_phone', $user['phone_number'])
            ->where('amount_debt', '<', 0)
            ->orderBy('updated_at', 'desc')
            ->get();
        $debt = (empty($debts)) ? null : $debts;
        if (empty($debt)) {
            $response = [
                'Message' => 'No Users',
                'data' => $debt,
                'success' => false,
            ];
            return response($response, 200);
        }
        foreach ($debt as $res) {
            $u = User::where('phone_number', $res->debitor_phone)
                ->where('id', '!=', $user->id)
                ->orWhere('phone_number', $res->creditor_phone)
                ->where('id', '!=', $user->id)
                ->first();
            $u = ' {"phone_number" : "' . $u['phone_number']
                . '","Full name" : "' . $u['first_name'] . ' ' . $u['last_name']
                . '","image" : "' . $u['image'] . '"}';
            $u = json_decode($u, true);
            array_push($users, $u);
        }
        $data = $this->paginate($users);
        $response = [
            'Message' => 'Debitor Users',
            'data' => $data,
            'success' => true,
        ];
        return response($response, 200);
    }

    public function creditor_user()
    {
        $user = Auth::user();
        $users = array();
        $debts = Debt::where('debitor_phone', $user['phone_number'])
            ->where('amount_debt', '>', 0)
            ->orWhere('creditor_phone', $user['phone_number'])
            ->where('amount_debt', '<', 0)
            ->orderBy('updated_at', 'desc')
            ->get();
        $debt = (empty($debts)) ? null : $debts;
        if (empty($debt)) {
            $response = [
                'Message' => 'No Users',
                'data' => $debt,
                'success' => false,
            ];
            return response($response, 200);
        }
        foreach ($debt as $res) {
            $u = User::where('phone_number', $res->debitor_phone)
                ->where('id', '!=', $user->id)
                ->orWhere('phone_number', $res->creditor_phone)
                ->where('id', '!=', $user->id)
                ->first();
            $u = ' {"phone_number" : "' . $u['phone_number']
                . '","Full name" : "' . $u['first_name'] . ' ' . $u['last_name']
                . '","image" : "' . $u['image'] . '"}';
            $u = json_decode($u, true);
            array_push($users, $u);
        }
        $data = $this->paginate($users);
        $response = [
            'Message' => 'Creditor Users',
            'data' => $data,
            'success' => true,
        ];
        return response($response, 200);
    }

    function search(Request $request)
    {
        $user = Auth::user();
        $users = array();
        $validator = Validator::make($request->all(), [
            'phone' => 'Required'
        ]);
        if ($validator->fails()) {
            $response = [
                'Message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        $debts = Debt::where('debitor_phone', $user['phone_number'])
            ->where('creditor_phone', 'like', '%' . $request['phone'] . '%')
            ->orWhere('creditor_phone', $user['phone_number'])
            ->where('debitor_phone', 'like', '%' . $request['phone'] . '%')
            ->orderBy('updated_at', 'desc')
            ->get();
        $debt = (empty($debts)) ? null : $debts;
        if (empty($debt)) {
            $response = [
                'Message' => 'No Users',
                'data' => $debt,
                'success' => false,
            ];
            return response($response, 200);
        }
        foreach ($debt as $res) {
            $u = User::where('phone_number', $res->debitor_phone)
                ->where('id', '!=', $user->id)
                ->orWhere('phone_number', $res->creditor_phone)
                ->where('id', '!=', $user->id)
                ->first();
            $u = ' {"phone_number" : "' . $u['phone_number']
                . '","Full name" : "' . $u['first_name'] . ' ' . $u['last_name']
                . '","image" : "' . $u['image'] . '"}';
            $u = json_decode($u, true);
            array_push($users, $u);
        }
        $data = $this->paginate($users);
        $response = [
            'Message' => 'User',
            'data' => $data,
            'success' => true,
        ];
        return response($response, 200);
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
