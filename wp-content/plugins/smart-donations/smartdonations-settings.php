<?php
if(!defined('ABSPATH'))
    die('Forbidden');

if(isset($_GET["posting"]))
{
    ?>
    <script type="text/javascript">
        alert('Information saved successfully');
    </script>
    <?php
    $sendlogto=$_GET["sendlogto"];
    if(isset($_GET["enabledebug"]))
        $enableDebug='y';
    else
        $enableDebug='n';


	if(isset($_GET["rednao_skippaypal"]))
		$rednao_skippaypal='y';
	else
		$rednao_skippaypal='n';

    update_option('smartDonationsEnableDebug',$enableDebug);
    update_option('smartDonationsSendToLog',trim($sendlogto));
	update_option('rednao_skippaypal',$rednao_skippaypal);

}else
{
    $enableDebug=get_option('smartDonationsEnableDebug');
    $sendlogto=get_option('smartDonationsSendToLog');
	$rednao_skippaypal=get_option('rednao_skippaypal');
}

?>

<div>
    <form action="?page=smart-donations/smartdonations.phpsettings" method="GET">
        <input type="hidden" name="page" value="smart-donations/smartdonations.phpsettings"/>
        <input type="hidden" name="posting" value="y">
        <table style="padding:10px;">
            <tr>
                <td>
                    <span>Enable Debug</span>
                </td>
                <td>
                    <input type="checkbox" name="enabledebug" value="y" <?php  echo $enableDebug=='y'?'checked="checked"':"" ?>>
                </td>
            </tr>

            <tr>
                <td>
                    <span>Send logging information to</span>
                </td>
                <td>
                    <input type="text" style="width: 200px;" name="sendlogto" value="<?php echo $sendlogto ?>">
                </td>
            </tr>

			<tr>
				<td>
					<span>Skip PayPal request validation</span>
				</td>
				<td>
					<input type="checkbox" name="rednao_skippaypal" value="y" <?php  echo $rednao_skippaypal=='y'?'checked="checked"':"" ?>>
				</td>
			</tr>

            <tr>
                <td></td>
                <td><button>Save</button></td>
            </tr>
        </table>
    </form>

    <p>Latest error log</p>
    <textarea style="width:500px;height: 500px;"><?php echo get_option('smart_donations_latest_error'); ?></textarea>
</div>