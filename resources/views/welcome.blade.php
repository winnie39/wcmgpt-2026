@component('layouts.app')
    <div class="main-container">

        <div class="container">

            <div class="card border-0 mb-3">
                <div class="card-header pb-0 mt-2">
                    <div class="row align-items-end">
                        <div class="col-6 text-left">
                            <img src="/images/dummy-profile.png" class="img-thumbnail rounded-circle" style="width: 70px"
                                alt="img">
                            <h6 class="text-no-shadow mt-1">Andrew Mathenge</h6>
                        </div>
                        <div class="col-6 text-right">
                            <h6 class="badge badge-warning">
                                No Plan </h6>
                            <h6 class="mb-0 text-no-shadow">My Balance</h6>
                            <h3 class="text-warning">$ </h3>
                        </div>
                    </div>
                </div>
                <hr class="my-1">
                <div class="card-footer">
                    <div class="row align-items-center">
                        <div class="col-6 text-center" style="border-right: 2px dashed #dee2e6 !important">
                            <h5 class="text-shadow">0.00 {{ config('app.currency') }}</h5>
                            <span class="text-secondary">Total Deposit</span>
                        </div>
                        <hr>
                        <div class="col-6 text-center" style="border-left: 2px dashed #dee2e6 !important">
                            <h5 class="text-shadow">0.00 {{ config('app.currency') }}</h5>
                            <span class="text-secondary">Total Withdraw</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4 text-center">
                            <div class="card-item" data-toggle="modal" data-target="#depositModal">
                                <img src="/images/deposit-2.png" alt="">
                                <p>Deposit</p>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="card-item" data-toggle="modal" data-target="#transferModal">
                                <img src="/images/transfer-2.png" alt="">
                                <p>Transfer</p>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="card-item" data-toggle="modal" data-target="#withdrawModal">
                                <img src="/images/wallet-3.png" alt="">
                                <p>Withdraw</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6 text-center" style="border-right: 2px dashed #dee2e6 !important">
                            <h5 class="text-shadow">0.00 $</h5>
                            <span class="text-secondary">Total Invest</span>
                        </div>
                        <hr>
                        <div class="col-6 text-center" style="border-left: 2px dashed #dee2e6 !important">
                            <h5 class="text-shadow">0.00 $</h5>
                            <span class="text-secondary">Total Earnings</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row align-items-center">
                        <div class="col-6 text-center" style="border-right: 2px dashed #dee2e6 !important">
                            <h5 class="text-shadow">0.00 $</h5>
                            <span class="text-secondary">Team Earnings</span>
                        </div>
                        <hr>
                        <div class="col-6 text-center" style="border-left: 2px dashed #dee2e6 !important">
                            <h5 class="text-shadow">0.00 $</h5>
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
                            <a href="https://zeustrade.pro/d6/user/profile-setting" class="card-box">
                                <img src="/images/profile-2.png" alt="">
                                <p>Profile</p>
                            </a>
                        </div>
                        <div class="col-3 text-center px-1">
                            <a href="https://zeustrade.pro/d6/user/address-setting" class="card-box">
                                <img src="/images/address-1.png" alt="">
                                <p>Address</p>
                            </a>
                        </div>
                        <div class="col-3 text-center px-1">
                            <a href="https://zeustrade.pro/d6/user/change-password" class="card-box">
                                <img src="/images/key.png" alt="">
                                <p>Password</p>
                            </a>
                        </div>
                        <div class="col-3 text-center pl-1">
                            <a href="https://zeustrade.pro/d6/user/withdraw-password" class="card-box">
                                <img src="/images/pin-lock-2.png" alt="">
                                <p>W-Pin</p>
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
                            <a href="https://zeustrade.pro/d6/user/commissions" class="card-box">
                                <img src="/images/money-graph.png" alt="">
                                <p>Commission Logs</p>
                            </a>
                        </div>
                        <div class="col-3 text-center px-1">
                            <a href="https://zeustrade.pro/d6/user/transactions" class="card-box">
                                <img src="/images/trx.png" alt="">
                                <p>Transaction Logs</p>
                            </a>
                        </div>
                        <div class="col-3 text-center px-1">
                            <a href="https://zeustrade.pro/d6/user/deposit/history" class="card-box">
                                <img src="/images/history-2.png" alt="">
                                <p>Deposit History</p>
                            </a>
                        </div>
                        <div class="col-3 text-center pl-1">
                            <a href="https://zeustrade.pro/d6/user/withdraw/history" class="card-box">
                                <img src="/images/clock.png" alt="">
                                <p>Withdraw History</p>
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
                            <a href="https://zeustrade.pro/d6/user/referred-users" class="card-box">
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
                            <a href="https://zeustrade.pro/d6/user/logout" class="card-box">
                                <img src="/images/logout-2.png" alt="">
                                <p>Log Out</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endcomponent
