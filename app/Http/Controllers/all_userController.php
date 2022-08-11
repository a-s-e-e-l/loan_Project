<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class all_userController extends Controller
{
    public function filter(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'type' => 'Required',
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
        $debt = null;
        if ($request->type == 'a') {
            $debts = Debt::with(array('user_cr' => function ($q) {
                $q->select('phone_number', 'first_name', 'last_name', 'image')
                    ->where('phone_number', '!=', Auth::user()->phone_number);
            }, 'user' => function ($q) {
                $q->select('phone_number', 'first_name', 'last_name', 'image')
                    ->where('phone_number', '!=', Auth::user()->phone_number);
            }))
                ->where('debitor_phone', $user->phone_number)
                ->orWhere('creditor_phone', $user->phone_number)
                ->orderBy('updated_at', 'desc')
                ->paginate($request->page_size);
            $debt = (empty($debts)) ? null : $debts;
        } elseif ($request->type == 'd') {
            $debts = Debt::with(array('user_cr' => function ($q) {
                $q->select('phone_number', 'first_name', 'last_name', 'image')
                    ->where('phone_number', '!=', Auth::user()->phone_number);
            }, 'user' => function ($q) {
                $q->select('phone_number', 'first_name', 'last_name', 'image')
                    ->where('phone_number', '!=', Auth::user()->phone_number);
            }))
                ->where('creditor_phone', $user->phone_number)
                ->where('amount_debt', '>', 0)
                ->orWhere('debitor_phone', $user->phone_number)
                ->where('amount_debt', '<', 0)
                ->orderBy('updated_at', 'desc')
                ->paginate($request->page_size);
            $debt = (empty($debts)) ? null : $debts;
        } elseif ($request->type == 'c') {
            $debts = Debt::with(array('user_cr' => function ($q) {
                $q->select('phone_number', 'first_name', 'last_name', 'image')
                    ->where('phone_number', '!=', Auth::user()->phone_number);
            }, 'user' => function ($q) {
                $q->select('phone_number', 'first_name', 'last_name', 'image')
                    ->where('phone_number', '!=', Auth::user()->phone_number);
            }))
                ->where('debitor_phone', $user->phone_number)
                ->where('amount_debt', '>', 0)
                ->orWhere('creditor_phone', $user->phone_number)
                ->where('amount_debt', '<', 0)
                ->orderBy('updated_at', 'desc')
                ->paginate($request->page_size);
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
        $dr = array();
        foreach ($debt as $d) {
            array_push($dr, empty($d->user_cr) ? $d->user : $d->user_cr);
        }
        $response = [
            'message' => 'Users',
            'data' => $dr,
            'success' => true,
        ];
        return response($response, 200);

    }

    public function all_user()
    {
        $user = Auth::user();
        $debts = Debt::with(array('user_cr' => function ($q) {
            $q->select('phone_number', 'first_name', 'last_name', 'image')
                ->where('phone_number', '!=', Auth::user()->phone_number);
        }, 'user' => function ($q) {
            $q->select('phone_number', 'first_name', 'last_name', 'image')
                ->where('phone_number', '!=', Auth::user()->phone_number);
        }))
            ->where('debitor_phone', $user->phone_number)
            ->orWhere('creditor_phone', $user->phone_number)
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
        $dr = array();
        foreach ($debt as $d) {
            array_push($dr, empty($d->user_cr) ? $d->user : $d->user_cr);
        }
        $data = collect($dr)->take(5);
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
        $validator = Validator::make($request->all(), [
            'phone' => 'Required',
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
        $debts = Debt::with(array('user_cr' => function ($q) {
            $q->select('phone_number', 'first_name', 'last_name', 'image')
                ->where('phone_number', '!=', Auth::user()->phone_number);
        }, 'user' => function ($q) {
            $q->select('phone_number', 'first_name', 'last_name', 'image')
                ->where('phone_number', '!=', Auth::user()->phone_number);
        }))
            ->where('debitor_phone', $user->phone_number)
            ->where('creditor_phone', 'like', '%' . $request->phone . '%')
            ->orWhere('creditor_phone', $user->phone_number)
            ->where('debitor_phone', 'like', '%' . $request->phone . '%')
            ->orderBy('updated_at', 'desc')
            ->paginate($request->page_size);
        $debt = (empty($debts)) ? null : $debts;
        $dr = array();
        foreach ($debt as $d) {
            array_push($dr, empty($d->user_cr) ? $d->user : $d->user_cr);
        }
        $response = [
            'message' => 'User',
            'data' => $dr,
            'success' => true,
        ];
        return response($response, 200);
    }

}
