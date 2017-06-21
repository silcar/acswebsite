<?php


function rednao_smart_donations_save()
{
    $donationName=$_REQUEST['name'];
    $returningURL=$_REQUEST['returningURL'];
    $donationOptions=$_REQUEST['donationOptions'];
    $email=$_REQUEST['email'];
    $donationType=$_REQUEST['donationType'];
    $donation_provider=$_REQUEST['donation_Provider'];
    $styles=$_REQUEST['styles'];
    $message="";
    $donationId=0;
	$success=false;

    if($donation_provider==null)
    {
        $message="Please pick a donation provider first";
    }else
    if($donationType==null)
    {
        $message="Please pick a donation type first";
    }
    else if($donationName==null)
    {

        $message= "Name is mandatory";

    }else
    {
        global $wpdb;
        $donationId=$_REQUEST['donationId'];

        if($donationId==null)
        {
            $count= $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM ".SMART_DONATIONS_TABLE_NAME." where donation_name=%s",$donationName));

            if($count>0)
            {
                $message="Donation Name already exists";

            }else
            {
                $values=array('donation_name'=>$donationName,
                              'returning_url'=>$returningURL,
                              'options'=>$donationOptions,
                              'email'=>$email,
                              'donation_type'=>$donationType,
                              'donation_provider'=>$donation_provider,
                              'styles'=>$styles
                            );
                $wpdb->insert(SMART_DONATIONS_TABLE_NAME,$values);
                $donationId=$wpdb->insert_id;
                $message="saved";
				$success=true;
                delete_transient("rednao_smart_donations_donation_$donationId");
            }
        }else
        {
            $wpdb->update(SMART_DONATIONS_TABLE_NAME,array(
                'donation_name'=>$donationName,
                'returning_url'=>$returningURL,
                'options'=>$donationOptions,
                'email'=>$email,
                'donation_type'=>$donationType,
                'donation_provider'=>$donation_provider,
                'styles'=>$styles
            ),array("donation_id"=>$donationId));
            $message="saved";
			$success=true;
            delete_transient("rednao_smart_donations_donation_$donationId");

        }

    }

    echo "{\"DonationId\":\"$donationId\",\"Message\":\"$message\",\"Success\":\"".($success?'y':'n')."\"}";

    die();

}


function rednao_smart_donations_list()
{
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
        return;
    }

    global $wpdb;
    $result=$wpdb->get_results("SELECT donation_id,donation_name FROM ".SMART_DONATIONS_TABLE_NAME);

    echo "[{\"Id\":\"0\",\"Name\":\"Select a donation\"}";
    foreach($result as $key=>$row)
    {
        echo ",{\"Id\":\"$row->donation_id\",\"Name\":\"$row->donation_name\"}";
    }
    echo"]";
    die();

}


function rednao_smart_progress_donations_list()
{
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
        return;
    }

    global $wpdb;
    $result=$wpdb->get_results("SELECT progress_id,progress_name  FROM ".SMART_DONATIONS_PROGRESS_TABLE);

    echo "[{\"Id\":\"0\",\"Name\":\"Select a progress indicator\"}";
    foreach($result as $key=>$row)
    {
        echo ",{\"Id\":\"$row->progress_id\",\"Name\":\"$row->progress_name\"}";
    }
    echo"]";
    die();

}


function rednao_smart_donations_campaign_list()
{
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
        return;
    }

    global $wpdb;
    $result=$wpdb->get_results("SELECT campaign_id,name  FROM ".SMART_DONATIONS_CAMPAIGN_TABLE);

    echo "[{\"Id\":\"0\",\"Name\":\"Select a campaign\"}";
    foreach($result as $key=>$row)
    {
        echo ",{\"Id\":\"$row->campaign_id\",\"Name\":\"$row->name\"}";
    }
    echo"]";
    die();

}



