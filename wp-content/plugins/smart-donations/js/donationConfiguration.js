function smartDonationConfigurationBase(title,containerName,options)
{
    this.title=title;
    this.containerName=containerName;

    if(options.isNew == false && typeof options.styles!='undefined')
        this.styles=options.styles;
    else
        this.styles=null;

    if(options.isNew)
        this.FillOptionsForNewDonation(options);
    this.InitiateGenerator(options);
    this.styles=this.generator.styles;

}





smartDonationConfigurationBase.prototype.InitiateGenerator=function()
{

}

smartDonationConfigurationBase.prototype.fillConfiguration=function()
{
    rnJQuery('#smartDonationsItemTitle').text(this.title);
    rnJQuery('#smartDonationsConfigurationFields').html(this.GetDonationConfigurationGeneratedCode());


    this.DonationConfigurationCompleted();
    var self=this;
    rnJQuery('.smartDonationsSettingField').click(function(){self.SettingChanged(self,this)});
    rnJQuery('.smartDonationsSettingField').keyup(function(){self.SettingChanged(self,this)});
    rnJQuery('.smartDonationsSettingField').change(function(){self.SettingChanged(self,this)});
    rnJQuery('#smartDonationsEmail').keyup(function(){self.SettingChanged(self,this)});
    rnJQuery('#smartDonationsCurrencyDropDown').change(function(){self.SettingChanged(self,this)});
    rnJQuery('#smartDonationsSelectedCountryAndLanguage').change(function(){self.SettingChanged(self,this)});

    rnJQuery('.smartDonationsSettingField').change();

    if(this instanceof smartDonationsFormConfiguration)
        smartDonationsSelectedProvider.InitializeFormConfiguration();

};

smartDonationConfigurationBase.prototype.DonationConfigurationCompleted=function(){

}

smartDonationConfigurationBase.prototype.SettingChanged=function(configuration,component){

    var changedFieldName=rnJQuery(component).first().attr("name");
    var newValue;
    if(rnJQuery(component).is(':checkbox'))
        newValue=rnJQuery(component).is(':checked');
    else
        newValue=rnJQuery(component).val();
    configuration.generator[changedFieldName]=newValue;
    configuration.generator.GenerateDonationItem();

    this.PropertyChanged(changedFieldName,newValue);


};

smartDonationConfigurationBase.prototype.PropertyChanged=function(field,value){

}

smartDonationConfigurationBase.prototype.FillOptionsForNewDonation=function(options)
{

}



/*************************************************************************************Classic Generator  ***************************************************************************************************/



function smartDonationClassicConfiguration(containerName,options)
{
    smartDonationConfigurationBase.call(this,'Classic',containerName,options);
}

smartDonationClassicConfiguration.prototype=Object.create(smartDonationConfigurationBase.prototype);

smartDonationClassicConfiguration.prototype.FillOptionsForNewDonation=function(options)
{
    options.smartDonationsdisplaycreditlogo=false;

}
/*

smartDonationConfigurationBase.prototype.PropertyChanged=function(field,value){
    if(field=="smartDonationsdisplaycreditlogo")
        if(value)
            this.styles.smartDonationsDonationButton_src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif";
        else
            this.styles.smartDonationsDonationButton_src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif";
}

*/
smartDonationClassicConfiguration.prototype.InitiateGenerator=function(options)
{
    this.generator=new smartDonationsClassicDonationGenerator(this.containerName,options,null,this.styles);

}

smartDonationClassicConfiguration.prototype.GetDonationConfigurationGeneratedCode=function(){
    return  "<div> "+
        "<div class='form-group'>    "+
        "<label class='control-label col-xs-2'>Display credit card logos</label> "+
        "<div class='col-xs-10'><input name='smartDonationsdisplaycreditlogo' class='smartDonationsSettingField ' type='checkbox' /> </div> "+
        "</tr>"+
        "</div>";

};



/************************************************************************************* Text Box  ***************************************************************************************************/



function smartDonationTextBoxConfiguration(containerName,options)
{
    smartDonationConfigurationBase.call(this,'Text Box',containerName,options);
}
smartDonationTextBoxConfiguration.prototype=Object.create(smartDonationConfigurationBase.prototype);


smartDonationTextBoxConfiguration.prototype.FillOptionsForNewDonation=function(options)
{
    options.smartDonationsComment="If you like this plugin, please donate";
    options.smartDonationsRecommendedDonation=15;
    options.smartDonationsStyle=2;

}



