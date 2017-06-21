

/************************************************************************** Classic Donation We Pay ***************************************************************************************************/


function smartDonationClassicConfiguration_wepay(containerName,options)
{
    smartDonationClassicConfiguration.call(this,containerName,options);
}

smartDonationClassicConfiguration_wepay.prototype=Object.create(smartDonationClassicConfiguration.prototype);

smartDonationClassicConfiguration_wepay.prototype.FillOptionsForNewDonation=function(options)
{
    options.smartDonationsButtonText="Donate $10";
    options.smartDonationsAmount=10;

}

smartDonationClassicConfiguration_wepay.prototype.InitiateGenerator=function(options)
{
    this.generator=new smartDonationsClassicDonationGenerator_wepay(this.containerName,options,this.styles)
}


smartDonationClassicConfiguration_wepay.prototype.GetDonationConfigurationGeneratedCode=function(){
    return  "<table> "+
        "<tr>    "+
        "<td>Button Text</td> "+
        "<td><input name='smartDonationsButtonText' class='smartDonationsSettingField' type='text' value='Donate $10' /> </td> "+
        "</tr>"+
        "<td>Amount</td> "+
        "<td><input name='smartDonationsAmount' class='smartDonationsSettingField smartDonationsNumericField' type='text' value='10' /> </td> "+
        "</tr>"+
        "</table>";

};



/************************************************************************** TextBox Donation We Pay ***************************************************************************************************/


function smartDonationTextBoxConfiguration_wepay(containerName,options)
{
    smartDonationTextBoxConfiguration.call(this,containerName,options);
}

smartDonationTextBoxConfiguration_wepay.prototype=Object.create(smartDonationTextBoxConfiguration.prototype);



smartDonationTextBoxConfiguration_wepay.prototype.InitiateGenerator=function(options)
{
    this.generator=new smartDonationsTextBoxDonationGenerator_wepay(this.containerName,options,this.styles);
}

smartDonationTextBoxConfiguration_wepay.prototype.GetDonationConfigurationGeneratedCode=function(){
    return  "<table> "+
        "<tr>    "+
        "<td>Comment</td> "+
        "<td><input name='smartDonationsComment' class='smartDonationsSettingField smartDonationsCommentField' type='text' value='If you like this plugin, please donate' /> </td> "+
        "</tr>"+
        "<td>Recommended Donation</td> "+
        "<td><input name='smartDonationsRecommendedDonation' class='smartDonationsSettingField smartDonationsNumericField' type='text' value='15' /> </td> "+
        "</tr>"+
        "<tr>    "+
        "<tr>    "+
        "<td>Style</td> "+
        "<td><select name='smartDonationsStyle' class='smartDonationsSettingField' ><option value='1'>One Line</option> <option selected='sel' value='2'>Two Lines</option><option value='3' >Three Lines</option></select></td> "+
        "</tr>"+
        "</table>";

};



/************************************************************************************* Three Buttons We Pay   ***************************************************************************************************/


function smartDonationsThreeButtonsConfiguration_wepay(containerName,options)
{

    smartDonationsThreeButtonsConfiguration.call(this,containerName,options);
}

smartDonationsThreeButtonsConfiguration_wepay.prototype=Object.create(smartDonationsThreeButtonsConfiguration.prototype);

smartDonationsThreeButtonsConfiguration_wepay.prototype.InitiateGenerator=function(options)
{
    this.generator=new smartDonationsThreeButtonsDonationGenerator_wepay(this.containerName,options,this.styles);
}



/************************************************************************************* Slider WePay  ***************************************************************************************************/



function smartDonationsSliderConfiguration_wepay(containerName,options)
{

    smartDonationsSliderConfiguration.call(this,containerName,options);
}



smartDonationsSliderConfiguration_wepay.prototype=Object.create(smartDonationsSliderConfiguration.prototype);




smartDonationsSliderConfiguration_wepay.prototype.InitiateGenerator=function(options)
{
    this.generator=new smartDonationsSliderDonationGenerator_wepay(this.containerName,options,this.styles)
}

