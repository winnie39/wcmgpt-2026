@component('layouts.app')
    <div class=" ">

        {{-- <form action="/change-bot-status" method="POST">
            <div class="card my-2 w-full relative bg-[#590fba]">
                <div class="flex justify-between">
                    @csrf
                    <div class="card-header  text-start flex flex-col  gap-y-3">
                        Bot status: {{ auth()->user()->trade->status ? 'Running...' : 'off' }}


                    </div>
                    <div class=" place-items-center flex pr-2">
                        <button type="submit"
                            class="  border-0 rounded-md py-1  {{ auth()->user()->trade->status ? ' bg-red-500' : 'bg-green-500' }}   text-white">
                            {{ auth()->user()->trade->status ? 'stop bot' : 'start bot' }} </button>
                    </div>
                </div>
            </div>
        </form> --}}
    </div>
    <form action="/stake" method="POST">
        @csrf
        <div x-data="data" class=" ">
            <div class="flex gap-x-3 w-full">
                <div class="card my-2 w-full relative">
                    <div class="card-header">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-auto">
                                <span class="material-icons">verified</span>
                            </div>
                            <div class="col pl-0">
                                <h6 class="subtitle mb-0">Total balance</h6>
                            </div>
                            <div class="col-7">
                                {{ config('app.currency') }}{{ (float) auth()->user()->trade->stake + (float) auth()->user()->wallet->deposit + auth()->user()->wallet->stop_bot + (float) auth()->user()->wallet->profits + (float) auth()->user()->wallet->referral_commission }}
                            </div>
                            {{-- <button type="button" x-on:click="totalBalanceModal =true"
                                class="absolute right-5 rounded-full border-collapse border-0 bg-slate-500 text-white">
                                ?
                            </button> --}}
                        </div>
                    </div>
                </div>

                <div class="card my-2 w-full relative">
                    <div class="card-header">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-auto">
                                <span class="material-icons">verified</span>
                            </div>
                            <div class="col pl-0">
                                <h6 class="subtitle mb-0">Net profit</h6>
                            </div>
                            <div class="col-7">
                                {{ config('app.currency') }}{{ (float) auth()->user()->wallet->profits }}
                            </div>
                            {{-- <button type="button" x-on:click="netProfitMOdal=true"
                                class="absolute right-5 rounded-full border-collapse border-0 bg-slate-500 text-white">
                                ?
                            </button> --}}
                        </div>
                    </div>
                </div>

            </div>

            <div class="  rounded-md overflow-hidden h-[500px] ">
                <div class="tradingview-widget-container__widget"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                    {
                        "symbol": "BINANCE:WLDUSDT",
                        "interval": "1",
                        "timezone": "Etc/UTC",
                        "theme": "dark",
                        "style": "3",
                        "locale": "en",
                        "enable_publishing": false,
                        "allow_symbol_change": true,
                        "support_host": "https://www.tradingview.com"
                    }
                </script>
            </div>

            <div class="pt-2.5">
                <div class="">
                    <div class="card border-0 mb-3 pb-3">
                        <div class="card-header pb-0 mt-2  ">
                            <input type="number" step="any" name="amount" class="form-control large-gift-card border"
                                autocomplete="off" x-model="amount" placeholder="00.00">
                            <x-input-error :messages="$errors->get('amount')" class="text-start mt-2" />

                            <div class="flex w-full justify-between pt-2 gap-x-3">
                                @if (auth()->user()->trade->stake > 0)
                                    <a href="/order-history" class=" w-full">
                                        <button type="button"
                                            class="  text-white bg-yellow-500 rounded-md border-0 py-2 px-6 w-full">VIEW
                                            TRADE
                                            LOGS</button>
                                    </a>
                                @endif

                                <button x-on:click="modal=true" type="button"
                                    class="  text-white bg-yellow-500 rounded-md border-0 py-2 px-6 w-full">
                                    {{ auth()->user()->trade->stake > 0 ? ' ADD MARGIN' : 'ACTIVATE NOW' }}</button>

                            </div>

                            <p class="text-center text-secondary mt-2">
                                Available Balance: <span class="text-success">
                                    {{ config('app.currency') }}{{ (float) auth()->user()->wallet->deposit + (float) auth()->user()->wallet->profits + (float) auth()->user()->wallet->referral_commission }}

                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <template x-if="modal">
                <div class="py-10 fixed  z-50 top-20 px-5 ">
                    <div class="overflow-y-scroll h-[400px]">
                        <div class="card border-0 mb-3 pb-3 bg-slate-900">
                            <div class="card-header pb-0 mt-2  ">
                                <div x-on:click="modal=false" class=" flex justify-end pb-2 cursor-pointer text-2xl">
                                    ×
                                </div>
                                <p>
                                    Activate DIAMOND TRADE Automated Trading for daily auto-reset with default settings.
                                    Utilizing
                                    advanced algorithms, the bot analyzes markets, executes BUY/SELL actions, achieving
                                    profits from 2% to 8%. One trade daily, MON-FRI for Forex and SAT-SUN for
                                    cryptocurrencies. Payments may occur at any time post-trade due to no fixed trading
                                    time. A new trading session will be opened automatically after the previous one is
                                    closed and payments done. Experience automatic session closure, real-time summaries, and
                                    easy navigation. Activate the bot now for a seamless trading experience!
                                </p>

                                <div class=" flex gap-x-3">
                                    {{-- <span x-text="acceptance"></span> --}}
                                    <input x-model="acceptance" type="checkbox" name="accept"> Accept our terms and
                                    conditions.
                                </div>

                                <div class=" pt-3">
                                    <button :disabled="!acceptance" type="submit"
                                        class=" text-white bg-yellow-500 disabled:bg-slate-500 rounded-md border-0 py-2 px-6 w-full">CONTINUE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <template x-if="totalBalanceModal">
                <div class="py-10 fixed top-20 px-5 ">
                    <div class="relative">
                        <div class="card border-0 mb-3 pb-3 bg-slate-900">
                            <div class="card-header pb-0 mt-2  ">
                                <div x-on:click="totalBalanceModal=false"
                                    class=" flex justify-end pb-2 cursor-pointer text-2xl">
                                    ×
                                </div>
                                <p>
                                    Your current account balance is
                                    {{ config('app.currency') }}{{ (float) auth()->user()->trade->stake + (float) auth()->user()->wallet->deposit + auth()->user()->wallet->stop_bot + (float) auth()->user()->wallet->profits + (float) auth()->user()->wallet->referral_commission }}.
                                    You have
                                    the
                                    flexibility to
                                    withdraw
                                    {{ config('app.currency') }}{{ (float) auth()->user()->wallet->profits + (float) auth()->user()->wallet->deposit + (float) auth()->user()->wallet->referral_commission + (float) auth()->user()->wallet->stop_bot }}
                                    at any
                                    time without interrupting the bot. Should you wish to
                                    withdraw an amount exceeding
                                    {{ config('app.currency') }}{{ (float) auth()->user()->wallet->profits + (float) auth()->user()->wallet->deposit + (float) auth()->user()->wallet->stop_bot + (float) auth()->user()->wallet->referral_commission }},
                                    kindly pause
                                    the bot
                                    temporarily to release
                                    your trade margin of
                                    {{ config('app.currency') }}{{ (float) auth()->user()->trade->stake }}.
                                </p>
                                <div class=" pt-3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <template x-if="netProfitMOdal">
                <div class="py-10 fixed top-20 px-5  ">
                    <div class="relative">
                        <div class="card border-0 mb-3 pb-3 bg-slate-900">
                            <div class="card-header pb-0 mt-2  ">
                                <div x-on:click="netProfitMOdal=false"
                                    class=" flex justify-end pb-2 cursor-pointer text-2xl">
                                    ×
                                </div>
                                <p>
                                    Your net profit, totaling
                                    {{ config('app.currency') }}{{ (float) auth()->user()->wallet->profits }} , represents
                                    the
                                    successful
                                    outcomes of your
                                    trades. Feel free to withdraw this amount at any time without halting the bot. Enjoy
                                    nearly instant withdrawals as you navigate your trading journey seamlessly.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </form>
    <script>
        const data = {
            acceptance: false,
            modal: false,
            totalBalanceModal: false,
            netProfitMOdal: false,
            amount: 0,
        }
    </script>
@endcomponent
