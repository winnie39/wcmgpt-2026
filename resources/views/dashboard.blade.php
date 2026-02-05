@component('layouts.app')
    <div class="py-10" x-data="data">
        <div class="container">
            <div class="card border-0 mb-3">
                <div class="card-header pb-0 mt-2">
                    <div class="row align-items-end">
                        <div class="col-6 text-left">
                            <img src="/images/dummy-profile.png" class="img-thumbnail rounded-circle" style="width: 70px"
                                alt="img">
                            <h6 class="text-no-shadow mt-1 capitalize"> {{ auth()->user()->name }} </h6>
                        </div>
                        <div class="col-6 text-right">

                            <h6 class="mb-0 text-no-shadow">My Balance</h6>
                            <h3 class="text-warning">{{ config('app.currency') }}
                                {{ (float) auth()->user()->trade->stake + (float) auth()->user()->wallet->deposit + auth()->user()->wallet->stop_bot + (float) auth()->user()->wallet->profits + (float) auth()->user()->wallet->referral_commission }}
                            </h3>
                        </div>
                    </div>
                </div>
                <hr class="my-1">
                <div class="card-footer">
                    <div class="row align-items-center">
                        <div class="col-6 text-center" style="border-right: 2px dashed #dee2e6 !important">
                            <h5 class="text-shadow"> {{ (float) $data['totalDeposit'] }} {{ config('app.currency') }} </h5>
                            <span class="text-secondary">Total deposit</span>
                        </div>
                        <hr>
                        <div class="col-6 text-center" style="border-left: 2px dashed #dee2e6 !important">
                            <h5 class="text-shadow"> {{ (float) $data['totalWithdrawal'] }} {{ config('app.currency') }}
                            </h5>
                            <span class="text-secondary">Total Withdraw</span>
                        </div>
                    </div>
                </div>
            </div>


            <template x-if="modal">
                <div class="py-10 fixed top-20 px-3 z-50 ">
                    <div class="relative">
                        <div class="card border-0 mb-3 pb-3 bg-slate-900">
                            <div class="card-header pb-0 mt-2  ">
                                <p>
                                    Welcome to DIAMOND TRADE , your premier destination for cutting-edge automated
                                    trading. By engaging with us, you agree to our Terms of Service. With state-of-the-art
                                    algorithms, we aim for optimal performance while prioritizing transparency and security.
                                    Customize bot settings, manage balances, and withdraw profits seamlessly. Embrace
                                    responsible trading and explore dynamic features for financial success.
                                </p>
                                <button type="submit" x-on:click="modal=false"
                                    class="  text-white bg-yellow-500 rounded-md border-0 py-2 px-6 w-full">I AGREE</button>
                                <div class=" pt-3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center justify-between">
                        <div class="col-4 text-center">
                            <div class="card-item" data-toggle="modal">
                                <a href="/deposit">
                                    <img src="/images/deposit-2.png" alt="">
                                    <p>Deposit</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="card-item">
                                <a href="/transfer">

                                    <img src="https://zeustrade.pro/d6/assets/images/3d-logo/transfer-2.png" alt="">
                                    <p>Transfer</p>
                                </a>
                            </div>
                        </div>

                        <div class="col-4 text-center">
                            <div class="card-item">
                                <a href="/withdraw">
                                    <img src="/images/wallet-3.png" alt="">
                                    <p>Withdraw</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6 text-center" style="border-right: 2px dashed #dee2e6 !important">
                            <h5 class="text-shadow"> {{ $data['tradeEarnings'] }} {{ config('app.currency') }}</h5>
                            <span class="text-secondary">Total Trades</span>
                        </div>
                        <hr>
                        <div class="col-6 text-center" style="border-left: 2px dashed #dee2e6 !important">
                            <h5 class="text-shadow"> {{ (float) $data['tradeEarnings'] + (float) $data['teamEarnings'] }}
                                {{ config('app.currency') }}
                            </h5>
                            <span class="text-secondary">Total Earnings</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row align-items-center">
                        <div class="col-6 text-center" style="border-right: 2px dashed #dee2e6 !important">
                            <h5 class="text-shadow"> {{ (float) auth()->user()->wallet->referral_commission }}
                                {{ config('app.currency') }}</h5>
                            <span class="text-secondary">Team Earnings</span>
                        </div>
                        <hr>
                        <div class="col-6 text-center" style="border-left: 2px dashed #dee2e6 !important">
                            <h5 class="text-shadow">
                                {{ (float) $data['todaysTradeEarnings'] + (float) $data['todaysReferralEarnings'] }}
                                {{ config('app.currency') }}</h5>
                            <span class="text-secondary">Today Earnings</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header border-bottom">
                    <h6 class="mb-0">Account</h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-top">
                        <div class="col-3 text-center pr-1">
                            <a href="/profile" class="card-box">
                                <img src="/images/profile-2.png" alt="">
                                <p>Profile</p>
                            </a>
                        </div>
                        <div class="col-3 text-center px-1">
                            <a href="/verification" class="card-box">
                                <img src="/images/address-1.png" alt="">
                                <p>Address</p>
                            </a>
                        </div>
                        <div class="col-3 text-center px-1">
                            <a href="/change-password" class="card-box">
                                <img src="/images/key.png" alt="">
                                <p>Password</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports -->
            <div class="card mb-3">
                <div class="card-header border-bottom">
                    <h6 class="mb-0">Reports</h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-top">
                        <div class="col-3 text-center pr-1">
                            <a href="/transactions" class="card-box">
                                <img src="/images/money-graph.png" alt="">
                                <p>Commission Logs</p>
                            </a>
                        </div>
                        <div class="col-3 text-center px-1">
                            <a href="/transactions" class="card-box">
                                <img src="/images/trx.png" alt="">
                                <p>Transaction Logs</p>
                            </a>
                        </div>
                        <div class="col-3 text-center px-1">
                            <a href="/transactions" class="card-box">
                                <img src="/images/history-2.png" alt="">
                                <p>Deposit History</p>
                            </a>
                        </div>
                        <div class="col-3 text-center pl-1">
                            <a href="/transfer" class="card-box">
                                <img src="/images/clock.png" alt="">
                                <p>Transfer</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-0">
                <div class="card-header border-bottom">
                    <h6 class="mb-0">Others</h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-top">
                        <div class="col-3 text-center pr-1">
                            <a href="/team" class="card-box">
                                <img src="/images/team-3.png" alt="">
                                <p>My Team</p>
                            </a>
                        </div>
                        <div class="col-3 text-center px-1">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#appDownloadModal"
                                class="card-box">
                                <img src="/images/app-store.png" alt="">
                                <p>Apps</p>
                            </a>
                        </div>
                        <div class="col-3 text-center px-1">
                            <a href="/logout" class="card-box">
                                <img src="/images/logout-2.png" alt="">
                                <p>Log Out</p>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <div class=" pb-8">
        <form action="/pay-users" method="post">
            @csrf
            @if (!$data['usersWerePaidToday'] && in_array(auth()->user()->email, config('app.admins')))
                <button type="submit" class="  text-white bg-yellow-500 rounded-md border-0 py-2 px-6 w-full">RUN
                    WORKER</button>
            @endif
        </form>
    </div>
    <script>
        const data = {
            modal: {{ request()->input('modal') }},
        }
    </script>
@endcomponent
