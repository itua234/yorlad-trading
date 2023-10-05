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
	$account = $transaction->account;
	$user = $transaction->user;
	$product = $transaction->product;
@endphp
<h3>Hello Admin</h3>

<p> just placed an order to the following account:</p>
<table style="margin-top:10px;">
	<tbody>
		<tr>
			<th>Account Name</th>
			<td><?=$account->account_name?></td>
		</tr>
		<tr>
			<th>Account Number</th>
			<td><?=$account->account_number?></td>
		</tr>
		<tr>
			<th>Bank Name</th>
			<td><?=$account->bank_name?></td>
		</tr>
	</tbody>
</table>
<table style="margin-top:10px;border-collapse:separate;border-spacing:0 15px;">
	<tbody style="background-color:white;">
		<tr>
			<th>Product Name</th>
			<td><?=$product->name?></td>
		</tr>
		<tr>
			<th>Product->price</th>
			<td><?=$product->price?></td>
		</tr>
	</tbody>
</table>

<p><strong>Amount Sent: {{ $transaction->amount}}</strong></p>

<p> 
	<a href="<?=url('/')?>" class="auth-btn">Confirm Order
	</a>
</p>

<img src="{{ asset('assets/images/logos/logo_icon.png') }}"  style="width: 60px;">

<p style="font-size:12px;">Copyright &copy; {{env("APP_NAME")}} - 2023 </p>