function rednao_smart_donations_add_campaign()
{
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
        return;
    }

    global $wpdb;

    if (isset($_POST["name"])) {
        $name=$_POST["name"];
    }else
        $name='';

    if (isset($_POST["description"])) {
        $description=$_POST["description"];
    }else
        $description='';

    if (isset($_POST["goal"])) {
        $goal=$_POST["goal"];
    }else
        $goal='';


    if (isset($_POST["thank_you_email"])) {
        $thank_you_email=$_POST["thank_you_email"];
    }else
        $thank_you_email='';

    if (isset($_POST["email_subject"])) {
        $email_subject=$_POST["email_subject"];
    }else
        $email_subject='';

    if($name==null)
    {
        echo "Campaign name is mandatory";
        die();
    }

    if(isset($_POST["email_from"]))
        $email_from=$_POST["email_from"];
    else
        $email_from="";




    if(!is_numeric($goal))
        $goal=0;



    $count= $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM ".SMART_DONATIONS_CAMPAIGN_TABLE." where name=%s",$name));

    if($count>0)
    {
        echo "A campaign with the same name exist";
        die();
    }

    $wpdb->insert(SMART_DONATIONS_CAMPAIGN_TABLE,array(
        'name'=>$name,
        'description'=>$description,
        'goal'=>$goal,
        'thank_you_email'=>$thank_you_email,
        'email_subject'=>$email_subject,
        'email_from'=>$email_from
    ));

    echo "success";
    die();


}



function rednao_smart_donations_edit_campaign()
{
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
        return;
    }

    global $wpdb;

    if (isset($_POST["name"])) {
        $name=$_POST["name"];
    }else
        $name='';
    if (isset($_POST["description"])) {
        $description=$_POST["description"];
    }else
        $description='';

    if (isset($_POST["goal"])) {
        $goal=$_POST["goal"];
    }else
        $goal='';

    if (isset($_POST["campaign_id"])) {
        $campaign_id=$_POST["campaign_id"];
    }else
        $campaign_id='';

    if (isset($_POST["thank_you_email"])) {
        $thank_you_email=$_POST["thank_you_email"];
    }else
        $thank_you_email='';

    if (isset($_POST["email_subject"])) {
        $email_subject=$_POST["email_subject"];
    }else
        $email_subject='';

    if(isset($_POST["email_from"]))
        $email_from=$_POST["email_from"];
    else
        $email_from="";

    if($name==null)
    {
        echo "Campaign name is mandatory";
        die();
    }

    if(!is_numeric($goal))
        $goal=0;



    $count= $wpdb->update(SMART_DONATIONS_CAMPAIGN_TABLE,array(
                "name"=>$name,
                "description"=>$description,
                "goal"=>$goal,
                "thank_you_email"=>$thank_you_email,
                "email_subject"=>$email_subject,
                "email_from"=>$email_from),array("campaign_id"=>$campaign_id));


    $result=$wpdb->get_results($wpdb->prepare("select progress_id from ".SMART_DONATIONS_PROGRESS_TABLE." where campaign_id=%d",$campaign_id));

    foreach($result as $key=>$value)
    {
        delete_transient("rednao_smart_donations_progress_$value->progress_id");
    }


    echo "success";
    die();


}


function rednao_smart_donations_save_progress_bar()
{
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
        return;
    }
    if (isset($_POST['progress_name'])) {
        $progress_name=$_POST['progress_name'];
    }else
        $progress_name='';

    if (isset($_POST['campaign_id'])) {
        $campaign_id=$_POST['campaign_id'];
    }else
        $campaign_id='';

    if (isset($_POST['progress_id'])) {
        $progress_id=$_POST['progress_id'];
    }else
        $progress_id='';

    if (isset($_POST['progress_type'])) {
        $progress_type=$_POST['progress_type'];
    }else
        $progress_type='';

    if (isset($_POST['styles'])) {
        $styles=$_POST['styles'];
    }else
        $styles='';

    if (isset($_POST['options'])) {
        $options=$_POST['options'];
    }else
        $options='';
    $message="";
    if($progress_name==null)
        $message= "Name is mandatory";
    else
    if($progress_type==null)
        $message= "Progress Type is mandatory";
    else
    {

        global $wpdb;
        if($progress_id==null)
        {
            $count= $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM ".SMART_DONATIONS_PROGRESS_TABLE." where progress_id='%d'",$progress_id));

            if($count>0)
            {
                $message="Progress Name already exists";

            }else
            {
                $values=array('progress_name'=>$progress_name,
                    'options'=>$options,
                    'campaign_id'=>$campaign_id,
                    'progress_type'=>$progress_type,
                    'styles'=>$styles
                );
                $wpdb->insert(SMART_DONATIONS_PROGRESS_TABLE,$values);
                $progress_id=$wpdb->insert_id;
                $message="saved";
                delete_transient("rednao_smart_donations_progress_$progress_id");
            }
        }else
        {
            $wpdb->update(SMART_DONATIONS_PROGRESS_TABLE,array(
                'progress_name'=>$progress_name,
                'options'=>$options,
                'campaign_id'=>$campaign_id,
                'progress_type'=>$progress_type,
                'styles'=>$styles,
            ),array("progress_id"=>$progress_id));
            $message="saved";
            delete_transient("rednao_smart_donations_progress_$progress_id");

        }
    }



    echo "{\"progress_id\":\"$progress_id\",\"Message\":\"$message\"}";

    die();

}

