<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class PaymentController extends Controller {

    private $currency = 'TZS';
    private $cost_per_sms;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('payment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $input = $request->all();
        if (request()->ajax() && isset($request->status)) {
            $payment = DB::table('payment')->where('payment_id', $request->payment_id);
            if ($request->status == 1) {
                $payment->update(['approved' => 1, 'confirmed_time' => 'now()', 'confirmed' => 1, 'sms_provided' => $request->number]);
                $client_id = $payment->first()->client_id;
                $client = DB::table('client')->where('client_id', $client_id)->first();
                $subject = 'karibuSMS Payment Accepted';
                $message = 'Hello ' . $client->email . ' ,<br/>'
                        . ' Your payment has been accepted and ' . $request->number . ' SMS provided into your account.';
                $this->sendEmail($client->email, $subject, $message);
                echo 1;
                exit;
            } else {
                $payment->delete();
                echo 0;
                exit;
            }
        } else {
            $array=[
               "currency"=>request('currency'), "amount"=>request("amount"), "transaction_code"=>request("transaction_code"), "cost_per_sms"=>request("cost_per_sms"), "method"=>request("method"), "client_id"=>request("client_id"), "confirmed"=>request("confirmed"), "staff_id_approved"=>request("staff_id_approved"), "approved"=>request("approved"), "payment_per_sms"=>request("payment_per_sms"), "sms_provided"=>request("sms_provided")
            ];
            DB::table('payment')->insert($array);
            $subject = 'karibuSMS Payment Accepted';
            $client = DB::table('client')->where('client_id', $request->client_id)->first();
            $message = 'Hello ' . $client->email . ' ,<br/>'
                    . ' Your payment has been accepted and ' . $request->number . ' SMS provided into your account.';
            $this->sendEmail($client->email, $subject, $message);
        }

        echo ' <div class="alert alert-success">Payment added successfully  </div>';
    }

    public function notifyAcceptedPayments() {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    /**
     * Show actual reports for payment done
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function report() {

        $total = DB::select("SELECT sum(amount) as total_amount FROM payment");
        $total_sms_remain = DB::table('sms_remain')->first()->total;
        $total_sms = DB::select("SELECT sum(message_count) as total_sms FROM message");
        $sms = array_shift($total_sms);
        $payments = DB::select("select a.name,a.price_per_sms, a.phone_number, a.email, b.time, b.invoice, b.payment_id, b.transaction_code, b.method, b.amount, b.currency, b.sms_provided, b.receipt FROM client a JOIN payment b ON a.client_id=b.client_id  where confirmed=1 and approved=1");
        $users_payment = DB::select('select a.name,a.price_per_sms, a.phone_number, a.email, b.time, b.invoice, b.payment_id, b.transaction_code, b.method, b.amount, b.currency, b.sms_provided, b.receipt FROM client a JOIN payment b ON a.client_id=b.client_id where b.approved <>1');
        return view('payment.report')->with(array(
                    'payment' => array_shift($total),
                    'total_sms_remain' => $total_sms_remain,
                    'sms_sent' => $sms->total_sms,
                    'users_payment' => $users_payment,
                    'payments' => $payments
        ));
    }

    public function userPayment() {
        return view('payment.user_payment');
    }

    public function addPayment() {

        return view('payment.add_payment');
    }

    public function addCardPayment() {
        $user = DB::table('client')->where('client_id', session('client_id'))->first();
        return view('payment.credit_card', compact('user'));
    }

    public function viewPaymentReports() {
        $payments = DB::table('payment')->where('client_id', session('client_id'))->get();
        return view('payment.view_report', compact('payments'));
    }

    public function getReceipt($payment_id) {
        $client = DB::table('client')->where('client_id', session('client_id'))->first();
        $payment = DB::table('payment')->where('payment_id', $payment_id)->first();
        $invoice = $payment->invoice;
        $currency = $payment->currency;
        $sms_price = $payment->cost_per_sms;
        $total_price = $payment->amount;


        $data = view('payment.receipt', compact('client', 'quantity', 'invoice', 'currency', 'sms_price', 'total_price'));

        $file = 'receipt_' . time() . '.doc';
        $file_path = 'media/images/business/' . session('client_id') . '/' . $file;

        $handle = fopen($file_path, 'wr+');
        fwrite($handle, $data);
        fclose($handle);
        return json_encode(array(
            'status' => 'success',
            'message' => 'receipt generated successfully',
            'file' => $file
        ));
    }

    public function getInvoice($quantity = null, $payment_id = null) {

        $client = DB::table('client')->where('client_id', session('client_id'))->first();
        if ($payment_id != NULL) {
            $payment = DB::table('payment')->where('payment_id', $payment_id)->first();
            $invoice = $payment->invoice;
            $currency = $payment->currency;
            $sms_price = $payment->cost_per_sms;
            $total_price = $payment->amount;
        } else {
            $invoice = $this->createInvoice($quantity);
            $currency = $this->currency;
            $sms_price = $this->cost_per_sms;
            $total_price = self::getSmsPrice($quantity);
        }

        $data = view('payment.invoice', compact('client', 'quantity', 'invoice', 'currency', 'sms_price', 'total_price'));

        $file = 'invoice_' . time() . '.doc';
        $folder = 'media/images/business/' . session('client_id');
        !is_dir($folder) ? mkdir($folder, 0777, TRUE) : '';
        $file_path = 'media/images/business/' . session('client_id') . '/' . $file;

        $handle = fopen($file_path, 'wr+');
        fwrite($handle, $data);
        fclose($handle);
        return json_encode(array(
            'status' => 'success',
            'message' => 'Invoice generated successfully',
            'price' => self::getSmsPrice($quantity),
            'file' => $file
        ));
    }

    private function createInvoice($quantity, $client_id = null) {
        $id = $client_id == NULL ? session('client_id') : $client_id;
        $check = DB::table('payment')
                        ->where('client_id', $id)
                        ->where('confirmed', 0)
                        ->where('receipt', NULL)->where('invoice', '!=', null)->first();

        if (empty($check)) {
            $invoice = random_int(10000, str_replace(1465, NULL, time()));

            DB::table('payment')->insertGetId([
                'client_id' => $id,
                'method' => 'booking',
                'amount' => self::getSmsPrice($quantity),
                'currency' => $this->currency,
                'cost_per_sms' => SMS_PRICE,
                'invoice' => $invoice,
                'confirmed' => 0,
                'approved' => 0,
                'payment_per_sms' => 1
                    ], 'payment_id');
            $this->cost_per_sms = SMS_PRICE;
            $subject = 'karibuSMS Payment Request';
            $client = DB::table('client')->where('client_id', $id)->first();
            $message = 'Hello karibuSMS ,<br/>'
                    . ' Your client ' . $client->firstname . ' has placed an order to buy SMS . These are details'
                    . '<p>Amount: ' . self::getSmsPrice($quantity) . ' </p>'
                    . '<p>cost per SMS ' . SMS_PRICE . '</p>'
                    . 'Kindly login into karibusms.com to approve payments <br/>'
                    . 'Thank you';
            $this->sendEmail('swillae1@gmail.com', $subject, $message);
        } else {
            $invoice = $check->invoice;
            $this->currency = $check->currency;
            $this->cost_per_sms = $check->cost_per_sms;
            DB::table('payment')->where('invoice', $invoice)->update(['amount' => self::getSmsPrice($quantity)]);
        }
        return $invoice;
    }

    /**
     * 
     * @param int $quantity
     * @return int
     */
    public static function getSmsPrice($quantity, $payment_price = null) {
        // in case we want to handle discounts and other pricing changes we do here

        return $payment_price == NULL ? $quantity * SMS_PRICE : $payment_price;
    }

    public function addReceipt() {
        $code = request('code');
        $payment = DB::table('payment')
                ->where('client_id', session('client_id'))
                ->where('confirmed', 0)
                ->where('receipt', NULL)
                ->first();
        if (!empty($payment)) {
            DB::table('payment')
                    ->where('client_id', session('client_id'))
                    ->where('confirmed', 0)
                    ->update(['receipt' => $code]);
            return json_encode(array(
                'status' => 'success',
                'message' => 'Thank you. You wrote: ' . $code . '. we will soon validate your payments, add SMS and generate your receipt'
            ));
        } else {
            if (request('quantity') !== NULL) {
                $this->getInvoice(request('quantity'));
                $this->addReceipt();
            } else {

                return json_encode(array(
                    'status' => 'success',
                    'message' => 'No invoice generated for this payment, please generate invoice first'
                ));
            }
        }
    }

    public function tocheckout() {
        $sms = request('sms');
        $invoice = $this->createInvoice($sms);
        $cardname = request('name');
        $cost = $sms * SMS_PRICE / EXCHANGE_RATE;
        $price = round($cost, 2);
        DB::table('client')
                ->where('client_id', session('client_id'))
                ->update(['city' => request('city'), 'email' => request('email')]);
        $user = DB::table('client')
                ->where('client_id', session('client_id'))
                ->first();
        DB::table('payment')->insert([
            'amount' => $price,
            'method' => "'Bank Card'",
            'currency' => "'USD'",
            'client_id' => session('client_id'),
            'cost_per_sms' => SMS_PRICE / EXCHANGE_RATE,
            'invoice' => $invoice,
            'confirmed' => 0,
            'approved' => 0,
            'payment_per_sms' => 1
        ]);
        return view('payment.checkout', compact('cardname', 'invoice', 'price', 'user', 'sms'));
    }

    public function bankCard() {

        define('ENV', 'SANDBOX');
        if (ENV == 'SANDBOX') {
            define('CO_PRIVATE_KEY', 'AD652F54-A99F-4D8E-B175-B565FEAEAB3E');
            define('CO_SELLER_ID', '901314453');
        } else {
            define('CO_PRIVATE_KEY', 'BEC72024-E7C1-11E4-901D-5ECC3A5D4FFE');
            define('CO_SELLER_ID', '102514285');
        }


        \Twocheckout::privateKey(CO_PRIVATE_KEY);
        \Twocheckout::sellerId(CO_SELLER_ID);

// Your username and password are required to make any Admin API call.
        \Twocheckout::username('inetstz_sandbox');
        \Twocheckout::password('Inets@Inets2015');

// If you want to turn off SSL verification (Please don't do this in your production environment)
        \Twocheckout::verifySSL(false);  // this is set to true by default
// To use your sandbox account set sandbox to true
        \Twocheckout::sandbox(TRUE);

        try {
            //get invoice information including currency, amount,state, city,email
            // payment information etc
            //$payment_info->currency;
            //get user currenty city
            $client_info = DB::select("SELECT c.firstname,c.client_id, c.lastname, c.location, c.email,c.phone_number,c.country  FROM client c WHERE c.client_id='" . session('client_id') . "'");


            $client = array_shift($client_info);

            //update the amount in the database to match the required USD
            $total = request('amount');

            //save in the database
            //$this->db->update('booking', array('usd_amount' => $total), array('invoice' => $invoice));

            $param = array(
                "merchantOrderId" => $client->client_id, //we can pass INVOICE later
                "token" => request('token'),
                "currency" => 'USD',
                "total" => $total,
                "billingAddr" => array(
                    "name" => $client->firstname . ' ' . $client->lastname,
                    "addrLine1" => '123 Mikocheni B Street',
                    "city" => 'Dar es salaam',
                    "state" => 'TZ',
                    "zipCode" => '255',
                    "country" => 'Tanzania',
                    "email" => $client->email,
                    "phoneNumber" => $client->phone_number
                )
            );

            $charge = \Twocheckout_Charge::auth($param);

//save this information in payment_request
//	    DB::table('payment_request')->insert([
//		'token' => request('token'),
//		'vendor' => '2checkout',
//		'content' => json_encode($charge),
//		'client_id' => $client->client_id
//	    ]);

            if ($charge['response']['responseCode'] == 'APPROVED') {
                //if payment is successful
                /*
                 * 1. return information to user to inform about that
                 * 2. approve user, there is no need for user to enter receipt number
                 */
                //save this information in payment_request
                $invoice = random_int(10000, str_replace(1465, NULL, time()));
                DB::table('payment')->insert([
                    'amount' => request('amount'),
                    'method' => 'Bank Card',
                    'currency' => 'USD',
                    'client_id' => $client->client_id,
                    'cost_per_sms' => SMS_PRICE / EXCHANGE_RATE,
                    'invoice' => $invoice,
                    'confirmed' => 0,
                    'approved' => 0,
                    'payment_per_sms' => 1
                ]);
                //return info to user
                echo json_encode(array('status' => 'success',
                    'message' => 'Payment Received Successfully'
                        )
                );
            } else {

                echo json_encode(array(
                    'status' => 'success',
                    'message' => $charge['response']['responseCode'] . $charge['response']['responseMsg']));
            }
        } catch (Twocheckout_Error $e) {
            return $e->getMessage();
        }
    }

    public function status() {

        switch (request('message_type')) {
            case 'ORDER_CREATED':

                echo 'order created';
                break;
            case 'FRAUD_STATUS_CHANGED':

                echo 'fraud status changed';
                break;
            case 'INVOICE_STATUS_CHANGED':

                $invoice_id = request('invoice_id ');
                $approved = request('invoice_status') == 'approved' ? 1 : 0;
                DB::table('payment')
                        ->where('invoice', $invoice_id)->update(['approved' => $approved]);

                break;
            case 'REFUND_ISSUED':
                echo 'refund issued';

                break;
            default:
                echo 'no tag message';
                break;
        }
    }

    public function addRegion() {
        
    }

}
