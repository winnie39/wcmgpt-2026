@component('components.mail.layout', [
    'userId' => $userId,
    'title' => 'KYC Verification Update - Action Required',
])
    <p>
        We regret to inform you that your recent Know Your Customer (KYC) verification submission has been declined. This
        may include issues with document clarity, mismatched information, or other verification
        concerns.


    </p>
    <p>
        To resolve this, please provide additional documents/clarifications. You can upload the necessary documents directly
        through your DIAMOND TRADE account under the KYC section.


    </p>
    <p>
        If you have any questions or require assistance, please reach out to our support team.. We appreciate your
        cooperation in ensuring a secure and compliant trading environment for all users.
    </p>
    <p>
        Thank you for your understanding.
    </p>
@endcomponent
