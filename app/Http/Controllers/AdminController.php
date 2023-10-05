<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Validator, Response, Hash};
use App\Models\{User, Otp, Product, Category, ReferralUser,
    Transaction, Account, Currency, Withdrawal};
use App\Rules\{
    ContainsNumber,
    HasSpecialCharacter,
    PhoneVerified
};
use Carbon\Carbon;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function logout(Request $request)
    {
        Auth::guard("admin")->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/login");
    }

    public function index()
    {
        return view('admin.index');
    }

    public function showProducts()
    {
        return view('admin.products');
    }

    public function showOrders()
    {
        return view('admin.orders');
    }

    public function showWithdrawals()
    {
        return view('admin.withdrawals');
    }

    public function createProduct(Request $request)
    {
        $product = new Product();
        $product->uuid = Str::uuid();
        $product->price = $request["price"];
        $product->category_id = (int) $request["category_id"];
        $product->old_price = (empty($request["old_price"]) ? NULL : $request["old_price"]);
        $product->name = $request["name"];
        $product->returns = (int) $request["returns"];
        $product->daily_income = (int) $request["daily_income"];
        $product->validity = $request["validity"];
        $product->expired_at = (empty($request["expired_at"]) ? NULL : $request["expired_at"]);
        $product->currency_id = 1;
        $product->photo = "product".mt_rand(1,10)."jpeg";
        $product->save();

        return Response::json([
            'status' => 'success',
            'message' => 'Registration successful',
            'results' => $product
        ], 200);
    }

    public function changeCurrency(Request $request)
    {
        $currency = Currency::find(1);
        $currency->type = $request["type"];
        $currency->save();

        return Response::json([
            'status' => 'success',
            'message' => 'Currency has been updated',
            'results' => $currency
        ], 200);
    }

    public function addAccount(Request $request)
    {
        $account = new Account();
        $account->account_name = $request["account_name"];
        $account->account_number = $request["account_number"];
        $account->bank_name = $request["bank_name"];
        $account->save();

        return Response::json([
            'status' => 'success',
            'message' => 'New Account has been added',
            'results' => $account
        ], 200);
    }

    public function changeAccountStatus(Request $request, $accountId)
    {
        $account = Account::find($accountId);
        $account->status = $request["status"];
        $account->save();

        return Response::json([
            'status' => 'success',
            'message' => 'New Account has been added',
            'results' => $account
        ], 200);
    }

    public function fetchAllProducts()
    {
        $products = Product::with("category")->get();
        $currency = Currency::first();

        return Response::json([
            'status'    => 'success',
            'results'     => $products
        ], 200);
    }

    public function fetchAllUsers()
    {
        $users = User::all();
        $currency = Currency::first();

        return Response::json([
            'status'    => 'success',
            'results'   => $users
        ], 200);
    }

    public function fetchAllOrders()
    {
        $transactions = Transaction::with([
            "user", "account", "product"
        ])->where("status", "!=", "success")
        ->orderBy("created_at", "desc")->get();
        $currency = Currency::first();

        return Response::json([
            'status'    => 'success',
            'results'     => $transactions
        ], 200);
    }

    public function fetchAllWithdrawals()
    {
        $withdrawals = Withdrawal::with([
            "user" => [
                "bank"
            ]
        ])->get();
        $currency = Currency::first();

        return Response::json([
            'status'    => 'success',
            'results'     => $withdrawals
        ], 200);
    }

    public function confirmOrder($id)
    {
        $transaction = Transaction::with("user")->where(["id" => $id])->first();
        $checkIfNew = Transaction::where([
            "user_id" => $transaction->user->id,
            "status" => "success"
        ])->first();

        if(is_null($checkIfNew)):
            $referer = ReferralUser::where("referee_id", 6)->first();
            $user = User::find($referer->user_id);
            $user->balance += env("REFERRAL_BONUS");
            //$user->total_income += env("REFERRAL_BONUS");
            $user->referral_income += env("REFERRAL_BONUS");
            $user->save();
        endif;

        $transaction->status = "success";
        $transaction->verified = 1;
        $transaction->save();

        return Response::json([
            'status' => 'success',
            "message" => "order has been confirmed",
            //'results' => $referer
        ], 200);
    }

    public function confirmWithdrawal($id)
    {
        $withdrawal = Withdrawal::find($id);

        $withdrawal->status = "success";
        $withdrawal->save();

        return Response::json([
            'status' => 'success',
            "message" => "withdrawal has been confirmed",
            'results' => $withdrawal
        ], 200);
    }
}
