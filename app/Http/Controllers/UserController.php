<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Validator, Response, Hash};
use App\Models\{User, Otp, Product, Category, Transaction, 
    Account, Withdrawal, BankDetail, Currency
};
use App\Rules\{
    ContainsNumber,
    HasSpecialCharacter,
    PhoneVerified
};
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::with("products")->get();

        return view('index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function getAccount()
    {
        $user = User::with("bank")
        ->where("id", Auth::user()->id)->first();
        $currency = Currency::first();

        return view('account', [
            'user' => $user,
            'currency' => $currency
        ]);
    }

    public function products()
    {
        $products = Product::all();
        $categories = Category::with("products")->get();
        $user = User::find(Auth::user()->id);
        $currency = Currency::first();
        
        return view('product', [
            'products' => $products,
            'categories' => $categories,
            'user' => $user,
            'currency' => $currency
        ]);
    }

    public function getOrders()
    {
        $transactions = Transaction::with(["product"])
        ->where(["user_id" => Auth::user()->id])->get();
        $user = User::find(Auth::user()->id);
        $currency = Currency::first();

        return view('order', [
            'transactions' => $transactions,
            'user' => $user,
            'currency' => $currency
        ]);
    }

    public function getActiveOrders()
    {
        $transactions = Transaction::with(["product"])
        ->where([
            "user_id" => Auth::user()->id,
            "status" => "success"
        ])->get();
        $user = User::find(Auth::user()->id);
        $currency = Currency::first();

        return view('active-orders', [
            'transactions' => $transactions,
            'user' => $user,
            'currency' => $currency
        ]);
    }

    public function getActiveOrderCount()
    {
        $transactions = Transaction::where([
            "user_id" => Auth::user()->id,
            "status" => "success"
        ])->get();
        
        return Response::json([
            'status'    => 'success',
            'message'   => 'transaction has been fetched successfully',
            'results'     => count($transactions)
        ], 200);
    }

    public function getWithdrawals()
    {
        $withdrawals = Withdrawal::where([
            "user_id" => Auth::user()->id
        ])->get();
        $user = User::find(Auth::user()->id);
        $currency = Currency::first();

        return view('withdrawal', [
            'withdrawals' => $withdrawals,
            'user' => $user,
            'currency' => $currency
        ]);
    }

    public function getOrder($id)
    {
        $transaction = Transaction::with(["product"])
        ->where(["id" => $id])->first();

        return Response::json([
            'status'    => 'success',
            'message'   => 'transaction has been fetched successfully',
            'results'     => $transaction
        ], 200);
    }

    public function runDailyTask($id)
    {
        $transaction = Transaction::find($id);
        $user = $transaction->user;
        $product = $transaction->product;
        $lastClicked = Carbon::parse($transaction->last_clicked);
        $now = Carbon::now()->format("Y-m-d");
        if($lastClicked->lessThan($now)):
            $user->balance += $product->daily_income;
            $user->save();
            $transaction->last_clicked = $now;
            $transaction->save();
        endif;

        return Response::json([
            'status'    => 'success',
            'message'   => 'transaction has been fetched successfully',
            'results'     => $user
        ], 200);
    }

    public function productData($id)
    {
        $product = Product::where(["uuid" => $id])->first();
        $user = User::find(Auth::user()->id);
        $currency = Currency::first();

        if($product):
            return view('product-data', [
                'product' => $product,
                'user' => $user,
                'currency' => $currency
            ]);
        endif;
    }

    public function order(Request $request)
    {
        $user = $request->user();
        $product = Product::find($request["productId"]);
        $accounts = Account::where("status", "active")->get();
        $account = $accounts[mt_rand(0, count($accounts) - 1)];
        $reference = $this->generateReference($user->id);

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->product_id = $product->id;
        $transaction->account_id = $account->id;
        $transaction->amount = $product->price;
        $transaction->reference = $reference;
        $transaction->date = date("M, d, Y H:i:s");
        $transaction->last_clicked = date("Y-m-d");
        $transaction->save();

        return Response::json([
            'status'    => 'success',
            'message'   => 'Registration successful',
            'results'     => $this->encryptJSON($transaction->fresh()),
            "redirect" => url("/")
        ], 200);
    }

    public function generateReference($id)
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return $id.substr(str_shuffle($str_result), 0, 7);
    }
    
    public function encryptJSON($data)
    {
        $encryptionKey = "r�G�RHE���b.Ih�} �n9�o�8��Z7";  //Generate a secure encryption key
        $iv = openssl_random_pseudo_bytes(16);  //Generate an initialization vector
        $encryptedData = openssl_encrypt($data , "aes-256-cbc", $encryptionKey, 0, $iv);
        $encryptedDataWithIV = base64_encode($iv.$encryptedData);

        return $encryptedDataWithIV;
    }

    public function decryptJSON($encryptedDataWithIV){
        $encryptedDataWithIV = base64_decode($encryptedDataWithIV);
        $encryptionKey = "r�G�RHE���b.Ih�} �n9�o�8��Z7";  //Same key used for encryption 
        $iv = substr($encryptedDataWithIV, 0, 16);  //Extract IV
        $decryptedData = openssl_decrypt(substr($encryptedDataWithIV, 16), "aes-256-cbc", $encryptionKey, 0, $iv);
        $decodedData = json_decode($decryptedData, true);  //Convert back to JSON

        return $decodedData;
    }


    public function addBankDetails(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'account_number' => ["required", "string"],
            'account_name' => ["required", "string"],
            'bank_name' => ["required", "string"]
        ]);

        if($validator->fails())
        {
            return response([
                'message' => "failed to send otp",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        }

        $user = $request->user();

        $data = BankDetail::updateOrCreate([
            "user_id" => $user->id
        ],[
            "account_name" => $request["account_name"],
            "account_number" => $request["account_number"],
            "bank_name" => $request["bank_name"]
        ]);

        return Response::json([
            'status'    => 'success',
            'message'   => 'Bank Details has been added successfully',
            'results'     => $data->fresh()
        ], 200);
    }


    public function withdraw(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'amount' => ["required", "string"],
            'pin' => ["required", "string", "size:4"]
        ]);

        if($validator->fails())
        {
            return response([
                'message' => "failed to send otp",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        }

        $user = User::find(Auth::user()->id);
        if($user->pin != $request["pin"]):
            return Response::json([
                'status'    => 'failed',
                'message'   => 'withdrawal failed',
                'error'     => [
                    "pin" => "withdrawal error"
                ]
            ], 422);
        elseif((int)$user-> balance < (int)$request["amount"] || (int)$request["amount"] <= 0):  //|| (int)$user->balance < 15000
            return Response::json([
                'status'    => 'failed',
                'message'   => 'withdrawal failed',
                'error'     => [
                    "pin" => "withdrawal error"
                ]
            ], 422);
        else:
            $withdraw = new Withdrawal();
            $withdraw->user_id = $user->id;
            $withdraw->amount = $request["amount"];
            $withdraw->save();

            $user->balance -= $request["amount"];
            $user->total_withdrawal += $request["amount"];
            $user->save();

            return Response::json([
                'status'    => 'success',
                'message'   => 'Your withdrawal request has been sent',
                'results'     => $user
            ], 200);
        endif;
        
    }


    public function saveWithdrawalPin(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'pin' => ["required", "string", "size:4"],
            'confirm_pin' => ["required", "same:pin"]
        ]);

        if($validator->fails())
        {
            return response([
                'message' => "failed to send otp",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        }

        $user = User::find(Auth::user()->id);
        $user->pin = $request["pin"];
        $user->save();

        return Response::json([
            'status'    => 'success',
            'message'   => 'account pin has been has been updated successfully',
            'results'     => $user
        ], 200);
    }
}