function rednao_smart_donations_execute_analytics()
{
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
        return;
    }
    if (isset($_POST['startDate'])) {
        $startDate=$_POST['startDate'];
    }else
        $startDate='';

    if (isset($_POST['endDate'])) {
        $endDateReceived=$_POST['endDate'];
    }else
        $endDateReceived='';

    if (isset($_POST['displayType'])) {
        $displayType=$_POST['displayType'];
    }else
        $displayType='';

    if (isset($_POST['campaign_id'])) {
        $campaign_id=$_POST['campaign_id'];
    }else
        $campaign_id='';

    $startDate=date('Y-m-d H:i:s', strtotime($startDate));
    $endDate=date('Y-m-d H:i:s', strtotime($endDateReceived." 23:59:59"));
    $endDateWithoutTime=date('Y-m-d H:i:s', strtotime($endDateReceived));

    if(!is_numeric($campaign_id))
    {
        echo "Invalid Camping Id";
        die();
    }

    if($startDate==null)
    {
        echo 'Start Date is mandatory';
        die();
    }
    if($endDate==null)
    {
        echo 'End Date is mandatory';
        die();
    }

    if($startDate>=$endDate)
    {
        echo 'End Date must be bigger than start date';
        die();
    }


    if($displayType==null)
    {
        echo 'Display Type is mandatory';
        die();
    }
    if($campaign_id==null)
    {
        echo 'Campaign is mandatory';
        die();
    }

    if(!StartDateIsValid($startDate,$displayType))
    {
        echo 'Start Date is invalid';
        die();
    }

    if(!EndDateIsValid($endDate,$displayType))
    {
        echo 'End Date is invalid';
        die();
    }


    $sumFormat='';

    if($displayType=='d')
    {
        $query="select concat(year(date),'-',month(date),'-' ,day(date)) date, sum(mc_gross) gross from ".SMART_DONATIONS_TRANSACTION_TABLE."
                where date between '$startDate' and '$endDate' and (campaign_id=$campaign_id or $campaign_id=-1)
                group by year(date),month(date),day(date)
                order by year(date),month(date),day(date)";
    }

    if($displayType=='w')
    {
        $query="select  concat(year(date),'-',month(date),'-' ,day(date)) date,gross from(
        select  adddate(date,interval 1-dayofweek(date) day) date, gross from
        (
            select date,sum(mc_gross) gross from ".SMART_DONATIONS_TRANSACTION_TABLE."
            where date between '$startDate' and '$endDate' and (campaign_id=$campaign_id or $campaign_id=-1)
            group by year(date),week(date)
            order by year(date),week(date)
        ) tb1)tb2";
    }

    if($displayType=='m')
    {
        $query="select concat(year(date),'-',month(date),'-' ,1) date, sum(mc_gross) gross from ".SMART_DONATIONS_TRANSACTION_TABLE."
        where date between '$startDate' and '$endDate' and (campaign_id=$campaign_id or $campaign_id=-1)
        group by year(date),month(date)
        order by year(date),month(date)";
    }

    if($displayType=='y')
    {
        $query="select concat(year(date),'-',1,'-' ,1) date, sum(mc_gross) gross from ".SMART_DONATIONS_TRANSACTION_TABLE."
        where date between '$startDate' and '$endDate' and (campaign_id=$campaign_id or $campaign_id=-1)
        group by year(date)
        order by year(date)";
    }


    global $wpdb;
    $result=$wpdb->get_results($query);

    $values=array();
    foreach($result as $row)
    {
        array_push($values,array($row->date,$row->gross));

    }

    $nextValue=$startDate;
    $index=0;
    $returnArray=array();
    $increment="";
    switch($displayType)
    {
        case 'd':
            $increment="+1 day";
            break;
        case 'w':
            $increment="+1 week";
            break;
        case 'm':
            $increment="+1 month";
            break;
        case 'y':
            $increment="+1 year";
            break;
    }

    $endStrTime=strtotime($endDateWithoutTime);
    $nextValueStrTime=strtotime($startDate);
    $nextValueDate=date('Y-n-j',$nextValueStrTime);
    while($nextValueStrTime<=$endStrTime)
    {

        if(isset($values[$index][0]) && $values[$index][0]==$nextValueDate)
        {
            array_push($returnArray,$values[$index]);
            $index+=1;
        }
        else
           array_push($returnArray,array($nextValueDate,0));


        $nextValueStrTime=strtotime($nextValueDate.' '.$increment);
        $nextValueDate=date('Y-n-j',$nextValueStrTime);


    }


    echo "[";
    for($i=0;$i<count($returnArray);$i++)
    {
        if($i!=0)
            echo ",";
        echo '["'.$returnArray[$i][0].'",'.$returnArray[$i][1].']';
    }

    echo "]";











    die();
}


