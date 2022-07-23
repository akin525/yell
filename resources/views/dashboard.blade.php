@include('layouts.sidebar')
<div class='alert alert-success'>
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    <i class='fa fa-ban-circle'></i><h6 class="text-capitalize">Important Notification: </br><b>Welcome Back {{Auth::user()->name}}</b></h6>
</div>
<div class="row">
    <!-- Column -->
    <div class="col-md-6 col-lg-3">
        <div class="card card-hover">
            <div class="box bg-cyan text-center">
                <h1 class="font-light text-white"><i class="mdi mdi-wallet"></i></h1>

                <h6 class="text-white">₦{{number_format(intval(Auth::user()->wallet *1), 2)}}</h6>
                <h6 class="text-white">Wallet Balance</h6>
            </div>
        </div>
    </div>
    <!-- Column -->
    <div class="col-md-6 col-lg-3">
        <div class="card card-hover">
            <div class="box bg-success text-center">
                <h1 class="font-light text-white"><i class="mdi mdi-wallet"></i></h1>
                <h6 class="text-white">₦{{number_format(intval($totaldeposite *1), 2)}}</h6>
                <h6 class="text-white">Total Deposit</h6>
            </div>
        </div>
    </div>
    <!-- Column -->
    <div class="col-md-6 col-lg-3">
        <div class="card card-hover">
            <div class="box bg-warning text-center">
                <h1 class="font-light text-white"><i class="mdi mdi-wallet"></i></h1>
                <h6 class="text-white">₦{{number_format(intval($bill *1), 2)}}</h6>
                <h6 class="text-white">Total Bill</h6>
            </div>
        </div>
    </div>
    <!-- Column -->
    <div class="col-md-6 col-lg-3">
        <div class="card card-hover">
            <div class="box bg-danger text-center">
                <h1 class="font-light text-white"><i class="mdi mdi-wallet"></i></h1>
                <h6 class="text-white">₦{{number_format(intval($charge *1), 2)}}</h6>
                <h6 class="text-white">Total Charges</h6>
            </div>
        </div>
    </div>
</div>



<br>
<div class="card">
    <div class="card-body">
        <div class='alert alert-info'>
            <button type='button' class='close'></button>
            <i class='fa fa-ban-circle'></i><strong>Notification: </br></strong>
            <center>
                <div class="card-body">
                    <li  class=" btn-info">
                            @if (Auth::user()->account_number==1 && Auth::user()->account_name==1)
                                <a href='{{route('vertual')}}' class='text-white'>Click this section to get your permament Virtual Bank Account (Transfer money to the account no to get your Yellowmantelecoms Wallet funded instantly!)</a>
                            @else
                                <h6 class='text-white'>{{Auth::user()->account_name}}</h6>
                                <h5 class='text-white'>Account No:{{Auth::user()->account_number}}</h5>
                                <h6 class='text-white'>WEMA-BANK</h6>
                            @endif

                    </li>
                </div>
            </center>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Deposit history</h5>
        <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Amount</th>
                    <th>Amount Before</th>
                    <th>Amount After</th>
                    <th>Date</th>
                </tr>
                </thead>
                @foreach($deposite as $depo)
                    <tr>
                        <td>{{$depo['username']}}</td>
                        <td>{{$depo['amount']}}</td>
                        <td>{{$depo['iwallet']}}</td>
                        <td>{{$depo['fwallet']}}</td>
                        <td>{{$depo['date']}}</td>
                    </tr>
                    @endforeach
            </table>
        </div>
    </div>

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