smartDonationTextBoxConfiguration.prototype.InitiateGenerator=function(options)
{
    this.generator=new smartDonationsTextBoxDonationGenerator(this.containerName,options,null,this.styles);
}





smartDonationTextBoxConfiguration.prototype.GetDonationConfigurationGeneratedCode=function(){
    return  "<div  class='form-horizontal' style='padding:30px;'> "+
        " <div class='form-group'>    "+
        " <label class='control-label col-xs-3'>Comment</label> "+
        "  <div class='col-xs-6'><input name='smartDonationsComment' class='smartDonationsSettingField smartDonationsCommentField form-control' type='text' value='If you like this plugin, please donate' /> </div> "+
        "</div>"+
        "<div class='form-group'><label class='control-label col-xs-3'>Recommended Donation</label> "+
        "<div class='col-xs-6'><input name='smartDonationsRecommendedDonation' class='smartDonationsSettingField smartDonationsNumericField form-control' type='text' value='15' /> </div> "+
        "</div>"+
        "<div class='form-group'>    "+
        " <label class='control-label col-xs-3'>Style</label> "+
        "<div class='col-xs-6'><select name='smartDonationsStyle' class='smartDonationsSettingField form-control' ><option value='1'>One Line</option> <option selected='sel' value='2'>Two Lines</option><option value='3' >Three Lines</option></select></div> "+
        "</div>"+
        "</div>";

};


/*************************************************************************************Three Buttons  ***************************************************************************************************/



function smartDonationsThreeButtonsConfiguration(containerName,options)
{
    smartDonationConfigurationBase.call(this,'Three Buttons',containerName,options);
}
smartDonationsThreeButtonsConfiguration.prototype=Object.create(smartDonationConfigurationBase.prototype);

smartDonationsThreeButtonsConfiguration.prototype.FillOptionsForNewDonation=function(options)
{
    options.smartDonationButtonStyle1="threeButtonsStyle1.png";
    options.smartDonationButtonText1="Thank you ($5)";
    options.smartdonationsDonationquantity1=5;

    options.smartDonationButtonStyle2="threeButtonsStyle1.png";
    options.smartDonationButtonText2="Wow, Thanks!($15)";
    options.smartdonationsDonationquantity2=15;

    options.smartDonationButtonStyle3="threeButtonsStyle1.png";
    options.smartDonationButtonText3="You... Just Rock($25)";
    options.smartdonationsDonationquantity3=15;

    options.smartDonationSameSize=true;
}

smartDonationsThreeButtonsConfiguration.prototype.InitiateGenerator=function(options)
{
    this.generator=new smartDonationsThreeButtonsDonationGenerator(this.containerName,options,null,this.styles);
}


