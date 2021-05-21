<?php

namespace backend\libraries;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
/**
* Common functions
*/
class Commons 
{

   //Hash String
   public static function hashString($string='123qwe')
   {
        $string_hash = Yii::$app->security->generatePasswordHash($string);
        return $string_hash;
   }

   //Generate random string
   public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
   }

   //Validate Hash
   public static function validateHash($string,$original_hash)
   {
        return Yii::$app->security->validatePassword($string, $original_hash);
   }

   //Function to return the networkID
    public static function whichNetwork($MSISDN)
    {
        //Prefix Arrays
        $safaricom=array('25470','25471','25472','25472');
        $airtel=array('25473','25475','25478');
        $orange=array('25477','25420');
        $yu=array('25475');
        $equitel=array('25476');

        //Normalize the number
        $MSISDN=(int)$MSISDN;

        //Get the first 5 digits
        $prefix=substr($MSISDN, 0,5);

        //Check if its in any of the arrays
        if (in_array($prefix, $safaricom)) {
            //Network Operator ID - 1
            return 1;
            exit;
        }elseif (in_array($prefix, $airtel)) {
            //Network Operator ID - 2
            return 2;
            exit;
        }elseif (in_array($prefix, $orange)) {
            //Network Operator ID - 3
            return 3;
            exit;
        }elseif (in_array($prefix, $yu)) {
            //Network Operator ID - 4
            return 2;
            exit;
        }elseif (in_array($prefix, $equitel)) {
            //Network Operator ID - 4
            return 2;
            exit;
        }else{
            //Network Operator ID - Not known
            return 7;
        }


    }   

   //Format MSISDN
   public static function formatMSISDN($MSISDN, $internationalMode = FALSE) {

    // default the country-dial code
    $countryDialCode = 254;
    try {
        //Sanitize the MSISDN
        $formatedMSISDN = preg_replace("/[^0-9\s]/", "", $MSISDN);

        //Get rid of the leading 0
        if ((substr($formatedMSISDN, 0, 1) == "0") && (strlen($formatedMSISDN) == 10)) {
            $formatedMSISDN = substr_replace($formatedMSISDN, "", 0, 1);
        }
        
        // If the # is less than the countries #
        if (strlen($formatedMSISDN) <= 9 && strlen($formatedMSISDN) > 0) {
            $formatedMSISDN = $countryDialCode . $formatedMSISDN;
            // If it is in international mode we apppend a  +
            if ($internationalMode) {
                $formatedMSISDN = "+" . $formatedMSISDN;
            }
        }
    } catch (Exception $exc) {
        $flogParams = array('MSISDN' => $formatedMSISDN);
        //CoreUtils::flog(2, $flogParams, "Error formating the MSISDN  \n" . $exc->getMessage(), "\n" . __CLASS__, __FUNCTION__, __LINE__);
    }

    return trim($formatedMSISDN);
}

   //Validate MSISDN
       /**
     * Function to validate the MSISDN
     *
     */
    public static function isValidMobileNo($userNumber, $format = 'emg') {

        global $err, $descr;
        $numberRule[0] = array('netlen' => 2, 'netNo' => 71, 'prefix' => 254, 'intprefix' => '+254', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); //safaricom 1
        $numberRule[1] = array('netlen' => 2, 'netNo' => 72, 'prefix' => 254, 'intprefix' => '+254', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); //safaricom 1
        $numberRule[2] = array('netlen' => 2, 'netNo' => 73, 'prefix' => 254, 'intprefix' => '+254', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); //celtel
        $numberRule[3] = array('netlen' => 2, 'netNo' => 75, 'prefix' => 254, 'intprefix' => '+254', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); //Yu
        $numberRule[4] = array('netlen' => 2, 'netNo' => 77, 'prefix' => 254, 'intprefix' => '+254', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); //Orange
        $numberRule[5] = array('netlen' => 2, 'netNo' => 20, 'prefix' => 254, 'intprefix' => '+254', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); //telcom

        $numberRule[6] = array('netlen' => 2, 'netNo' => 71, 'prefix' => 255, 'intprefix' => '+255', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); //TZ Tigo
        $numberRule[7] = array('netlen' => 2, 'netNo' => 78, 'prefix' => 255, 'intprefix' => '+255', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); //TZ Zain
        $numberRule[8] = array('netlen' => 2, 'netNo' => 75, 'prefix' => 255, 'intprefix' => '+255', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); //TZ Vodacom
        $numberRule[9] = array('netlen' => 2, 'netNo' => 77, 'prefix' => 255, 'intprefix' => '+255', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); //TZ Zantel
        $numberRule[10] = array('netlen' => 2, 'netNo' => 73, 'prefix' => 255, 'intprefix' => '+255', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); //TZ TTLC
        $numberRule[11] = array('netlen' => 2, 'netNo' => 79, 'prefix' => 255, 'intprefix' => '+255', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); //TZ Benson Online

        $numberRule[12] = array('netlen' => 1, 'netNo' => 7, 'prefix' => 256, 'intprefix' => '+256', 'localprefix' => '0', 'userlen' => 8, 'numlen' => 12); //UG numbers
        $numberRule[13] = array('netlen' => 2, 'netNo' => 70, 'prefix' => 254, 'intprefix' => '+254', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); // safaricom
        $numberRule[14] = array('netlen' => 1, 'netNo' => 2, 'prefix' => 233, 'intprefix' => '+233', 'localprefix' => '0', 'userlen' => 8, 'numlen' => 12);  // Ghana numbers

        $numberRule[15] = array('netlen' => 2, 'netNo' => 97, 'prefix' => 260, 'intprefix' => '+260', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); // Zambia numbers
        $numberRule[16] = array('netlen' => 2, 'netNo' => 96, 'prefix' => 260, 'intprefix' => '+260', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); // Zambia numbers
        $numberRule[17] = array('netlen' => 2, 'netNo' => 70, 'prefix' => 254, 'intprefix' => '+254', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); // safaricom
        $numberRule[18] = array('netlen' => 2, 'netNo' => 78, 'prefix' => 254, 'intprefix' => '+254', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); //celtel
         $numberRule[19] = array('netlen' => 2, 'netNo' => 79, 'prefix' => 254, 'intprefix' => '+254', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); // safaricom
        $numberRule[20] = array('netlen' => 2, 'netNo' => 76, 'prefix' => 254, 'intprefix' => '+254', 'localprefix' => '0', 'userlen' => 7, 'numlen' => 12); // equitel

        $userNumber = 0 + str_replace(' ', '', $userNumber);
        $len = strlen($userNumber);
        $mobileNumber = 0;
        $netNo = 0;

        //CoreUtils::flog2('DEBUG', "THE USER NUMBER => $userNumber", __FILE__, __FUNCTION__, __LINE__);
        //find country with the lowest prefix, and use it as the "minimum mobile number"
        $minPrefix = $numberRule[0]['prefix'];
        $maxPrefix = $numberRule[0]['prefix'];
        foreach ($numberRule as $nm) {
            if ($nm['prefix'] < $minPrefix) {
                $minPrefix = $nm['prefix'];
            }
            if ($nm['prefix'] > $maxPrefix) {
                $maxPrefix = $nm['prefix'];
            }
        }
        $leastUserNumber = $minPrefix * 1000000000;
        $maxUserNumber = ($maxPrefix * 1000000000) + 999999999;
//        if ($userNumber > 0 and $userNumber < 269999999999) {
        if ($userNumber > $leastUserNumber and $userNumber < $maxUserNumber) {
            //CoreUtils::flog2('DEBUG', "THE USER NUMBER => $userNumber is of required length.", __FILE__, __FUNCTION__, __LINE__);

            $myRule = null;
            foreach ($numberRule as $rule) {
                $upperNet = 0;
                $netOK = true;
                $xs = $rule['userlen'] + $rule['netlen'];

                //CoreUtils::flog2('DEBUG', "The total length is=> $xs", __FILE__, __FUNCTION__, __LINE__);
                //CoreUtils::flog2('DEBUG', "The total length is=> $len", __FILE__, __FUNCTION__, __LINE__);

                if ($len < $xs) {
                    $err .= "$userNumber - [ len:$len < valid:$xs] ";
                    $descr = "INVALID:$userNumber too short";
                    continue;
                }

                $mobileNumber = 0 + substr($userNumber, (-1 * $xs), $xs);

                //CoreUtils::flog2('DEBUG', "The mobileNumber => $mobileNumber", __FILE__, __FUNCTION__, __LINE__);

                $netNo = 0 + substr($userNumber, (-1 * $xs), $rule['netlen']);

               //CoreUtils::flog2('DEBUG', "The netNo => $netNo", __FILE__, __FUNCTION__, __LINE__);

                if ($len >= $xs) {
                    $netOK = false;
                    $lx = $len - $xs;
                    if ($lx > 0) {
                        $upperNet = 0 + substr($userNumber, (-1 * ($lx + $xs)), $lx);
                    } else {
                        $upperNet = 0;
                    }
                    if ($upperNet == 0 or $upperNet == $rule['prefix'] or $upperNet == $rule['netNo'] or $upperNet == $rule['localprefix'] or $upperNet == $rule['intprefix'])
                        $netOK = true;
                }
                //$err .= "<br/> un:$userNumber, mn:$mobileNumber, net:$netNo upp:$upperNet ln:$len ".printArray($rule);

                if ($netNo == $rule['netNo'] and $netOK) {
                    $myRule = $rule;
                    break;
                }
            }

            if (is_null($myRule)) {
                $err .= "$userNumber - network:'$netNo' or prefix:'$upperNet' not acceptable";
                $descr = "INVALID:$userNumber not a valid network";
                return 0;
            }

            // i have a number and details
            switch ($format) {

                case 'int':
                case 'international':
                    $number = $myRule['intprefix'] . $mobileNumber;
                    break;
                case 'local':
                    $number = $myRule['localprefix'] . $mobileNumber;
                    break;
                default: // emg
                    $number = $myRule['prefix'] . $mobileNumber;
                    break;
            }
            return $number;
        } elseif ($userNumber == 0) {
            $err .= "'$mobileNumber' not numeric";
            $descr = "INVALID:$mobileNumber not a number";
            return 0;
        }
        $err .= "'$mobileNumber' not within given range";
        $descr = "INVALID:$mobileNumber not within given range";
        return 0;
    }
}

?>