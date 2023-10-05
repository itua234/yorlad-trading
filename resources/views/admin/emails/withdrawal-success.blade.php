<style>
.auth-btn{
	border: transparent; 
	border-radius: 5px;
	text-decoration:none;
	padding: 10px 20px;
	background: #3e4684;
	color: white;
	border: none;
	font-weight: 600;
}
.auth-btn:hover,
.auth-btn:focus,
.auth-btn:active{
	color:#3e4684;
	background-color: white;
	border: 2px solid #3e4684;
}	
</style>
<div style="text-align: left">
	<img src="{{ asset('assets/images/logos/logo_full_blue_bg.png')}}" style="width: 180px; ">
</div>
@php
	$transaction = $transaction;
	$account = $transaction->account;
	$user = $transaction->user;
@endphp
<h3>Hello Admin</h3>
<p>Welcome to Yorlad's Trading Forum!</p>
<p>What happens next?.</p>
<p>Use the OTP token below to verify your email</p>

<p><strong>{{ $transaction->amount}}</strong></p>

<p>This message was sent to you by {{ env('APP_NAME') }}</p>

<p>For support, contact us via 
	<a href="mail-to:contact@<?=env('APP_DOMAIN')?>">mail-to:contact@<?=env('APP_DOMAIN')?>
	</a>
</p>

<img src="{{ asset('assets/images/logos/logo_icon.png') }}"  style="width: 60px;">

<p style="font-size:12px;">Copyright &copy; {{env("APP_NAME")}} - 2023 </p>