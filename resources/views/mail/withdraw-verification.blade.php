@component('components.mail.layout', [
    'userId' => $userId,
    'title' => 'Welcome to DIAMOND TRADE  - Verify Your Email.',
])
    <p>Welcome to DIAMOND TRADE ! We're thrilled to have you on board. To ensure the security of your account, please use
        the
        following verification code to complete your registration:
    </p>
    <p style="text-align: center;">
    <h2 style="text-align: center;  color:white; "> {{ $code }} </h2>
    </p>
    <p>
        Please enter this code on the registration page to confirm your email address. If you did not sign up for DIAMOND
        TRADE ,
        please disregard this email.
    </p>
    <p>
        Thank you for choosing DIAMOND TRADE . We look forward to providing you with a seamless and secure trading
        experience.
    </p>
@endcomponent
