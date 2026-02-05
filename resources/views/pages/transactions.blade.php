@component('layouts.app')
    <div class="text-white">
        Transactions

    </div>
    @if (count($data['transactions']) > 0)
        <div class="flex flex-col gap-y-4">

            @foreach ($data['transactions'] as $transaction)
                <div class=" rounded-md bg-[#631ac6] text-white p-2">
                    <div class="flex flex-col gap-y-3">
                        <div class="flex justify-between">
                            <div>Description</div>
                            <div class=" first-letter:capitalize"> {{ $transaction->description }} </div>
                        </div>

                        <div class="flex justify-between">
                            <div>Amount</div>
                            <div> {{ config('app.currency') }} {{ (float) $transaction->amount_before_deduction }} </div>
                        </div>

                        <div class="flex justify-between">
                            <div>Transaction Type</div>
                            <div class=" capitalize"> {{ strtolower($transaction->type_text) }} </div>
                        </div>

                        <div class="flex justify-between">
                            <div>Status</div>
                            <div class=" capitalize">{{ strtolower($transaction->status_text) }}</div>
                        </div>

                        <div class="flex justify-between">
                            <div>Date</div>
                            <div> {{ $transaction->created_at }} </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class=" rounded-md bg-[#631ac6] text-white p-2">
            <div class="flex flex-col gap-y-3">
                <div class="text-red-600 text-center"> No transactions found </div>

            </div>
        </div>
    @endif
@endcomponent