function StartDateIsValid($startDate,$displayType)
{
    switch($displayType)
    {
        case 'd':
            return true;
            break;
        case 'w':
            return date('w',strtotime($startDate))==0;
            break;
        case 'm':
            return date('j',strtotime($startDate))==1;
            break;
        case 'y':
            return date('j',strtotime($startDate))==1&&date('n',strtotime($startDate))==1;
            break;
        default:
            return false;
    }

}

function EndDateIsValid($endDate,$displayType)
{
    switch($displayType)
    {
        case 'd':
            return true;
            break;
        case 'w':
            return date('w',strtotime($endDate))==6;
            break;
        case 'm':
            $numberOfDaysInMonth=date('t',strtotime(($endDate)));
            return date('j',strtotime($endDate))==$numberOfDaysInMonth;
            break;
        case 'y':
            return date('j',strtotime($endDate))==31&&date('n',strtotime($endDate))==12;
            break;
        default:
            return false;
    }
}

function GetPostOrDie($name){
    if (isset($_POST[$name])) {
        $aux=$_POST[$name];
    }else
        $aux='';
    if($aux==null)
        die();

    return $aux;
}

function GetGetOrDie($name){
    if (isset($_GET[$name])) {
        $aux=$_GET[$name];
    }else
        $aux="";

    if($aux==null)
        die();

    return $aux;
}

