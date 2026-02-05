@component('components.mail.layout', ['userId' => $userId, 'title' => 'Your Deposit is Pending'])
    <p>
        We hope this message finds you well. We want to inform you that your recent deposit on DIAMOND TRADE is currently
        pending
        processing. Our team is diligently working to complete the verification and processing of your deposit.

    </p>
    <p>

        Your deposit details:
    <ul style="color: white">
        <li> Amount: {{ $amount }} {{ config('app.currency') }}</li>
        <li> Transaction ID: {{ $code }} {{ config('app.currency') }}</li>
        <li> Withdrawal Method: CRYPTO</li>
    </ul>
    </p>
    <p>
        If you have any concerns or questions regarding your deposit, please do not hesitate to contact our support team at
        [support@email.com].
    </p>
    <p>
        Thank you for your understanding.
    </p>
@endcomponent