smartDonationsThreeButtonsConfiguration.prototype.GetDonationConfigurationGeneratedCode=function(){
    return  "" +
        "<table style='margin-left: -10px;' > "+
            "<tr>" +
               "<td><span>Make Same Size</span></td>"+
                "<td><input type='checkbox' name='smartDonationSameSize' class='smartDonationsSettingField' checked='true'/></td>" +
            "</tr>"+
            "<tr style='height:50px'>    "+
                "<td> <span><strong>Button 1</strong></span> </td>"+
                "<td>" +
                "       <table>" +
                "           <tr>" +
                "               <td style='text-align: left; margin-left:10px'>" +
                "                   <span>Style</span> <select name='smartDonationButtonStyle1' class='smartDonationsSettingField'><option value='threeButtonsStyle1.png' selected='sel'>Style 1</option><option value='threeButtonsStyle2.png'>Style 2</option></select> " +
                "               </td>" +
                "           </tr> " +
                "           <tr>" +
                "               <td style='text-align: left; margin-left:10px'>"+
                "                   <span >Text</span>  <input name='smartDonationButtonText1' class='smartDonationsSettingField smartDonationsCommentField' type='text' value='Thank you (&#36;5)' />  " +
                "               </td>" +
                "           </tr>" +
                "           <tr>" +
                "               <td style='text-align: left; margin-left:10px'>" +
                "                   <span>Donation Quantity</span> <input name='smartdonationsDonationquantity1' class='smartDonationsNumericField smartDonationsSettingField' type='text' value='5' />" +
                "               </td>" +
                "           </tr>" +
                "       </table> " +
                "</td> "+
            "</tr>" +
        "<tr style='height:15px'></tr>"+
        "<tr style='height:50px'>    "+
        "<td> <span><strong>Button 2</strong></span> </td>"+
        "<td>" +
        "       <table>" +
        "           <tr>" +
        "               <td style='text-align: left; margin-left:10px'>" +
        "                   <span>Style</span> <select name='smartDonationButtonStyle2' class='smartDonationsSettingField'><option value='threeButtonsStyle1.png' selected='sel'>Style 1</option><option value='threeButtonsStyle2.png'>Style 2</option></select> " +
        "               </td>" +
        "           </tr> " +
        "           <tr>" +
        "               <td style='text-align: left; margin-left:10px'>"+
        "                   <span >Text</span>  <input name='smartDonationButtonText2' class='smartDonationsSettingField smartDonationsCommentField' type='text' value='Wow, Thanks!(&#36;15)' />  " +
        "               </td>" +
        "           </tr>" +
        "           <tr>" +
        "               <td style='text-align: left; margin-left:10px'>" +
        "                   <span>Donation Quantity</span> <input name='smartdonationsDonationquantity2' class='smartDonationsNumericField smartDonationsSettingField' type='text' value='15' />" +
        "               </td>" +
        "           </tr>" +
        "       </table> " +
        "</td> "+
        "</tr>" +
        "<tr style='height:15px'></tr>"+
        "<tr style='height:50px'>    "+
        "<td> <span><strong>Button 3</strong></span> </td>"+
        "<td>" +
        "       <table>" +
        "           <tr>" +
        "               <td style='text-align: left; margin-left:10px'>" +
        "                   <span>Style</span> <select name='smartDonationButtonStyle3' class='smartDonationsSettingField'><option value='threeButtonsStyle1.png' selected='sel'>Style 1</option><option value='threeButtonsStyle2.png'>Style 2</option></select> " +
        "               </td>" +
        "           </tr> " +
        "           <tr>" +
        "               <td style='text-align: left; margin-left:10px'>"+
        "                   <span >Text</span>  <input name='smartDonationButtonText3' class='smartDonationsSettingField smartDonationsCommentField' type='text' value='You... Just Rock(&#36;25)' />  " +
        "               </td>" +
        "           </tr>" +
        "           <tr>" +
        "               <td style='text-align: left; margin-left:10px'>" +
        "                   <span>Donation Quantity</span> <input name='smartdonationsDonationquantity3' class='smartDonationsNumericField smartDonationsSettingField' type='text' value='25' />" +
        "               </td>" +
        "           </tr>" +
        "       </table> " +
        "</td> "+
        "</tr>"+
        "</table>";

};


/************************************************************************************* Slider ***************************************************************************************************/



function smartDonationsSliderConfiguration(containerName,options)
{
    smartDonationConfigurationBase.call(this,'Slider',containerName,options);
}
smartDonationsSliderConfiguration.prototype=Object.create(smartDonationConfigurationBase.prototype);

smartDonationsSliderConfiguration.prototype.FillOptionsForNewDonation=function(options)
{
    options.smartDonationText="If you like it, please donate.";
    options.smartDonationsMinValue=5;
    options.smartDonationsMaxValue=50;
    options.smartDonationsDefaultValue=25;
    options.smartDonationIncrementOf=1
    options.currentValue=25;
}

smartDonationsSliderConfiguration.prototype.InitiateGenerator=function(options)
{
    this.generator=new smartDonationsSliderDonationGenerator(this.containerName,options,null,this.styles);
}

