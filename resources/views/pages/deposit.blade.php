@component('layouts.app')
    <div id="depositModalBoday" class="modal-body" x-data="alpineData" x-init="$watch('paymentMethod', () => {
        paymentMethodDetails = methods.filter((item) => item.id == paymentMethod)[0]
    })">
        <div class="main-container">
            <div class="container">
                <form id="depositForm" action="/deposit" method="post" enctype="multipart/form-data">
                    @csrf
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
                    <div x-text="'Enter Amount to Deposit in ('+ paymentMethodDetails['currency']+')'"></div>
                    <div class="input-group mb-3">
                        <input type="number" step="any" x-model="amount" name="amount"
                            class="form-control large-gift-card border" value="" autocomplete="off"
                            placeholder="00.00" id="amount">
                    </div>
                    <x-input-error :messages="$errors->get('amount')" class="text-start mt-2" />

                    <div>

                        <div x-text="paymentMethodDetails['parameter']"></div>
                        <div class="input-group mb-3">
                            <input type="text" step="any" x-model="phone" name="address" class="form-control "
                                value="" autocomplete="off"
                                :placeholder="'Enter ' + paymentMethodDetails['parameter']" id="address">
                        </div>
                        <x-input-error :messages="$errors->get('address')" class="text-start mt-2" />
                    </div>
                    <div>
                        <label for="exampleFormControlInput1" class="form-label">Screenshot:</label>
                        <div class="input-group">
                            <input type="file" name="image" class="form-control" aria-label="phone" id="phone"
                                aria-describedby="basic-addon1">
                        </div>
                        <div class="input-info-text min-max"></div>
                    </div>

                    <x-input-error :messages="$errors->get('image')" class="text-start mt-2" />

                    <p class="text-center text-secondary mb-4">
                    </p>

                    <div class="card my-2">
                        <div class="card-header">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-auto">
                                    <span class="material-icons"> <img src="/images/tether.png" class=" h-5 w-5"
                                            alt=""> </span>
                                </div>

                                <div class="col pl-0">
                                    <h6 class="subtitle mb-0">Mode</h6>
                                </div>
                                <div class="col-7" x-text="paymentMethodDetails['name']">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card my-2">
                        <div class="card-header">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-auto">
                                    <span class="material-icons">explore</span>
                                </div>
                                <div class="col pl-0">
                                    <h6 class="subtitle mb-0">Fee</h6>
                                </div>
                                <div class="col-7" x-text=" '0.00'+ paymentMethodDetails['currency']">

                                </div>
                            </div>
                        </div>



                        <div class="my-1">
                            <button class="btn btn-default my-2 rounded w-100 disabled" type="submit">Deposit</button>
                        </div>
                        <div class=" px-2 pb-4">
                            <div class="font-semibold ">
                                Instructions
                            </div>
                            <div class="" x-html="paymentMethodDetails['description']">
                            </div>
                        </div>

                        {{-- <div class=" text-xs text-center">
                            Deposit confidently using {{ config('app.currency') }} on DIAMOND TRADE , subject to tier-based limits
                            and regulatory
                            compliance.
                            Ensure accuracy in wallet addresses. Enjoy swift processing with notifications, and stay
                            informed
                            about any applicable fees. Prioritize security with 2FA and comply with AML/KYC requirements.
                            Users
                            must adhere to local regulations, and DIAMOND TRADE  reserves the right to adjust procedures based on
                            evolving standards. By initiating a deposit, users accept these terms, acknowledging the
                            importance
                            of compliance and staying informed about policy updates.
                        </div> --}}
                </form>
            </div>
        </div>
    </div>

    <script>
        const alpineData = {
            paymentMethodDetails: @json($data['methods'])[0],
            amount: 20000,
            phone: '',
            currency: @json($data['methods'])[0]['currency'],
            paymentMethod: @json($data['methods'])[0]['id'],
            methods: @json($data['methods']),
        }
    </script>
@endcomponent
