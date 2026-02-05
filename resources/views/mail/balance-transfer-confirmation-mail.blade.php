@component('components.mail.layout', [
    'userId' => $data['sender']->id,
    'title' => 'Successful Balance Transfer Confirmation',
])
    <p>
        We're delighted to inform you that your recent balance transfer request has been processed successfully. The
        specified amount has been transferred to the account associated with the email address:
        {{ $data['receiver']->email }} .

    </p>
    <p>
        Transaction Details:
    <ul style="color: white">
        <li> Charge: {{ $data['charge'] }} {{ config('app.currency') }}</li>
        <li> Amount: {{ $data['amount'] }} {{ config('app.currency') }}</li>
        <li> Receipient: {{ $data['receiver']->email }}</li>
        <li> Amount Received: {{ $data['amountAfterDeductions'] }} {{ config('app.currency') }}</li>
    </ul>
    </p>
    <p>
        If you have any questions or concerns regarding this transfer, please contact our support team.
    </p>
    <p>
        Thank you for choosing DIAMOND TRADE .
    </p>
@endcomponent
