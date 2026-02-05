@component('components.mail.layout', ['userId' => $userId, 'title' => 'Withdrawal Pending Approval '])
    <p>
        We're writing to inform you that your recent withdrawal request on DIAMOND TRADE has been successfully submitted and
        is
        currently pending approval.
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
        Our team is diligently reviewing your request, and once approved, your funds will be processed accordingly.
    </p>
    <p>
        If you have any questions or need further assistance, please feel free to reach out to us..

    </p>
    <p>
        Thank you for your patience.

    </p>
@endcomponent
