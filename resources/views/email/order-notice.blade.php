<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Order Information</title>
	<link
		href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&display=swap"
		rel="stylesheet">
	<style>
		.paragraph table {
			width: 100%;
			margin-bottom: 1rem;
			border-collapse: collapse;
		}

		.paragraph table td,
		.paragraph table th {
			padding: .75rem;
			vertical-align: top;
			border-top: 1px solid #dee2e6
		}

		.paragraph table thead th {
			vertical-align: bottom;
			/*border-bottom: 2px solid #dee2e6*/
		}

		.paragraph table tbody+tbody {
			border-top: 2px solid #dee2e6
		}

		.paragraph table {
			border: 1px solid #dee2e6
		}

		/*.paragraph table*/

		.paragraph table th,
		.paragraph table td {
			/*border: 1px solid #dee2e6*/
			border: 1px solid #a9acaf;
		}

		.table_title {
			background: #e4ff002b;
		}


		.paragraph table thead td,
		.paragraph table thead th {
			border-bottom-width: 2px
		}

		.paragraph img,
		.paragraph p img,
		.paragraphp span img {
			width: 100% !important;
			height: auto !important;
		}


		.paragraph table tbody tr:hover {
			color: #212529;
			background-color: rgba(0, 0, 0, .075)
		}



		@media (max-width:575.98px) {
			.paragraph table {
				display: block;
				width: 100%;
				overflow-x: auto;
				-webkit-overflow-scrolling: touch
			}
		}
	</style>
</head>

<body>
	<div style="border:5px solid red; padding: 15px; border-radius: 10px; max-width: 500px; background-color: #c2d5c2;
			font-family: 'Open Sans', sans-serif;
			margin: 0 auto;">
		<table style="width: 100%;">
			<thead>
				<tr>
					<th style="width: 20%; "><img src="{{asset('/uploads/logo/logo.png')}}" alt="B2B"
							style="width: 70px; height: auto;"></th>
					<th
						style="font-size: 25px; color: darkblue; font-weight: 600; text-shadow: 0px 1px 2px darkblue; border-bottom: 1px solid darkblue; width: 80%;">
						B2B
					</th>
				</tr>
			</thead>

		</table>
		<div>
			<h1 style="text-align: center; font-weight: 700; font-size: 30px;">Order Placed notification</h1>
			<p>
				Dear {{$name}},
				<br>
				<br>
				<br>

				Your order of purchasing products with us has been placed in order list. <br>
				We will notify you about your order proccessing as soon as possible. <br>
				<br>
				<br>
				<br>
			</p>
		</div>

		<div class="paragraph">
			<table>
				<thead>
					<tr>
                        <th>S.N.</th>
						<th>Product Title</th>
						<th>Quantity</th>
						<th>Unit Price</th>
						<th>Total amount</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$orderlist=$order_list;
						?>
					@foreach($orderlist as $key=>$list)
					<tr>
						<td>{{$key+1}}</td>
						<td>{{$list->product_info->title}}</td>
						<td>{{$list->quantity}}</td>
						
						<td>
						@if($list->product_info->ranges->isEmpty())
							{{$list->product_info->price}}
						@endif
						@foreach($list->product_info->ranges as $range)
							@if($range->from <= $list->quantity && $range->to >= $list->quantity)
							{{$range->price}}
							
							@endif
						@endforeach
						</td>
						<td>{{number_format(@$list->amount, 2)}}</td>

					</tr>
					@endforeach
					<tr>
						<td colspan="4">
							<b>Grand Total=</b>
						</td>
						<td><b>{{
                        array_reduce($order_list->toArray(),function($total,$item){
                            $total+=  $item['amount'];
                            return $total; 
                        },0)    
                        }}</b></td> </tr> </tbody> </table> </div> <br>
								<p> Regards,</p>
								<p>B2B Admin</p>

		</div>

</body>

</html>