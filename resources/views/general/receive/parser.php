<?php

/// we include this to take all basic requirements
include_once '../../../include/bootstrap.php';


// Define constants
$payloadSuccess = '{ payload: { success: "true" } }';
$payloadFailure = '{ payload: { success: "false" } }';

//// import payload/variables from smssync
$from = @$_POST["from"];
$message = @$_POST["message"];
$secret = @$_POST["secret"];
$sent_timestamp = @$_POST["sent_timestamp"];

$content = ' <table style="min-width:80%;">
            <tbody>
                <tr class="odd">
                    <td>' . $from . '</td>
                    <td class="">' . $message . '</td>
                    <td class="">' . $sent_timestamp . '</td>
                </tr>
            </tbody>
        </table>';
$handle = fopen('received_sms.html', 'a+');
$write = fwrite($handle, $content);
fclose($handle);
if ($secret != 1414) {
    error_record("WARNING: Message received from unknown source."
    . " <br/> Track the source as early as possible for security", NULL);
    exit();
}

class Utility {

    public static function numberInput($input) {
        $input = trim($input);
        $amount = 0;

        if (preg_match("/^[0-9,]+\.?$/", $input)) {
            $amount = 100 * (int) str_replace(',', '', $input);
        } elseif (preg_match("/^[0-9,]+\.[0-9]$/", $input)) {
            $amount = 10 * (int) str_replace(array('.', ','), '', $input);
        } elseif (preg_match("/^[0-9,]*\.[0-9][0-9]$/", $input)) {
            $amount = (int) str_replace(array('.', ','), '', $input);
        } else {
            $amount = (int) $input;
        }
        return $amount;
    }

    public static function dateInput($input) {
        $timeStamp = strtotime($input);
        if ($timeStamp != FALSE) {
            return $timeStamp;
        }
        return 0;
    }

    public static function generatePassword($length = 10, $chars = "abcdefghijkmnopqrstuvwxyz023456789") {
        srand((double) microtime() * 1000000);

        $pass = '';
        for ($i = 0; $i < $length; $i++) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
        }

        return $pass;
    }

}

class ChargeCalculator {

    static public function calculateCost($type, $time, $amount) {
        switch ($type) {
            case Transaction::TZ_MPESA_PRIVATE_PAYMENT_SENT:
                return ChargeCalculator::sendingCost($time, $amount);
                break;
            case Transaction::TZ_MPESA_PRIVATE_WITHDRAW:
                return ChargeCalculator::withdrawCost($time, $amount);
                break;
            case Transaction::TZ_MPESA_PRIVATE_BALANCE_REQUEST:
                return 6000;
                break;
        }
        return 0;
    }

    static protected function sendingCost($time, $amount) {
        if ($amount <= 99900) {
            return 1000;
        } elseif ($amount <= 299900) {
            return 3000;
        } elseif ($amount <= 499900) {
            return 6000;
        } elseif ($amount <= 999900) {
            return 10000;
        } elseif ($amount <= 1999900) {
            return 25000;
        } elseif ($amount <= 4999900) {
            return 30000;
        } elseif ($amount <= 29999900) {
            return 60000;
        } elseif ($amount <= 49999900) {
            return 120000;
        } else {
            return 180000;
        }
    }

    static protected function withdrawCost($time, $amount) {
        if ($amount <= 299900) {
            return 50000;
        } elseif ($amount <= 999900) {
            return 60000;
        } elseif ($amount <= 1999900) {
            return 120000;
        } elseif ($amount <= 4999900) {
            return 150000;
        } elseif ($amount <= 9999900) {
            return 220000;
        } elseif ($amount <= 19999900) {
            return 260000;
        } elseif ($amount <= 29999900) {
            return 420000;
        } elseif ($amount <= 39999900) {
            return 550000;
        } elseif ($amount <= 49999900) {
            return 650000;
        } else {
            return 700000;
        }
    }

}

class Transaction {

// Extended attributes for tigopesa
    const TZ_TIGO_PRIVATE_PAYMENT_RECEIVED = 701;
    const TZ_TIGO_PRIVATE_PAYMENT_SENT = 702;
    const TZ_TIGO_PRIVATE_PAYBILL_PAID = 703;
    const TZ_TIGO_PRIVATE_AIRTIME_YOU = 704;
    const TZ_TIGO_PRIVATE_DEPOSIT = 705;
    const TZ_TIGO_PRIVATE_WITHDRAW = 706;
    const TZ_TIGO_PRIVATE_DEPOSIT_BANK = 707;
    const TZ_TIGO_PRIVATE_BALANCE_REQUEST = 708;
    const TZ_TIGO_PRIVATE_UNKOWN = 799;
//Extended attributes for mpesa