smartDonationsSliderConfiguration.prototype.GetDonationConfigurationGeneratedCode=function(){
    return  "" +
        "<div style='margin-left: -10px;padding:0;' class='form-horizontal' > "+
        "<div class='form-group' style='margin-bottom: 5px'>" +
        " <label class='control-label col-xs-3'>Text</label>"+
        "<div class='col-xs-6'><input type='text' name='smartDonationText' class='smartDonationsSettingField smartDonationsCommentField form-control' value='If you like it, please donate.'/></div>" +
        "</div>"+
        "<div class='form-group' style='margin-bottom: 5px'>" +
        " <label class='control-label col-xs-3'>Donation Text</label>"+
        "<div class='col-xs-6'><input type='text' name='smartDonationDonationText' class='smartDonationsSettingField smartDonationsCommentField form-control' value='Current donation:'/></div>" +
        "</div>"+
        "<div class='form-group' style='margin-bottom: 5px'>" +
        " <label class='control-label col-xs-3'>Minimun Value</label>"+
        "<div class='col-xs-6'><input type='text' name='smartDonationsMinValue' class='smartDonationsSettingField smartDonationsNumericField form-control' value='5'/></div>" +
        "</div>"+
        "<div class='form-group' style='margin-bottom: 5px'>" +
        " <label class='control-label col-xs-3'>Maximun Value</label>"+
        "<div class='col-xs-6'><input type='text' name='smartDonationsMaxValue' class='smartDonationsSettingField smartDonationsNumericField form-control' value='50'/></div>" +
        "</div>"+
        "<div class='form-group' style='margin-bottom: 5px'>" +
        " <label class='control-label col-xs-3'>Default Value</label>"+
        "<div class='col-xs-6'><input type='text' name='smartDonationsDefaultValue' class='smartDonationsSettingField smartDonationsNumericField form-control' value='25'/></div>" +
        "</div>"+
        "<div class='form-group' style='margin-bottom: 5px'>" +
        " <label class='control-label col-xs-3'>Increments Of</label>"+
        "<div class='col-xs-6'><input type='text' name='smartDonationIncrementOf' class='smartDonationsSettingField smartDonationsNumericField form-control' value='1'/></div>" +
        "</div>"+
        "<div class='form-group' style='margin-bottom: 5px'>"+
        " <label class='control-label col-xs-3'>Allowed Values</label>"+
        "<div class='col-xs-6'><input type='text' name='smartDonationAllowedValues' class='smartDonationsSettingField smartDonationsNumericField form-control' value=''/><span class='description'>*Example 10,20,30,40</span></div>" +
        "</div>"+
        "</table>";

};



/************************************************************************************* Form Configuration ***************************************************************************************************/



function smartDonationsFormConfiguration(containerName,options)
{
    smartDonationConfigurationBase.call(this,'Forms',containerName,options);
    this.generator=new smartDonationsFormDonationGenerator('target',options,null,this.styles);
    this.generator.DonationGeneratedListener=this.DonationGenerationCompleted;


}
smartDonationsFormConfiguration.prototype=Object.create(smartDonationConfigurationBase.prototype);

smartDonationsFormConfiguration.prototype.FillOptionsForNewDonation=function(options)
{
    options.FormElements=new Array();
}

smartDonationsFormConfiguration.prototype.InitiateGenerator=function(options)
{
    this.generator=new smartDonationsSliderDonationGenerator(this.containerName,options,null,this.styles);
}

