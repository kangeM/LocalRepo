<?php

namespace App\Http\Controllers;

use App\Configs\ZuruPay;
use Illuminate\Http\Request;
use App\Http\Helpers\CoreUtils;

class CraftController extends Controller
{


/**
     * @var CoreUtils
     */
    private $coreUtils;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->coreUtils = new CoreUtils();
    }



    public function getPayableBill(Request $request)
    {

        try {
            //code...
            $soapUrl = 'https://uat.craftsilicon.com/elmathirdpartyvendors/elmathirdpartyvendors.asmx'; // ZuruPay::CRAFT_SOAP_URL;
            $SOAPAction = "http://craftsilicon.com/ValidateAccountID";
            $sessionID = $this->generateToken();
            $partnerID = $request->partnerID;
            $requestDetails = $request->accountNumber;
            // xml post structure


            $xml_post_string = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                     <Body>
                         <ValidateAccountID xmlns="http://craftsilicon.com/">
                             <SessionID>' . $sessionID . '</SessionID>
                             <PartnerID>' . $partnerID . '</PartnerID>
                             <RequestDetails>Meternumber:' . $requestDetails . '</RequestDetails>
                         </ValidateAccountID>
                     </Body>
                 </Envelope>';

            $headers = array(
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "Content-length: " . strlen($xml_post_string),
                "SOAPAction: " . $SOAPAction,
            ); //SOAPAction: your op URL

            $url = $soapUrl;

            $this->coreUtils->flog(4, -1,"Request to CS ".print_r($xml_post_string,true), __METHOD__, __LINE__, "KE" );
            // PHP cURL  for https connection with auth
            $ch = curl_init();
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            //  curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 100);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // converting
            $response = curl_exec($ch);
            $xml = html_entity_decode($response);

            $this->coreUtils->flog(4, -1,"Response from CS ".print_r($xml,true), __METHOD__, __LINE__, "KE" );

            $response = strtr($xml, ['</soap:' => '</', '<soap:' => '<']);
            $output = json_decode(json_encode(simplexml_load_string($response)));
            $status = $output->Body->ValidateAccountIDResponse->ValidateAccountIDResult->ValidateAccountID->Status;
            $res = $output->Body->ValidateAccountIDResponse->ValidateAccountIDResult->ValidateAccountID->Message;
            $arrayRes = explode('|', $res);
            if (count($arrayRes) > 6) {
                $accountID = $arrayRes[1];
                $name =  $arrayRes[3];
                $dueAmount =  $arrayRes[5];
                $dueDate =  $arrayRes[7];

                $json = array(
                    "statusCode" => 200,
                    "statusMessage" => "Success",
                    "response" => array(
                        'accountID' => $accountID,
                        'accountName' => $name,
                        'dueAmount' => $dueAmount,
                        'dueDate' => $dueDate
                    )

                );
            } else {
                $json = array(
                    "statusCode" => 5000,
                    "statusMessage" => "No Bill FOUND",
                    "response" => array()

                );
            }
        } catch (\Throwable $th) {
            $json = array(
                "statusCode" => 5000,
                "statusMessage" => "An error occured. Contact Support ".$th."",
                "response" => array()

            );
        }



        echo json_encode($json);
    }

    public function generateToken()
    {
        $this->coreUtils->flog(
            4,
            -1,
            "Generating Token",
            __METHOD__,
            __LINE__,
            "KE"
        );


        $soapUrl = 'https://uat.craftsilicon.com/elmathirdpartyvendors/elmathirdpartyvendors.asmx';//ZuruPay::CRAFT_SOAP_URL;
        $SOAPAction = "http://craftsilicon.com/GetSessionKey";
        $userID ='testacc';// ZuruPay::CRAFT_API_USER;
        $userKey = 'test@2016';//ZuruPay::CRAFT_API_PASS;
        // xml post structure

        $xml_post_string = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
        <Body>
            <GetSessionKey xmlns="http://craftsilicon.com/">
                <APIUserID>' . $userID . '</APIUserID>
                <APIUserKey>' . $userKey . '</APIUserKey>
            </GetSessionKey>
        </Body>
    </Envelope>';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
            "SOAPAction: " . $SOAPAction,
        ); //SOAPAction: your op URL

        $url = $soapUrl;

        $this->coreUtils->flog(
            4,
            -1,
            "Payload Request" .json_encode($headers)." ".$xml_post_string,
            __METHOD__,
            __LINE__,
            "KE"
        );

        // PHP cURL  for https connection with auth
        $ch = curl_init();
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        //  curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // converting
        $response = curl_exec($ch);

        $this->coreUtils->flog(
            4,
            -1,
            "Payload Response" .$response,
            __METHOD__,
            __LINE__,
            "KE"
        );

        $xml = html_entity_decode($response);
        $response = strtr($xml, ['</soap:' => '</', '<soap:' => '<']);
        $output = json_decode(json_encode(simplexml_load_string($response)));
        $status = $output->Body->GetSessionKeyResponse->GetSessionKeyResult->GetSessionKey->Status;
        $key = $output->Body->GetSessionKeyResponse->GetSessionKeyResult->GetSessionKey->SessionKey;
        return $key;
    }

    public function makePayment(Request $request2)
    {
           $request = (object) $request2;

            try {

            $soapUrl = 'https://uat.craftsilicon.com/elmathirdpartyvendors/elmathirdpartyvendors.asmx';//ZuruPay::CRAFT_SOAP_URL;
            $SOAPAction = "http://craftsilicon.com/MakePayment";
            $sessionID = $this->generateToken();
            $partnerID = "007001001";//$request->partnerID;
            $requestDetails = $request->accountNumber;
            $bankReference = uniqid('ZURUPAY_');
            $mobileNumber = $request->payerMSISDN;
            $amount = $request->netAmount;
            // xml post structure

            $this->coreUtils->flog(4,-1,"######## Generating Payment######## partnerID:".$partnerID,  __METHOD__, __LINE__,"KE");

            $xml_post_string = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                     <Body>
                         <MakePayment xmlns="http://craftsilicon.com/">
                             <SessionID>' . $sessionID . '</SessionID>
                             <PartnerID>' . $partnerID . '.</PartnerID>
                             <MobileNumber>' . $mobileNumber . '</MobileNumber>
                             <BankReference>' . $bankReference . '</BankReference>
                             <RequestDetails>Meternumber:' . $requestDetails . ':Amount:' . $amount . '</RequestDetails>
                         </MakePayment>
                     </Body>
                 </Envelope>';

            $headers = array(
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "Content-length: " . strlen($xml_post_string),
                "SOAPAction: " . $SOAPAction,
            ); //SOAPAction: your op URL



           $this->coreUtils->flog(4,-1,"=====> Payment Request URL ".$soapUrl."\n".json_encode($headers)."\n".$xml_post_string , __METHOD__, __LINE__,"KE");


            $url = $soapUrl;

            // PHP cURL  for https connection with auth
            $ch = curl_init();
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            //  curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 100);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // converting
            $response = curl_exec($ch);
            $xml = html_entity_decode($response);

            $this->coreUtils->flog(4,-1,"<<<<=====>>> Payment Response URL ".$response , __METHOD__, __LINE__,"KE");

            $response = strtr($xml, ['</soap:' => '</', '<soap:' => '<']);
            $output = json_decode(json_encode(simplexml_load_string($response)));
            $status = $output->Body->MakePaymentResponse->MakePaymentResult->MakePayment->Status;
            if ($status == 'SUCCESS') {
                $CSReference = $output->Body->MakePaymentResponse->MakePaymentResult->MakePayment->CSReference;
                $reference = $output->Body->MakePaymentResponse->MakePaymentResult->MakePayment->Reference;
                $json = array(
                    "statusCode" => 200,
                    "statusMessage" => "Success",
                    "response" => array(
                        'CSReference' => $CSReference,
                        'Reference' => $reference,
                        'amount' => "",
                        'message' => ""
                    )


                );

                $this->coreUtils->flog(4,-1,"<<<<=====>>> Payment Response  ".print_r($json,true), __METHOD__, __LINE__,"KE");

            } else {
                $json = array(
                    "statusCode" => 5000,
                    "statusMessage" => "FAILED. Try again or contact support There ..'.$status.'",
                    "response" => array()

                );

              $this->coreUtils->flog(4,-1,"<<<<=====>>> Payment Response  ".print_r($json,true), __METHOD__, __LINE__,"KE");
            }
        } catch (\Throwable $th) {
            $json = array(
                "statusCode" => 5000,
                "statusMessage" => "An error occured. Contact Support '.$th.'",
                "response" => array()

            );
        }



        echo json_encode($json);
    }
}

