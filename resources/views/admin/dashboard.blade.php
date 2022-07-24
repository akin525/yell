@include('admin.layouts.sidebar')
<div class="midde_cont">
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title">
                    <h2>Dashboard</h2>
                </div>
            </div>
        </div>
        <div class='alert alert-info'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <i class='fa fa-ban-circle'></i><strong>Notification: </br></strong>Welcome Back {{"$user->username"}}
        </div>
        <div class="card">
            <div class="card-body">
                <div class="w3-panel w3-yellow w3-round-xlarge">
                    <div class="card-body">
                        <center>
                            <!--                    <h4 class="w3-text-green"><b>&nbsp;&nbsp; &nbsp;&nbsp; <a class="w3-btn w3-green w3-border w3-round-large" href="with.php">Withdraw From MCD Wallet</a>-->
                            <a class="w3-btn w3-green w3-border w3-round-large" href="{{route('admin/credit')}}">Credit User</a>
                            <a class="w3-btn w3-green w3-border w3-round-large" href="#">Withdraw MCD Wallet</a>

                            <a class="w3-btn w3-green w3-border w3-round-large" href="{{route('admin/credit')}}">Refund User</a>
                            <a class="w3-btn w3-green w3-border w3-round-large" href="{{route('admin/charge')}}">Charge User</a>
                            <a class="w3-btn w3-green w3-border w3-round-large" href="#">Withdraw MCD Commission</a>

                            <!--                            <a class="w3-btn w3-green w3-border w3-round-large" href="method.php">All Payment Method</a>-->
                        </center>
                    </div>
                    </b></h4>  	</div>
            </div>
        </div>
        <br>
        <div class="row">
            <!-- Column -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-hover">
                    <div class="box bg-cyan text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-counter"></i></h1>

                        <h6 class="text-white">{{$data['bill']}}</h6>
                        <h6 class="text-white">Number Of Today Bill</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-hover">
                    <div class="box bg-success text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-counter"></i></h1>
                        <h6 class="text-white">{{$data['deposit']}}</h6>
                        <h6 class="text-white">Number Of Today Deposit</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-hover">
                    <div class="box bg-warning text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-counter"></i></h1>
                        <h6 class="text-white">{{$data['user']}}</h6>
                        <h6 class="text-white">Today Total New User</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-hover">
                    <div class="box bg-danger text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-counter"></i></h1>
                        <h6 class="text-white">{{$data['nou']}}</h6>
                        <h6 class="text-white">Today Visitors</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Column -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-hover">
                    <div class="box bg-secondary text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-wallet"></i></h1>

                        <h6 class="text-white">₦{{number_format(intval($data['sum_deposits'] *1),2)}}</h6>
                        <h6 class="text-white">Total Today Deposit</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-hover">
                    <div class="box bg-success text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-wallet"></i></h1>
                        <h6 class="text-white">₦{{number_format(intval($data['sum_bill'] *1), 2)}}</h6>
                        <h6 class="text-white">Total Today Purchase</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-hover">
                    <div class="box bg-secondary text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-wallet"></i></h1>
                        <h6 class="text-white">₦{{number_format(intval($totalwallet *1), 2)}}</h6>
                        <h6 class="text-white">Total Users Wallet</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-hover">
                    <div class="box bg-danger text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-wallet"></i></h1>
                        <h6 class="text-white">₦{{number_format(intval($totaldeposite *1), 2)}}</h6>
                        <h6 class="text-white">All Deposit</h6>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <!-- Column -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-hover">
                    <div class="box bg-cyan text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-wallet"></i></h1>

                        <h6 class="text-white">₦{{number_format(intval($bill *1), 2)}}</h6>
                        <h6 class="text-white">Total Bills</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-hover">
                    <div class="box bg-success text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-account"></i></h1>
                        <h6 class="text-white">{{$alluser}}</h6>
                        <h6 class="text-white">Total Users</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-hover">
                    <div class="box bg-warning text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-wallet"></i></h1>
                        <h6 class="text-white">₦{{number_format(intval($tran *1), 2)}}</h6>
                        <h6 class="text-white">Renomobilemoney Balance</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-hover">
                    <div class="box bg-danger text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-wallet"></i></h1>
                        <h6 class="text-white">₦{{number_format(intval($lock *1), 2)}}</h6>
                        <h6 class="text-white">Airtime Discount</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Column -->
            <div class="col-md-3 col-lg-6">
                <div class="card card-hover">
                    <div class="box bg-cyan text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-wallet"></i></h1>

                        <h6 class="text-white">₦{{number_format(intval($totalprofit *1), 2)}}</h6>
                        <h6 class="text-white">Total Profit</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-3 col-lg-6">
                <div class="card card-hover">
                    <div class="box bg-danger text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-wallet"></i></h1>
                        <h6 class="text-white">₦{{number_format(intval($totalcharge *1), 2)}}</h6>
                        <h6 class="text-white">Total Charges</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.row -->
        <br>
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Deposit History</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                        <th class="table-active"> Username </th>
                        <th> Transaction Id </th>
                        <th> Date</th>
                        <th>Amount</th>
                        </thead>
                        <tbody>
                        @foreach($deposite as $de)
                            <tr>
                                <td>{{$de->username}}</td>
                                <td>{{$de->payment_ref}}</td>
                                <td>{{$de->date}}</td>
                                <td>{{$de->amount}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

        <script>
            $(function () {
                "use strict";
                // Bar chart
                new Chart(document.getElementById("bar-chart"), {
                    type: 'bar',
                    data: {
                        labels: ["Total Users Wallet", "Total Bills", "Deposits"],
                        datasets: [
                            {
                                label: "Population (millions)",
                                backgroundColor: ["#03a9f4", "#e861ff","#08ccce"],
                                data: [200000,300000,400000]
                            }
                        ]
                    },
                    options: {
                        legend: { display: false },
                        title: {
                            display: true,
                            text: 'System Payment Chart'
                        }
                    }
                });


                // line second
            });
        </script>

        <script>
            // Horizental Bar Chart
            new Chart(document.getElementById("bar-chart-horizontal"), {
                type: 'horizontalBar',
                data: {
                    labels: ["All Users", "Active Users"],
                    datasets: [
                        {
                            label: "Total Users",
                            backgroundColor: ["#0000FF","#00FF00"],
                            data: [250,200]
                        }
                    ]
                },
                options: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'System Customers Chart'
                    }
                }
            });
        </script>

<!-- this page js -->
<script src="{{asset('assets/libs/moment/min/moment.min.js')}}"></script>
<script src="{{asset('assets/libs/fullcalendar/dist/fullcalendar.min.js')}}"></script>
<script src="{{asset('dist/js/pages/calendar/cal-init.js')}}"></script>
<script src="{{asset('assets/extra-libs/multicheck/datatable-checkbox-init.js')}}"></script>
<script src="{{asset('assets/extra-libs/multicheck/jquery.multicheck.js')}}"></script>
<script src="{{asset('assets/extra-libs/DataTables/datatables.min.js')}}"></script>
<script>
    /****************************************
     *       Basic Table                   *
     ****************************************/
    $('#zero_config').DataTable();
</script>
@include('layouts.footer')
