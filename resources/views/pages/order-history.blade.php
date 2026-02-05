@component('layouts.app')
    @if (!count($tradeLogs))
        <div class=" ">
            <div class="card my-2 w-full relative bg-[#590fba]">
                <div class="card-header text-red-500 text-center flex flex-col  gap-y-3">
                    No Trade logs found

                </div>
            </div>
        </div>
    @endif
    @foreach ($tradeLogs as $log)
        <div x-data="data" class=" ">
            <div class="card my-2 w-full relative bg-[#590fba]">
                <div class="card-header flex flex-col  gap-y-3">
                    <div class=" flex justify-between  ">
                        <div class="">
                            <h6 class="subtitle mb-0">Order Referrence</h6>
                        </div>
                        <div class=" text-yellow-600">
                            {{ $log->order_id }}
                        </div>
                    </div>

                    <div class=" flex justify-between  ">
                        <div class="">
                            <h6 class="subtitle mb-0">Capital</h6>
                        </div>
                        <div class=" text-yellow-600">
                            {{ (float) $log->margin }}
                        </div>
                    </div>
                    <div class=" flex justify-between  ">
                        <div class="">
                            <h6 class="subtitle mb-0">Percentage Profit</h6>
                        </div>
                        <div class=" text-yellow-600">

                            {{ is_numeric($log->rate) ? (float) $log->rate : $log->rate }}
                        </div>
                    </div>



                    <div class=" flex justify-between  ">
                        <div class="">
                            <h6 class="subtitle mb-0">Actual Profit as loss</h6>
                        </div>
                        <div class=" text-yellow-600">

                            {{ $log->actual_profits_and_loss }}
                        </div>
                    </div>


                    <div class=" flex justify-between  ">
                        <div class="">
                            <h6 class="subtitle mb-0">Transaction Type</h6>
                        </div>
                        <div class=" text-yellow-600">
                            {{ $log->order_type }}
                        </div>
                    </div>

                    <div class=" flex justify-between  ">
                        <div class="">
                            <h6 class="subtitle mb-0">Symbol Code</h6>
                        </div>
                        <div class=" text-yellow-600">
                            {{ $log->symbol }}
                        </div>
                    </div>

                    <div class=" flex justify-between  ">
                        <div class="">
                            <h6 class="subtitle mb-0">Bot Commencement
                            </h6>
                        </div>
                        <div class=" text-yellow-600">
                            {{ $log->bot_start_time }}
                        </div>
                    </div>
                    <div class=" flex justify-between  ">
                        <div class="">
                            <h6 class="subtitle mb-0">Bot Conclusion

                            </h6>
                        </div>
                        <div class=" text-yellow-600">
                            {{ $log->bot_close_time }}
                        </div>
                    </div>
                    <div class=" flex justify-between  ">
                        <div class="">
                            <h6 class="subtitle mb-0">Trading Session Start


                            </h6>
                        </div>
                        <div class=" text-yellow-600">
                            {{ $log->session_open_time }}
                        </div>
                    </div>
                    <div class=" flex justify-between  ">
                        <div class="">
                            <h6 class="subtitle mb-0">Trading Session End
                            </h6>
                        </div>
                        <div class=" text-yellow-600">
                            {{ $log->session_close_time }}
                        </div>
                    </div>


                    <div class=" flex justify-between ">
                        <div class="">
                            <h6 class="subtitle mb-0">Opening Session Price
                            </h6>
                        </div>
                        <div class=" text-yellow-600">
                            {{ $log->session_open_price }}
                        </div>
                    </div>

                    <div class=" flex justify-between ">
                        <div class="">
                            <h6 class="subtitle mb-0">Closing Session Price

                            </h6>
                        </div>
                        <div class=" text-yellow-600">
                            {{ $log->session_close_price }}
                        </div>
                    </div>

                </div>
            </div>


        </div>
    @endforeach

    <script>
        const data = {
            acceptance: false,
            modal: false,
            totalBalanceModal: false,
            netProfitMOdal: false,
        }
    </script>
@endcomponent
