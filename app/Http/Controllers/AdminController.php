<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Validator, Response, Hash};
use App\Models\{User, Otp, Product, Category, Transaction, Account, Currency, Withdrawal};
use App\Rules\{
    ContainsNumber,
    HasSpecialCharacter,
    PhoneVerified
};
use Carbon\Carbon;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "password" => "required",
            "email" => "required"
        ]);

        if($validator->fails())
        {
            return response([
                'message' => "Login failed",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        }

        $user = User::where(['email' => $request["email"]])->first();
        if(!$user || !Hash::check($request["password"], $user->password)):
            return Response::json([
                'status' => 'fail',
                'message' => 'Invalid credentials',
                'error' => true
            ], 400);
        elseif($user->user_type !== "admin"):
            return Response::json([
                'status' => 'fail',
                'message' => 'You are not an admin',
                'error' => true
            ], 400);
        endif;

        //Authentication successful
        Auth::login($user, true);
        $user = Auth::user();
        $token = $user->createToken("web-session")->plainTextToken;
        $user->token = $token;
        
        return Response::json([
            'status' => 'success',
            "message" => "Login successful",
            'results' => $user,
            "redirect" => url("/")
        ], 200);

    }

    public function logout(Request $request)
    {
        Auth::logout();
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

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function createProduct(Request $request)
    {
        $product = new Product();
        $product->uuid = Str::uuid();
        $product->price = $request["price"];
        $product->category_id = (int) $request["category_id"];
        $product->new_price = (empty($request["new_price"]) ? NULL : $request["new_price"]);
        $product->name = $request["name"];
        $product->returns = (int) $request["returns"];
        $product->daily_income = (int) $request["daily_income"];
        $product->validity = $request["validity"];
        $product->expired_at = (empty($request["expired_at"]) ? NULL : $request["expired_at"]);
        $product->currency_id = 1;
        $product->save();

        return Response::json([
            'status' => 'success',
            'message' => 'Registration successful',
            'results' => $product
        ], 200);
    }

    public function verifyTransaction(Request $request)
    {
        $transaction = Transaction::find($request["transactionId"]);
        if($transaction->verified) exit();

        $transaction->status = $request["status"];
        $transaction->verified = 1;
        $transaction->save();

        return Response::json([
            'status' => 'success',
            'message' => 'transaction has been verified successfully',
            'results' => $transaction
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

        return Response::json([
            'status'    => 'success',
            'results'     => $users
        ], 200);
    }

    public function fetchAllOrders()
    {
        $transactions = Transaction::with(["user", "account", "product"])->get();
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


}
