rnJQuery(function()
{
    if( window.smartDonationsProgressItemsToLoad)
        for(var i=0;i< window.smartDonationsProgressItemsToLoad.length;i++)
            smartDonationsLoadProgress(window.smartDonationsProgressItemsToLoad[i].options,window.smartDonationsProgressItemsToLoad[i].element);

});


function smartDonationsLoadProgress(options,containerName)
{
    var progressTypeSelected= options.smartDonationsProgressType;
    options.isNew=false;

    var aux;


   this.styles=options.styles;


    if(progressTypeSelected=='progressBar')
        aux=new smartdonationsGoalBar(containerName,options,null,styles);
    else
    if(progressTypeSelected=='panels')
        aux=new smartDonationsPanels(containerName,options,null,styles);
    else
      throw 'Undefined donation type';

    aux.GenerateDonationItem();
    return aux;


}




function smartDonationsBaseProgressIndicator(containerName2,options){

    if(options.styles!=null)
        this.styles=options.styles;
    else
    {
        this.styles={};
        this.GenerateDefaultStyle();
    }
    this.containerName=containerName2;
    this.Goal=options.Goal;
    this.Amount=options.Amount;
    this.Donators=options.Donators;

    if(this.Goal==0)
        this.Goal=this.Amount;
}

function SmartdonationsGetValueOrDefault(value,defaultValue)
{
    if(typeof value=='undefined')
        return defaultValue;
    return value;

}

smartDonationsBaseProgressIndicator.prototype.GenerateDefaultStyle=function()
{
    return {};
}

smartDonationsBaseProgressIndicator.prototype.GetRootContainer=function()
{
    return rnJQuery('#'+this.containerName);
}

smartDonationsBaseProgressIndicator.prototype.DonationGeneratedCode=function(){};

smartDonationsBaseProgressIndicator.prototype.GenerateDonationItem=function()
{
    var generator=this;
    this.GetRootContainer().html('').append(this.DonationGeneratedCode());
    this.GetRootContainer().find(".donationForm").submit(function(){generator.SubmitFired(generator)});
    this.StyleItem();
    this.GenerationCompleted();

}

smartDonationsBaseProgressIndicator.prototype.StyleItem=function()
{
    if(this.styles==null)
        return;

    for(var property in this.styles)
    {
        this.GetRootContainer().find("."+property).attr("style",this.styles[property]);
    }
}