smartDonationsFormConfiguration.prototype.GetDonationConfigurationGeneratedCode=function(){
    return ''+
        '<table id="rednaoformbuilder" class="rednaoformbuilder container">\
        <tr>\
        <td style="vertical-align: top;">\
            <div class="span6">\
                <div class="clearfix" style="text-align:left;">\
                 <h2>Your Form</h2>\
                    <hr>\
                        <div id="build">\
                         <div id="target" class="form-horizontal" style="background-color:white;">\
                                <fieldset id="redNaoElementlist" class="formelements" style="width:600px;">\
                                    <div class="rednaoformbuilder formelement last" style="height:77px;width:100%;"></div>\
                                </fieldset>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            </td>\
            <td style="vertical-align: top;">\
            <div id="formBuilderButtonSet" class="smartDonationsSlider">\
        <input type="radio" id="formRadio1" value="Components"  name="smartDonationFormEditStyle"  checked="checked" style="display:inline-block;"/><label style="width:100px;display:inline-block;" for="formRadio1">Components</label>\
        <input type="radio" id="formRadio2"  value="General" name="smartDonationFormEditStyle" style="display:inline-block;"/><label label style="width:100px;margin-left:-5px;display:inline-block;" for="formRadio2">General</label>\
        </div>\
        <div id="formBuilderContainer">\
        <div class="span6" id="smartDonationsFormBuilderComponents">\
                    <h2>Drag &amp; Drop components</h2>\
                    <hr>\
                        <div class="tabbable" style="width:540px">\
                            <ul class="nav nav-tabs" id="navtab">\
                                <li id="alayout" class="formtab"><a href="#layout">Layout</a></li>\
                                <li id="atabinput" class="formtab"><a href="#input">Input</a></li>\
                                <li><a id="atabradioscheckboxes" class="formtab">Radios / Checkboxes</a></li>\
                                <li><a id="atabselect" class="formtab">Select</a></li>\
                                <li><a id="atabbuttons" class="formtab">Donation</a></li>\
                            </ul>\
                            <div class="form-horizontal" id="components">\
                                <fieldset  >\
                                    <div class="tab-content">\
                                        <div class="tab-pane active rednaotablist" id="layout" style="display: none">\
                                            <div class="component">\
                                                <div class="control-group rednaotitle">\
                                                </div>\
                                            </div>\
                                        </div>\
                                        <div class="tab-pane active rednaotablist" id="tabinput">\
                                            <div class="component">\
                                                <div class="control-group rednaotextinput">\
                                                </div>\
                                            </div>\
                                            <div class="component">\
                                                <div class="control-group rednaoprependedtext">\
                                                </div>\
                                            </div>\
                                            <div class="component">\
                                                <div class="control-group rednaoappendedtext">\
                                                </div>\
                                            </div>\
                                            <div class="component">\
                                                <div class="control-group rednaoprependedcheckbox">\
                                                </div>\
                                            </div>\
                                            <div class="component">\
                                                <div class="control-group rednaoappendedcheckbox">\
                                                </div>\
                                            </div>\
                                            <div class="component">\
                                                <div class="control-group rednaotextarea">\
                                                </div>\
                                            </div>\
                                        </div>\
                                        <div class="tab-pane rednaotablist" id="tabradioscheckboxes">\
                                            <div class="component">\
                                                <div class="control-group rednaomultipleradios"></div>\
                                            </div>\
                                            <div class="component">\
                                                <div class="control-group rednaoinlineradios"></div>\
                                            </div>\
                                            <div class="component">\
                                                <div class="control-group rednaomultiplecheckboxes">\
                                                </div>\
                                            </div>\
                                            <div class="component">\
                                                <div class="control-group rednaoinlinecheckboxes">\
                                                </div>\
                                            </div>\
                                        </div>\
                                        <div class="tab-pane rednaotablist" id="tabselect">\
                                            <div class="component">\
                                                <div class="control-group rednaoselectbasic">\
                                                </div>\
                                            </div>\
                                            <div class="component">\
                                                <div class="control-group rednaoselectmultiple">\
                                                </div>\
                                            </div>\
                                        </div>\
                                        <div class="tab-pane rednaotablist" id="tabbuttons">\
                                            <div class="component">\
                                                <div class="control-group rednaodonationrecurrence">\
                                                </div>\
                                            </div>\
                                            <div class="component">\
                                                <div class="control-group rednaodonationamount">\
                                                </div>\
                                            </div>\
                                            <div class="component">\
                                                <div class="control-group rednaoanonymousdonation">\
                                                </div>\
                                            </div>\
                                             <div class="component">\
                                                <div class="control-group rednaodonationbutton">\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </fieldset>\
                            </div>\
                        </div>\
                    </div>\
                     <div id="formPropertiesContainer" style="padding:5px;display:none;">\
                        <span>Notify to</span>\
                        <input type="text" name="smartDonationsName" id="smartDonationsNotifyToEmail" style="width:500px"/>\
                        <span class="description" style="margin-bottom:5px; display:block;"> *Emails to notify when a donation is received, if empty the paypal email will be used</span>\
                        <span class="description" >Please separate each address with a semicolon (example: person1@hotmail.com;person2@gmail.com)</span>\
                     </div>\
                    </div>\
                </td>\
            </tr>\
        </table>';

};

smartDonationsFormConfiguration.prototype.DonationConfigurationCompleted=function(){
    SmartDonationsStartFormElements();


    rnJQuery('#smartDonationsNotifyToEmail').val(smartDonationsDonationType.generator.emailToNotify);

    rnJQuery( "#formBuilderButtonSet" ).buttonset();
    rnJQuery('input[name=smartDonationFormEditStyle]').change(smartDonationFormEditTypeChanged);


    function smartDonationFormEditTypeChanged()
    {
        var typeOfEdition=rnJQuery('input[name=smartDonationFormEditStyle]:checked').val();

        if(typeOfEdition=='Components')
        {
            rnJQuery('#smartDonationsFormBuilderComponents').show();
            rnJQuery('#formPropertiesContainer').hide();
        }

        if(typeOfEdition=='General')
        {
            rnJQuery('#smartDonationsFormBuilderComponents').hide();
            rnJQuery('#formPropertiesContainer').show();
        }

    }



}


smartDonationsFormConfiguration.prototype.DonationGenerationCompleted=function(){
    rnJQuery('#redNaoElementlist').append('<div class="rednaoformbuilder formelement last" style="height:77px;width:100%;"></div>');
    SmartDonationsPrepareDraggableItems();
}