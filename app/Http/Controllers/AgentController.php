<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\CountryHelper;
use App\Http\Controllers\Helpers\ToastNotificationHelper;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function addAgentTransaction(Request $request, $method)
    {

        $message = $request->message;

        if ($method == 'vodacom') {
            $messageData = $this->vodacomMessageDetails($message);

            if (!$messageData) {
                $messageData = $this->otherMoneyMessageDetails($message);
            }

            if (!$messageData) {
                $messageData = $this->getSafaricomMessageDetails($message);
            }
        } else if ($method == 'mtn') {
            $messageData = $this->getMtnMessageDetails($message);

            if (!$messageData) {
                $messageData = $this->getMtnMessageDetails($message);
            }
        }


        if (!$messageData) {
            return [
                'status' => 'failure',
                'message' => $message,
            ];
        }

        if ($messageData['type'] == Transaction::DEPOSIT) {
            $paymentDone = Transaction::where('code', 'like', $messageData['transaction_id'])->first();

            if ($messageData && $paymentDone == null) {
                $conversion = CountryHelper::convertCurrency($messageData['amount'], $messageData['currency'], config('app.currency'));

                $messageData =  Transaction::query()->create([
                    'amount' => $conversion->amount,
                    'status' => Transaction::UNCOMPLETED,
                    'type' => $messageData['type'],
                    'address' =>  strtoupper($messageData['phone']),
                    'code' => $messageData['transaction_id'],
                    'currency' => config('app.currency'),
                    'description' => 'DEPOSIT',
                    'method' => isset($messageData['method']) ? $messageData['method'] : 'VODACOM MPESA',
                    'amount_before_deduction' => $conversion->amount,
                ]);

                ToastNotificationHelper::notify(Transaction::DEPOSIT, $messageData['amount']);

                return [
                    'status' => 'success',
                    'message' => $messageData,
                ];
            }
        } else {



            $payments =  Transaction::where('address', 'like', '%' . substr($messageData['phone'], -8) . '%')->where('status', Transaction::PENDING)->get();

            if (count($payments) > 0) {

                foreach ($payments as $payment) {
                    Transaction::whereId($payment['id'])->update([
                        'status' => Transaction::COMPLETED,
                        'code' => $messageData['transaction_id']
                    ]);

                    $user = User::find($payment['user_id']);
                    ToastNotificationHelper::notify(Transaction::WITHDRAWAL, $payment['amount'], $user['phone_number']);


                    $data = [
                        'user' => User::find($payment['user_id']),
                        'transaction' => $payment,
                    ];
                }


                return [
                    'status' => 'success',
                    'message' => $messageData,
                ];
            }
        }
    }

    private function getSafaricomMessageDetails($input)
    {
        if (strpos(strtolower($input), 'umepokea') !== false || strpos(strtolower($input), 'received') || strpos(strtolower($input), 'umelipwa') || strpos(strtolower($input), 'amekutumia')) {
            $type = Transaction::DEPOSIT;
        } else if (strpos(strtolower($input), 'imetumwa') !== false || strpos(strtolower($input), 'sent')) {
            $type = Transaction::WITHDRAWAL;
        } else {
            return false;
        }

        $transactionId = strtok($input, ' ');

        // Detect phone numbers
        $name = explode(' ', $input);
        $currencyPattern = '/Tsh\d+(,\d{3})*(\.\d{1,2})?/';
        preg_match_all($currencyPattern, $input, $currencyMatches);
        $currencies = $currencyMatches[0];
        if (!isset($currencies[0])) {
            return false;
        }

        $data = [
            'transaction_id' => $transactionId,
            'phone' => "{$name[5]} {$name[6]}",
            'amount' => isset($currencies[0]) ? $currencies[0] : "Amount not found",
            'type' => $type,
            'method' => 'MPESA KENYA',
            'currency' => 'TZS'
        ];

        // Separate currency and amount
        if (isset($data['amount'])) {
            $currency = 'TZS';
            $amount = preg_replace('/[^0-9.]/', '', $data['amount']);
            $data['currency'] = $currency;
            $data['amount'] = (float)str_replace(',', '', $amount);
        }

        // Return the data
        return $data;
    }

    public function getMtnMessageDetails($message)
    {

        if (strpos(strtolower($message), 'received') !== false || strpos(strtolower($message), 'amekutumia') !== false || strpos(strtolower($message), 'umepokea') !== false) {
            $type = Transaction::DEPOSIT;
        } else if (strpos(strtolower($message), 'imetumwa') !== false || strpos(strtolower($message), 'sent') !== false) {
            $type = Transaction::WITHDRAWAL;
        } else {
            return false;
        }

        // Regular expressions
        $phonePattern = '/\b\d{12}\b/';  // Assuming 12 digits for phone number
        $amountPattern = '/UGX (\d+)/';  // Amount in UGX
        $idPattern = '/ID\s*:\s*(\d+)/'; // Transaction ID

        preg_match($phonePattern, $message, $phoneMatches);
        $phoneNumber = isset($phoneMatches[0]) ? $phoneMatches[0] : "Phone number not found";

        preg_match($amountPattern, $message, $amountMatches);
        $amount = isset($amountMatches[1]) ? $amountMatches[1] : "Amount not found";

        preg_match($idPattern, $message, $idMatches);
        $transactionId = isset($idMatches[1]) ? $idMatches[1] : "Transaction ID not found";

        return [
            'phone' => '+' . $phoneNumber,
            'amount' => (int) $amount,
            'transaction_id' => $transactionId,
            'type' => $type,
            'method' => 'MTN AGENT',
            'currency' => "UGX"
        ];
    }


    private function vodacomMessageDetails($input)
    {
        if (strpos(strtolower($input), 'received') !== false || strpos(strtolower($input), 'amekutumia') !== false || strpos(strtolower($input), 'umepokea') !== false) {
            $type = Transaction::DEPOSIT;
        } else if (strpos(strtolower($input), 'imetumwa') !== false || strpos(strtolower($input), 'sent') !== false) {
            $type = Transaction::WITHDRAWAL;
        } else {
            return false;
        }


        $transactionId = strtok($input, ' ');

        $phonePattern = '/\d{12}/';
        preg_match_all($phonePattern, $input, $phoneMatches);
        $phoneNumbers = $phoneMatches[0];
        if (!isset($phoneMatches[0])) {
            return false;
        }

        $currencyPattern = '/Tsh\d+(,\d{3})*(\.\d{1,2})?/';
        preg_match_all($currencyPattern, $input, $currencyMatches);
        $currencies = $currencyMatches[0];
        if (!isset($currencies[0])) {
            return false;
        }

        if (!isset($phoneNumbers[0])) {
            return null;
        }

        $data = [
            'transaction_id' => $transactionId,
            'phone' => '+' . $phoneNumbers[0],
            'amount' => isset($currencies[0]) ? $currencies[0] : "Amount not found",
            'type' => $type,
            'method' => 'MPESA TANZANIA',
            'currency' => 'mtn',
        ];

        if (isset($data['amount'])) {
            $currency = 'TZS';
            $amount = preg_replace('/[^0-9.]/', '', $data['amount']);
            $data['currency'] = $currency;
            $data['amount'] = (float)str_replace(',', '', $amount);
        }

        // Return the data
        return $data;
    }

    private function otherMoneyMessageDetails($input)
    {
        if (strpos(strtolower($input), 'received') !== false || strpos(strtolower($input), 'amekutumia') !== false || strpos(strtolower($input), 'umepokea') !== false) {
            $type = Transaction::DEPOSIT;
        } else if (strpos(strtolower($input), 'imetumwa') !== false || strpos(strtolower($input), 'sent') !== false) {
            $type = Transaction::WITHDRAWAL;
        } else {
            return false;
        }

        $transactionId = strtok($input, ' ');

        $phonePattern = '/\d{12}/';
        preg_match_all($phonePattern, $input, $phoneMatches);
        $phoneNumbers = $phoneMatches[0];
        if (empty($phoneNumbers)) {
            return false;
        }

        $currencyAndAmountPattern = '/(\w+)\s([\d,.]+)/';
        preg_match_all($currencyAndAmountPattern, $input, $currencyAndAmountMatches);
        $currency = $currencyAndAmountMatches[1][0];
        $amount =  $currencyAndAmountMatches[2][0];

        if (!isset($currencyAndAmountMatches[1][0])) {
            return false;
        }

        if (!isset($currencyAndAmountMatches[2][0])) {
            return false;
        }

        if (!isset($phoneNumbers[0])) {
            return null;
        }

        $data = [
            'transaction_id' => $transactionId,
            'phone' => '+' . $phoneNumbers[0],
            'amount' => $amount,
            'currency' => 'TZS',
            'type' => $type,
            'method' => 'VODACOM AGENT'
        ];

        if ($amount !== "Amount not found") {
            $amount = (float)str_replace(',', '', $amount);
            $data['amount'] = $amount;
        }

        return $data;
    }
}
