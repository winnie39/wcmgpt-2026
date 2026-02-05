@component('components.mail.layout', [
    'userId' => $userId,
    'title' => 'Withdrawal Approved - Transaction Successful! ',
])
    <p>
        Exciting news! We're thrilled to inform you that your recent withdrawal request on DIAMOND TRADE has been
        successfully
        approved and processed.
    </p>
    <p>

        Withdrawal details:
    <ul style="color: white">
        <li> Amount: {{ $amount }} {{ config('app.currency') }}</li>
        <li> Transaction ID: {{ $code }}</li>
        <li> Withdrawal Method: CRYPTO</li>
    </ul>
    </p>
    <p>
        Your funds should reflect in your designated account shortly, depending on the withdrawal method.
    </p>
    <p>
        If you have any questions or require further assistance, please don't hesitate to contact us.

    </p>
    <p>

        Thank you for choosing DIAMOND TRADE . Happy trading!

    </p>
@endcomponent
