@component('components.mail.layout', [
    'userId' => $data['userId'],
    'title' => ' Bot Payment Confirmation - Order Details ',
])
    <p>
        We are pleased to confirm that your DIAMOND TRADE trading bot has successfully executed a trade, resulting in a
        payment to
        your account. Below are the details of the completed order:
    </p>
    <p>

        <b>
            Order Details:
        </b>
    <ul style="color: white">
        <li> Order ID: {{ $data['order']['order_id'] }}</li>
        <li> Bot Activation Time: {{ $data['order']['bot_start_time'] }}</li>
        <li> Bot Closure Time: {{ $data['order']['bot_close_time'] }} </li>
        <li> Session Open Time: {{ $data['order']['session_open_time'] }} </li>
        <li> Session Close Time: {{ $data['order']['session_close_time'] }} </li>
        <li> Session Open Price: {{ $data['order']['session_open_price'] }} </li>
        <li> Session Close Price: {{ $data['order']['session_close_price'] }} </li>
        <li> Margin: {{ $data['order']['margin'] }}</li>
        <li> Order Type: {{ $data['order']['order_type'] }} </li>
        <li> Symbol: {{ $data['order']['symbol'] }} </li>
        <li> Profit Percentage: {{ (float) $data['order']['rate'] }}% </li>
    </ul>
    </p>
    <p>
        <b>
            Payment Details:
        </b>
    <ul style="color: white">
        <li> Payment Amount: {{ $data['order']['actual_profits_and_loss'] }} {{ config('app.currency') }}</li>
        <li> Deferred Fee: {{ $data['order']['deferred_fee'] }} {{ config('app.currency') }}</li>
        <li> Handling Fee: {{ $data['order']['handling_fee'] }} {{ config('app.currency') }}</li>
        <li> Net Paid Amount:
            {{ (float) $data['order']['actual_profits_and_loss'] - (float) $data['order']['deferred_fee'] - $data['order']['handling_fee'] }}
            {{ config('app.currency') }}
        </li>
    </ul>
    </p>

    <p>
        Your account now reflects the updated balance, and the profits from the bot activity have been successfully
        credited. </p>
    <p>
        If you have any questions or need further clarification, please reach ou`t to our support team.
    </p>
    <p>
        Thank you for choosing DIAMOND TRADE for your automated trading needs.

    </p>
@endcomponent
