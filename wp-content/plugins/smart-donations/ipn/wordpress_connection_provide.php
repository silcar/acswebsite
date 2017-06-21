<?php
require_once('connection_provider_base.php');

class wordpress_connection_provide  extends connection_provider_base
{

    public function IsValid()
    {
		if(get_option('rednao_skippaypal')=='y')
			return true;

        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval)
        {
            $keyval = explode ('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }
        // read the post from PayPal system and add 'cmd'

        $args=Array();
       // $args['cmd']="_notify-validate'";

        $args['headers']=Array
                        (
                            'Content-Type'=>'application/x-www-form-urlencoded;',
                            'Method'=>'Post'
                        );

        $req = "cmd=_notify-validate";
        $args['body']=array('cmd'=>"_notify-validate");
        if(function_exists('get_magic_quotes_gpc'))
        {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value)
        {
            if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1)
            {
                $args['body'][$key]=stripslashes($value);
                $value = urlencode(stripslashes($value));
            } else
            {
                $args['body'][$key]=$value;
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }


        // STEP 2: Post IPN data back to paypal to validate
        $url="https://www.paypal.com/cgi-bin/webscr";

        if(SMART_DONATIONS_SANDBOX=="y")
            $url="https://www.sandbox.paypal.com/cgi-bin/webscr";
        $res=wp_remote_post($url,$args);

        global $rednaolog;
        $rednaolog.="Payal response:".$res['body']."<br/>";;

       return strcmp ($res['body'], "VERIFIED") == 0;


    }

}

?>