function rednao_smart_donations_execute_analytics_list()
{
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
        return;
    }
    $rows=(int)GetPostOrDie('rows');
    $rpage=(int)GetPostOrDie('page');
    $sortColumn=GetPostOrDie('sidx');
    $order=GetPostOrDie('sord');
    $startDate=GetGetOrDie('date');
    $campaign_Id=GetGetOrDie('campaign_Id');
    $displayType=GetGetOrDie('displayType');

    $startDate=date('Y-m-d H:i:s', strtotime($startDate));

    $step=($rpage-1)*$rows;

    if(!is_numeric($rows) || !is_numeric($rpage))
    {
        echo "Invalid arguments";
    }

    if(!is_numeric($campaign_Id))
    {
        echo "Invalid Camping Id";
        die();
    }


    if(!StartDateIsValid($startDate,$displayType))
    {
        die();
    }


    $increment="";
    switch($displayType)
    {
        case 'd':
            $increment="+1 day";
            break;
        case 'w':
            $increment="+1 week";
            break;
        case 'm':
            $increment="+1 month";
            break;
        case 'y':
            $increment="+1 year";
            break;
    }

    $endDate=strtotime($startDate.' '.$increment);
    $endDate=Date('Y-m-d H:i:s',$endDate);


    switch($sortColumn)
    {
        case "Date":
            $sortColumn="date";
           break;
        case "FirstName":
            $sortColumn="first_name";
            break;
        case "LastName":
            $sortColumn="last_name";
            break;
        case "Email":
            $sortColumn="payer_email";
            break;
        case "Gross":
            $sortColumn="mc_gross";
            break;
        case "Fee":
            $sortColumn="mc_fee";
            break;

        default:
            $sortColumn="date";
    }

    if($displayType=='d')
    {
        $query="select coalesce(campaign_id,0) campaign_id,transaction_id, date, mc_gross gross,first_name,last_name,payer_email,mc_fee from ".SMART_DONATIONS_TRANSACTION_TABLE."
                where date between '$startDate' and '$endDate' and (campaign_id=$campaign_Id or $campaign_Id=-1)
                order by $sortColumn $order limit $step,$rows";

        $queryCount="select count(*) from ".SMART_DONATIONS_TRANSACTION_TABLE."
                where date between '$startDate' and '$endDate' and (campaign_id=$campaign_Id or $campaign_Id=-1)";
    }

    if($displayType=='w')
    {
        $query="select  campaign_id,transaction_id,date, gross,first_name,last_name,payer_email,mc_fee from(
        select  campaign_id,transaction_id,date, gross,first_name,last_name,payer_email,mc_fee from
        (
            select coalesce(campaign_id,0) campaign_id,transaction_id,date,mc_gross gross,first_name,last_name,payer_email,mc_fee from ".SMART_DONATIONS_TRANSACTION_TABLE."
            where date between '$startDate' and '$endDate' and (campaign_id=$campaign_Id or $campaign_Id=-1)
            order by $sortColumn $order limit $step,$rows
        ) tb1)tb2";

        $queryCount=" select count(*) from ".SMART_DONATIONS_TRANSACTION_TABLE."
            where date between '$startDate' and '$endDate' and (campaign_id=$campaign_Id or $campaign_Id=-1)";
    }

    if($displayType=='m')
    {
        $query="select coalesce(campaign_id,0) campaign_id,transaction_id, date, mc_gross gross,first_name,last_name,payer_email,mc_fee from ".SMART_DONATIONS_TRANSACTION_TABLE."
        where date between '$startDate' and '$endDate' and (campaign_id=$campaign_Id or $campaign_Id=-1)
        order by $sortColumn $order limit $step,$rows";

        $queryCount="select count(*) from ".SMART_DONATIONS_TRANSACTION_TABLE."
        where date between '$startDate' and '$endDate' and (campaign_id=$campaign_Id or $campaign_Id=-1)";
    }

    if($displayType=='y')
    {
        $query="select coalesce(campaign_id,0) campaign_id,transaction_id, date, mc_gross gross,first_name,last_name,payer_email,mc_fee from ".SMART_DONATIONS_TRANSACTION_TABLE."
        where date between '$startDate' and '$endDate' and (campaign_id=$campaign_Id or $campaign_Id=-1)
        order by $sortColumn $order limit $step,$rows";

        $queryCount="select count(*) from ".SMART_DONATIONS_TRANSACTION_TABLE."
        where date between '$startDate' and '$endDate' and (campaign_id=$campaign_Id or $campaign_Id=-1)";
    }


    global $wpdb;
    $count= $wpdb->get_var($queryCount);
    $result=$wpdb->get_results($query);

    $firstRecord=true;
    echo '{"total":"'.ceil($count/$rows).'","records":"'.$count.'","rows": [';
    foreach($result as $row)
    {
        if(!$firstRecord)
            echo ",";
        else
            $firstRecord=false;

        echo '{"TransactionId":'.json_encode($row->transaction_id).',"Date":"'.$row->date.'","Gross":"'.$row->gross.'","FirstName":'.json_encode($row->first_name).',"LastName":'.json_encode($row->last_name).',"Email":'.json_encode($row->payer_email).',"Fee":"'.$row->mc_fee.'","campaign_id":"'.$row->campaign_id.'"}';




    }

    echo "]}";
    die();

}


