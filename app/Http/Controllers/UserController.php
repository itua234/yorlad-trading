<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Validator, Response, Hash, Mail};
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
use App\Mail\OrderPlaced;
use App\Util\{
    Paystack,
    Flutterwave
};

class UserController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::with(["products" => function($query){
            $query->orderBy("price", "asc");
        }])->get();

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

        $payment = new Paystack;
        $response = $payment->getBankList();
        $banks = $response["data"];

        /*usort($banks, function($a, $b){
            return strcmp($a["name"], $b["name"]);
        });*/

        return view('account', [
            'user' => $user,
            'currency' => $currency,
            'banks' => $banks
        ]);
    }

    public function products()
    {
        $products = Product::all();
        $categories = Category::with(["products" => function($query){
            $query->orderBy("price", "asc");
        }])->get();
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
        ->where(["user_id" => Auth::user()->id])
        ->orderBy("created_at", "desc")->get();
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
        ])->orderBy("created_at", "desc")->get();
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
        $withdrawals = Withdrawal::with([
            "user" => [
                "bank"
            ]
        ])
        ->where([
            "user_id" => Auth::user()->id
        ])->orderBy("created_at", "desc")->get();
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
            $user->total_income += $product->daily_income;
            $user->save();
            $transaction->last_clicked = $now;
            $transaction->save();
        endif;

        $oldFormat = $transaction->last_clicked;
        $newFormat = Carbon::createFromFormat("Y-m-d", $oldFormat)->format("M d Y");
        $transaction->last_clicked = $newFormat;
        return Response::json([
            'status'    => 'success',
            'message'   => 'you have received your daily reward',
            'results'     => [
                "user" => $user,
                "transaction" => $transaction
            ]
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
        $url = $this->generatePaymentUrl($user, (int) $product->price, $reference);

        $transaction = new Transaction();
        $transaction->uuid = Str::uuid();
        $transaction->user_id = $user->id;
        $transaction->product_id = $product->id;
        $transaction->account_id = $account->id;
        $transaction->amount = $product->price;
        $transaction->reference = $reference;
        $transaction->date = date("M, d, Y H:i:s");
        $transaction->last_clicked = date("Y-m-d");
        $transaction->save();

        //$url ="https://cashier.payeegrid.com/checkout?transaction=".$transaction->uuid;
        return Response::json([
            'status'    => 'success',
            'message'   => 'Registration successful',
            'results'     => $transaction,
            "redirect" => $url
        ], 200);
    }

    public function generatePaymentUrl($user, $total, $reference)
    {
        $payment = new Flutterwave;
        $response = $payment->initializePayment(
            $user,
            [
                'tx_ref' => $reference,
                'amount' => $total,
            ]
        );

        return $response['data']["link"];
    }

    public function getTransactionData(Request $request)
    {
        $reference = $request['reference'];
        $transaction = Transaction::where(['reference' => $reference])->first();
        if (!$transaction) exit();
        if ($transaction->verified) exit();

        $payment = new Paystack;
        $paymentDetails = $payment->getPaymentData($reference);
        $amount = $paymentDetails['data']["amount"];
        $amount = $amount / 100;

        $transaction->status = "success";
        $transaction->verified = 1;
        $transaction->save();

        return CustomResponse::success("success", $wallet);
    }

    public function spark()
    {
        $reference = $this->generateReference(1);

        $payment = new Flutterwave;
        $response = $payment->createTransferRecipient(
            [
                "account_number" => "2123894269",
                "bank_code" => "057",
                "reference" => $reference,
                "amount" => "100"
            ], "0816578475"
        );
        return $response;
    }

    public function generateReference($id)
    {
        //$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        //return $id.substr(str_shuffle($str_result), 0, 7);
        $token = "";
        $codeAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codeAlphabet .= 'abcdefghijklmnopqrstuvwxyz';
        $codeAlphabet .= '0123456789';
        $max = strlen($codeAlphabet) - 1;
        for($i=0; $i<14; $i++):
            $token .= $codeAlphabet[mt_rand(0, $max)]; 
        endfor; 
        return $id.strtolower($token);
    }
    
    public function encryptJSON($data)
    {
        $encryptionKey = "r�G�RHE���b.Ih�} �n9�o�8��Z7";  //Generate a secure encryption key
        $iv = openssl_random_pseudo_bytes(16);  //Generate an initialization vector
        $encryptedData = openssl_encrypt($data , "aes-256-cbc", $encryptionKey, 0, $iv);
        $encryptedDataWithIV = base64_encode($iv.$encryptedData);

        return $encryptedDataWithIV;
    }

    public function decryptJSON($encryptedDataWithIV)
    {
        $encryptedDataWithIV = base64_decode($encryptedDataWithIV);
        $encryptionKey = "r�G�RHE���b.Ih�} �n9�o�8��Z7";  //Same key used for encryption 
        $iv = substr($encryptedDataWithIV, 0, 16);  //Extract IV
        $decryptedData = openssl_decrypt(substr($encryptedDataWithIV, 16), "aes-256-cbc", $encryptionKey, 0, $iv);
        $decodedData = json_decode($decryptedData, true);  //Convert back to JSON

        return $decodedData;
    }

    public function verifyBankDetails(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'account_number' => ["required", "string"],
            'bank_name' => ["required", "string"]
        ]);

        if($validator->fails())
        {
            return response([
                'message' => "failed to send otp",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        }

        $payment = new Paystack;
        $response = $payment->resolve(
            [
                "account_number" => $request["account_number"],
                "bank_code" => $request["bank_name"]
            ]
        );

        if($response['status'] == true):
            $bank = $payment->getBank($request['bank_name']);
        
            return Response::json([
                'status' => 'success',
                'message' => 'Bank Details has been verified successfully',
                'results' => $response["data"]
            ], 200);
        else:
            return Response::json([
                'status'    => 'fail',
                'message'   => $response['message'],
                'error'  => [
                    "account_name" => $response['message']
                ]
            ], 422);
        endif;
    }


    public function addBankDetails(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'account_number' => ["required", "string"],
            //'account_name' => ["required", "string"],
            'bank_name' => ["required", "string"]
        ]);

        if($validator->fails())
        {
            return response([
                'message' => "failed to send otp",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        }

        $payment = new Paystack;
        $response = $payment->resolve(
            [
                "account_number" => $request["account_number"],
                "bank_code" => $request["bank_name"]
            ]
        );

        if($response['status'] == true):
            $bank = $payment->getBank($request['bank_name']);
            
            $user = $request->user();

            $account = BankDetail::updateOrCreate([
                "user_id" => $user->id
            ],[
                'account_name' => $response['data']["account_name"],
                "account_number" => $request["account_number"],
                'bank_code' => $request['bank_name'],
                'bank_name' => $bank
            ]);
            
            return Response::json([
                'status' => 'success',
                'message' => 'Bank Details has been added successfully',
                'results' => $account
            ], 200);
        else:
            return Response::json([
                'status'    => 'fail',
                'message'   => $response['message'],
                'error'  => [
                    "account_name" => $response['message']
                ]
            ], 422);
        endif;
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
        elseif(is_null($user->bank)):
            return Response::json([
                'status'    => 'failed',
                'message'   => 'withdrawal failed',
                'error'     => [
                    "pin" => "please update your bank details"
                ]
            ], 422);
        else:
            $reference = $this->generateReference($user->id);

            $withdraw = new Withdrawal();
            $withdraw->user_id = $user->id;
            $withdraw->reference = $reference;
            $withdraw->account_name = $user->bank->account_name;
            $withdraw->account_number = $user->bank->account_number;
            $withdraw->bank_name = $user->bank->bank_name;
            $withdraw->amount = $request["amount"];
            $withdraw->save();

            $payment = new Flutterwave;
            $response = $payment->createTransferRecipient(
                [
                    "account_number" => $user->bank->account_number,
                    "bank_code" => $user->bank->bank_code,
                    "reference" => $reference,
                    "amount" => $request["amount"]
                ], $user->phone
            );

            if($response["data"]["status"] == "NEW"):
                $user->balance -= $request["amount"];
                $user->total_withdrawal += $request["amount"];
                $user->save();

                return Response::json([
                    'status'    => 'success',
                    'message'   => 'Your withdrawal request has been sent',
                    'results'     => $user
                ], 200);
            elseif($response["data"]["status"] == "FAILED"):
                return Response::json([
                    'status'    => 'failed',
                    'message'   => 'withdrawal failed',
                    'error'     => [
                        "pin" => "failed to process withdrawal, please try again later"
                    ]
                ], 422);
            endif;
        endif;
        
    }

    public function payoutWebhook(Request $request)
    {
        $signature = $request->header('verif-hash');
        $secretHash = env('FLW_SECRET_HASH', '');
        if(!$signature || ($signature !== $secretHash)):
            abort(401);
        else:
            $payload = $request->all();
            $data = $payload["data"];
            $reference = $data["reference"];

            $withdrawal = Withdrawal::where(['reference' => $reference])->first();
            if (!$withdrawal) exit();
            if ($withdrawal->verified) exit();

            if($data["status"] == "FAILED"):
                $withdrawal->verified = 1;
                $withdrawal->status = "failed";
                $withdrawal->save();

                $user = $withdrawal->user;
                $user->balance += $data["amount"];
                $user->total_withdrawal -= $data["amount"];
                $user->save();
            elseif($data["status"] == "SUCCESSFUL"):
                $withdrawal->verified = 1;
                $withdrawal->status = "success";
                $withdrawal->save();
            endif;

            return response(200);
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

    public function verifyTransaction(Request $request)
    {
        $transactionId = $request['transaction_id'];
        $reference = $request['tx_ref'];
        $status = $request['status'];

        $transaction = Transaction::with(["user", "product"])->where(['reference' => $reference])->first();
        if (!$transaction) exit();
        if ($transaction->verified) exit();

        if($status == "cancelled"):
            $transaction->verified = 1;
            $transaction->status = "pending";
            $transaction->save();

            return redirect("/orders");
        endif;

        $payment = new Flutterwave;
        $response = $payment->verifyTransaction($transactionId);
        
        $amount = 0;
        if($response['data']["status"] === "successful"):
            $transaction->status = "success";
            $amount = $response["data"]["amount"];

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
        endif;
        $transaction->amount_paid = $amount;
        $transaction->save();

        $user = $transaction->user;
        $user->balance += $transaction->product->daily_income;
        $user->total_income += $transaction->product->daily_income;
        $user->save();

        return redirect("/orders");
    }

    public function createProduct(Request $request)
    {
        $product = new Product();
        $product->uuid = Str::uuid();
        $product->price = $request["price"];
        $product->category_id = (int) $request["category_id"];
        //$product->old_price = (empty($request["old_price"]) ? NULL : $request["old_price"]);
        $product->name = $request["name"];
        $product->returns = (int) $request["returns"];
        $product->daily_income = (int) $request["daily_income"];
        $product->validity = $request["validity"];
        //$product->expired_at = (empty($request["expired_at"]) ? NULL : $request["expired_at"]);
        $product->currency_id = 1;
        $product->photo = "product".mt_rand(1,10).".jpeg";
        $product->save();

        return Response::json([
            'status' => 'success',
            'message' => 'Registration successful',
            'results' => $product
        ], 200);
    }

}
