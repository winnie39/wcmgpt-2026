@component('components.mail.layout', [
    'userId' => $userId,
    'title' => 'Withdrawal Pending Cancellation - Important Notice ',
])
    <p>
        We regret to inform you that your pending withdrawal request on DIAMOND TRADE has been canceled. This may be due to
        [specific reason], and we understand this may cause inconvenience.

    </p>
    <p>

        Withdrawal details:
    <ul style="color: white">
        <li> Amount: {{ $amount }} {{ config('app.currency') }}</li>
        <li> Transaction ID: {{ $code }} {{ config('app.currency') }}</li>
        <li> Withdrawal Method: CRYPTO</li>
    </ul>
    </p>
    <p>
        If you have any questions regarding the cancellation or if you wish to resubmit a withdrawal request, please contact
        our support team.
    </p>
    <p>
        We appreciate your understanding and look forward to assisting you further.


    </p>
    <p>
        Thank you for your patience.

    </p>
@endcomponent