    const TZ_MPESA_PRIVATE_PAYMENT_RECEIVED = 601;
    const TZ_MPESA_PRIVATE_PAYMENT_SENT = 602;
    const TZ_MPESA_PRIVATE_PAYBILL_PAID = 603;
    const TZ_MPESA_PRIVATE_AIRTIME_YOU = 604;
    const TZ_MPESA_PRIVATE_AIRTIME_OTHER = 605;
    const TZ_MPESA_PRIVATE_DEPOSIT = 606;
    const TZ_MPESA_PRIVATE_WITHDRAW = 607;
    const TZ_MPESA_PRIVATE_BALANCE_REQUEST = 608;
    const TZ_MPESA_PRIVATE_UNKNOWN = 699;
//############### Properties ####################
    const MONEY_IN = 1;
    const MONEY_OUT = 2;
    const MONEY_NEUTRAL = 3;
    const STATUS_COMPLETED = 1;
    const STATUS_DECLINED = 2;
    const STATUS_CANCELLED = 3;
    const STATUS_ATTEMPTED = 4;

    protected $id = 0;
    protected $type = 0;
    protected $superType = 0;
    protected $receipt = "";
    protected $time = "";
    protected $phonenumber = "";
    protected $name = "";
    protected $account = "";
    protected $status = 0;
    protected $amount = 0;
    protected $postBalance = 0;
    protected $note = "";
    protected $transactionCost = 0;
    protected $idUpdated = false;
    protected $typeUpdated = false;
    protected $superTypeUpdated = false;
    protected $receiptUpdated = false;
    protected $timeUpdated = false;
    protected $phonenumberUpdated = false;
    protected $nameUpdated = false;
    protected $accountUpdated = false;
    protected $statusUpdated = false;
    protected $amountUpdated = false;
    protected $postBalanceUpdated = false;
    protected $noteUpdated = false;
    protected $transactionCostUpdated = false;
    protected $isDataRetrived = false;

# # # # # # # # Initializer # # # # # # # # # #

    public function __construct($id, $initValues = NULL) {
        $this->id = (int) $id;
#initValues is an object with values for fast restoring state (optimisation)
        if (isset($initValues)) {
            $this->assignValues($initValues);
        }
    }

}

class Parser {

    public function dateInput($time) {
        $dt = \DateTime::createFromFormat("j/n/Y h:i A", $time);
        return $dt->getTimestamp();
    }

