function SmartDonationsInitialize()
{

}

var smartDonations_arrow_closed="http://localhost/~edseventeen/rednao/wp-content/plugins/smart-donations/images/arrow_right.png";
var smartDonations_arrow_open="http://localhost/~edseventeen/rednao/wp-content/plugins/smart-donations/images/arrow_down.png";

var smartDonationsRootPath="http://localhost/~edseventeen/rednao/wp-content/plugins/smart-donations/";

TestCase("GeneratorTest", {

    "setUp":function(){



    },

    "test generator is working": function() {
        /*:DOC +=



         <form id='smart_donations_general_options'>
         <div id="rednaoSmartDonaitions">

         <input type="hidden" name="donationId" id="smartDonationsDonationId" value=""/>

         <div  >
         <div class="treeDiv" id="smartDonationsBasic" style="display: inline-block">
         <img class="treeButton" src="http://localhost/~edseventeen/rednao/wp-content/plugins/smart-donations/images/arrow_down.png" alt=""/>
         <h2 class="treeTitle">Basic</h2>
         </div>
         <button style="margin-left: 530px;width:100px;cursor: hand;cursor: pointer;" id="smartDonationsSaveButton" >Save</button>
         </div>
         <div  id="smartDonationsBasicDetail">
         <hr/>
         <div class="category">
         <span>Donation Provider</span>
         <select name="smartDonationsProvider" id="rednao_smart_donations_provider" style="margin-bottom:5px;">
         <option value="paypal" selected="sel">PayPal</option>
         <option value="wepay">WePay</option>
         </select>
         <br/>
         <span>Name</span>
         <input type="text" name="smartDonationsName" id="smartDonationsName"/>
         <span class="description" style="margin-bottom:5px;"> *The name of the donation, this name is displayed in the donations list</span>
         <br/>
         <div>
         <span id="emailText">Email</span>
         <input type="text" name="business" id="smartDonationsEmail"/>
         <img id="imgEmailQuestion" src="http://localhost/~edseventeen/rednao/wp-content/plugins/smart-donations/images/questionMark_small.jpg" style="vertical-align: middle; cursor: hand; cursor: pointer; display: none;">

         <span class="description"> *Email Used for the donation</span>
         </div>
         </div>
         </div>


         <br/>



         <div class="treeDiv" id="smartDonationsAdvanced">
         <img class="treeButton" src="http://localhost/~edseventeen/rednao/wp-content/plugins/smart-donations/images/arrow_right.png" alt=""/>
         <h2 class="treeTitle">Advanced Options</h2>
         </div>
         <div  id="smartDonationsAdvancedDetail">
         <hr/>
         <div class="category" >
         <span>Returning Url</span>
         <input type="text" id="smartDonationsReturningUrl"/>
         <span class="description">*Page displayed after he does a donation</span>
         </div>
         </div>
         </form>

         <form id='smart_donations_component_options' action="https://www.paypal.com/cgi-bin/webscr" method="post" class="donationForm" target="_blank">


         <!--Item Container--->
         <input type="hidden" id="smartDonationsType" name="smartDonationsType"/>
         <input type="hidden" id="smartDonationsProvider" name="donation_provider"/>


         <div id="smartdonationsItemsContainer">
         <div id="smartDonationsItemsContainerHeader">
         <span>Select a Donation Type</span>
         </div>
         <div id="smartDonationsItemsContainerBody">
         <div id="smartDonationsSlideAnimation">
         <div id="smartDonationsItemsList">
         <div class="smartDonationsItem" id="classicd">
         <input type="hidden"  value="classic"/>
         <img id="smartDonationsImageClassic" src="http://localhost/~edseventeen/rednao/wp-content/plugins/smart-donations/images/classic_donation.png" alt="" >
         </div>

         <div class="smartDonationsItem" id="textbox">
         <input type="hidden"  value="textbox" />
         <img id="smartDonationsImageTextBox" src="http://localhost/~edseventeen/rednao/wp-content/plugins/smart-donations/images/text_box_donation.png" alt="">
         </div>

         <div class="smartDonationsItem" id="threebuttons">
         <input type="hidden"  value="threeButtons" />
         <img  src="http://localhost/~edseventeen/rednao/wp-content/plugins/smart-donations/images/three_buttons_donation.png" alt="">
         </div>

         <div class="smartDonationsItem" id="slider">
         <input type="hidden"  value="slider" />
         <img  id="smartDonationsImageSlider" src="http://localhost/~edseventeen/rednao/wp-content/plugins/smart-donations/images/slider_donation.png" alt="">
         </div>
         </div>




         <div id="smartDonationsConfiguration">
         <img id="smartDonationsBackFromConfiguration" src="http://localhost/~edseventeen/rednao/wp-content/plugins/smart-donations/images/arrow_back.png" alt="">
         <span id="smartDonationsItemTitle">Test</span>


         <div id="smartDonationsConfigurationFields" class="smartDonationsCustomFields">

         </div>


         <div id="smartDonationsPreview" >
         <img id="smartDonationsEditImageButton" src="http://localhost/~edseventeen/rednao/wp-content/plugins/smart-donations/images/editButton.png" style="height: 25px; position: relative;display: inline;float:right;margin-top:5px; cursor: hand;cursor:pointer;">
         <span id="smartDonationsPreviewText">Preview</span>

         <div id="smartDonationsPreviewContainer">

         </div>




         </div>
         </div>



         </div>


         </div>
         </div>

         </div>

         </form> */
        SmartDonations_donationTypeClicked(rnJQuery("#classicd"));
        SmartDonations_donationTypeClicked(rnJQuery("#textbox"));
        SmartDonations_donationTypeClicked(rnJQuery("#threebuttons"));
        SmartDonations_donationTypeClicked(rnJQuery("#slider"));

        rnJQuery('#rednao_smart_donations_provider').val('wepay');
        SmartDonations_donationTypeClicked(rnJQuery("#classicd"));
        SmartDonations_donationTypeClicked(rnJQuery("#textbox"));
        SmartDonations_donationTypeClicked(rnJQuery("#threebuttons"));
        SmartDonations_donationTypeClicked(rnJQuery("#slider"));

    },
    "test donation item": function() {
        /*:DOC += <div id='wepayclassic'></div>

         */


        var smartDonationsRootPath="http://localhost/~edseventeen/rednao/wp-content/plugins/smart-donations/";
        if(!window.smartDonationsItemsToLoad)
            window.smartDonationsItemsToLoad=new Array();

        window.smartDonationsItemsToLoad.push({'options':{"smartDonationsType":"classic","donation_provider":"paypal","smartDonationsButtonText":"Donate $10","smartDonationsAmount":"10","business":"wef","styles":{"wepay-widget-button":"font-family:Impact,Charcoal,sans-serif;color:#64ff3d;"}},'element':'wepayclassic'});
        window.smartDonationsItemsToLoad.push({'options':{"smartDonationsType":"threeButtons","donation_provider":"paypal","smartDonationSameSize":"on","smartDonationButtonStyle1":"threeButtonsStyle2.png","smartDonationButtonText1":"Thank you ($5)","smartdonationsDonationquantity1":"5","smartDonationButtonStyle2":"threeButtonsStyle2.png","smartDonationButtonText2":"Wow, Thanks!($15)","smartdonationsDonationquantity2":"15","smartDonationButtonStyle3":"threeButtonsStyle1.png","smartDonationButtonText3":"You... Just Rock($25)","smartdonationsDonationquantity3":"25","cmd":"_donations","business":"zxcv","lc":"US","no_note":"0","currency_code":"USD","bn":"PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest","amount":"5","cmd":"_donations","business":"zxcv","lc":"US","no_note":"0","currency_code":"USD","bn":"PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest","amount":"15","cmd":"_donations","business":"zxcv","lc":"US","no_note":"0","currency_code":"USD","bn":"PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest","amount":"25","styles":{"smartDonationsThreeButtonImage1":"cursor:pointer; cursor:hand;overflow:hidden;width:10px;","smartDonationsThreeButtonSpan1":"position:relative;vertical-align:top;font-family:Verdana;cursor:pointer;cursor:hand;","smartDonationsThreeButtonImage2":"cursor:pointer; cursor:hand;overflow:hidden;","smartDonationsThreeButtonSpan2":"position:relative;vertical-align:top;cursor:pointer;cursor:hand;font-family:Impact,Charcoal,sans-serif;","smartDonationsThreeButtonImage3":"cursor:pointer; cursor:hand;overflow:hidden;","smartDonationsThreeButtonSpan3":"position:relative;vertical-align:top;font-family:Verdana;cursor:pointer;cursor:hand;","smartDonationsThreeButtonImage1_src":"http://www.mundoberry.com/wp-content/uploads/2012/12/Google-Apps.jpeg","smartDonationsThreeButtonImage2_src":"http://localhost/~edseventeen/rednao/wp-content/plugins/smart-donations/images/threeButtonsStyle1.png","smartDonationsThreeButtonImage3_src":"http://localhost/~edseventeen/rednao/wp-content/plugins/smart-donations/images/threeButtonsStyle1.png"}},'element':'wepayclassic'});
        window.smartDonationsItemsToLoad.push({'options':{"smartDonationsType":"textbox","donation_provider":"paypal","smartDonationsComment":"If you like this plugin, please donate","smartDonationsRecommendedDonation":"15","smartDonationsStyle":"3","cmd":"_donations","business":"asdfasdf","lc":"US","no_note":"0","currency_code":"USD","bn":"PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest","amount":"15","styles":{"smartDonationsCommentText":"vertical-align:middle; margin-left:5px;font-family:verdana;","smartDonationsDonationBox":"vertical-align:middle; margin-left:5px;font-family:verdana;","smartDonationsDonationButton":"vertical-align:middle; margin-left:5px;width:10px;height:10px;","smartDonationsDonationButton_src":"http://www.mundoberry.com/wp-content/uploads/2012/12/Google-Apps.jpeg"}},'element':'wepayclassic'});
        window.smartDonationsItemsToLoad.push({'options':{"smartDonationsType":"slider","donation_provider":"paypal","smartDonationText":"If you like it, please donate.","smartDonationsMinValue":"5","smartDonationsMaxValue":"50","smartDonationsDefaultValue":"25","smartDonationIncrementOf":"1","cmd":"_donations","business":"slidr@asdaf.com","lc":"US","no_note":"0","currency_code":"USD","bn":"PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest","amount":"25","styles":{"smartDonationsDonationButton_src":"http://www.mundoberry.com/wp-content/uploads/2012/12/Google-Apps.jpeg","smartDonationsCommentText":"font-family:Comic Sans MS,cursive;color:#e62929;","ui-slider-range-min":"border-color:#ff0088;background-image:none;background-color:#8c7aff;","ui-slider-horizontal":"background-image:none;border-color:#ff1919;background-color:#37ff21;","smartDonationsCurrentDonationText":"font-family:Impact,Charcoal,sans-serif;","smartDonationsAmount":"font-family:Times New Roman,Times,serif;","smartDonationsDonationButton":"width:10px;height:10px;"}},'element':'wepayclassic'});


        window.smartDonationsItemsToLoad.push({'options':{"smartDonationsType":"classic","donation_provider":"wepay","smartDonationsButtonText":"Donate $10","smartDonationsAmount":"10","business":"wef","styles":{"wepay-widget-button":"font-family:Impact,Charcoal,sans-serif;color:#64ff3d;"}},'element':'wepayclassic'});
        window.smartDonationsItemsToLoad.push({'options':{"smartDonationsType":"threeButtons","donation_provider":"wepay","smartDonationSameSize":"on","smartDonationButtonStyle1":"threeButtonsStyle2.png","smartDonationButtonText1":"Thank you ($5)","smartdonationsDonationquantity1":"5","smartDonationButtonStyle2":"threeButtonsStyle2.png","smartDonationButtonText2":"Wow, Thanks!($15)","smartdonationsDonationquantity2":"15","smartDonationButtonStyle3":"threeButtonsStyle1.png","smartDonationButtonText3":"You... Just Rock($25)","smartdonationsDonationquantity3":"25","cmd":"_donations","business":"zxcv","lc":"US","no_note":"0","currency_code":"USD","bn":"PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest","amount":"5","cmd":"_donations","business":"zxcv","lc":"US","no_note":"0","currency_code":"USD","bn":"PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest","amount":"15","cmd":"_donations","business":"zxcv","lc":"US","no_note":"0","currency_code":"USD","bn":"PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest","amount":"25","styles":{"smartDonationsThreeButtonImage1":"cursor:pointer; cursor:hand;overflow:hidden;width:10px;","smartDonationsThreeButtonSpan1":"position:relative;vertical-align:top;font-family:Verdana;cursor:pointer;cursor:hand;","smartDonationsThreeButtonImage2":"cursor:pointer; cursor:hand;overflow:hidden;","smartDonationsThreeButtonSpan2":"position:relative;vertical-align:top;cursor:pointer;cursor:hand;font-family:Impact,Charcoal,sans-serif;","smartDonationsThreeButtonImage3":"cursor:pointer; cursor:hand;overflow:hidden;","smartDonationsThreeButtonSpan3":"position:relative;vertical-align:top;font-family:Verdana;cursor:pointer;cursor:hand;","smartDonationsThreeButtonImage1_src":"http://www.mundoberry.com/wp-content/uploads/2012/12/Google-Apps.jpeg","smartDonationsThreeButtonImage2_src":"http://localhost/~edseventeen/rednao/wp-content/plugins/smart-donations/images/threeButtonsStyle1.png","smartDonationsThreeButtonImage3_src":"http://localhost/~edseventeen/rednao/wp-content/plugins/smart-donations/images/threeButtonsStyle1.png"}},'element':'wepayclassic'});
        window.smartDonationsItemsToLoad.push({'options':{"smartDonationsType":"textbox","donation_provider":"wepay","smartDonationsComment":"If you like this plugin, please donate","smartDonationsRecommendedDonation":"15","smartDonationsStyle":"3","cmd":"_donations","business":"asdfasdf","lc":"US","no_note":"0","currency_code":"USD","bn":"PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest","amount":"15","styles":{"smartDonationsCommentText":"vertical-align:middle; margin-left:5px;font-family:verdana;","smartDonationsDonationBox":"vertical-align:middle; margin-left:5px;font-family:verdana;","smartDonationsDonationButton":"vertical-align:middle; margin-left:5px;width:10px;height:10px;","smartDonationsDonationButton_src":"http://www.mundoberry.com/wp-content/uploads/2012/12/Google-Apps.jpeg"}},'element':'wepayclassic'});
        window.smartDonationsItemsToLoad.push({'options':{"smartDonationsType":"slider","donation_provider":"wepay","smartDonationText":"If you like it, please donate.","smartDonationsMinValue":"5","smartDonationsMaxValue":"50","smartDonationsDefaultValue":"25","smartDonationIncrementOf":"1","cmd":"_donations","business":"slidr@asdaf.com","lc":"US","no_note":"0","currency_code":"USD","bn":"PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest","amount":"25","styles":{"smartDonationsDonationButton_src":"http://www.mundoberry.com/wp-content/uploads/2012/12/Google-Apps.jpeg","smartDonationsCommentText":"font-family:Comic Sans MS,cursive;color:#e62929;","ui-slider-range-min":"border-color:#ff0088;background-image:none;background-color:#8c7aff;","ui-slider-horizontal":"background-image:none;border-color:#ff1919;background-color:#37ff21;","smartDonationsCurrentDonationText":"font-family:Impact,Charcoal,sans-serif;","smartDonationsAmount":"font-family:Times New Roman,Times,serif;","smartDonationsDonationButton":"width:10px;height:10px;"}},'element':'wepayclassic'});

        if( window.smartDonationsItemsToLoad)
            for(var i=0;i< window.smartDonationsItemsToLoad.length;i++)
                smartDonationsLoadDonation(window.smartDonationsItemsToLoad[i].options,window.smartDonationsItemsToLoad[i].element);
    },

    "test styles are loaded":function(){
        /*:DOC += <div id='wepayclassic'></div>
         */

        var donation={'options':{"smartDonationsType":"classic","donation_provider":"paypal","smartDonationsButtonText":"Donate $10","smartDonationsAmount":"10","business":"wef","styles":{"wepay-widget-button":"font-family:Impact,Charcoal,sans-serif;color:#64ff3d;"}},'element':'wepayclassic'};

        var result=smartDonationsLoadDonation(donation.options,donation.element);
        assertEquals(donation.options.styles,result.styles);


    }
});
