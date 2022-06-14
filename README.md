# engage-eml-ivr-menu-php-app
This application demonstrates sample IVR server application using an API call and Engage markup language (EML). It also showcases the statuscallback events to the server application.


<h2>Creating the Server Application</h2>

<p>The following section explains about how to create a PHP server application using the "<Gather>, <Say>, <Dial>, and <Hangup>" verbs.</p>


<h2>Installing the Customer Application</h2>

Before you install, ensure that PHP is installed from https://www.php.net/downloads.

<h3>Source Code Download</h3>
Download the sample ivr server application for the current repository as a zip file or clone the repository

<h3>Steps</h3>
<p>Create a directory where the PHP software is extracted or installed and make it your working directory.<br>
$ mkdir myapp <br>
$ cd myapp <br>
Add the ivr_menu_eml.php file into myapp directory.
</p>

Note: <br>
<ul>
<li>Make sure 3000 port is free, if 3000 port is used by any other application you can change the port</li>
<li>index.js contains localhost as ip address. If you have public ip replace localhost with your public ip and jump to section "How to run application". If you don’t know the public ip continue with section "Application behind NAT"</li>
</ul>
</p>

<h3>Application behind NAT (Optional)</h3>
<p>You can use NGROK (ngrok.com) to expose your local machine to internet. It’s a quick way to test web application from internet. You can let EDP interact with your application running on local machine without really having a public IP or domain name. </p>

<p>Below mentioned steps needs to be executed if your application is running behind NAT. Otherwise jump to section "Run Server Application"</p>

<ul>
	<li>Download ngrok from https://ngrok.com/download</li>
	<li>sign up with ngrok account. Get the authetication key from your account</li>
	<li>ngrok binary is a command line executable.</li>
	<li>Run the following command. </li>
</ul>

<p>Here is sequence of commands if you are using linux machine. 
<ul>
	<li>$wget https://bin.equinox.io/c/4VmDzA7iaHb/ngrok-stable-linux-amd64.zip</li>
	<li>$unzip ngrok-stable-linux-amd64.zip</li>
	<li>$rm ngrok-stable-linux-amd64.zip</li>
	<li>$chmod 755 ngrok</li>
	<li>$sudo mv ngrok /usr/bin/</li>
	<li>Authenticate your ngrok agent by running the command in terminal. "ngrok config add-authtoken TOKEN"</li>
	<li>$ngrok http 3000</li>
</ul>

<br>This command will provide you the public URL which you can use in the application. In the sample show http://60bc-27-7-127-107.ngrok.io and https://60bc-27-7-127-107.ngrok.io are the public URL.

![image](https://user-images.githubusercontent.com/105645941/173058143-fcf053a5-274a-4ff1-953f-7b07e1c293b3.png)


For windows system, follow the below steps
<ul>
	<li>Download ngrok from https://ngrok.com/download</li>
	<li>sign up with ngrok account. Get the authetication key from your account</li>
	<li>Authenticate your ngrok agent by running the command in terminal. "ngrok config add-authtoken TOKEN"</li>
	<li>$ngrok http 3000</li>
</ul>
</p>

<p>
The path referred in sample application can be used with NGROK tunnel URL as illustrated below. Only https example is listed below but you can use http also likewise.<br>

| Path                  | Public URL (using NGROK)                          |
|-----------------------|---------------------------------------------------|
| /eml                  | https://60bc-27-7-127-107.ngrok.io/eml            |
| /gatherAction         | https://60bc-27-7-127-107.ngrok.io/gatherAction   |
| /statuscallback       | https://60bc-27-7-127-107.ngrok.io/statuscallback |
| / (no path specified) | https://60bc-27-7-127-107.ngrok.io/               |
	
Note:<br>
You will have to change the NGROK tunnel URL as per your local setting: Modify gatherAction URL in the ivr_menu_eml.php. Replace the example ngrok url with your ngrok application tunnel url in line number 15.<br>
</p>
------------------

### Executing the Server Application
Execute the server application with the following command from where PHP is installed.

$ php -S <YOUR_PUBLIC_IP>:3000 ivr_menu_eml.php
	
<p> Application will receive a HTTP POST request, in response it will send EML Prompt. </p> 
------------------	
	
### Making a Call
The following example shows a SIP URI in the "To:" parameter, which is used for the SIP or WebRTC endpoints. The "To:" can also be any PSTN number.

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


NOTE: 
<ul>
<li>The apikey and AccID are obtained from your account in Engage Portal.</li>
<li>"From" number should be the phone number allocated to your account</li>
<li>Replace YOUR_PUBLIC_IP with the IP address of your server. If you are using the application behind NAT (NGROK), the ‘Url’ and ‘StatusCallback’ parameters are mentioned as below.</li>
</ul>

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

