@include('admin.layouts.sidebar')
<div class="row">
    <div class="row column1">
        <div class="col-md-6 col-lg-3">
            <div class="full counter_section margin_bottom_30">
                <div class="couter_icon">
                    <div>
                        <i class="fa fa-google-wallet blue1_color"></i>
                    </div>
                </div>
                <div class="counter_no">
                    <div>
                        <h5 class="total_no text-center">{{ number_format($tt) ?? 'Total Transactions' }}</h5>
                        <h6 class="head_couter">Total Transactions</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="full counter_section margin_bottom_30">
                <div class="couter_icon">
                    <div>
                        <i class="fa fa-google-wallet yellow_color"></i>
                    </div>
                </div>
                <div class="counter_no">
                    <div>
                        <h5 class="total_no text-center">{{ number_format($ft) ?? 'Total Today' }}</h5>
                        <h6 class="head_couter">Transactions Today</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="full counter_section margin_bottom_30">
                <div class="couter_icon">
                    <div>
                        <i class="fa fa-google-wallet blue1_color"></i>
                    </div>
                </div>
                <div class="counter_no">
                    <div>
                        <h5 class="total_no text-center">{{ $st ?? 'Transactions Yesterday' }}</h5>
                        <h6 class="head_couter">Transactions Yesterday</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="full counter_section margin_bottom_30">
                <div class="couter_icon">
                    <div>
                        <i class="fa fa-google-wallet yellow_color"></i>
                    </div>
                </div>
                <div class="counter_no">
                    <div>
                        <h5 class="total_no text-center">{{ number_format($rt) ?? 'Total Reversed' }}</h5>
                        <h6 class="head_couter">Transactions 2Days Ago</h6>
                    </div>
                </div>
            </div>
    </div>

        </div>
    </div>

<div class="row">
    <div class="row column1">
        <div class="col-md-6 col-lg-3">
            <div class="full counter_section margin_bottom_30">
                <div class="couter_icon">
                    <div>
                        <i class="fa fa-money blue1_color"></i>
                    </div>
                </div>
                <div class="counter_no">
                    <div>
                        <h5 class="total_no text-center">₦{{ number_format($amount) ?? 'Total Transactions' }}</h5>
                        <h6 class="head_couter">Sum of Total Transaction </h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="full counter_section margin_bottom_30">
                <div class="couter_icon">
                    <div>
                        <i class="fa fa-money red_color"></i>
                    </div>
                </div>
                <div class="counter_no">
                    <div>
                        <h5 class="total_no text-center">₦{{ number_format($am) ?? 'Total Today' }}</h5>
                        <h6 class="head_couter">Sum Of Today Transactions </h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="full counter_section margin_bottom_30">
                <div class="couter_icon">
                    <div>
                        <i class="fa fa-money blue1_color"></i>
                    </div>
                </div>
                <div class="counter_no">
                    <div>
                        <h5 class="total_no text-center">₦{{ $am1 ?? 'Transactions Yesterday' }}</h5>
                        <h6 class="head_couter">Sum Of  Yesterday Transactions</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="full counter_section margin_bottom_30">
                <div class="couter_icon">
                    <div>
                        <i class="fa fa-money red_color"></i>
                    </div>
                </div>
                <div class="counter_no">
                    <div>
                        <h5 class="total_no text-center">₦{{ number_format($am2) ?? 'Total Reversed' }}</h5>
                        <h6 class="head_couter">Sum Of Total Transactions 2Days Ago</h6>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 header-title">Deposit Table</h4>
                {{--                    <p class="text-muted mb-4 font-13">Use <code>pencil icon</code> to view user profile.</p>--}}
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Username</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>I. Wallet</th>
                            <th>F. Wallet</th>
                            <th>Ref</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $dat)
                            <tr>
                                <td>{{$dat->id}}</td>
                                <td>{{$dat->username}}
                                </td>
                                <td>{{$dat->amount}}</td>
                                <td class="center">

                                    @if($dat->status=="1")
                                        <span class="badge badge-success">Delivered</span>
                                    @elseif($dat->status=="0")
                                        <span class="badge badge-warning">Not-Delivered</span>
                                    @else
                                        <span class="badge badge-info">{{$dat->status}}</span>
                                    @endif

                                </td>
                                <td>{{$dat->iwallet}}</td>
                                <td>{{$dat->fwallet}}</td>
                                <td>{{$dat->payment_ref}}</td>
                                <td>{{$dat->date}}</td>
                                <td><a href="profile/{{ $dat->username }}" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->
</div>
<!-- end row -->
@include('layouts.footer')
