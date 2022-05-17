<?php

// Make sure that MIME type is set to XML. This will ensure that XML is rendered properly.

header('Content-type: application/xml');



// This is the HTTP-URL of the main EML document

// The EML document contains <Gather> verb and <Say> verb to play the welcome prompt and main menu for the IVR.

// Customer need to replace this HTTP-URL with the actual server address.

$main_menu_url = "http://60bc-27-7-127-107.ngrok.io/";



// Define the SIP address for different department (update the sip username & domain to reflect your actual client setting)

$customer_department_sip_address = "sip:131312@sipaz1.engageio.com";

$sales_department_sip_address = "sip:131313@sipaz1.engageio.com";

$hr_department_sip_address = "sip:131314@sipaz1.engageio.com";



// Define the E164 number for different department (replace the fake number with the real number when it is available)

$customer_department_phone_number = "+18001234567";

$sales_department_phone_number = "+17001245567";

$hr_department_phone_number = "+16001234567";



function logToConsole($myReq, $url, $method) {

   define('STDOUT', fopen('php://stdout', 'w'));

   fwrite(STDOUT, print_r($method , true));

   fwrite(STDOUT, print_r($url , true));

   fwrite(STDOUT, print_r($myReq , true));

}

if(preg_match('/statuscallback/', $_SERVER["REQUEST_URI"])) {

   //****************************************/

   // CALL API StatusCallBack webhook handler

   //****************************************/

   logToConsole($_REQUEST, $_SERVER["REQUEST_URI"], $_SERVER['REQUEST_METHOD']);

   echo "";

} else {

   logToConsole($_REQUEST, $_SERVER["REQUEST_URI"], $_SERVER['REQUEST_METHOD']);

   echo "<Response>";



   // Transfer the call to different department based on user input

   switch(@$_REQUEST['Digits']) {

      // Customer Service

      case 1:

         echo "<Say>I'm going to transfer you to customer service department. Please wait for a moment.</Say>";

         echo "<Dial><Client>{$customer_department_sip_address}</Client></Dial>";

         // echo "<Dial>{$customer_department_phone_number}</Dial>";

         break;



      // Sales department

      case 2:

         echo "<Say>I'm going to transfer you to sales department. Please wait for a moment.</Say>";

         echo "<Dial><Client>{$sales_department_sip_address}</Client></Dial>";

         // echo "<Dial>{$sales_department_phone_number}</Dial>";

         break;



      // HR deparment

      case 3:

         echo "<Say>I'm going to transfer you to human resource department. Please wait for a moment.</Say>";

         echo "<Dial><Client>{$hr_department_sip_address}</Client></Dial>";

         // echo "<Dial>{$hr_department_phone_number}</Dial>";

         break;



      // Hangup the call

      case '*':

         echo "<Say>Good Bye!</Say>";

         echo "<Hangup/>";

         break;



      // For other input, repeat the main menu

      case 9:

      default:

         echo "<!-- customer need to replace the HTTP-URL with the actual server address -->";

         echo "<Gather action=\"{$main_menu_url}\" numDigits=\"1\" finishOnKey=\"#\">

   <Say> Thank you for calling Radisys Corporation. For customer service, press 1. For sales department, press 2. For human resources, press 3. To repeat menu options, press 9. To disconnect the call, press star. </Say> </Gather>";

         break;

   }

   echo "</Response>";

} ?>