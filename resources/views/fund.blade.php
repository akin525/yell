@include('layouts.sidebar')

<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <!--                                        <h4 class="font-weight-bold mb-0">--><?php //echo $name; ?><!--</h4>-->
            </div>
        </div>
        <!--                    <div class="col-xl-9 col-md-8">-->
        <div class="col-12 grid-margin stretch-card">
            <div class="card corona-gradient-card">
                <div class="card-body py-0 px-0 px-sm-3">

                </div>
            </div>
        </div>
        <br>
        <style>
            img {
                max-width: 100%;
                height: auto;
            }
        </style>
        <div class="card-body">
            <div class="center">
                <img    src="{{asset('images/r.jpg')}}" alt="" />    <! --I intentionally disabled this sectin sir  (there was alt="#" in this place) -->
            </div>
        </div>

        <br>
        <div class="card">
            <div class="card-body">
                <br>
                <br>
                @foreach($data2 as $data)
                    <div class='alert alert-success'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        <i class='fa fa-ban-circle'></i><strong>Notification: </br></strong><b class='align-content-center'>Note that ₦{{$data->charges}} will be charged On every Funding</b></div>

                    <div class='alert alert-success'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        <i class='fa fa-ban-circle'></i><strong>Notification: </br></strong><b class='align-content-center'>Note that ₦{{$data->len}}  is the Minimum Funding Amount</b></div>
            </div>
        </div>



        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><i class="mdi mdi-wallet"></i>Wallet Balance</h4>
                        <div class="wallet-details">
                            <!--                                <span>Wallet Balance</span>-->
                            <h3>₦{{number_format(intval(Auth::user()->wallet *1), 2)}}</h3>
                            <div class="d-flex justify-content-between my-4">
                            </div>
                            <div class="wallet-progress-chart">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Enter Amount Below</h4>
                        <!--                        --><?php
                        //                        if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        //
                        //                            $amou=intval(mysqli_real_escape_string($con,$_POST['amount']));
                        //
                        //                            print "
                        //                    <script>
                        //                        window.location = 'fun.php?amount=$amou';
                        //                    </script>
                        //                    ";
                        //                        }
                        //                        ?>
                        <form  action="" method="post" id="paymentForm" >
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">

                                        <label class="form-control">NGN</label>
                                    </div>
                                    <input type="number" min="{{$data->len}}" maxlength="4" class="form-control" name="amount" id="amount" placeholder="00.00" required/>
                                </div>
                                @endforeach
                            </div>
                            <input type="hidden"  id="email-address" value="{{$user->email}}">
                    </div>
                </div>
                <button class="btn btn-outline-success btn-block withdraw-btn" type="submit" onclick="payWithPaystack()">Click Fund With Paystack</button>
                <script src="https://js.paystack.co/v1/inline.js"> </script>
                <br>
                {{--                <a href="fun.php"><button  type="button" class=" btn-block withdraw-btn"  >Fund With Transfer</button></a>--}}

                </form>
                <!--                <button class="btn btn-success btn-block withdraw-btn" type="submit" onClick="makePayment()"> Fund With Flutterwave</button>-->
                <!--                <script src="https://checkout.flutterwave.com/v3.js"> </script>-->

            </div>
        </div>

        <p>OR</p>
        <div class="card">
            <div class="card-body">
                <div class='alert alert-info'>
                    <button type='button' class='close'></button>
                    <i class='fa fa-ban-circle'></i><h6 class="text-center text-white">Transfer money to your Virtual Bank Account to get your PrimeData Wallet credited instantly! </br></h6>

                    <center>
                        <div class="card-body">
                            <li  class=" btn-info">
                                @if (Auth::user()->account_number==1 && Auth::user()->account_name==1)
                                    <a href='#' class='text-white'>Click this section to get your permament Virtual Bank Account (Transfer money to the account no to get your PrimeData Wallet funded instantly!)</a>
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
        <!--        <div class="row">-->
        <!--            <div class="col-md-7 grid-margin stretch-card">-->

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
                        @foreach($fund as $depo)
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

        </div>


    <script type="text/javascript">
        (function() {
            var options = {
                whatsapp: "+2348103153004", // WhatsApp number
                call_to_action: "Message us", // Call to action
                position: "left", // Position may be 'right' or 'left'
            };
            var proto = document.location.protocol,
                host = "whatshelp.io",
                url = proto + "//static." + host;
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = url + '/widget-send-button/js/init.js';
            s.onload = function() {
                WhWidgetSendButton.init(host, proto, options);
            };
            var x = document.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
        })();
    </script>

    <script>
        const paymentForm = document.getElementById('paymentForm');
        paymentForm.addEventListener("submit", payWithPaystack, false);
        function payWithPaystack(e) {
            e.preventDefault();
            let handler = PaystackPop.setup({
                key: 'pk_test_17fd09d2f1b858a21859595153d9770573a7c996', // Replace with your public key
                email: document.getElementById("email-address").value,
                amount: document.getElementById("amount").value * 100,
                ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
// label: "Optional string that replaces customer email"
                onClose: function(){
                    alert('Window closed.');
                },
                callback: function(response){
                    let message = 'Payment complete! Reference: ' + response.reference;
                    // alert(message);


                    window.location = '{{ route('tran', '/') }}/'+response.reference;

                }
            });
            handler.openIframe();
        }
    </script>
    <!-- html -->
    <table id="data-table-buttons" class="table table-striped table-bordered align-middle">
        <thead>
        <tr>
            <th width="1%"></th>
            <th width="1%" data-orderable="false"></th>
            ...
        </tr>
        </thead>
        <tbody>
        ...
        </tbody>
    </table>

    <!-- script -->
    <script>
        $('#data-table-default').DataTable({
            responsive: true,
            dom: '<"row"<"col-sm-5"B><"col-sm-7"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>',
            buttons: [
                { extend: 'copy', className: 'btn-sm' },
                { extend: 'csv', className: 'btn-sm' },
                { extend: 'excel', className: 'btn-sm' },
                { extend: 'pdf', className: 'btn-sm' },
                { extend: 'print', className: 'btn-sm' }
            ],
        });
    </script>
@include('layouts.footer')
