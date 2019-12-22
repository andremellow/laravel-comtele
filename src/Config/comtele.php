<?php

return [

	
    /*
    |--------------------------------------------------------------------------
    | Send Configuration
    |--------------------------------------------------------------------------
    |
    | This is the configuratino section for the send method 
    | https://docs.comtele.com.br/reference#get_send
    | 
    */
    'send' => [

    	/*
	    |--------------------------------------------------------------------------
	    | Sender
	    |--------------------------------------------------------------------------
	    |
	    | This is the a note about the SMS sent. You can use this field 
	    | to send and Individual ID or your application name.
	    | This field is required from the API.
	    | 
    	*/
   
        'sender'    => env('COMTELE_SEND_SENDER', 'Laravel'),

        /*
	    |--------------------------------------------------------------------------
	    | URL
	    |--------------------------------------------------------------------------
	    |
	    | This URL is specific for the send method
	    | 
    	*/
        'url'       => env('COMTELE_SEND_URL', 'https://sms.comtele.com.br/api/v2/send')
    ],

	/*
    |--------------------------------------------------------------------------
    | Auth Key
    |--------------------------------------------------------------------------
    |
    | This is the authorization key to connect to the Comtele API. 
    | To get to your Auth Key access https://sms.comtele.com.br
    | The key will be under Developer Information.
    | 
	*/

    'auth_key' => env('COMTELE_AUTH_KEY', '')

];