smartDonationsBaseProgressIndicator.prototype.formatCurrency=function formatCurrency(n, c, d, t) {
    "use strict";

    var s, i, j;

    c = isNaN(c = Math.abs(c)) ? 2 : c;
    d = d === undefined ? "." : d;
    t = t === undefined ? "," : t;

    s = n < 0 ? "-" : "";
    i = parseInt(n = Math.abs(+n || 0).toFixed(c), 10) + "";
    j = (j = i.length) > 3 ? j % 3 : 0;

    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

smartDonationsBaseProgressIndicator.prototype.GenerationCompleted=function()
{

}

smartDonationsBaseProgressIndicator.prototype.SubmitFired=function(generator)
{

}

smartDonationsBaseProgressIndicator.prototype.GetStartOfDonationForm=function(defaultQuantity)
{
    return this.donationProvider.GetStartOfDonationForm(this, defaultQuantity);


};


smartDonationsBaseProgressIndicator.prototype.ChangeAmountToDonate=function(amount)
{
    try
    {
        var amount=parseFloat(amount);
        this.GetRootContainer().find(".amountToDonate").val(amount);
    }catch(exception)
    {

    }
}


smartDonationsBaseProgressIndicator.prototype.GetEndOfDonationForm=function()
{
    return this.donationProvider.GetEndOfDonationForm();
};




/*************************************************************************************Goal Bar Generator***************************************************************************************************/

function smartdonationsGoalBar(containerName,options){
    smartDonationsBaseProgressIndicator.call(this,containerName,options);

    this.orientation=options.orientation;
    this.comment=options.comment;

    if(typeof options.currencySign=='undefined')
        this.currencySign="$"
    else
        this.currencySign=options.currencySign;


}
smartdonationsGoalBar.prototype=Object.create(smartDonationsBaseProgressIndicator.prototype);


smartdonationsGoalBar.prototype.GenerateDefaultStyle=function()
{
    this.styles.amountText="font-family: Trebuchet MS;font-weight: bold;color: #333;font-size: 16px;";
    this.styles.progressAmount="display: inline-block;padding: 0;border-top: 0;font-family: Trebuchet MS;font-weight: bold;color: #060;height: 45px;position: absolute;right: 0;bottom: 0;border-right: 1px solid #060;border-left: 0;padding-right: 2px;";
    this.styles.currentText="display: inline-block;padding: 0;margin: 0;font-size: 16px;";
    this.styles.goalMessage="clear: both;text-align: center;width: 350px;padding-top: 30px;font-family: cursive,sans-serif;font-size: 20px;margin: 5px 0 0 0;padding: 0;line-height:normal;";
    this.styles.progressBar="height: 100%;width: 0%;background-color: rgb(0, 147, 17);background-color: rgba(0, 147, 17,.9);position: absolute;bottom: 0;left: 0;";
    this.styles.smartDonationsHorizontalThermomenter="background: rgb(247,247,247);display: inline-block;width: 350px;height: 70px;position: relative;border-radius: 33px 17px 46px 17px;-moz-border-radius: 33px 17px 46px 17px;-webkit-border-radius: 33px 17px 46px 17px;border: 0px solid #800000;background: -moz-linear-gradient(top,  rgba(247,247,247,1) 0%, rgba(241,241,241,1) 50%, rgba(225,225,225,1) 51%, rgba(246,246,246,1) 100%);background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(247,247,247,1)), color-stop(50%,rgba(241,241,241,1)), color-stop(51%,rgba(225,225,225,1)), color-stop(100%,rgba(246,246,246,1)));background: -webkit-linear-gradient(top,  rgba(247,247,247,1) 0%,rgba(241,241,241,1) 50%,rgba(225,225,225,1) 51%,rgba(246,246,246,1) 100%);background: -o-linear-gradient(top,  rgba(247,247,247,1) 0%,rgba(241,241,241,1) 50%,rgba(225,225,225,1) 51%,rgba(246,246,246,1) 100%);background: -ms-linear-gradient(top,  rgba(247,247,247,1) 0%,rgba(241,241,241,1) 50%,rgba(225,225,225,1) 51%,rgba(246,246,246,1) 100%);background: linear-gradient(to bottom,  rgba(247,247,247,1) 0%,rgba(241,241,241,1) 50%,rgba(225,225,225,1) 51%,rgba(246,246,246,1) 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#f7f7f7\', endColorstr=\'#f6f6f6\',GradientType=0 );";
    this.styles.smartDonationsVerticalThermomenter="display:inline-block;width:70px;height:300px;position:relative;border-radius: 33px 17px 46px 17px;-moz-border-radius: 33px 17px 46px 17px;-webkit-border-radius: 33px 17px 46px 17px;border: 0px solid #800000; background: rgb(247,247,247);background: -moz-linear-gradient(left,  rgba(247,247,247,1) 0%, rgba(241,241,241,1) 50%, rgba(225,225,225,1) 51%, rgba(246,246,246,1) 100%);background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(247,247,247,1)), color-stop(50%,rgba(241,241,241,1)), color-stop(51%,rgba(225,225,225,1)), color-stop(100%,rgba(246,246,246,1)));background: -webkit-linear-gradient(left,  rgba(247,247,247,1) 0%,rgba(241,241,241,1) 50%,rgba(225,225,225,1) 51%,rgba(246,246,246,1) 100%);background: -o-linear-gradient(left,  rgba(247,247,247,1) 0%,rgba(241,241,241,1) 50%,rgba(225,225,225,1) 51%,rgba(246,246,246,1) 100%);background: -ms-linear-gradient(left,  rgba(247,247,247,1) 0%,rgba(241,241,241,1) 50%,rgba(225,225,225,1) 51%,rgba(246,246,246,1) 100%);background: linear-gradient(left,  rgba(247,247,247,1) 0%,rgba(241,241,241,1) 50%,rgba(225,225,225,1) 51%,rgba(246,246,246,1) 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#f7f7f7\', endColorstr=\'#f6f6f6\',GradientType=1 );"


}

smartdonationsGoalBar.prototype.DonationGeneratedCode=function(){

    if(this.orientation=='h')
    {
        return '<div style="text-align: center;clear:both;">\
            <div>\
            <div class="thermometer horizontal smartDonationsEditableItem smartDonationsHorizontalThermomenter"  >\
                <div class="track" style="height: 20px;top: 10px;width: 90%;border: 1px solid #aaa;position: relative;margin: 14px auto;background: linear-gradient(to right, rgb(0, 0, 0) 0%, rgb(255, 255, 255) 10%);background-position: 0 -1px;background-size: 5% 100%;left: 0;">\
                    <div class="goal" style="top: 0;text-align: right;left: 100%;height: 100%;">\
                        <div class="amount goalAmount" style="display: inline-block;padding: 0;border-top: 0;height: 33px;bottom: 0;border-right: 1px solid black;">\
                        <div style="position: relative;right: 2px;top:23px;">\
                            <span class="amountText smartDonationsEditableItem" ></span></div>\
                        </div>\
                    </div>\
                    <div class="progress progressBar " style="">\
                        <div class="amount progressAmount" >\
                            <span class="currentText smartDonationsEditableItem"></span></div>\
                    </div>\
                    <div class="progress effect smartDonationsEditableItem" style="background-color:rgba(0,0,0,0); height: 100%;width: 100%;background: -moz-linear-gradient(top,  rgba(255,255,255,0) 0%, rgba(254,254,254,0) 8%, rgba(250,250,250,0.7) 27%, rgba(247,247,247,0) 46%, rgba(237,237,237,0.5) 100%);background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0)), color-stop(8%,rgba(254,254,254,0)), color-stop(27%,rgba(250,250,250,0.7)), color-stop(46%,rgba(247,247,247,0)), color-stop(100%,rgba(237,237,237,0.5)));background: -webkit-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(254,254,254,0) 8%,rgba(250,250,250,0.7) 27%,rgba(247,247,247,0) 46%,rgba(237,237,237,0.5) 100%);        background: -o-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(254,254,254,0) 8%,rgba(250,250,250,0.7) 27%,rgba(247,247,247,0) 46%,rgba(237,237,237,0.5) 100%);background: -ms-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(254,254,254,0) 8%,rgba(250,250,250,0.7) 27%,rgba(247,247,247,0) 46%,rgba(237,237,237,0.5) 100%);background: linear-gradient(to bottom,  rgba(255,255,255,0) 0%,rgba(254,254,254,0) 8%,rgba(250,250,250,0.7) 27%,rgba(247,247,247,0) 46%,rgba(237,237,237,0.5) 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#00ffffff\', endColorstr=\'#80ededed\',GradientType=0 );position: absolute;bottom: 0;left: 0;">\
                    </div>\
                </div>\
            </div>\
            <br/>\
            <span class="goalMessage smartDonationsEditableItem" >\
            '+this.comment+'</span>\
        </div>\
        </div>';
    }else
    {
        return '<div style="text-align: center">\
            <div  class="thermometer smartDonationsEditableItem smartDonationsVerticalThermomenter" >\
                <div class="track" style="height: 280px;top: 10px;width: 20px;border: 1px solid #aaa;position: relative;margin: 0 auto;background: linear-gradient(to bottom, rgb(0, 0, 0) 0%, rgb(255, 255, 255) 10%);background-position: 0 -1px;background-size: 100% 5%;">\
                    <div class="goal" style="top: 0;text-align: right;">\
                        <div class="amount" style="display: inline-block;padding: 0 5px 0 40px;border-top: 1px solid black;font-family: Trebuchet MS;font-weight: bold;color: #333;height: 33px;margin:0">\
                            <span class="amountText smartDonationsEditableItem" ></span>\
                        </div>\
                    </div>\
                    <div class="progress progressBar">\
                        <div class="amount" style="position:relative;display: inline-block;padding: 0 5px 0 40px;border-top: 1px solid #060;font-family: Trebuchet MS;font-weight: bold;color: #060;height: 33px;margin:0;">\
                            <span class="currentText smartDonationsEditableItem"></span>\
                        </div>\
                    </div>\
                    <div class="progress effect smartDonationsEditableItem" style="width:100%;position: absolute;bottom: 0;left: 0;background-color:rgba(0,0,0,0); height: 100%;background: -moz-linear-gradient(left,  rgba(255,255,255,0) 0%, rgba(254,254,254,0) 8%, rgba(250,250,250,0.7) 27%, rgba(247,247,247,0) 46%, rgba(237,237,237,0.5) 100%);background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(255,255,255,0)), color-stop(8%,rgba(254,254,254,0)), color-stop(27%,rgba(250,250,250,0.7)), color-stop(46%,rgba(247,247,247,0)), color-stop(100%,rgba(237,237,237,0.5)));background: -webkit-linear-gradient(left,  rgba(255,255,255,0) 0%,rgba(254,254,254,0) 8%,rgba(250,250,250,0.7) 27%,rgba(247,247,247,0) 46%,rgba(237,237,237,0.5) 100%);        background: -o-linear-gradient(left,  rgba(255,255,255,0) 0%,rgba(254,254,254,0) 8%,rgba(250,250,250,0.7) 27%,rgba(247,247,247,0) 46%,rgba(237,237,237,0.5) 100%);background: -ms-linear-gradient(left,  rgba(255,255,255,0) 0%,rgba(254,254,254,0) 8%,rgba(250,250,250,0.7) 27%,rgba(247,247,247,0) 46%,rgba(237,237,237,0.5) 100%);background: linear-gradient(left,  rgba(255,255,255,0) 0%,rgba(254,254,254,0) 8%,rgba(250,250,250,0.7) 27%,rgba(247,247,247,0) 46%,rgba(237,237,237,0.5) 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#00ffffff\', endColorstr=\'#80ededed\',GradientType=1 );"></div>\
                </div>\
            </div>\
            <br/>\
            <span class="goalMessage smartDonationsEditableItem" > '+this.comment+'</span>\
        </div>';
    }
};

smartdonationsGoalBar.prototype.GenerationCompleted=function(){

    if(this.orientation=="h")
    {

    }
    this.createThermometer(this, this.Goal, this.Amount);
}




smartdonationsGoalBar.prototype.createThermometer=function thermometer(generator, goalAmount, progressAmount, animate) {
    "use strict";

    var $thermo = generator.GetRootContainer().find('.thermometer'),
        $progress = jQuery(".progressBar", $thermo),
        $goal = jQuery(".goal", $thermo),
        percentageAmount,
        isHorizontal = $thermo.hasClass("horizontal"),
        newCSS = {};

    goalAmount = goalAmount || parseFloat($goal.text()),
        progressAmount = progressAmount || parseFloat($progress.text()),
        percentageAmount = Math.min(Math.round(progressAmount / goalAmount * 1000) / 10, 100); //make sure we have 1 decimal point

    //let's format the numbers and put them back in the DOM
    $goal.find(".amountText").text(generator.currencySign + generator.formatCurrency(goalAmount));






    //let's set the progress indicator
    $progress.find(".amount").hide();

    newCSS[isHorizontal ? "width" : "height"] = percentageAmount + "%";






    $progress.animate(newCSS, 1200, function () {
        $progress.find(".currentText").text("a");
        jQuery(this).find(".amount").show();
        var isColliding=false;

        if(!$thermo.hasClass('horizontal'))
        {
            var currentText=$thermo.find(".currentText");
            var goalText=$thermo.find(".amountText");
            var goalTextTop=goalText.offset().top;
            var goalTextHeight=goalText.height();


            var currentTextTop=currentText.offset().top;
            if(currentTextTop<(goalTextTop+goalTextHeight))
            {
                isColliding=true;
            }
        }
        jQuery(this).find(".amount").hide();
        $progress.find(".currentText").text(generator.currencySign + generator.formatCurrency(progressAmount));
        if(isColliding)
            $thermo.find(".goal .amount").fadeOut(500,function()
            {
                var currentAmountDiv=$thermo.find(".progress div");
                currentAmountDiv.append("<strong style='font-size:10px;color:black;position: relative;top:-5px;'>Goal:"+generator.formatCurrency(goalAmount)+"</strong>")
                $thermo.find(".progress div").fadeIn(500);
            });
        else
            $thermo.find(".progress div").fadeIn(500);
    });


};




/*************************************************************************************Panels***************************************************************************************************/

function smartDonationsPanels(containerName,options){
    smartDonationsBaseProgressIndicator.call(this,containerName,options);

    this.hidegoals=options.hidegoals;
    this.hidecurrent=options.hidecurrent;
    this.hidedonators=options.hidedonators;

}
smartDonationsPanels.prototype=Object.create(smartDonationsBaseProgressIndicator.prototype);


smartDonationsPanels.prototype.GenerateDefaultStyle=function()
{
    this.styles.panelAmount="display: inline-block;background-color: #B6D9E3; text-align: center;  border-style: solid;border-width: 1px;-webkit-border-radius: 7px;-moz-border-radius: 7px;border-radius: 7px; margin:0 2px 0 2px; padding: 0;";
    this.styles.amountText="margin:6px;line-height:40px; font-size: 40px; font-family:Modern, sans-serif; font-weight: bold;color:white;";
    this.styles.panelTitle="background-color: #ca4c3f;padding-right:3px;padding-left: 3px;border-top-style: solid;border-top-width: 1px;-webkit-border-bottom-right-radius: 7px;-webkit-border-bottom-left-radius: 7px;-moz-border-radius-bottomright: 7px;-moz-border-radius-bottomleft: 7px;border-bottom-right-radius: 7px;border-bottom-left-radius: 7px;";
    this.styles.titleText="color: white; width: 100%; font-family: verdana;";



}

smartDonationsPanels.prototype.DonationGeneratedCode=function(){
    var component='<div style="text-align: center;">';


    if(!this.hidecurrent)
    {
       component+='<div class="panelAmount smartDonationsEditableItem" >\
                        <div style="padding: 6px;">\
                        <span  class="amountText smartDonationsEditableItem">'+this.formatCurrency(this.Amount)+'</span>\
                        </div>\
                    <div class="panelTitle smartDonationsEditableItem" >\
                        <span class="titleText smartDonationsEditableItem">Current</span>\
                    </div></div>';
    }


    if(!this.hidegoals)
    {
        component+=    ' <div class="panelAmount smartDonationsEditableItem" >\
                <div style="padding: 6px;">\
                    <span  class="amountText smartDonationsEditableItem">'+this.formatCurrency(this.Goal)+'</span>\
                </div>\
                <div class="panelTitle smartDonationsEditableItem" >\
                    <span  class="titleText smartDonationsEditableItem">Goal</span>\
                </div>\
            </div>';
    }

    if(!this.hidedonators)
    {
        component+=    '<div class="panelAmount smartDonationsEditableItem">\
        <div style="padding: 6px;">\
            <span class="amountText smartDonationsEditableItem">'+this.Donators+'</span>\
        </div>\
        <div class="panelTitle smartDonationsEditableItem">\
        <span class="titleText smartDonationsEditableItem" >Donors</span>\
        </div>\
        </div>';
    }

    component+='</div>';
    return component;
}