@component('components.mail.layout', ['userId' => $userId, 'title' => 'Balance Transfer Received Successfully'])
    <p>
        We are pleased to inform you that a balance transfer has been successfully processed to your account. The specified
        amount has been received and is now reflected in your DIAMOND TRADE account.
    </p>
    <p>
        Transaction Details:
    <ul style="color: white">
        <li> Charge: {{ $data['charge'] }} {{ config('app.currency') }}</li>
        <li> Sender Email: {{ $data['sender']->email }} {{ config('app.currency') }}</li>
        <li> Cost: {{ $data['charge'] }} </li>
    </ul>
    </p>
    <p>
        Should you have any inquiries or require further assistance, please don't hesitate to contact our support team.
    </p>
    <p>
        Thank you for choosing DIAMOND TRADE .
    </p>
@endcomponent
