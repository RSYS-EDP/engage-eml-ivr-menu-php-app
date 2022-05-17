# engage-rest-api-simple-ivr-sample-php
Engage REST API IVR sample using PHP

### Creating the Server Application

The following section explains about how to create a PHP server application using the <Gather>, <Say>, <Dial>, and <Hangup> verbs.


### Installing the Customer Application

Before you install, ensure that PHP is installed from https://www.php.net/downloads.

Create a directory where the PHP software is extracted or installed and make it your working directory.

$ mkdir myapp

$ cd myapp


### Application behind NAT
NOTE: This is an optional step while creating a sample customer business application.

You can use ngrok (https://ngrok.com/) to expose your local machine to the Internet. It is easy to test the Web application from the Internet. This allows EDP to interact with your application running on the local machine without any public IP address or domain name.

If your application is not running behind the Network Address Translation (NAT), see Executing the Server Application.

Perform the following steps if your application is running behind NAT.
Download the ngrok from https://ngrok.com/download
The ngrok binary is a command line executable.

Run the following command.

If you are using a Linux machine, execute the following commands.

---------------------

$wget https://bin.equinox.io/c/4VmDzA7iaHb/ngrok-stable-linux-amd64.zip
$unzip ngrok-stable-linux-amd64.zip
$rm ngrok-stable-linux-amd64.zip
$chmod 755 ngrok
$sudo mv ngrok /usr/bin/
$ngrok http 3000

---------------------

This command provides you the public URL that can be used in the application. In the sample example, the public URLs are http://60bc-27-7-127-107.ngrok.io and https://60bc-27-7-127-107.ngrok.io.


The path referred in the sample application is used with the NGROK tunnel URL as per the following table. Here only HTTPS URLs are listed, however you can use the HTTP URLs. Edit the NGROK tunnel URL as per the your local settings.

------------------

| Path                  | Public URL (using NGROK) |
| -------------         | ------------- |
| /eml                  | https://60bc-27-7-127-107.ngrok.io/eml  |
| /gatherAction         | https://60bc-27-7-127-107.ngrok.io/gatherAction  |
| /statuscallback       | https://60bc-27-7-127-107.ngrok.io/statuscallback  |
| / (no path specified) | https://60bc-27-7-127-107.ngrok.io/ |


------------------

### Executing the Server Application
Execute the server application with the following command from where PHP is installed.

$ php -S <YOUR_PUBLIC_IP>:3000 myapp/index.php

### Making a Call
The following example shows a SIP URI in the "To:" number, which is used for the SIP or WebRTC endpoints. The "To:" number can also be a PSTN number where the "To:" number can be set to “8080808080”.

Perform the following steps to make a call using EDP.
To make a call using the EDP, execute the server application with the following command.

-----------------
curl -k -XPOST https://<<base URL>>/api/v1/accounts/{AccID}/call \
--header 'apikey: <<Your API Key>>' \
--header 'Content-Type: application/json' \
--d '{
"From":"6070707112",
"To":sip:123456787@sipaz1.engageio.com,
"Url":https://<YOUR_PUBLIC_IP>:3000/eml,
"StatusCallback": https://<YOUR_PUBLIC_IP>:3000/statuscallback,
"StatusCallbackEvent":"initiated,ringing,answered,completed",
"StatusCallbackMethod":"POST",
"Type":"voice"
}'
-----------------


NOTE: The apikey and AccID are accessed from the Engage Portal.

Replace the <YourApplicationPublicIp> with the IP address of your server. If you are using the application behind NAT (NGROK), the ‘Url’ and ‘StatusCallback’ parameters are mentioned as below.

------------------
curl -k -XPOST https://<<base URL>>/api/v1/accounts/{AccID}/call \
--header 'apikey: <<Your API Key>>' \
--header 'Content-Type: application/json' \
--d '{
"From":"6070707112",
"To":sip:123456787@sipaz1.engageio.com,
"Url":https://60bc-27-7-127-107.ngrok.io/eml,
"StatusCallback": https://60bc-27-7-127-107.ngrok.io/statuscallback,
"StatusCallbackEvent":"initiated,ringing,answered,completed",
"StatusCallbackMethod":"POST",
"Type":"voice"
}'
-----------------

