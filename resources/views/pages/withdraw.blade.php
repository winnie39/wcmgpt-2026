@component('layouts.app')
    <div id="withdrawModalBody" class="modal-body" x-data="init" x-init="$watch('amount', value => {
        charge = parseFloat(parseFloat(parseFloat(paymentMethodDetails['percentage']) * parseFloat(amount) * paymentMethodDetails['conversion']) + parseFloat(paymentMethodDetails['flatFee'])).toFixed(2)
    });
    
    $watch('paymentMethod', () => {
        paymentMethodDetails = methods.filter((item) => item.id == paymentMethod)[0]
    })">
        <form id="withdrawForm" action="/withdraw" method="post">
            @csrf
            <div class="main-container">
                <div class="container mb-4">
                    <div class="text-start flex flex-col pb-4 place-items-start  justify-start w-full">
                        <div>Payment method</div>
                        <div class=" flex flex-col justify-items-start  place-items-start">
                            @isset($data['methods'])
                                @foreach ($data['methods'] as $method)
                                    <div class=" inline-flex justify-center place-items-center gap-x-2 ">
                                        <input type="radio" x-model="paymentMethod" checked name="method"
                                            value="{{ $method['id'] }}" class="" />
                                        <span class=" text-xs"> {{ $method['name'] }} </span>
                                    </div>
                                @endforeach
                            @endisset

                            <x-input-error :messages="$errors->get('method')" class="text-start mt-2" />
                        </div>
                    </div>
                    <div class="text-start flex flex-col pb-4 place-items-start  justify-start w-full">
                        <div>Wallet</div>
                        <div class=" flex flex-col justify-items-start  place-items-start">
                            <div class=" inline-flex justify-center place-items-center gap-x-2 ">
                                <input type="radio" x-model="wallet" checked name="wallet" value="bonus"
                                    class="" />
                                <span class=" text-xs"> Referral Bonus </span>
                            </div>
                            <div class=" inline-flex justify-center place-items-center gap-x-2 ">
                                <input type="radio" x-model="wallet" name="wallet" value="profits" class="" />
                                <span class=" text-xs"> Trade profits </span>

                            </div>


                            <x-input-error :messages="$errors->get('wallet')" class="text-start mt-2" />
                        </div>
                    </div>
                    <div x-text="'Enter Amount to withdraw in  {{ config('app.currency') }}' "></div>

                    <div class="form-group mb-1">
                        <input type="number" step="any" min="0" name="amount"
                            class="form-control large-gift-card border" autocomplete="off" x-model="amount"
                            placeholder="00.00" id="withdraw_amount">
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />

                    </div>
                    <p class="text-center text-secondary mb-4">
                        {{-- <template x-if="wallet=='bonus'">
                            <div>

                                Available: <span class="text-success">
                                    {{ config('app.currency') }}
                                    {{ (float) auth()->user()->wallet->referral_commission }}
                            </div>

                            </span>
                        </template> --}}
                    </p>
                    <div>

                        <div x-text="paymentMethodDetails['parameter']"></div>
                        <div class="input-group mb-3">
                            <input type="text" step="any" x-model="phone" name="address" class="form-control "
                                value="" autocomplete="off"
                                :placeholder="'Enter ' + paymentMethodDetails['parameter']" id="address">
                        </div>
                        <x-input-error :messages="$errors->get('address')" class="text-start mt-2" />
                    </div>
                    <div class="form-group position-relative" hidden="">
                        <div class="bottom-right mb-1 mr-1">
                            <button class="btn btn-sm btn-success rounded">Apply</button>
                        </div>
                        <input type="text" class="form-control" placeholder="Promo Code (optional)">
                    </div>
                </div>

                <div class="container mb-4 withdraw-preview-details">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <ul class="list-group list-group-flush payment-list">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Limit</span>
                                            <span><span class="min fw-bold">3000.00</span> {{ config('app.currency') }} -
                                                <span class="max fw-bold">10000000.00</span>
                                                {{ config('app.currency') }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Charge</span>
                                            <span><span class="charge fw-bold"
                                                    x-text="charge + paymentMethodDetails['currency']"></span>
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Receivable</span> <span><span class="receivable fw-bold"
                                                    x-text="(parseFloat(amount * paymentMethodDetails['conversion']) - charge).toFixed(2)+  paymentMethodDetails['currency']"></span>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container text-center">
                    <button type="submit" class="btn btn-default mb-2 mx-auto rounded w-100">Withdraw Money</button>
                </div>
            </div>
        </form>
    </div>
    {{-- </div> --}}

    <script>
        const init = {
            amount: 10000,
            data: @json($data),
            methods: @json($data['methods']),
            paymentMethodDetails: @json($data['methods'])[0],
            paymentMethod: @json($data['methods'])[0]['id'],
            currency: @json($data['methods'])[0]['currency'],
            charge: 0,
            wallet: 'bonus'
        }
    </script>
@endcomponent