    public function parse_tigopesa($input) {

        $result = array("SUPER_TYPE" => 0,
        "TYPE" => 0,
        "RECEIPT" => "",
        "TIME" => 0,
        "PHONE" => "",
        "NAME" => "",
        "ACCOUNT" => "",
        "STATUS" => "",
        "AMOUNT" => 0,
        "BALANCE" => 0,
        "NOTE" => "",
        "COST" => 0);



// REFACTOR: should be split into subclasses
        if (strpos($input, "You have received") !== FALSE) {
            $result["SUPER_TYPE"] = Transaction::MONEY_IN;

            $temp = array();
            preg_match_all("/New balance is Tsh ([0-9\.\,]+)[\s\n]+You have received Tsh ([0-9\.\,]+)[\s\n]+from ([A-Z '\.]+),[\s\n]+([0-9]+)\. (\d\d?\/\d\d?\/\d{4}) (\d\d?:\d\d [AP]M)\; with TxnId:([^.]+\.[^.]+\.[^.]+)\./mi", $input, $temp);
            if (isset($temp[1][0])) {
                $result["TYPE"] = Transaction::TZ_TIGO_PRIVATE_PAYMENT_RECEIVED;
                $result["RECEIPT"] = $temp[7][0];
                $result["AMOUNT"] = Utility::numberInput($temp[2][0]);
                $result["NAME"] = $temp[3][0];
                $result["PHONE"] = $temp[4][0];
                $result["TIME"] = $this->dateInput($temp[5][0] . " " . $temp[6][0]);
                $result["BALANCE"] = Utility::numberInput($temp[1][0]);
            }
        } elseif (strpos($input, "Money sent successfully to") !== FALSE) {
            $result["SUPER_TYPE"] = Transaction::MONEY_OUT;
            $result["TYPE"] = Transaction::TZ_TIGO_PRIVATE_PAYMENT_SENT;

            $temp = array();
            preg_match_all("/New balance is Tsh ([0-9\.\,]+)[\s\n]+Money sent successfully to[\s\n]+([A-Z '\.]+), ([0-9]+)\.[\s\n]+Amount: Tsh ([0-9\.\,]+) Fee: Tsh ([0-9\.\,]+)TxnID:[\s\n]+([^.]+\.[^.]+\.[^.]+)\./mi", $input, $temp);
            if (isset($temp[1][0])) {
                $result["RECEIPT"] = $temp[6][0];
                $result["AMOUNT"] = Utility::numberInput($temp[4][0]);
                $result["NAME"] = $temp[2][0];
                $result["PHONE"] = $temp[3][0];
                $result["TIME"] = time();
                $result["BALANCE"] = Utility::numberInput($temp[1][0]);
                $result["COST"] = Utility::numberInput($temp[5][0]);
            }
        } elseif (strpos($input, "Cash-In of Tsh") !== FALSE) {
            $result["SUPER_TYPE"] = Transaction::MONEY_IN;
            $result["TYPE"] = Transaction::TZ_TIGO_PRIVATE_DEPOSIT;

            $temp = array();
            preg_match_all("/New balance is Tsh ([0-9\.\,]+)[\s\n]+Cash-In of Tsh ([0-9\.\,]+)[\s\n]+successful\. Agent ([A-Z '\.]+)\.[\s\n]+TxnID:[\s\n]+([^.]+\.[^.]+\.[^.]+)\./mi", $input, $temp);
            if (isset($temp[1][0])) {
                $result["RECEIPT"] = $temp[4][0];
                $result["AMOUNT"] = Utility::numberInput($temp[2][0]);
                $result["NAME"] = $temp[3][0];
                $result["TIME"] = time();
                $result["BALANCE"] = Utility::numberInput($temp[1][0]);
            }
        } elseif (strpos($input, "Cash-Out to") !== FALSE) {
            $result["SUPER_TYPE"] = Transaction::MONEY_OUT;
            $result["TYPE"] = Transaction::TZ_TIGO_PRIVATE_WITHDRAW;

            $temp = array();
            preg_match_all("/New balance is Tsh ([0-9\.\,]+)[\s\n]+Cash-Out to ([A-Z '\.]+) was successful\. Amount Tsh[\s\n]+([0-9\.\,]+) Charges Tsh ([0-9\.\,]+)TxnID[\s\n]+([^.]+\.[^.]+\.[^.]+)\./mi", $input, $temp);
            if (isset($temp[1][0])) {
                $result["RECEIPT"] = $temp[5][0];
                $result["AMOUNT"] = Utility::numberInput($temp[3][0]);
                $result["NAME"] = $temp[2][0];
                $result["TIME"] = time();
                $result["BALANCE"] = Utility::numberInput($temp[1][0]);
                $result["COST"] = Utility::numberInput($temp[4][0]);
            }
        } elseif (strpos($input, "recharge request is successful") !== FALSE) {
            $result["SUPER_TYPE"] = Transaction::MONEY_OUT;
            $result["TYPE"] = Transaction::TZ_TIGO_PRIVATE_AIRTIME_YOU;

            $temp = array();
            preg_match_all("/New balance is Tsh ([0-9\.\,]+)[\s\n]+Your[\s\n]+recharge request is successful[\s\n]+for amount Tsh ([0-9\.\,]+)[\s\n]+TxnId :[\s\n]+([^.]+\.[^.]+\.[^.]+)\./mi", $input, $temp);
            if (isset($temp[1][0])) {
                $result["RECEIPT"] = $temp[3][0];
                $result["AMOUNT"] = Utility::numberInput($temp[2][0]);
                $result["NAME"] = "Tigo";
                $result["TIME"] = time();
                $result["BALANCE"] = Utility::numberInput($temp[1][0]);
            }
        } elseif (strpos($input, "Bill Transaction has been sent") !== FALSE) {
            $result["SUPER_TYPE"] = Transaction::MONEY_OUT;
            $result["TYPE"] = Transaction::TZ_TIGO_PRIVATE_PAYBILL_PAID;

            $temp = array();
            preg_match_all("/Bill Transaction has been sent[\s\n]+to ([A-Z '\.]+)\.Please wait for[\s\n]+confirmation TxnId:[\s\n]+([^.]+\.[^.]+\.[^,]+)\, Bill[\s\n]+Number:([0-9]+),[\s\n]+transaction amount : ([0-9\.\,]+)[\s\n]+Tsh,new balance :([0-9\.\,]+) Tsh,[\s\n]+Company ([A-Z '\.]+)\./mi", $input, $temp);
            if (isset($temp[1][0])) {
                $result["RECEIPT"] = $temp[2][0];
                $result["AMOUNT"] = Utility::numberInput($temp[4][0]);
                $result["ACCOUNT"] = $temp[3][0];
                $result["NAME"] = $temp[1][0] != $temp[6][0] ? $temp[6][0] . " - " . $temp[1][0] : $temp[1][0];
                $result["TIME"] = time();
                $result["BALANCE"] = Utility::numberInput($temp[5][0]);
            }
        } elseif (strpos($input, "Bank payment successfull. The details are") !== FALSE) {
            $result["SUPER_TYPE"] = Transaction::MONEY_OUT;
            $result["TYPE"] = Transaction::TZ_TIGO_PRIVATE_DEPOSIT_BANK;

            $temp = array();
            preg_match_all("/Bank payment successfull\. The details are : TxnId:[\s\n]+([^.]+\.[^.]+\.[^,]+), Ref[\s\n]+Number:([0-9]+),[\s\n]+transaction amount : ([0-9\.\,]+)[\s\n]+Tsh , charges: ([0-9\.\,]+) Tsh,new[\s\n]+balance :([0-9\.\,]+) Tsh, Bank Name :[\s\n]+([A-Z '\.]+)/mi", $input, $temp);
            if (isset($temp[1][0])) {
                $result["RECEIPT"] = $temp[1][0];
                $result["AMOUNT"] = Utility::numberInput($temp[3][0]);
                $result["ACCOUNT"] = $temp[2][0];
                $result["NAME"] = $temp[6][0];
                $result["TIME"] = time();
                $result["BALANCE"] = Utility::numberInput($temp[5][0]);
                $result["COST"] = Utility::numberInput($temp[4][0]);
            }
        } else {
            $result["SUPER_TYPE"] = Transaction::MONEY_NEUTRAL;
            $result["TYPE"] = Transaction::TZ_TIGO_PRIVATE_UNKOWN;
        }

        return $result;
    }

