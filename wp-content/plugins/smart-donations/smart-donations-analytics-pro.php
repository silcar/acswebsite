
<?php
require_once('smart-donations-license-helpers.php');
if (isset($_POST['license_email'])) {
    $email=$_POST['license_email'];
}else
    $email='';

if (isset($_POST['license_key'])) {
    $key=$_POST['license_key'];
}else
    $key='';

$error="";
$licensingError=0;

if($email!=null||$key!=null)
{
    if(smart_donations_check_license($email,$key,$error,true))
    {
        require_once('smart-donations-analytics.php');
        return;
    }
    else{
        if($error==null)
            $error="Invalid user or license key";
        echo "<div class='error below-h2'><p><strong>Error:</strong> $error</p></div>";
        $licensingError=1;

    }
}

echo "<script type='text/javascript' language='javascript'>var smartDonationsLicensingError=$licensingError;var smartDonationsEmail='$email';var smartDonationsKey='$key'</script>";



?>


<?php

wp_enqueue_script('jquery');
wp_enqueue_script('isolated-slider',plugin_dir_url(__FILE__).'js/rednao-isolated-jq.js');
wp_enqueue_script('smart-donations-pro',plugin_dir_url(__FILE__).'js/smart-donations-pro.js','isolated-slider');
?>

<div style="display: inline-block">
    <p>The analytics tab is a pro feature, you can learn more and unlock it here:</p>
    <a target="_blank" style="display: block; font-size: 20px; font-weight: bold; margin-top:5px;margin-bottom:10px;" href="<?php echo REDNAO_URL?>smartdonations.html">Learn More (Video Tutorials)</a>
</div>

<div style="display: inline-block; vertical-align: top; margin:10px; padding: 10px; border-width: 1px;border-color: #d3d3d3; width:300px;" id="licenseDiv">
    <p style="text-align: center;display: inline-block;">If you already have a pro license</p> <a onclick="Unlock();" style="cursor: hand;cursor:pointer;">Click Here</a>
</div>

<a target="_blank" href="<?php echo REDNAO_URL?>smartdonations.html"> <img id="smartDonationsImageClassic" src="<?php echo plugin_dir_url(__FILE__)?>images/analitics-pro.png" alt="" width="760" height="760"></a>


<script type="text/javascript" language="javascript">




    <?php
        if($email!=null||$key!=null)
        {
            echo "var smartDonationsValidationFailed=true";
        }
    ?>

</script>


