<?php
echo "a";





echo "<p>request:</p>";
print_r($_REQUEST);
echo file_get_contents( 'php://input' );


?>


<a class="wepay-widget-button wepay-green" id="wepay_widget_anchor_51944e6131304" href="https://stage.wepay.com/donations/37690526">Donate</a><script type="text/javascript">var WePay = WePay || {};WePay.load_widgets = WePay.load_widgets || function() { };WePay.widgets = WePay.widgets || [];WePay.widgets.push( {object_id: 37690526,callback_uri:"http://177.225.146.15/~edseventeen/rednao/wp-content/plugins/smart-donations/wepay-ipn.php",widget_type: "donation_campaign",anchor_id: "wepay_widget_anchor_51944e6131304",widget_options: {callback_uri:"http://177.225.146.15/~edseventeen/rednao/wp-content/plugins/smart-donations/wepay-ipn.php",donor_chooses: true,allow_cover_fee: true,enable_recurring: true,allow_anonymous: true,button_text: "Donate"}});if (!WePay.script) {WePay.script = document.createElement('script');WePay.script.type = 'text/javascript';WePay.script.async = true;WePay.script.src = 'https://stage.wepay.com/min/js/widgets.v2.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(WePay.script, s);} else if (WePay.load_widgets) {WePay.load_widgets();}</script>