function rednao_smart_donations_execute_analytics_op()
{
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
        return;
    }

    if (isset($_POST["campaign_id"])) {
        $campaign_id=$_POST["campaign_id"];
    }else
        $campaign_id='';


    if (isset($_POST["oper"])) {
        $oper=$_POST["oper"];
    }else
        $oper='';

    if (isset($_POST["TransactionId"])) {
        $transactionId=$_POST["TransactionId"];
    }else
        $transactionId='';

    if($oper==="del")
    {
        global $wpdb;

        $campaign_id=$wpdb->get_var($wpdb->prepare("select campaign_id from ".SMART_DONATIONS_TRANSACTION_TABLE." WHERE transaction_id=%d",$transactionId));
        $wpdb->query($wpdb->prepare("delete from ".SMART_DONATIONS_TRANSACTION_TABLE." WHERE transaction_id=%d",$transactionId));

        $result=$wpdb->get_results($wpdb->prepare("select progress_id from ".SMART_DONATIONS_PROGRESS_TABLE." where campaign_id=%d",$campaign_id));
        foreach($result as $key=>$value)
        {
            delete_transient("rednao_smart_donations_progress_$value->progress_id");
        }
        delete_transient("rednao_smart_donations_wall_".$campaign_id);
        return;

    }
    if (isset($_POST["FirstName"])) {
        $firstName=$_POST["FirstName"];
    }else
        $firstName='';

    if (isset($_POST["LastName"])) {
        $lastName=$_POST["LastName"];
    }else
        $lastName='';


    if (isset($_POST["Date"])) {
        $date=$_POST["Date"];
    }else
        $date='';

    if (isset($_POST["Email"])) {
        $email=$_POST["Email"];
    }else
        $email='';

    if (isset($_POST["Gross"])) {
        $gross=$_POST["Gross"];
    }else
        $gross='';


    if (isset($_POST["Fee"])) {
        $fee=$_POST["Fee"];
    }else
        $fee='';





    if($firstName==null)
    {
        status_header(501);
        echo "First name is mandatory";
        die();
    }

    if($lastName==null)
    {
        status_header(501);
        echo "Last name is mandatory";
        die();
    }

    if($email==null)
    {
        status_header(501);
        echo "Email is mandatory";
        die();
    }

    if(!is_numeric($gross) or $gross<=0)
    {
        status_header(501);
        echo "Gross should me bigger than 0";
        die();
    }


    if(!strtotime($date))
    {
        echo "Invalid Date, the format should be YYYY-MM-DD";
        status_header(501);
        die();
    }


    if(!is_null($fee))
        $fee=0;

    if($campaign_id==null)
        $campaign_id=0;

    $date=date('Y-m-d H:i:s', strtotime($date));
    if($oper==="edit")
    {
        global $wpdb;





        $wpdb->update(SMART_DONATIONS_TRANSACTION_TABLE,array(
            'date'=>$date,
            'payer_email'=>$email,
            'first_name'=>$firstName,
            'last_name'=>$lastName,
            'mc_fee'=>$fee,
            'mc_gross'=>$gross
        ),array("transaction_id"=>$transactionId));

        $result=$wpdb->get_results($wpdb->prepare("select progress_id from ".SMART_DONATIONS_PROGRESS_TABLE." where campaign_id=%d",$campaign_id));
        foreach($result as $key=>$value)
        {
            delete_transient("rednao_smart_donations_progress_$value->progress_id");
        }

        delete_transient("rednao_smart_donations_wall_".$campaign_id);
    }

    if($oper=="add")
    {
        global $wpdb;

        $wpdb->insert(SMART_DONATIONS_TRANSACTION_TABLE,array(
            'date'=>$date,
            'payer_email'=>$email,
            'first_name'=>$firstName,
            'last_name'=>$lastName,
            'mc_fee'=>$fee,
            'mc_gross'=>$gross,
            'campaign_id'=>$campaign_id
        ));

        $result=$wpdb->get_results($wpdb->prepare("select progress_id from ".SMART_DONATIONS_PROGRESS_TABLE." where campaign_id=%d",$campaign_id));
        foreach($result as $key=>$value)
        {
            delete_transient("rednao_smart_donations_progress_$value->progress_id");
        }
        delete_transient("rednao_smart_donations_wall_".$campaign_id);
    }

    die();

}

function rednao_smart_donations_save_form_values()
{
	$additionalData="{}";
	if(isset($_POST["additionalData"]))
		$additionalData=stripslashes($_POST["additionalData"]);
    if(isset($_POST["formString"]))
    {
        if(isset($_POST['emailToNotify']))
            $emailsToNotify=$_POST['emailToNotify'];
        else
            $emailsToNotify='';
        $attempts=0;
        while($attempts<10)
        {
            $attempts++;
            $randomString="rednaoform_".RandomString();
            if(!get_transient($randomString))
            {
                update_option($randomString,$emailsToNotify.'rednaosplitter'.stripslashes($_POST["formString"]).'rednaosplitter'.$additionalData,60*60*24*3);
                echo "{\"status\":\"success\", \"randomString\":\"$randomString\"}";
                die();
            }

            echo "{\"status\":\"error\", \"message\":\"Could not generate random string\"}";
        }
        echo "{\"status\":\"error\", \"message\":\"Form is empty\"}";

    }
}


function RandomString()
{
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $randstring = '';
    for ($i = 0; $i < 20; $i++) {
        $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}
?>