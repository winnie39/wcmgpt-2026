@component('layouts.app')
    <form action="/transfer" method="POST">
        <div class="modal-content">
            @csrf

            <div id="transferModalBody" class="modal-body" x-data="data" x-init="$watch('email', () => confirmEmail());
            $watch('amount', () => setCharge())" form
                id ="transferForm" action="https://zeustrade.pro/d6/user/transfer-balance" method="post"
                enctype="multipart/form-data">
                <div class="container mb-4">
                    <p class="text-center text-secondary mb-1">Enter Amount to send</p>
                    <p class=" text-green-500 text-center"> ( Charge: {{ $data['flatFee'] }} {{ config('app.currency') }} +
                        {{ (float) ($data['percentage'] * 100) }}% ) </p>
                    <div class="form-group mb-1">
                        <input type="number" id="amount" name="amount" x-model="amount"
                            class="form-control large-gift-card border transferAmount" placeholder="00.00">
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>
                    <div class=" text-center">Available: <span class="text-green-500">
                            {{ config('app.currency') }}
                            {{ auth()->user()->wallet->referral_commission + auth()->user()->wallet->deposit + auth()->user()->wallet->profits }}
                        </span> </div>

                    <div class=" py-4">
                        <div class=" text-center pb-2">Amount to be received</div>
                        <input type="number" id="cutAmount" x-bind:value="amount - charge"
                            class="form-control text-center text-danger text-no-shadow calculation"
                            placeholder="Amount Will Cut From Your Account" readonly="">
                    </div>

                    <div class="form-group mt-3">
                        <input type="text" name="email" x-model="email"
                            class="form-control form-control-lg text-center checkUserTransfer" placeholder="Email"
                            id="email">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        <div x-show="!emailIsValid" class=" text-red-600">Email not found.</div>
                    </div>
                </div>
                <div class="container text-center">
                    <button type="submit" class="btn btn-default mb-2 mx-auto rounded w-100">Transfer Now</button>
                </div>
            </div>
        </div>
    </form>


    <script>
        const data = {
            amount: null,
            data: @json($data),
            email: '',
            charge: 0,
            emailIsValid: true,
            setCharge: function() {
                this.charge = parseFloat(parseFloat(parseFloat(this.data['percentage']) * parseFloat(this.amount)) +
                    parseFloat(this.data['flatFee'])).toFixed(2)

                // this.charge = parseFloat((this.data['percentage'] * this.amount) + this.data['flatFee'])
            },
            confirmEmail: function() {
                axios.post('/transfer/receiver-mail', {
                    email: this.email
                }).then(response => {
                    this.emailIsValid = response.data
                })
            }
        }
    </script>
@endcomponent
