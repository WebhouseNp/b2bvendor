<table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <!-- <th>Product Name </th> -->
                        <th>Customer Name</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Phone</th>
                        <th>Track Number</th>
                        <th>Order placed time</th>

                        <th>Payment Type</th>
                        <th>Status</th>
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
                <tbody>


                    @if($orders->count())

                    @foreach($orders as $key => $order_data)
                    

                    <tr class="category_row{{$order_data->id}}">
                        <td> {{$key +1}}</td>
                        <td>{{$order_data->user->name ?? '' }}</td>
                        <td>{{Carbon\Carbon::parse($order_data->created_at)->format('Y,M d')}}</td>
                        <td>{{
                        array_reduce($order_data->order_list->toArray(),function($total,$item){
                            $total+=  $item['amount'];
                            return $total; 
                        },0)    
                        }}</td>
                        <td>{{$order_data->phone}}</td>
                        <td>{{$order_data->track_no}}</td>
                        <td>{{ date('g:i a', strtotime($order_data->created_at)) }}</td>

                        <td>{{$order_data->payment_type}}</td>
                        <!-- <td><span class="btn btn-rounded btn-sm {{orderProccess($order_data->status) }} changeStatus"
                                data-status="{{$order_data->status}}" data-order_id="{{$order_data->id}}"
                                style="cursor: pointer;">{{$order_data->status}}</span></td> -->
                        <td>
                            <ul class="action_list">
                                <li>
                                    <a href="{{route('order.edit',$order_data->id)}}" data-
                                        class="btn btn-info btn-md"><i class="fa fa-eye"></i></a>

                                </li>
                                {{--
                                <li>

                                    <form action="" method="post">
                                @csrf()
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure you want to delete this Category?')"
                                    class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                                </form>
                                </li>
                                --}}

                            </ul>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">
                            You do not have any order yet.
                        </td>
                    </tr>
                    @endif
                </tbody>

            </table>