@component('layouts.app')
    {{-- 
    <div class=" rounded-md bg-[#631ac6] text-white p-2">
        <label for="">Referral Link</label>
        <div class="flex  gap-y-3 gap-x-3 w-full">
            <div class="form-group mb-1 w-full">
                <input type="text" step="any" name="withdraw_amount" id="myInput"
                    value="{{ auth()->user()->referral->link ?? null }}" readonly
                    class="form-control large-gift-card border text-sm text-start rounded-sm" autocomplete="off"
                    required="" id="withdraw_amount">
                <x-input-error :messages="$errors->get('wallet')" class="mt-2" />
            </div>
            <button onclick="myFunction()" class=" btn btn-primary btn-sm">Copy</button>
        </div>
    </div>
    <script>
        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            document.execCommand("copy");
        }
    </script>
    @if (count($referrals) > 0)
        <div class="flex flex-col gap-y-4">

            @foreach ($referrals as $item)
                <div class=" rounded-md bg-[#631ac6] text-white p-2">
                    <div class="flex flex-col gap-y-3">
                        <div class="flex justify-between">
                            <div>Name</div>
                            <div class=" first-letter:capitalize"> {{ $item->user->name }} </div>
                        </div>

                        <div class="flex justify-between">
                            <div>Phone number</div>
                            <div> {{ (float) $item->user->phone_number }}$ </div>
                        </div>

                        <div class="flex justify-between">
                            <div>Date</div>
                            <div> {{ $item->user->created_at }} </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class=" rounded-md bg-[#631ac6] text-white p-2">
            <div class="flex flex-col gap-y-3">
                <div class="text-red-600 text-center"> No team members found </div>

            </div>
        </div>
    @endif
 --}}









    <!-- scroll-to-top start -->

    <!-- scroll-to-top end -->

    <div class="page-wrapper">

        <body class="body-scroll d-flex flex-column h-100 menu-overlay" data-page="homepage">
            <!-- Begin page content -->
            <main class="flex-shrink-0 main">







                <div class="  text-center text-white ">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col col-sm-8 col-md-6 col-lg-5 mx-auto">

                                    <img src="/images/team-img.png" alt="" class="mw-100">
                                    <h5>Invite your contacts<br>or Friends and Earn Rewards</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class=" my-4 rounded-md bg-[#631ac6] text-white p-2">
                    <div class="flex w-full justify-center gap-x-3">
                        @foreach ($referralLevels as $item)
                            <div class=" flex flex-col">
                                <div>

                                    Level {{ (float) $item->level }}
                                </div>
                                <div class=" text-lg">
                                    {{ (float) $item->rate * 100 }}%
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <script>
                    function myFunction() {
                        var copyText = document.getElementById("myInput");
                        copyText.select();
                        document.execCommand("copy");
                    }
                </script>

                <div class="main-container">
                    <div class="container mb-4">
                        <div class="card border-0 mb-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto pr-0">
                                        <div class="card-box">
                                            <img src="https://zeustrade.pro/d6/assets/images/3d-logo/reffer-2.png"
                                                alt="">
                                        </div>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <h6 class="mb-1">Refer and Earn Rewards</h6>
                                        <p class="small text-secondary">Share your referal link and start earning</p>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container mb-4">
                        <div class="alert alert-success d-none" id="successmessage">Refferal link copied</div>
                        <div class="flex  gap-y-3 gap-x-3 w-full">
                            <div class="form-group mb-1 w-full">
                                <input type="text" step="any" name="withdraw_amount" id="myInput"
                                    value="{{ auth()->user()->referral->link ?? null }}" readonly
                                    class="form-control large-gift-card border text-sm text-start rounded-sm"
                                    autocomplete="off" required="" id="withdraw_amount">
                                <x-input-error :messages="$errors->get('wallet')" class="mt-2" />
                            </div>
                            <button onclick="myFunction()" class=" btn btn-primary btn-sm">Copy</button>
                        </div>
                        <p class="text-center text-secondary">Share link to social</p>
                        <div class="row justify-content-center">
                            <a class="col-auto" target="_blank"
                                href="whatsapp://send?text=Hello, visit {{ auth()->user()->referral->link ?? null }} to begin your ai trading journey today."
                                data-action="share/whatsapp/share">
                                <div class="card-box">
                                    <img src="https://zeustrade.pro/d6/assets/templates/basic/assets/img/whatsapp.png"
                                        alt="">
                                </div>
                            </a>



                            <a class=" col-auto cursor-pointer" target="_blank"
                                href="https://www.facebook.com/sharer/sharer.php?u={{ auth()->user()->referral->link ?? null }}">

                                <div class="card-box cursor-pointer">
                                    <img class=" "
                                        src="https://zeustrade.pro/d6/assets/templates/basic/assets/img/facebook.png"
                                        alt="">
                                </div>

                            </a>

                            <a href="https://twitter.com/share?url={{ auth()->user()->referral->link ?? null }}"
                                target="_blank" class="col-auto">
                                <div class="card-box">
                                    <img src="https://zeustrade.pro/d6/assets/templates/basic/assets/img/twitter.png"
                                        alt="">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="container mb-4">
                        <h6 class="subtitle mb-3">Recently Invited friends</h6>
                        @if (count($referrals) > 0)
                            <div class="flex flex-col gap-y-4">

                                @foreach ($referrals as $item)
                                    <div class=" rounded-md bg-[#631ac6] text-white p-2">
                                        <div class="flex flex-col gap-y-3">
                                            <div class="flex justify-between">
                                                <div>Name</div>
                                                <div class=" first-letter:capitalize"> {{ $item->user->name }} </div>
                                            </div>

                                            <div class="flex justify-between">
                                                <div>Phone number</div>
                                                <div> {{ (float) $item->user->phone_number }}$ </div>
                                            </div>

                                            <div class="flex justify-between">
                                                <div>Date</div>
                                                <div> {{ $item->user->created_at }} </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class=" rounded-md bg-[#631ac6] text-white p-2">
                                <div class="flex flex-col gap-y-3">
                                    <div class="text-red-600 text-center"> No team members found </div>

                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </body>


        <!-- Deposit Modal -->


        <!--AutoPayment Redirect-->
        <div id="LocationPayment"></div>

        <!-- Withdraw Modal -->
        <!-- Modal -->


        <!-- Transfer Modal -->
        <!-- Modal -->


    </div>
@endcomponent
