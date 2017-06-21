<?php



function rednao_smart_donations_json_object($object,$styles,$amount,$goal,$donators,$returningUrl)
{
    $json="{";
    $variables=explode("&",$object);
    foreach($variables as $val)
    {
        $variable=explode('=',$val);

        $json=$json."\"$variable[0]\":\"".(count($variable)>1?str_replace("\"","\\\"", urldecode($variable[1])):"")."\",";
    }
    if($styles!=null)
    {
        $json=$json."\"styles\":".rednao_smart_donations_json_object($styles,null,null,null,null,null).",";
    }

    if($amount!=null)
    {
        $json=$json."\"Amount\":".$amount.",";
    }

    if($goal!=null)
    {
        $json=$json."\"Goal\":".$goal.",";
    }

    if($donators!=null)
    {
        $json=$json."\"Donators\":".$donators.",";
    }

    if($returningUrl!=null)
    {
        $json=$json."\"returningUrl\":\"".$returningUrl."\",";
    }





    $json=substr_replace($json ,"",-1);
    $json=$json."}";
    return $json;
}

function rednao_smart_donations_load_donation($id,$title,$returnComponent)
{

    $options=get_transient("rednao_smart_donations_donation_$id");
    $options=false;
    if($options==false)
    {
        global $wpdb;
        $result=$wpdb->get_results($wpdb->prepare("select options,styles,donation_type,returning_url from ".SMART_DONATIONS_TABLE_NAME." where donation_id=%d",$id));
        if(count($result)>0)
        {
            $result=$result[0];
            $options=$result->options;
            $styles=$result->styles;
            $returningUrl=$result->returning_url;
            if($options!=null)
            {
                if($result->donation_type=="forms")
                {
                    $options=str_replace("\\\"","\"",$options);
                }else
                {
                    $options=rednao_smart_donations_json_object($options,$styles,null,null,null,$returningUrl);
                }
                set_transient("rednao_smart_donations_donation_$id",$options,60*60*24*31);
            }
        }else
            $options="";

    }

	require_once(SMART_DONATIONS_DIR.'/donation_provider/donation_provider_config.php');
	$donationProviderNames=array();
	$donationProviderNames=apply_filters('smart-donations-register-provider',$donationProviderNames);
    wp_enqueue_script('jquery');
    wp_enqueue_script('isolated-slider',plugin_dir_url(__FILE__).'js/rednao-isolated-jq.js');
    wp_enqueue_script('smart-donations-donation-provider',plugin_dir_url(__FILE__).'js/donationProvider.js',array('isolated-slider'));
	wp_enqueue_script('smart-donations-eventmanager',plugin_dir_url(__FILE__).'js/eventmanager.js');
    wp_enqueue_script('smart-donations-generator',plugin_dir_url(__FILE__).'js/donationGenerator.js',array_merge(array('isolated-slider','smart-donations-donation-provider','smart-donations-eventmanager'),$donationProviderNames));
    wp_enqueue_script('smart-donations-generator-wepay',plugin_dir_url(__FILE__).'js/donationGenerator_wepay.js',array('smart-donations-generator'));
    wp_enqueue_script('smart-donations-raphael',plugin_dir_url(__FILE__).'js/raphael-min.js',array('isolated-slider'));
    wp_enqueue_script('smart-donations-formelements',plugin_dir_url(__FILE__).'js/formBuilder/formelements.js',array('isolated-slider'));
    wp_enqueue_style('smart-donations-main-style',plugin_dir_url(__FILE__).'css/mainStyle.css');
    wp_enqueue_style('smart-donations-Slider',plugin_dir_url(__FILE__).'css/smartDonationsSlider/jquery-ui-1.10.2.custom.min.css');
    echo "<script type=\"text/javascript\">var ajaxurl = '".admin_url('admin-ajax.php')."';</script>";
    $random=rand();
	$ipnUrl=trim(site_url());
	if(substr($ipnUrl, -1)!=="/")
		$ipnUrl.="/";

    if($returnComponent==false)
    {
        if($options==null)
            return;

        if($title)
			echo "<div class='widget-wrapper widget'><div class='title-wrapper'><h3 class='widgettitle widget-title'>$title</h3><div class='clear'></div></div>";


    ?>

    <div id="donationContainer<?php echo $random?>" class='wcontainer'></div>

    <script>
        var smartDonationsRootPath="<?php echo plugin_dir_url(__FILE__)?>";
		var smartDonationsSandbox="<?php echo SMART_DONATIONS_SANDBOX ?>";
		var smartDonationsIPNUrl="<?php echo $ipnUrl.'?sd_ipn_trigger=1' ?>";
        if(!window.smartDonationsItemsToLoad)
            window.smartDonationsItemsToLoad=new Array();;

        window.smartDonationsItemsToLoad.push({'options':<?php echo $options?>,'element':'donationContainer<?php echo $random?>'});

    </script>
<?php
        if($title)
            echo "</div>";

    }else{
        if($options==null)
            return "";
        return "<div id='donationContainer$random'></div>
            <script>
                var smartDonationsRootPath=\"".plugin_dir_url(__FILE__)."\";
                 var smartDonationsSandbox=\"".SMART_DONATIONS_SANDBOX."\";
                  var smartDonationsIPNUrl=\"".$ipnUrl.'?sd_ipn_trigger=1'."\";

                if(!window.smartDonationsItemsToLoad)
                    window.smartDonationsItemsToLoad=new Array();;
                window.smartDonationsItemsToLoad.push({'options':$options,'element':'donationContainer$random'});
            </script>
           ";
    }
}




