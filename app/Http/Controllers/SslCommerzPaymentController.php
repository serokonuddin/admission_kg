<?php

namespace App\Http\Controllers;

use App\Models\Finance\StudentFeeTansaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Library\SslCommerz\SslCommerzNotification;
use Session;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\DB;

class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }
    public function admissionstore(Request $request)
    {
        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }
    public function index(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "Admission Payment_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "Admission Payment_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }
    function housenumber($param)
    {

        return (($param - 1) % 4) + 1;
    }
    function generateRandomNumber()
    {
        $numbers = '0123456789';
        $specials = '!@#$%^&*()-_=+[]{}';

        // Generate a random number string with length - 1
        $randomNumbers = '';
        for ($i = 0; $i < 9 - 1; $i++) {
            $randomNumbers .= $numbers[random_int(0, strlen($numbers) - 1)];
        }

        // Add one random special character
        $specialChar = $specials[random_int(0, strlen($specials) - 1)];

        // Insert the special character at a random position
        $position = random_int(0, strlen($randomNumbers));
        $result = substr($randomNumbers, 0, $position)  . substr($randomNumbers, $position);

        return $result;
    }
    public function kgadmission($paymenthistory, $admission)
    {
        DB::table('student_fee_tranjection')
            ->where('id', $paymenthistory->id)
            ->update(['status' => 'Complete', 'updated_at' => date('Y-m-d H:i:s')]);
        $max = DB::table('student_admission')
            ->where('version_id', $admission->version_id)
            ->where('shift_id', $admission->shift_id)
            ->where('payment_status', 1)
            ->max('temporary_id');
        if ($admission->version_id == 1 && $admission->shift_id == 1) {
            $number = (10000 + (int)$max + 1) - 10000;
        } else if ($admission->version_id == 1 && $admission->shift_id == 2) {
            $number = (30000 + (int)$max + 1) - 30000;
        } else if ($admission->version_id == 2 && $admission->shift_id == 1) {
            $number = (20000 + (int)$max + 1) - 20000;
        } else if ($admission->version_id == 2 && $admission->shift_id == 2) {
            $number = (40000 + (int)$max + 1) - 40000;
        }
        DB::table('student_admission')
            ->where('id', $admission->id)
            ->update(['payment_status' => 1, 'temporary_id' => $number]);
        return $number;
    }


    public function KgStudentCreate($temporary_id)
    {
        $student = DB::table('student_admission')
            ->where('temporary_id', $temporary_id)
            ->first();

        if (!$student) {
            $session_id = (int)$student->session_id + 1;
            $count = DB::table('student_activity')
                ->where('session_id', $session_id)
                // ->where('version_id', $student->version_id)
                // ->where('shift_id', $student->shift_id)
                ->where('class_code', 0)
                ->count();

            // if ($admission->group_name == 'Science' && $admission->version_id == 1) {
            //     $middel = 1000;
            // } else if ($admission->group_name == 'Science' && $admission->version_id == 2) {
            //     $middel = 4000;
            // } else if ($admission->group_name == 'Business studies' && $admission->version_id == 1) {
            //     $middel = 5000;
            // } else if ($admission->group_name == 'Business studies' && $admission->version_id == 2) {
            //     $middel = 6000;
            // } else if ($admission->group_name == 'Humanities' && $admission->version_id == 1) {
            //     $middel = 3000;
            // } else {
            //     $middel = 3601;
            // }
            $serial = 1000 + $count + 1;
            $student_code = $session_id . '' . ($serial);

            $studentdata = array(
                'student_code' => $student_code,
                'first_name' => $student->name_en,
                'bangla_name' => $student->name_bn,
                'email' => $student->email,
                'mobile' => $student->phone,
                'gender' => $student->gender,
                'mobile' => $student->mobile,
                'birthdate' => $student->dob,
                'email' => $student->email,
                'local_guardian_name' => $student->gurdian_name,
                'sms_notification' => $student->phone,
                'photo' => $student->photo,
                'birth_certificate' => $student->birth_image,
                'birth_no' => $student->birth_registration_number,
                'service_number' => $student->service_name,
                'name' => $student->service_holder_name,
                'arms_name' => $student->name_of_service ?? $student->service_name,
                'in_service' => $student->in_service,
                'office_address' => $student->office_address,
                'name_of_staff' => $student->name_of_staff,
                'staff_designation' => $student->staff_designation,
                'staff_id' => $student->staff_id,
                'staff_certification' => $student->staff_certification,
                'arm_certification' => $student->arm_certification,
                'categoryid' => $student->category_id,
                'passing_year' => date('Y'),
                'sms_notification' => $student->phone,
                'category_id' => 1,
                'active' => 1,
            );

            $studentid = DB::table('students')->insertGetId($studentdata);
            DB::table('student_admission')->where('temporary_id', $temporary_id)->update(['student_code' => $student_code, 'status' => 2]);
            $student_activity = array(
                'student_code' => $student_code,
                'session_id' => $session_id,
                'class_id' => $student->class_id,
                'class_code' => $student->class_id,
                'version_id' => $student->version_id,
                'shift_id' => $student->shift_id,
                'group_id' => null,
                'roll' => $student_code,
                'house_id' => $this->housenumber($serial),
                'category_id' => 1,
                'active' => 1,
                'created_by' => 1,
            );
            DB::table('student_activity')->insertGetId($student_activity);
            $password = $this->generateRandomNumber();
            $user = array(
                'name' => $student->name_en,
                'email' => $student->email,
                'username' => $student->username,
                'phone' => $student->phone,
                'ref_id' => $student_code,
                'password_text' => $password,
                'password' => bcrypt($password),
                'group_id' => 4,
            );
            DB::table('users')->insert($user);
            //$tran_id=0;
            DB::table('student_fee_tranjection')
                ->where('id', $tran_id)
                ->update(['status' => 'Complete', 'student_code' => $student_code, 'updated_at' => date('Y-m-d H:i:s')]);




            sms_send($student->phone, 'College Admission payment for BAF Shaheen college Dhaka is completed. Please login and fill up your admission form. Usermame: ' . $student->username . ', Password: ' . $password . '. Link: https://bafsdadmission.com/login');
            $text = "College Admission payment for BAF Shaheen college Dhaka is completed. Please login and fill up your admission form.";
            return redirect()->route('sslredirect')->with('warging', $text);
        }
    }
    public function success(Request $request)
    {

        $text = "Admission Payment is Successful";

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_details = DB::table('student_fee_tranjection')
            ->where('id', $tran_id)
            ->select('*')->first();
        // dd($order_details);
        // if ($order_details) {

        //         DB::table('student_fee_tranjection')
        //         ->where('id', $tran_id)
        //         ->update(['status' => 'Complete', 'updated_at' => date('Y-m-d H:i:s')]);
        //        // $this->KgStudentCreate($order_details->admission_id);
        //         $text="Payment Successfully Paid";
        //         return redirect()->route('sslredirect')->with('warging', $text);

        // }
        if ($order_details->status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */


                $admission = DB::table('student_admission')->where('id', $order_details->admission_id)->first();
                $temporay_id = $this->kgadmission($order_details, $admission);
                sms_send($admission->mobile, 'KG Admission payment for ' . env('APP_NAME') . ' is completed.Your Temporay Number is ' . $temporay_id . '. Please Collect Your Admit Card Link: ' . env('APP_URL') . '/admissionview');
                $text = "Admission payment for " . env('APP_NAME') . " is completed. Please Collect Your Admit Card.";
                return redirect()->route('admissionSearchByNumber', $temporay_id)->with('warging', $text);
            }
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            $admission = DB::table('student_admission')->where('id', $order_details->admission_id)->first();
            $temporay_id = $this->kgadmission($order_details, $admission);
            sms_send($admission->mobile, 'KG Admission payment for ' . env('APP_NAME') . ' is completed.Your Temporay Number is ' . $temporay_id . '. Please Collect Your Admit Card Link: ' . env('APP_URL') . '/admissionview');
            $text = "Admission payment for " . env('APP_NAME') . " is completed. Please Collect Your Admit Card.";
            return redirect()->route('admissionSearchByNumber', $temporay_id)->with('warging', $text);


            // return redirect()->route('sslredirect')->with('warging', $text);
        } else {
            return redirect()->route('admissionview')->with('warging', $text);
            $tran_id = $request->input('tran_id');

            DB::table('student_fee_tranjection')
                ->where('id', $tran_id)
                ->update(['status' => 'Invalid', 'updated_at' => date('Y-m-d H:i:s')]);
            #That means something wrong happened. You can redirect customer to your product page.
            $text = "Invalid Transaction";
            return redirect()->route('admissionview')->with('warging', $text);
        }
    }
    public function success1(Request $request, $tran_id)
    {

        $text = "Admission Payment is Successful";

        $tran_id = $tran_id;
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_details = DB::table('student_fee_tranjection')
            ->where('id', $tran_id)
            ->select('*')->first();

        if ($order_details) {
            if ($order_details->class_code == 11) {
                //  DB::table('student_fee_tranjection')
                //    ->where('id', $tran_id)
                //    ->update(['status' => 'Complete', 'updated_at' => date('Y-m-d H:i:s')]);
                // return redirect()->route('studentFee')->with('success', "Payment Success");
            } elseif ($order_details->class_id == 0 && $order_details->admission_id != null && $order_details->admission_id != '') {
                DB::table('student_fee_tranjection')
                    ->where('id', $tran_id)
                    ->update(['status' => 'Complete', 'updated_at' => date('Y-m-d H:i:s')]);
                $this->KgStudentCreate($order_details->admission_id);
                $text = "Payment Successfully Paid";
                return redirect()->route('sslredirect')->with('warging', $text);
            }
        }
        if ($order_details->status == 'Pending') {
            $validation = 1;
            //$sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */

                $admission = DB::table('student_admission')->where('id', $order_details->admission_id)->first();
                $temporay_id = $this->kgadmission($order_details, $admission);
                sms_send($admission->mobile, 'KG Admission payment for BAF Shaheen college Dhaka is completed.Your Temporay Number is ' . $temporay_id . '. Please Collect Your Admit Card Link: ' . env('APP_URL') . '/admissionview');
                $text = "Admission payment for BAF Shaheen college Dhaka is completed. Please Collect Your Admit Card.";
                return redirect()->route('admissionSearchByNumber', $temporay_id)->with('warging', $text);




                $admission = DB::table('admission_temporary')
                    ->where('student_code', $order_details->student_code)
                    ->first();


                $userdata = DB::table('users')
                    ->where('username', $admission->username)
                    ->select('*')->first();

                if (empty($userdata)) {
                    $groupdata = DB::table('academygroups')->where('id', $admission->group_id)->first();
                    // if ($admission->class_id == 59 || $admission->class_id == 11) {
                    //     $groupdata = DB::table('academygroups')->where('group_name', $admission->group_name)->first();

                    //     $count = DB::table('student_activity')
                    //         ->where('session_id', $admission->session_id)
                    //         ->where('version_id', $admission->version_id)
                    //         ->where('class_code', 11)
                    //         ->where('group_id', $groupdata->id)
                    //         ->count();

                    //     if ($admission->group_name == 'Science' && $admission->version_id == 1) {
                    //         $middel = 1000;
                    //     } else if ($admission->group_name == 'Science' && $admission->version_id == 2) {
                    //         $middel = 4000;
                    //     } else if ($admission->group_name == 'Business studies' && $admission->version_id == 1) {
                    //         $middel = 5000;
                    //     } else if ($admission->group_name == 'Business studies' && $admission->version_id == 2) {
                    //         $middel = 6000;
                    //     } else if ($admission->group_name == 'Humanities' && $admission->version_id == 1) {
                    //         $middel = 3000;
                    //     } else {
                    //         $middel = 3601;
                    //     }
                    // } else {
                    //     $middel = 1000;
                    // }


                    $serial = $order_details->student_code;
                    $trimmed = substr($order_details->student_code, 2);        // removes the first 2 characters
                    $serial = (int)$trimmed;
                    $student_code = $order_details->student_code;

                    $studentdata = array(
                        'student_code' => $student_code,
                        'first_name' => $admission->full_name,
                        'email' => $admission->email,
                        'mobile' => $admission->phone,
                        'registration_number' => $admission->registration_number,
                        'roll_number' => $admission->roll_number,
                        'board' => $admission->board,
                        'passing_year' => date('Y'),
                        'sms_notification' => $admission->phone,
                        'category_id' => 1,
                        'active' => 1,
                    );

                    $studentid = DB::table('students')->insertGetId($studentdata);
                    // DB::table('admission_temporary')->where('id', $order_details->admission_id)->update(['student_code' => $student_code]);
                    $student_activity = array(
                        'student_code' => $student_code,
                        'session_id' => $admission->session_id,
                        'class_id' => $admission->class_id,
                        'class_code' => 11,
                        'version_id' => $admission->version_id,
                        'group_id' => $groupdata->id ?? '',
                        'roll' => $student_code,
                        'shift_id' => 1,
                        'house_id' => $this->housenumber($serial),
                        'category_id' => 1,
                        'active' => 1,
                        'created_by' => 1,
                    );
                    DB::table('student_activity')->insertGetId($student_activity);
                    $password = $this->generateRandomNumber();
                    $user = array(
                        'name' => $admission->full_name,
                        'email' => $admission->email,
                        'username' => $admission->username,
                        'phone' => $admission->phone,
                        'ref_id' => $student_code,
                        'password' => bcrypt($password),
                        'password_text' => $password,
                        'group_id' => 4,
                    );
                    DB::table('users')->insert($user);
                }

                DB::table('student_fee_tranjection')
                    ->where('id', $tran_id)
                    ->update(['status' => 'Complete', 'student_code' => $student_code, 'updated_at' => date('Y-m-d H:i:s')]);
                DB::table('admission_temporary')
                    ->where('id', $admission->id)
                    ->update(['payment_status' => 1]);

                DB::table('board_list')
                    ->where('roll_number', $admission->roll_number)
                    ->where('session_id', $admission->session_id)
                    ->update(['is_admit' => 1]);

                // $update_product = DB::table('orders')
                //     ->where('transaction_id', $tran_id)
                //     ->update(['status' => 'Processing']);


                sms_send($admission->phone, 'college Admission payment for BAF Shaheen college Dhaka is completed. Please login and fill up your admission form. Usermame: ' . $admission->username . ', Password: ' . $password . '. Link: https://bafsdadmission.com/login');
                $text = "college Admission payment for BAF Shaheen college Dhaka is completed. Please login and fill up your admission form.";
                return redirect()->route('sslredirect')->with('warging', $text);
            }
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            return redirect()->route('admissionview')->with('warging', $text);
            $tran_id = $request->input('tran_id');

            $admission = DB::table('admission_temporary')
                ->where('id', $order_details->admission_id)
                ->first();
            DB::table('student_fee_tranjection')
                ->where('id', $tran_id)
                ->update(['status' => 'Complete', 'updated_at' => date('Y-m-d H:i:s')]);
            DB::table('admission_temporary')
                ->where('id', $admission->id)
                ->update(['payment_status' => 1]);
            $text = "Admission Payment is successfully Completed.  Check Your Email or Phone number for login information";
            return redirect()->route('sslredirect')->with('warging', $text);
        } else {
            return redirect()->route('admissionview')->with('warging', $text);
            $tran_id = $request->input('tran_id');

            DB::table('student_fee_tranjection')
                ->where('id', $tran_id)
                ->update(['status' => 'Invalid', 'updated_at' => date('Y-m-d H:i:s')]);
            #That means something wrong happened. You can redirect customer to your product page.
            $text = "Invalid Transaction";
            return redirect()->route('admissionview')->with('warging', $text);
        }
    }

    public function fail(Request $request)
    {
        return redirect()->route('admissionview')->with('warging', 'Payment fail');
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('student_fee_tranjection')
            ->where('id', $tran_id)
            ->select('id', 'status')->first();
        if ($order_details) {
            if ($order_details->fee_for != 1) {
                DB::table('student_fee_tranjection')
                    ->where('id', $tran_id)
                    ->update(['status' => 'Failed', 'updated_at' => date('Y-m-d H:i:s')]);
            }
            return redirect()->route('studentFee')->with('success', "Payment Failed");
        }
        if ($order_details->status == 'Pending') {
            $update_product = DB::table('student_fee_tranjection')
                ->where('id', $tran_id)
                ->update(['status' => 'Failed', 'updated_at' => date('Y-m-d H:i:s')]);
            $text = "Admission Payment is Falied";
            return redirect()->route('admissionview')->with('warging', $text);
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

            $text = "Admission Payment is already Successful.  Check Your Email or Phone number for login information";
            return redirect()->route('admissionview')->with('warging', $text);
        } else {
            $update_product = DB::table('student_fee_tranjection')
                ->where('id', $tran_id)
                ->update(['status' => 'Invalid', 'updated_at' => date('Y-m-d H:i:s')]);
            $text = "Admission Payment is Invalid";
            return redirect()->route('admissionview')->with('warging', $text);
        }
    }

    public function cancel(Request $request)
    {
        return redirect()->route('admissionview')->with('warging', 'Payment Cancel');
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('student_fee_tranjection')
            ->where('id', $tran_id)
            ->select('id', 'status')->first();
        if ($order_details) {
            if ($order_details->fee_for != 1) {
                DB::table('student_fee_tranjection')
                    ->where('id', $tran_id)
                    ->update(['status' => 'Canceled', 'updated_at' => date('Y-m-d H:i:s')]);
            }
            return redirect()->route('studentFee')->with('warging', "Payment Canceled");
        }
        if ($order_details->status == 'Pending') {
            $update_product = DB::table('student_fee_tranjection')
                ->where('id', $tran_id)
                ->update(['status' => 'Canceled', 'updated_at' => date('Y-m-d H:i:s')]);
            $text = "Admission Payment is Cancel";
            return redirect()->route('admissionview')->with('warging', $text);
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            $text = "Admission Payment is already Successful.  Check Your Email or Phone number for login information";
            return redirect()->route('admissionview')->with('warging', $text);
        } else {
            $update_product = DB::table('student_fee_tranjection')
                ->where('id', $tran_id)
                ->update(['status' => 'Invalid', 'updated_at' => date('Y-m-d H:i:s')]);
            $text = "Admission Payment is Invalid";
            return redirect()->route('admissionview')->with('warging', $text);
        }
    }

    public function ipn(Request $request)
    {
        return 'ok';
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('student_fee_tranjection')
                ->where('id', $tran_id)
                ->select('id', 'status')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $admission = DB::table('admission_temporary')
                        ->where('id', $order_details->admission_id)
                        ->where('session_id', $order_details->session_id)
                        ->where('class_id', $order_details->class_id)
                        ->first();

                    // $user=array(
                    //     'name'=>
                    // );
                    $update_product = DB::table('student_fee_tranjection')
                        ->where('id', $tran_id)
                        ->update(['status' => 'Complete']);

                    // $update_product = DB::table('orders')
                    //     ->where('transaction_id', $tran_id)
                    //     ->update(['status' => 'Processing']);

                    $text = "Admission Payment is successfully Completed. Check Your Email or Phone number for login information";
                    return redirect()->route('sslredirect')->with('warging', $text);
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
                $update_product = DB::table('student_fee_tranjection')
                    ->where('id', $tran_id)
                    ->update(['status' => 'Completed']);
                #That means Order status already updated. No need to udate database.

                $text = "Admission Payment is already successfully Completed. Check Your Email or Phone number for login information";
                return redirect()->route('sslredirect')->with('warging', $text);
            } else {
                #That means something wrong happened. You can redirect customer to your product page.
                $update_product = DB::table('student_fee_tranjection')
                    ->where('id', $tran_id)
                    ->update(['status' => 'Invalid']);
                $text = "Invalid Transaction";
                return redirect()->route('sslredirect')->with('warging', $text);
            }
        } else {
            $update_product = DB::table('student_fee_tranjection')
                ->where('id', $tran_id)
                ->update(['status' => 'Invalid']);
            $text = "Invalid Data";
            return redirect()->route('sslredirect')->with('warging', $text);
        }
    }
    public function paymentnow($tran_id)
    {

        $payment = StudentFeeTansaction::with('student')->find($tran_id);

        $fee_for = array(
            1 => 'Admission Fee',
            2 => 'Session Charge',
            3 => 'Tuition Fee',
            4 => 'Exam Fee',
            5 => 'Government Charge',
            6 => 'Board Fee',
            7 => 'Coaching Fee',
            8 => 'Conveyance Fee',
            9 => 'Student Welfare',
            10 => 'EMIS',
            11 => 'MISC',
            12 => 'Fine & Charge'
        );
        //dd($payment);
        if (empty($payment)) {
            return back()->with('success', 'Payment information not found');
        }



        $post_data = array();
        $post_data['total_amount'] = $payment->amount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $tran_id; // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $payment->student->first_name;
        $post_data['cus_email'] = $payment->student->email;
        $post_data['cus_add1'] = $payment->student->present_addr;
        $post_data['cus_add2'] = $payment->student->permanent_addr;
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = $payment->nationality;
        $post_data['cus_phone'] = '88' . $payment->sms_notification;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "testshahe68ix";
        $post_data['ship_add1'] = "Dhaka Cantonment, Police Station: Kafarul";
        $post_data['ship_add2'] = "Dhaka Cantonment, Police Station: Kafarul";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1206";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = $fee_for[$payment->fee_for];
        $post_data['product_category'] = $fee_for[$payment->fee_for];
        $post_data['product_profile'] = $fee_for[$payment->fee_for];



        #Before  going to initiate the payment order status need to insert or update as Pending.
        // $update_product = DB::table('orders')
        //     ->where('transaction_id', $post_data['tran_id'])
        //     ->updateOrInsert([
        //         'name' => $post_data['cus_name'],
        //         'email' => $post_data['cus_email'],
        //         'phone' => $post_data['cus_phone'],
        //         'amount' => $post_data['total_amount'],
        //         'status' => 'Pending',
        //         'address' => $post_data['cus_add1'],
        //         'transaction_id' => $post_data['tran_id'],
        //         'currency' => $post_data['currency']
        //     ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function validateTransaction($transactionId)
    {
        // Get the store credentials from .env
        // $storeId = env('SSLCZ_STORE_ID');
        // $storePassword = env('SSLCZ_STORE_PASSWORD');

        // Construct the URL with query parameters
        $url = "https://securepay.sslcommerz.com/validator/api/merchantTransIDvalidationAPI.php";
        $queryParams = [
            'tran_id' => $transactionId,
            'store_id' => 'shahe663e56ef63edf',
            'store_passwd' => 'shahe663e56ef63edf@ssl',
            'v' => 3,
            'format' => 'json',
        ];

        // Make the GET request
        $response = Http::get($url, $queryParams);

        // Check for a successful response
        if ($response->successful()) {
            $data = $response->json();
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to validate transaction.',
            ], 500);
        }
    }
}
