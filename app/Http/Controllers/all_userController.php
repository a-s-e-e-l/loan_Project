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
    public function filter(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'type' => 'Required'
        ]);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors(),
                'data' => null,
                'success' => false,
            ];
            return response($response, 200);
        }
        $debt = null;
        if ($request->type == 'a') {
            $debts = Debt::where('debitor_phone', $user['phone_number'])
                ->orWhere('creditor_phone', $user['phone_number'])
                ->orderBy('updated_at', 'desc')
                ->get();
            $debt = (empty($debts)) ? null : $debts;
        } elseif ($request->type == 'd') {
            $debts = Debt::where('creditor_phone', $user['phone_number'])
                ->where('amount_debt', '>', 0)
                ->orWhere('debitor_phone', $user['phone_number'])
                ->where('amount_debt', '<', 0)
                ->orderBy('updated_at', 'desc')
                ->get();
            $debt = (empty($debts)) ? null : $debts;
        } elseif ($request->type == 'c') {
            $debts = Debt::where('debitor_phone', $user['phone_number'])
                ->where('amount_debt', '>', 0)
                ->orWhere('creditor_phone', $user['phone_number'])
                ->where('amount_debt', '<', 0)
                ->orderBy('updated_at', 'desc')
                ->get();
            $debt = (empty($debts)) ? null : $debts;
        }
        if (empty($debt)) {
            $response = [
                'message' => 'No Users',
                'data' => $debt,
                'success' => false,
            ];
            return response($response, 200);
        }
        $users = array();
        foreach ($debt as $res) {
            $u = User::where('phone_number', $res->debitor_phone)
                ->where('id', '!=', $user->id)
                ->orWhere('phone_number', $res->creditor_phone)
                ->where('id', '!=', $user->id)
                ->first();
            $u = collect($u)->only(['phone_number', 'first_name', 'last_name', 'image']);
            array_push($users, $u);
        }
        $data = $this->paginate($users);
        $response = [
            'message' => 'Users',
            'data' => $data,
            'success' => true,
        ];
        return response($response, 200);

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
                'message' => 'No Users',
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
        $data = collect($users)->take(5);
        $response = [
            'message' => 'All Users',
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
            'phone' => 'Required',
        ]);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors(),
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
                'message' => 'No Users',
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
            $u = collect($u)->only(['phone_number', 'first_name', 'last_name', 'image']);
            array_push($users, $u);
        }
        $data = $this->paginate($users);
        $response = [
            'message' => 'User',
            'data' => $data,
            'success' => true,
        ];
        return response($response, 200);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
