<x-guest-layout>
    <!-- Loading wrapper start -->
    <div id="loading-wrapper">
        <div class="spinner-border"></div>
        GLOBAL MOBILE DATA...
    </div>
    <!-- Loading wrapper end -->

    <!-- *************
        ************ Login container start *************
    ************* -->
    <div class="login-container">

        <div class="container-fluid h-100">

            <!-- Row start -->
            <div class="row no-gutters h-100 card-body">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="login-about">
                        <div class="slogan">
                            {{--                            <span>WHY CHOOSE US?</span>--}}
                            {{--                            <br>--}}
                            <span>We are the best at what we do.</span>
                        </div>
                        <div class="about-desc">
                            Connect with us through several channels
                            We have several channels you can choose to connect and make transactions on our platform, from our Website to Mobile App, API, SMS and our Powerful Whatsapp Bot.
                        </div>
                        <a href="#" class="know-more">Know More <img src="{{asset('img/right-arrow.svg')}}" alt="Uni Pro Admin"></a>

                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="login-wrapper">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="login-screen">
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="login-body pb-4">
                    <a href="#" class="login-logo">
                        <img src="{{asset('img/5.jpg')}}" alt="Global Mobile Data">
                    </a>
                    <h6>In order to access Global Mobile Data Account, please enter the email id you provided during the registration process.</h6>
                    <x-jet-validation-errors class="alert-danger card-body" />
                    <div class="field-wrapper mb-3">
                        <input type="email" name="email" autofocus placeholder="Enter your emial id">
                        <div class="field-placeholder">Email ID</div>
                    </div>
                    <div class="actions">
                        <button type="submit" class="btn btn-outline-danger ms-auto">Submit</button>
                    </div>
                </div>
            </div>
        </form>
                    </div>
                </div>
            </div>
            <!-- Row end -->


        </div>
    </div>
</x-guest-layout>