    public function parse_mpesa($input) {
        $result = array("SUPER_TYPE" => 0,
        "TYPE" => 0,
        "RECEIPT" => "",
        "TIME" => 0,
        "PHONE" => "",
        "NAME" => "",
        "ACCOUNT" => "",
        "STATUS" => "",
        "AMOUNT" => 0,
        "BALANCE" => 0,
        "NOTE" => "",
        "COST" => 0);



// REFACTOR: should be split into subclasses
        if (strpos($input, "You have received") !== FALSE) {
            $result["SUPER_TYPE"] = Transaction::MONEY_IN;

            $temp = array();
            preg_match_all("/([A-Z0-9]+) Confirmed\.[\s\n]+You have received Tsh([0-9\.\,]+) from[\s\n]+([A-Z '\.]+)[\s\n]+on (\d\d?\/\d\d?\/\d\d) at (\d\d?:\d\d [AP]M)[\s\n]+New M-PESA balance is Tsh([0-9\.\,]+)/mi", $input, $temp);
            if (isset($temp[1][0])) {
                $result["TYPE"] = Transaction::TZ_MPESA_PRIVATE_PAYMENT_RECEIVED;
                $result["RECEIPT"] = $temp[1][0];
                $result["AMOUNT"] = Utility::numberInput($temp[2][0]);
                $result["NAME"] = $temp[3][0];
                $result["PHONE"] = "";
                $result["TIME"] = $this->dateInput($temp[4][0] . " " . $temp[5][0]);
                $result["BALANCE"] = Utility::numberInput($temp[6][0]);
            }
        } elseif (preg_match("/sent to .+ for account/", $input) > 0) {
            $result["SUPER_TYPE"] = Transaction::MONEY_OUT;
            $result["TYPE"] = Transaction::TZ_MPESA_PRIVATE_PAYBILL_PAID;

            $temp = array();
            preg_match_all("/([A-Z0-9]+) Confirmed\.[\s\n]+Tsh([0-9\.\,]+) sent to[\s\n]+(.+)[\s\n]+for account[\s\n]+(.+)[\s\n]+on (\d\d?\/\d\d?\/\d\d) at (\d\d?:\d\d [AP]M)[\s\n]+New M-PESA balance is Tsh([0-9\.\,]+)\./mi", $input, $temp);
            if (isset($temp[1][0])) {
                $result["RECEIPT"] = $temp[1][0];
                $result["AMOUNT"] = Utility::numberInput($temp[2][0]);
                $result["NAME"] = $temp[3][0];
                $result["ACCOUNT"] = $temp[4][0];
                $result["TIME"] = $this->dateInput($temp[5][0] . " " . $temp[6][0]);
                $result["BALANCE"] = Utility::numberInput($temp[7][0]);
            }
        } elseif (preg_match("/Give Tsh[0-9\.\,]+ cash to/", $input) > 0) {
            $result["SUPER_TYPE"] = Transaction::MONEY_IN;
            $result["TYPE"] = Transaction::TZ_MPESA_PRIVATE_DEPOSIT;

            $temp = array();
            preg_match_all("/([A-Z0-9]+) Confirmed\.[\s\n]+on (\d\d?\/\d\d?\/\d\d) at (\d\d?:\d\d [AP]M)[\s\n]+Give Tsh([0-9\.\,]+) cash to (.+)[\s\n]+New M-PESA balance is Tsh([0-9\.\,]+)/mi", $input, $temp);
            if (isset($temp[1][0])) {
                $result["RECEIPT"] = $temp[1][0];
                $result["AMOUNT"] = Utility::numberInput($temp[4][0]);
                $result["NAME"] = $temp[5][0];
                $result["TIME"] = $this->dateInput($temp[2][0] . " " . $temp[3][0]);
                $result["BALANCE"] = Utility::numberInput($temp[6][0]);
            }
        } elseif (preg_match("/Withdraw Tsh[0-9\.\,]+ from/", $input) > 0) {
            $result["SUPER_TYPE"] = Transaction::MONEY_OUT;
            $result["TYPE"] = Transaction::TZ_MPESA_PRIVATE_WITHDRAW;

            $temp = array();
            preg_match_all("/([A-Z0-9]+) Confirmed\.[\s\n]+on (\d\d?\/\d\d?\/\d\d) at (\d\d?:\d\d [AP]M)[\s\n]+Withdraw Tsh([0-9\.\,]+) from[\s\n]+(.+)[\s\n]+New M-PESA balance is Tsh([0-9\.\,]+)/mi", $input, $temp);
            if (isset($temp[1][0])) {
                $result["RECEIPT"] = $temp[1][0];
                $result["AMOUNT"] = Utility::numberInput($temp[4][0]);
                $result["NAME"] = $temp[5][0];
                $result["TIME"] = $this->dateInput($temp[2][0] . " " . $temp[3][0]);
                $result["BALANCE"] = Utility::numberInput($temp[6][0]);
            }
        } elseif (preg_match("/sent to .+ on/", $input) > 0) {
            $result["SUPER_TYPE"] = Transaction::MONEY_OUT;
            $result["TYPE"] = Transaction::TZ_MPESA_PRIVATE_PAYMENT_SENT;

            $temp = array();
            preg_match_all("/([A-Z0-9]+) Confirmed\.[\s\n]+Tsh([0-9\.\,]+) sent to ([A-Z '\.]+) on (\d\d?\/\d\d?\/\d\d) at (\d\d?:\d\d [AP]M)\.[\s\n]+New M-PESA balance is Tsh([0-9\.\,]+)/mi", $input, $temp);
            if (isset($temp[1][0])) {
                $result["RECEIPT"] = $temp[1][0];
                $result["AMOUNT"] = Utility::numberInput($temp[2][0]);
                $result["NAME"] = $temp[3][0];
                $result["PHONE"] = "";
                $result["TIME"] = $this->dateInput($temp[4][0] . " " . $temp[5][0]);
                $result["BALANCE"] = Utility::numberInput($temp[6][0]);
            }
        } elseif (preg_match("/You bought Tsh[0-9\.\,]+ of airtime on/", $input) > 0) {
            $result["SUPER_TYPE"] = Transaction::MONEY_OUT;
            $result["TYPE"] = Transaction::TZ_MPESA_PRIVATE_AIRTIME_YOU;

            $temp = array();
            preg_match_all("/([A-Z0-9]+) confirmed\.[\s\n]+You bought Tsh([0-9\.\,]+) of airtime on (\d\d?\/\d\d?\/\d\d) at (\d\d?:\d\d [AP]M)[\s\n]+New M-PESA balance is Tsh([0-9\.\,]+)/mi", $input, $temp);
            if (isset($temp[1][0])) {
                $result["RECEIPT"] = $temp[1][0];
                $result["AMOUNT"] = Utility::numberInput($temp[2][0]);
                $result["NAME"] = "Vodaphone";
                $result["TIME"] = $this->dateInput($temp[3][0] . " " . $temp[4][0]);
                $result["BALANCE"] = Utility::numberInput($temp[5][0]);
            }
        } elseif (preg_match("/You bought Tsh[0-9\.\,]+ of airtime for (\d+) on/", $input) > 0) {
            $result["SUPER_TYPE"] = Transaction::MONEY_OUT;
            $result["TYPE"] = Transaction::TZ_MPESA_PRIVATE_AIRTIME_OTHER;

            $temp = array();
            preg_match_all("/([A-Z0-9]+) confirmed\.[\s\n]+You bought Tsh([0-9\.\,]+) of airtime for (\d+) on (\d\d?\/\d\d?\/\d\d) at (\d\d?:\d\d [AP]M)[\s\n]+New M-PESA balance is Tsh([0-9\.\,]+)/mi", $input, $temp);
            if (isset($temp[1][0])) {
                $result["RECEIPT"] = $temp[1][0];
                $result["AMOUNT"] = Utility::numberInput($temp[2][0]);
                $result["NAME"] = $temp[3][0];
                $result["TIME"] = $this->dateInput($temp[4][0] . " " . $temp[5][0]);
                $result["BALANCE"] = Utility::numberInput($temp[6][0]);
            }
        } elseif (strpos($input, "Your M-PESA balance was") !== FALSE) {
            $result["SUPER_TYPE"] = Transaction::MONEY_NEUTRAL;
            $result["TYPE"] = Transaction::TZ_MPESA_PRIVATE_BALANCE_REQUEST;

            $temp = array();
            preg_match_all("/([A-Z0-9]+) Confirmed\.[\s\n]+Your M-PESA balance was Tsh([0-9\.\,]+)[\s\n]+on (\d\d?\/\d\d?\/\d\d) at (\d\d?:\d\d [AP]M)/mi", $input, $temp);
            if (isset($temp[1][0])) {
                $result["RECEIPT"] = $temp[1][0];
                $result["TIME"] = $this->dateInput($temp[3][0] . " " . $temp[4][0]);
                $result["BALANCE"] = Utility::numberInput($temp[2][0]);
            }
        } else {
            $result["SUPER_TYPE"] = Transaction::MONEY_NEUTRAL;
            $result["TYPE"] = Transaction::TZ_MPESA_PRIVATE_UNKNOWN;
        }
        $result["COST"] = ChargeCalculator::calculateCost($result["TYPE"], $result["TIME"], $result["AMOUNT"]);

        return $result;
    }

}

if ($write) {

//check if is payment related sms
//payment messages do not contains phone number, this is the security measure
    if (in_array(strtolower($from), array('mpesa', 'm-pesa', 'tigopesa', 'tigo-pesa', '+255714825469', '+255759553355', '+255658553355'))) {
        $parse = new Parser();
//we break message into components

        if (preg_match('/M-PESA/', $message)) {
            $data = $parse->parse_mpesa($message);
        } else {
            $data = $parse->parse_tigopesa($message);
        }
        // if ($data['TYPE'] == 701 || $data['TYPE'] == 601) {
//This is the receive payment message
        $payment_data = array(
        'confirmation_code' => $data['RECEIPT'],
        'amount' => substr($data['AMOUNT'], 0, -2), //we remove last estended 00 number
        'from' => $data['PHONE'],
        'name' => $data['NAME'],
        'vendor' => $from,
        'balance' => substr($data['BALANCE'], 0, -2),
        'content' => $message
        );
        //print_r($payment_data);
        $db->insert('rps', $payment_data);
        // }

        echo $payloadSuccess;
    }
} else {
    echo $payloadFailure;
}
exit();
?>