function rednao_smart_donations_load_progress($id,$title,$returnComponent)
{

    $options=get_transient("rednao_smart_donations_progress_$id");
    $options=false;
    if($options==false)
    {
        $options=null;
        global $wpdb;
        $result=$wpdb->get_results($wpdb->prepare("select options,styles,campaign_id from ".SMART_DONATIONS_PROGRESS_TABLE." where progress_id=%d",$id));
        if(count($result)>0)
        {
            $result=$result[0];
            $options=$result->options;
            $styles=$result->styles;
            $campaign_id=$result->campaign_id;
            if($campaign_id==null)
                return "";


            if($campaign_id==0)
                $result=$wpdb->get_results($wpdb->prepare("select coalesce(goal,0) goal,sum(mc_gross) amount,(select count(*) from ".SMART_DONATIONS_TRANSACTION_TABLE." where campaign_id=%d) donators
                                                    from ".SMART_DONATIONS_TRANSACTION_TABLE." tran
                                                    left join wp_smart_donations_campaign_table camp
                                                    on tran.campaign_id=camp.campaign_id
                                                    where tran.campaign_id=%d
                                                    group by tran.campaign_id,goal",$campaign_id,$campaign_id));
            else
                $result=$wpdb->get_results($wpdb->prepare("select coalesce(goal,0) goal,sum(mc_gross) amount,(select count(*) from ".SMART_DONATIONS_TRANSACTION_TABLE." where campaign_id=%d) donators
                                                    from ".SMART_DONATIONS_CAMPAIGN_TABLE." camp
                                                    left join ".SMART_DONATIONS_TRANSACTION_TABLE." tran
                                                    on tran.campaign_id=camp.campaign_id
                                                    where camp.campaign_id=%d
                                                    group by tran.campaign_id,goal",$campaign_id,$campaign_id));

            $amount=0;
            $goal=0;
            $donators=0;
            if(count($result)>0)
            {
                $amount=$result[0]->amount;
                $goal=$result[0]->goal;
                $donators=$result[0]->donators;
            }

            if($options!=null)
            {
                $options=rednao_smart_donations_json_object($options,$styles,$amount,$goal,$donators,null);
                set_transient("rednao_smart_donations_progress_$id",$options,60*60*24*31);
            }
        }

    }
    wp_enqueue_script('jquery');
    wp_enqueue_script('isolated-slider',plugin_dir_url(__FILE__).'js/rednao-isolated-jq.js');
    wp_enqueue_script('smart-donations-progress-gen',plugin_dir_url(__FILE__).'js/smart-donations-progress-gen.js',array('isolated-slider'));
    wp_enqueue_style('smart-donations-main-style',plugin_dir_url(__FILE__).'css/mainStyle.css');
    wp_enqueue_style('smart-donations-Slider',plugin_dir_url(__FILE__).'css/smartDonationsSlider/jquery-ui-1.10.2.custom.min.css');
    $random=rand();

    if($returnComponent==false)
    {
        if($options===null)
            return;

        if($title)
            echo "<div class='widget-wrapper widget'><div class='title-wrapper'><h3 class='widgettitle widget-title'>$title</h3><div class='clear'></div></div>"
        ?>


        <div id="progressContainer<?php echo $random?>" class='wcontainer'></div>

        <script>
            var smartDonationsRootPath="<?php echo plugin_dir_url(__FILE__)?>";

            if(!window.smartDonationsProgressItemsToLoad)
                window.smartDonationsProgressItemsToLoad=new Array();;

            window.smartDonationsProgressItemsToLoad.push({'options':<?php echo $options?>,'element':'progressContainer<?php echo $random?>'});

        </script>
    <?php
        if($title)
            echo "</div>";
    }else{
        if(options===null)
            return "";
        return "<div id='progressContainer$random'></div>
            <script>
                var smartDonationsRootPath=\"".plugin_dir_url(__FILE__)."\";
                if(!window.smartDonationsProgressItemsToLoad)
                    window.smartDonationsProgressItemsToLoad=new Array();;
                window.smartDonationsProgressItemsToLoad.push({'options':$options,'element':'progressContainer$random'});
            </script>
           ";
    }
}



function rednao_smart_donations_load_wall($campaignId,$title,$numberOfRows,$currency,$decimalSign,$thousandSeparator,$returnComponent)
{

    $rows=Array();
    $options=get_transient("rednao_smart_donations_wall_$campaignId");
    $options=false;
    if($options==false)
    {
        $options=null;
        global $wpdb;
        $results=$wpdb->get_results($wpdb->prepare("select case when is_anonymous=1 then 'anonymous' else payer_email end payer_email,case when is_anonymous=1 then 'anonymous' else first_name end first_name,case when is_anonymous=1 then '' else last_name end last_name, sum(mc_gross) amount from ".SMART_DONATIONS_TRANSACTION_TABLE." where campaign_id=%d group by payer_email,is_anonymous order by amount desc limit %d" ,$campaignId,$numberOfRows));
        if(count($results)>0)
        {


            foreach($results as $row)
            {
                array_push($rows,Array( "payer_email"=>htmlspecialchars($row->payer_email),
                                        "first_name"=>htmlspecialchars($row->first_name),
                                        "last_name"=>htmlspecialchars($row->last_name),
                                        "amount"=>htmlspecialchars($row->amount),
                ));
            }
            set_transient("rednao_smart_donations_wall_$campaignId",$rows,60*60*24*31);
        }

    }else
        $rows=$options;

    if($returnComponent==false)
    {
        echo "<div class='widget-wrapper'><h3 class='widgettitle'>$title</h3><table class='smartDonationsWallTable'>";
        $count = 1;
        foreach ($rows as $row)
        {
            echo "<tr class='smartDonationsWallRow'>";
            echo " <td><span class='smartdonationsWallCounter'>$count. </span><span class='smartDonationsWallDonatorName'>" . $row['first_name'] . " " . $row['last_name'] . "<span></td>";
            echo "<td style='text-align:right'><span class='smartDonationsWallDonatorAmount' >" . $currency . " " . number_format($row['amount'], 2, $decimalSign, $thousandSeparator);
            $row['amount'] . "<span></td>";
            echo "</tr>";
            $count += 1;
        }
        echo "</table></div>";
    }else{
        $table="<table class='smartDonationsWallTable'>";
        $count = 1;
        foreach ($rows as $row)
        {
            $table.= "<tr class='smartDonationsWallRow'>";
            $table.= " <td><span class='smartdonationsWallCounter'>$count. </span><span class='smartDonationsWallDonatorName'>" . $row['first_name'] . " " . $row['last_name'] . "<span></td>";
            $table.= "<td style='text-align:right'><span class='smartDonationsWallDonatorAmount' >" . $currency . " " . number_format($row['amount'], 2, $decimalSign, $thousandSeparator);
            $row['amount'] . "<span></td>";
            $table.= "</tr>";
            $count += 1;
        }
        $table.= "</table>";
        return $table;
    }
    wp_enqueue_style('smart-donations-main-style',plugin_dir_url(__FILE__).'css/mainStyle.css');
    /*wp_enqueue_script('jquery');
    wp_enqueue_script('isolated-slider',plugin_dir_url(__FILE__).'js/rednao-isolated-jq.js');
    wp_enqueue_script('smart-donations-progress-gen',plugin_dir_url(__FILE__).'js/smart-donations-progress-gen.js',array('isolated-slider'));
    wp_enqueue_style('smart-donations-main-style',plugin_dir_url(__FILE__).'css/mainStyle.css');
    wp_enqueue_style('smart-donations-Slider',plugin_dir_url(__FILE__).'css/smartDonationsSlider/jquery-ui-1.10.2.custom.min.css');
    $random=rand();


        if($options===null)
            return;

        if($title)
            echo "<div class='widget-wrapper'><h3 class='widgettitle'>$title</h3>"
        ?>


        <div id="progressContainer<?php echo $random?>"></div>

        <script>
            var smartDonationsRootPath="<?php echo plugin_dir_url(__FILE__)?>";

            if(!window.smartDonationsProgressItemsToLoad)
                window.smartDonationsProgressItemsToLoad=new Array();;

            window.smartDonationsProgressItemsToLoad.push({'options':<?php echo $options?>,'element':'progressContainer<?php echo $random?>'});

        </script>
        <?php
        if($title)
            echo "</div>";*/


}


?>