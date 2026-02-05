@component('components.mail.layout', ['userId' => $userId, 'title' => ' Deposit Approved - Ready to Trade! '])
    <p>
        We're delighted to inform you that your recent deposit on DIAMOND TRADE has been successfully approved. Your account
        is
        now
        funded and ready for seamless trading.
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
        Feel free to explore the diverse trading opportunities on our platform. If you have any questions or require
        assistance, our support team is here to help.
        .
    </p>
    <p>
        Thank you for choosing DIAMOND TRADE . Happy trading!

    </p>
@endcomponent
