/************************************************************************************* Progress Base ***************************************************************************************************/

function SmartDonationsConfigurationProgressBase(title,containerName,options)
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

SmartDonationsConfigurationProgressBase.prototype.fillConfiguration=function()
{
    rnJQuery('#smartDonationsItemTitle').text(this.title);
    rnJQuery('#smartDonationsConfigurationFields').html(this.GetProgressConfigurationGeneratedCode());

    var self=this;
    rnJQuery('.smartDonationsSettingField').click(function(){self.SettingChanged(self,this)});
    rnJQuery('.smartDonationsSettingField').keyup(function(){self.SettingChanged(self,this)});
    rnJQuery('.smartDonationsSettingField').change(function(){self.SettingChanged(self,this)});
    rnJQuery('#smartDonationsEmail').keyup(function(){self.SettingChanged(self,this)});
    rnJQuery('#smartDonationsCurrencyDropDown').change(function(){self.SettingChanged(self,this)});

    rnJQuery('.smartDonationsSettingField').change();

};

SmartDonationsConfigurationProgressBase.prototype.SettingChanged=function(configuration,component){

    var changedFieldName=rnJQuery(component).first().attr("name");
    var newValue;
    if(rnJQuery(component).is(':checkbox'))
        newValue=rnJQuery(component).is(':checked');
    else
        newValue=rnJQuery(component).val();

    if(Object.isNullOrEmpty(configuration.generator[changedFieldName])||configuration.generator[changedFieldName]!==newValue)
    {
        configuration.generator[changedFieldName]=newValue;
        this.PropertyChanged(changedFieldName,newValue);
        configuration.generator.GenerateDonationItem();
    }




};

SmartDonationsConfigurationProgressBase.prototype.PropertyChanged=function(field,value){

}

SmartDonationsConfigurationProgressBase.prototype.FillOptionsForNewDonation=function(options)
{

}

SmartDonationsConfigurationProgressBase.prototype.InitiateGenerator=function(options){

}



/************************************************************************************* Progress Indicator ***************************************************************************************************/

function SmartDonationsConfigurationProgressIndicator(containerName,options)
{
    SmartDonationsConfigurationProgressBase.call(this,'Progress Indicators',containerName,options);
}

SmartDonationsConfigurationProgressIndicator.prototype=Object.create(SmartDonationsConfigurationProgressBase.prototype);

SmartDonationsConfigurationProgressIndicator.prototype.PropertyChanged=function(field,value)
{
    if(field=="orientation")
    {
        if(value=='h')
            this.styles.progressBar="height: 100%;width: 0%;background-color: rgb(0, 147, 17);background-color: rgba(0, 147, 17,.9);position: absolute;bottom: 0;left: 0;";
        else
            this.styles.progressBar="height: 0%;width: 100%;background: rgba(0, 147, 17,.9);position: absolute;bottom: 0;left: 0;";
    }
}

SmartDonationsConfigurationProgressIndicator.prototype.GetProgressConfigurationGeneratedCode=function(){
    return  "<div  class='form-horizontal' style='padding:0;'> "+
        "<div class='form-group' style='margin-bottom: 1px;'>    "+
        "<label class='control-label col-xs-3'>Orientation</label> "+
        "<div class='col-xs-3'><select class='smartDonationsSettingField form-control' name='orientation'>" +
        "   <option value='h' selected='selected'>Horizontal</option>" +
        "   <option  value='v'>Vertical</option>" +
        "</select> </div> "+
        "<label class='control-label col-xs-3'>Currency Sign</label>" +
        "<div class='col-xs-3'><input type='text' class='smartDonationsSettingField form-control' style='width:50px;text-align: center;' name='currencySign' value='$'/></div>" +
        "</div>" +
        "<div class='form-group' style='margin-bottom: 1px;'>" +
        "<label class='control-label col-xs-3'>Comment</label>" +
        "<div class='col-xs-5'><input type='text' class='smartDonationsSettingField smartDonationsCommentField form-control' name='comment' value='Thank you, we are almost there!!'/></div>" +
        "</div>"+
        "</div>";

};


SmartDonationsConfigurationProgressIndicator.prototype.InitiateGenerator=function(options)
{
    this.generator=new smartdonationsGoalBar(this.containerName,options);
}





/************************************************************************************* Panels  ***************************************************************************************************/

function SmartDonationsConfigurationPanels(containerName,options)
{
    SmartDonationsConfigurationProgressBase.call(this,'Panels',containerName,options);
}

SmartDonationsConfigurationPanels.prototype=Object.create(SmartDonationsConfigurationProgressBase.prototype);

SmartDonationsConfigurationPanels.prototype.PropertyChanged=function(field,value)
{
    if(field=="orientation")
    {
        if(value=='h')
            this.styles.progressBar="height: 100%;width: 0%;background-color: rgb(0, 147, 17);background-color: rgba(0, 147, 17,.9);position: absolute;bottom: 0;left: 0;";
        else
            this.styles.progressBar="height: 0%;width: 100%;background: rgba(0, 147, 17,.9);position: absolute;bottom: 0;left: 0;";
    }
}

SmartDonationsConfigurationPanels.prototype.GetProgressConfigurationGeneratedCode=function(){
    return  "<div  class='form-horizontal' style='padding:30px;'> "+
                "<div class='form-group'>     "+
                    "<label class='control-label col-xs-2'>Hide Current</label> "+
                    "<div class='col-xs-6'><input name='hidecurrent' class='smartDonationsSettingField' type='checkbox' /> </div> "+
                "</div>"+
                "<div class='form-group'>     "+
                    "<label class='control-label col-xs-2'>Hide Goals</label> "+
                    "<div class='col-xs-6'><input name='hidegoals' class='smartDonationsSettingField' type='checkbox'  /> </div> "+
                "</div>"+
                "<div class='form-group'>"+
                    "<label class='control-label col-xs-2'>Hide Donors</label> "+
                    "<div class='col-xs-6'><input name='hidedonators' class='smartDonationsSettingField' type='checkbox' /> </div> "+
                "</div>"+
        "</div>";

};


SmartDonationsConfigurationPanels.prototype.InitiateGenerator=function(options)
{
    this.generator=new smartDonationsPanels(this.containerName,options);
}
