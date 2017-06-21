rnJQuery(function()
{
    if( window.smartDonationsItemsToLoad)
        for(var i=0;i< window.smartDonationsItemsToLoad.length;i++)
            smartDonationsLoadDonation(window.smartDonationsItemsToLoad[i].options,window.smartDonationsItemsToLoad[i].element);
    else
        SmartDonationsInitialize();
});

/***Base Object*******/
function smartDonationsLoadDonation(options,containerName)
{
    var donationTypeSelected= options.smartDonationsType;
    options.isNew=false;
    if(!options.donation_provider)
        options.donation_provider='paypal';

    var aux;


    if(typeof options.styles =='undefined'||options.styles!=null)
        this.styles=options.styles;

        if(donationTypeSelected=='classic')
            aux=new smartDonationsClassicDonationGenerator(containerName,options,null,styles);
        else
        if(donationTypeSelected=='textbox')
            aux=new smartDonationsTextBoxDonationGenerator(containerName,options,null,styles);
        else
        if(donationTypeSelected=="threeButtons")
            aux=new smartDonationsThreeButtonsDonationGenerator(containerName,options,null,styles);
        else
        if(donationTypeSelected=="slider")
            aux=new smartDonationsSliderDonationGenerator(containerName,options,null,styles);
        else if(donationTypeSelected=='forms')
            aux=new smartDonationsFormDonationGenerator(containerName,options,null,styles)
        else
            throw 'Undefined donation type';

    aux.GenerateDonationItem();
    return aux;


}




function smartDonationsBaseGenerator(containerName2,options,donationProvider,styles){

    if(typeof options.donation_provider=='undefined')
        options.donation_provider='paypal';
    var args={donation_provider:options.donation_provider,provider:null};
    RedNaoEventManager.Publish('GetProvider',args);

    if(args.provider==null)
        throw 'Invalid provider';

    this.donationProvider=args.provider;

    if(styles!=null)
        this.styles=styles;
    else
    {
        this.styles={};
        this.GenerateDefaultStyle();
    }
    this.containerName=containerName2;

    this.business=options.business;
    this.returningUrl=options.returningUrl;
    this.donation_currency=SmartdonationsGetValueOrDefault(options.donation_currency,'USD');
    this.selectedCountry=SmartdonationsGetValueOrDefault(options.selectedCountry,'en_US');
    this.DonationGeneratedListener=null;
    this.donation_description=options.donation_description;

    if(typeof(options.campaign_id)=='undefined')
        this.campaign_id=0;
    else
        this.campaign_id=options.campaign_id;

}

function SmartdonationsGetValueOrDefault(value,defaultValue)
{
    if(typeof value=='undefined')
        return defaultValue;
    return value;

}

smartDonationsBaseGenerator.prototype.GenerateDefaultStyle=function()
{
    return {};
}

smartDonationsBaseGenerator.prototype.GetRootContainer=function()
{
    return rnJQuery('#'+this.containerName);
}

smartDonationsBaseGenerator.prototype.DonationGeneratedCode=function(){};

smartDonationsBaseGenerator.prototype.GenerateDonationItem=function()
{
    var generator=this;
    var self=this;
    this.GetRootContainer().html('').append(this.DonationGeneratedCode());
    this.GetRootContainer().find(".donationForm").submit(function(event){
        if(self instanceof smartDonationsFormDonationGenerator)
            return;
        generator.SubmitFired(generator);
        var continueNormalSubmision=self.donationProvider.Submit();
        if(!continueNormalSubmision)
            event.preventDefault();
    });
    this.GenerationCompleted();
    this.StyleItem();
    if(this.DonationGeneratedListener!=null)
        this.DonationGeneratedListener();
}

smartDonationsBaseGenerator.prototype.StyleItem=function()
{
    if(this.styles==null)
        return;

    for(var property in this.styles)
    {
        this.GetRootContainer().find("."+property).attr("style",this.styles[property]);
    }
}

smartDonationsBaseGenerator.prototype.GenerationCompleted=function()
{


}

smartDonationsBaseGenerator.prototype.SubmitFired=function(generator)
{

}

smartDonationsBaseGenerator.prototype.GetStartOfDonationForm=function(defaultQuantity)
{
    return this.donationProvider.GetStartOfDonationForm(this, defaultQuantity);


};


smartDonationsBaseGenerator.prototype.ChangeAmountToDonate=function(amount)
{
    try
    {
        var amount=parseFloat(amount);
        if(!isNaN(amount))
        {
            this.GetRootContainer().find(".amountToDonate").val(amount);
            this.donationProvider.SetAmount(amount);
        }
    }catch(exception)
    {

    }
}


smartDonationsBaseGenerator.prototype.GetEndOfDonationForm=function()
{
    return this.donationProvider.GetEndOfDonationForm();
};

smartDonationsBaseGenerator.prototype.GetDonationImage=function(usingCreditCardLogo)
{
    if(this.donationProvider.Id!='paypal')
        return '';

    if(usingCreditCardLogo)
    {
        if(this.selectedCountry.indexOf("en_")==0)
            return "https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif";
        if(this.selectedCountry.indexOf("de_")==0)
            return "https://www.paypalobjects.com/de_DE/AT/i/btn/btn_donateCC_LG.gif";
        if(this.selectedCountry.indexOf("nl_")==0)
            return "https://www.paypalobjects.com/nl_NL/BE/i/btn/btn_donateCC_LG.gif";
        if(this.selectedCountry.indexOf("fr_")==0)
            return "https://www.paypalobjects.com/fr_FR/BE/i/btn/btn_donateCC_LG.gif";
        if(this.selectedCountry.indexOf("pt_")==0)
            return "https://www.paypalobjects.com/pt_BR/BR/i/btn/btn_donateCC_LG.gif";
        if(this.selectedCountry.indexOf("zh_")==0)
            return "https://www.paypalobjects.com/zh_XC/i/btn/btn_donateCC_LG.gif";
        if(this.selectedCountry.indexOf("da_")==0)
            return "https://www.paypalobjects.com/da_DK/DK/i/btn/btn_donateCC_LG.gif";
        if(this.selectedCountry.indexOf("ru_")==0)
            return "https://www.paypalobjects.com/ru_RU/i/btn/btn_donateCC_LG.gif";
        if(this.selectedCountry.indexOf("es_")==0)
            return "https://www.paypalobjects.com/es_XC/i/btn/btn_donateCC_LG.gif";
        if(this.selectedCountry.indexOf("he_")==0)
            return "https://www.paypalobjects.com/he_IL/IL/i/btn/btn_donateCC_LG.gif";
        if(this.selectedCountry.indexOf("it_")==0)
            return "https://www.paypalobjects.com/it_IT/IT/i/btn/btn_donateCC_LG.gif";
        if(this.selectedCountry.indexOf("ja_")==0)
            return "https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_donateCC_LG.gif";
        if(this.selectedCountry.indexOf("no_")==0)
            return "https://www.paypalobjects.com/no_NO/NO/i/btn/btn_donateCC_LG.gif";
        if(this.selectedCountry.indexOf("pl_")==0)
            return "https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_donateCC_LG.gif";
        if(this.selectedCountry.indexOf("sv_")==0)
            return "https://www.paypalobjects.com/sv_SE/SE/i/btn/btn_donateCC_LG.gif";
        if(this.selectedCountry.indexOf("th_")==0)
            return "https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif";
        if(this.selectedCountry.indexOf("tr_")==0)
            return "https://www.paypalobjects.com/tr_TR/TR/i/btn/btn_donateCC_LG.gif";

        return "https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif";
    }



    if(this.selectedCountry.indexOf("en_")==0)
        return "https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif";
    if(this.selectedCountry.indexOf("de_")==0)
        return "https://www.paypalobjects.com/de_DE/AT/i/btn/btn_donate_LG.gif";
    if(this.selectedCountry.indexOf("nl_")==0)
        return "https://www.paypalobjects.com/nl_NL/BE/i/btn/btn_donate_LG.gif";
    if(this.selectedCountry.indexOf("fr_")==0)
        return "https://www.paypalobjects.com/fr_FR/BE/i/btn/btn_donate_LG.gif";
    if(this.selectedCountry.indexOf("pt_")==0)
        return "https://www.paypalobjects.com/pt_BR/i/btn/btn_donate_LG.gif";
    if(this.selectedCountry.indexOf("zh_")==0)
        return "https://www.paypalobjects.com/zh_XC/i/btn/btn_donate_LG.gif";
    if(this.selectedCountry.indexOf("da_")==0)
        return "https://www.paypalobjects.com/da_DK/i/btn/btn_donate_LG.gif";
    if(this.selectedCountry.indexOf("ru_")==0)
        return "https://www.paypalobjects.com/ru_RU/i/btn/btn_donate_LG.gif";
    if(this.selectedCountry.indexOf("es_")==0)
        return "https://www.paypalobjects.com/es_XC/i/btn/btn_donate_LG.gif";
    if(this.selectedCountry.indexOf("he_")==0)
        return "https://www.paypalobjects.com/he_IL/i/btn/btn_donate_LG.gif";
    if(this.selectedCountry.indexOf("it_")==0)
        return "https://www.paypalobjects.com/it_IT/IT/i/btn/btn_donate_LG.gif";
    if(this.selectedCountry.indexOf("ja_")==0)
        return "https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_donate_LG.gif";
    if(this.selectedCountry.indexOf("no_")==0)
        return "https://www.paypalobjects.com/no_NO/i/btn/btn_donate_LG.gif";
    if(this.selectedCountry.indexOf("pl_")==0)
        return "https://www.paypalobjects.com/pl_PL/PL/i/btn/btn_donate_LG.gif";
    if(this.selectedCountry.indexOf("sv_")==0)
        return "https://www.paypalobjects.com/sv_SE/i/btn/btn_donate_LG.gif";
    if(this.selectedCountry.indexOf("th_")==0)
        return "https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif";
    if(this.selectedCountry.indexOf("tr_")==0)
        return "https://www.paypalobjects.com/tr_TR/i/btn/btn_donate_LG.gif";

    return "https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif";
};



/************************************************************************************* Classic Generator ***************************************************************************************************/


function smartDonationsClassicDonationGenerator(containerName,options,donationProvider,styles){
    smartDonationsBaseGenerator.call(this,containerName,options,donationProvider,styles);

    this.smartDonationsdisplaycreditlogo=options.smartDonationsdisplaycreditlogo;

}

smartDonationsClassicDonationGenerator.prototype=Object.create(smartDonationsBaseGenerator.prototype);

smartDonationsClassicDonationGenerator.prototype.GenerateDefaultStyle=function()
{
    this.styles.smartDonationsDonationButton_src="";
}

smartDonationsClassicDonationGenerator.prototype.DonationGeneratedCode=function()
{
    var imageToUse;

    if(typeof this.styles=='undefined'||this.styles.smartDonationsDonationButton_src=="")
    {
        if(this.smartDonationsdisplaycreditlogo||this.smartDonationsdisplaycreditlogo=='y')
            imageToUse=this.GetDonationImage(true);
        else
            imageToUse=this.GetDonationImage(false);
    }else
        imageToUse=this.styles.smartDonationsDonationButton_src;


        return   this.GetStartOfDonationForm()+
                    this.donationProvider.GetButton(imageToUse)+
                this.GetEndOfDonationForm();



}






/************************************************************************************* Text Box  ***************************************************************************************************/



function smartDonationsTextBoxDonationGenerator(containerName,options,donationProvider,styles){
    smartDonationsBaseGenerator.call(this,containerName,options,donationProvider,styles);

    this.smartDonationsComment=options.smartDonationsComment;
    this.smartDonationsRecommendedDonation=options.smartDonationsRecommendedDonation;
    this.smartDonationsStyle=options.smartDonationsStyle;
}

smartDonationsTextBoxDonationGenerator.prototype=Object.create(smartDonationsBaseGenerator.prototype);

smartDonationsTextBoxDonationGenerator.prototype.GenerateDefaultStyle=function()
{
    this.styles.smartDonationsCommentText="vertical-align:middle; margin-left:5px;font-family:verdana;";
    this.styles.smartDonationsDonationBox="vertical-align:middle; margin-left:5px;font-family:verdana;";
    this.styles.smartDonationsDonationButton="vertical-align:middle; margin-left:5px;";
}

smartDonationsTextBoxDonationGenerator.prototype.GetCommentTag=function()
{
    return '<span class="smartDonationsTextBoxDonationField smartDonationsCommentText smartDonationsEditableItem">'+this.smartDonationsComment+'</span>';
}

smartDonationsTextBoxDonationGenerator.prototype.GetTextBoxTag=function()
{
    return '<input type="text" class="smartDonationsNumericField smartDonationsTextBoxDonationField smartDonationsDonationBox smartDonationsEditableItem"  value="'+this.smartDonationsRecommendedDonation+'">';
}

smartDonationsTextBoxDonationGenerator.prototype.GetButtonTag=function()
{
    var imageToUse;
    if(typeof this.styles=='undefined'||typeof this.styles.smartDonationsDonationButton_src=='undefined')
        imageToUse=this.GetDonationImage(false);
    else
        imageToUse=this.styles.smartDonationsDonationButton_src;


    return  this.donationProvider.GetButton(imageToUse);

}


smartDonationsTextBoxDonationGenerator.prototype.SubmitFired=function(generator)
{
    generator.ChangeAmountToDonate(rnJQuery('#'+generator.containerName).find(".smartDonationsDonationBox").val());

}


smartDonationsTextBoxDonationGenerator.prototype.DonationGeneratedCode=function()
{
    if(this.smartDonationsStyle==1)
    {
        return  this.GetStartOfDonationForm((this.smartDonationsRecommendedDonation?this.smartDonationsRecommendedDonation:0))+
            '<table class="smartDonationsTextBoxDonationContainer">\
                              <tr>\
                                  <td>'+
            this.GetCommentTag()+

            this.GetTextBoxTag()+

            this.GetButtonTag()+
            '</td>\
        </tr> \
  </table>'
            +this.GetEndOfDonationForm();
    }

    if(this.smartDonationsStyle==2)
    {
        return  this.GetStartOfDonationForm((this.smartDonationsRecommendedDonation?this.smartDonationsRecommendedDonation:0))+
            '<table class="smartDonationsTextBoxDonationContainer">\
                              <tr>\
                                  <td>'+
            this.GetCommentTag()+
            '</td>\
         </tr>\
               <td>'+
            this.GetTextBoxTag()+
            this.GetButtonTag()+
            '</td>\
        </tr> \
  </table>'
            +this.GetEndOfDonationForm();
    }

    if(this.smartDonationsStyle==3)
    {
        return  this.GetStartOfDonationForm((this.smartDonationsRecommendedDonation?this.smartDonationsRecommendedDonation:0))+
             '<table class="smartDonationsTextBoxDonationContainer">\
                               <tr>\
                                   <td>'+
                        this.GetCommentTag()+
                        '</td>\
                     </tr>\
                     <tr>\
                         <td>'+
                        this.GetTextBoxTag()+
                        '</td>\
                     </tr>\
                     <tr>  \
                         <td>'+
                        this.GetButtonTag()+
                        '</td>\
                    </tr> \
              </table>'
            +this.GetEndOfDonationForm();
    }


}




/************************************************************************************* Three Buttons  ***************************************************************************************************/



    function smartDonationsThreeButtonsDonationGenerator(containerName,options,donationProvider,styles){
        smartDonationsBaseGenerator.call(this,containerName,options,donationProvider,styles);



        this.smartDonationButtonStyle1=options.smartDonationButtonStyle1;
        this.smartDonationButtonText1=options.smartDonationButtonText1;
        this.smartdonationsDonationquantity1=options.smartdonationsDonationquantity1;

        this.smartDonationButtonStyle2=options.smartDonationButtonStyle2;
        this.smartDonationButtonText2=options.smartDonationButtonText2;
        this.smartdonationsDonationquantity2=options.smartdonationsDonationquantity2;

        this.smartDonationButtonStyle3=options.smartDonationButtonStyle3;
        this.smartDonationButtonText3=options.smartDonationButtonText3;
        this.smartdonationsDonationquantity3=options.smartdonationsDonationquantity3;

        this.smartDonationSameSize=options.smartDonationSameSize;


        if(typeof this.styles=='undefined')
            this.styles={};

        if(typeof this.styles.smartDonationsThreeButtonImage1_src=='undefined')
        {
            this.styles.smartDonationsThreeButtonImage1_src=smartDonationsRootPath+'images/'+this.smartDonationButtonStyle1;
            this.styles.smartDonationsThreeButtonImage2_src=smartDonationsRootPath+'images/'+this.smartDonationButtonStyle2;
            this.styles.smartDonationsThreeButtonImage3_src=smartDonationsRootPath+'images/'+this.smartDonationButtonStyle3;
        }



    }
    smartDonationsThreeButtonsDonationGenerator.prototype=Object.create(smartDonationsBaseGenerator.prototype);


    smartDonationsThreeButtonsDonationGenerator.prototype.GenerateDefaultStyle=function()
    {
        this.styles.smartDonationsThreeButtonImage1="cursor:pointer; cursor:hand;overflow:hidden;"
        this.styles.smartDonationsThreeButtonSpan1="position:relative;vertical-align:top;font-family:Verdana;cursor:pointer;cursor:hand;";
        // this.styles.smartDonationsThreeButtonImage1_src="threeButtonsStyle1.png";

        this.styles.smartDonationsThreeButtonImage2="cursor:pointer; cursor:hand;overflow:hidden;"
        this.styles.smartDonationsThreeButtonSpan2="position:relative;vertical-align:top;font-family:Verdana;cursor:pointer;cursor:hand;";
        //this.styles.smartDonationsThreeButtonImage2_src="threeButtonsStyle1.png";

        this.styles.smartDonationsThreeButtonImage3="cursor:pointer; cursor:hand;overflow:hidden;"
        this.styles.smartDonationsThreeButtonSpan3="position:relative;vertical-align:top;font-family:Verdana;cursor:pointer;cursor:hand;";
        //this.styles.smartDonationsThreeButtonImage3_src="threeButtonsStyle1.png";
    }

    smartDonationsThreeButtonsDonationGenerator.prototype.AdjustSize=function(image,span,generator)
    {
        var image = this.GetRootContainer().find(image);
        var text = this.GetRootContainer().find(span);

        this.ResizeImage(image, text,generator);
        this.CenterTextInImage(image, text);

    }


     smartDonationsThreeButtonsDonationGenerator.prototype.ResizeImage=function(image,text,generator) {

        var offsetWidth = 30;
        var offsetHeight = 10;

        var width = text.width();
        var height = text.height();

         if(this.smartDonationSameSize)
         {
             var spans=generator.GetRootContainer().find('.smartDonationsThreeButtonSpan1,.smartDonationsThreeButtonSpan2,.smartDonationsThreeButtonSpan3');
             for(var i=0;i<spans.length;i++)
             {
                 var spanToCheck=rnJQuery(spans[i]);

                 if(spanToCheck.width()>width)
                    width=spanToCheck.width();

                 if(spanToCheck.height()>height)
                    height=spanToCheck.height();
             }
         }

         width=width+offsetWidth;
         height=height+offsetHeight;

        image.width(width );
        image.height(height );

        var parent= rnJQuery(image).parent();
        parent.width(width);
        parent.height(height);

         parent=parent.parent();
        parent.css('display','inline-block');

    }

     smartDonationsThreeButtonsDonationGenerator.prototype.CenterTextInImage=function(image,text) {

        var top = image.offset().top - text.offset().top;
        var left = image.offset().left - text.offset().left;

        top += (image.height() / 2) - (text.height() / 2)-1;
        left += (image.width() / 2) - (text.width() / 2);

        text.css("top", top);
        text.css("left", left);
    }

    smartDonationsThreeButtonsDonationGenerator.prototype.AdjustButtonDimensions=function(text,button,textWidth,textHeight,buttonWidth,buttonHeight)
    {
        var offsetWidth=16;
        var offsetheight=10;

        buttonWidth+=offsetWidth;
        buttonHeight+=offsetheight;

        button.width(buttonWidth);
        button.height(buttonHeight);

        var top=(buttonHeight/2)-(textHeight/2);
        var left=(buttonWidth/2)-(textWidth/2);



        left-=buttonWidth;

        text.css('top',top);
        text.css('left',left);

    }





smartDonationsThreeButtonsDonationGenerator.prototype.DonationGeneratedCode=function()
{
    return '<div class="smartDonationsThreeButtonsDiv1 " >'+ this.GetStartOfDonationForm(this.smartdonationsDonationquantity1)+
        '<div class="smartdonationsThreeButtonStyle"> \
            <image class="smartDonationsThreeButtonImage1 smartDonationsThreeButton smartDonationsEditableItem" src="" />\
            <span class="smartDonationsThreeButtonSpan1 smartDonationsThreeButtonSpan smartDonationsEditableItem" >'+this.smartDonationButtonText1+'</span>\
             </div>'+this.GetEndOfDonationForm()+
        this.GetStartOfDonationForm(this.smartdonationsDonationquantity2)+
        '<div class="smartdonationsThreeButtonStyle smartDonationsThreeButtonMiddleDiv" > \
            <image class="smartDonationsThreeButtonImage2 smartDonationsThreeButton smartDonationsEditableItem" src=""/>\
            <span class="smartDonationsThreeButtonSpan2 smartDonationsThreeButtonSpan smartDonationsEditableItem" >'+this.smartDonationButtonText2+'</span>\
             </div>'+this.GetEndOfDonationForm()+
        this.GetStartOfDonationForm(this.smartdonationsDonationquantity3)+
        '<div class="smartdonationsThreeButtonStyle"> \
            <image class="smartDonationsThreeButtonImage3 smartDonationsThreeButton smartDonationsEditableItem" src="" />\
            <span class="smartDonationsThreeButtonSpan3 smartDonationsThreeButtonSpan smartDonationsEditableItem" >'+this.smartDonationButtonText3+'</span>\
             </div>'+this.GetEndOfDonationForm()+'</div>';


}


smartDonationsThreeButtonsDonationGenerator.prototype.GenerationCompleted=function()
{
    var generator=this;

    rnJQuery(function()
    {
        generator.GetRootContainer().find('.smartDonationsDonationGeneratedItem').css('display','inline-block');
    })

    rnJQuery(function(){
        generator.CreateAndLayoutImage('.smartDonationsThreeButtonImage1','.smartDonationsThreeButtonSpan1',generator.styles.smartDonationsThreeButtonImage1_src);
        generator.CreateAndLayoutImage('.smartDonationsThreeButtonImage2','.smartDonationsThreeButtonSpan2',generator.styles.smartDonationsThreeButtonImage2_src);
        generator.CreateAndLayoutImage('.smartDonationsThreeButtonImage3','.smartDonationsThreeButtonSpan3',generator.styles.smartDonationsThreeButtonImage3_src);
    });




}

smartDonationsThreeButtonsDonationGenerator.prototype.CreateAndLayoutImage=function(image,span,imageName)
{
    var generator=this;
    generator.GetRootContainer().find(image).attr('src',imageName).load(function(){generator.AdjustSize(image,span,generator)});
    generator.GetRootContainer().find(image+','+span).click(function(){
        rnJQuery(this).parent().parent().submit();
    });
}






/************************************************************************************* Slider ***************************************************************************************************/




function smartDonationsSliderDonationGenerator(containerName,options,donationProvider,styles){
    smartDonationsBaseGenerator.call(this,containerName,options,donationProvider,styles);

    this.smartDonationText=options.smartDonationText;
    this.smartDonationsMinValue=options.smartDonationsMinValue;
    this.smartDonationsMaxValue=options.smartDonationsMaxValue;
    this.smartDonationsDefaultValue=options.smartDonationsDefaultValue;
    this.smartDonationIncrementOf=options.smartDonationIncrementOf;
    this.currentValue=options.smartDonationsDefaultValue;
    this.smartDonationAllowedValues=options.smartDonationAllowedValues;

    if(typeof this.styles.SmileStrokeColor=='undefined')
    {
        this.styles.SmileStrokeColor="000000";
        this.styles.SmileFillColor="FFFFFF";
    }

    if(typeof options.smartDonationDonationText=='undefined')
        this.smartDonationDonationText="Current Donation:";
    else
        this.smartDonationDonationText=options.smartDonationDonationText;

}

smartDonationsSliderDonationGenerator.prototype=Object.create(smartDonationsBaseGenerator.prototype);


smartDonationsSliderDonationGenerator.prototype.GenerateDefaultStyle=function()
{
    this.styles.SmileStrokeColor="000000";
    this.styles.SmileFillColor="FFFFFF";
    this.styles.smartDonationsSliderTable="border-style: none;margin: 0;text-align: center;width: auto;margin: auto;";
    this.styles.smartDonationsSliderTd="border-style:none;padding:0;margin:0;"

}

smartDonationsBaseGenerator.prototype.StyleItem=function()
{
    if(this.styles==null)
        return;

    for(var property in this.styles)
    {
        var element=this.GetRootContainer().find("."+property);
        if(property=='ui-slider-range-min')
        {
            var previousWidth=0;
            previousWidth=element.css('width');
            element.attr("style",this.styles[property]);
            element.css('width',previousWidth);
        }else if(property=='ui-slider-handle')
        {
            var previousLeft=0;
            previousLeft=element.css('left');
            element.attr("style",this.styles[property]);
            element.css('left',previousLeft);
        }else
            element.attr("style",this.styles[property]);



    }
}

smartDonationsSliderDonationGenerator.prototype.slide=function(value,minvalue,maxvalue,generator)
{

    generator.currentValue=value;

    generator.GetRootContainer().find('.smartDonationsAmount').text(value);
    generator.ValueUpdated(generator,value);

    value=value-minvalue;

    value=value*0.7/(maxvalue-minvalue);

    generator.printSmile(value +.3);



}

smartDonationsSliderDonationGenerator.prototype.ValueUpdated=function(generator,value){}

smartDonationsSliderDonationGenerator.prototype.printSmile=function(smilePercentage)
{



    this.paper.clear();

    //interpolation
    this.paper.circle(25, 25, 24).attr({stroke:'#'+this.styles.SmileStrokeColor,fill:'#'+this.styles.SmileFillColor});

    this.paper.circle(16, 17, 5).attr({stroke:'#'+this.styles.SmileStrokeColor,fill:'#'+this.styles.SmileFillColor});
    this.paper.circle(34, 17, 5).attr({stroke:'#'+this.styles.SmileStrokeColor,fill:'#'+this.styles.SmileFillColor});

    this.paper.path("M" + this.interpolate(15, 10, smilePercentage) + " "
        + this.interpolate(35, 25, smilePercentage) + ",  C"
        + this.interpolate(15, 15, smilePercentage) + " "
        + this.interpolate(35, 45, smilePercentage) + "  ,  "
        + this.interpolate(35, 35, smilePercentage) + " "
        + this.interpolate(35, 45, smilePercentage) + ",    "
        + this.interpolate(35, 41, smilePercentage) + " "
        + this.interpolate(35, 25, smilePercentage)).attr({stroke:'#'+this.styles.SmileStrokeColor,fill:'#'+this.styles.SmileFillColor});


    // paper.path("M0," + originY + " C" + smileSizeX.toString() + " " +(originY+smileSizeY).toString() + ", " + (100 - smileSizeX).toString() + " " + (originY+ smileSizeY).toString() + ",50 " + originY ).attr({ stroke: "red" });
}

smartDonationsSliderDonationGenerator.prototype.interpolate=function(start,end,smilePercentage) {
    return (start + ((end - start) * smilePercentage)).toString();
}



smartDonationsSliderDonationGenerator.prototype.changed=function() {

    printSmile(document.getElementById("text").value);
}

smartDonationsSliderDonationGenerator.prototype.GenerationCompleted=function()
{
    var generator=this;
    if(this.paper)
        this.paper.clear();


    try
    {
          generator.smartDonationsMaxValue=parseInt(generator.smartDonationsMaxValue);
          generator.smartDonationsMinValue=parseInt(generator.smartDonationsMinValue);
          generator.smartDonationIncrementOf=parseInt(generator.smartDonationIncrementOf);
    }catch(error)
    {
        generator.smartDonationsMaxValue=0;
        generator.smartDonationsMinValue=0;
        generator.smartDonationIncrementOf=1;

    }




    if(generator.smartDonationsMaxValue<=0||generator.smartDonationsMinValue<=0||generator.smartDonationIncrementOf<=0|| generator.smartDonationsMinValue>generator.smartDonationsMaxValue)
        return;






    rnJQuery(function(){
        var smileDiv=generator.GetRootContainer().find(".smartDonationsSmile");
        if(generator.paper)
        {
            generator.paper.clear();
            smileDiv.html('');

        }

        var defaultValue=generator.smartDonationsDefaultValue;
        var minValue=generator.smartDonationsMinValue;
        var maxValue=generator.smartDonationsMaxValue;
        var incrementOf=generator.smartDonationIncrementOf;
        var slideCallback=function(slide,ui){generator.slide(ui.value,minValue,maxValue,generator)};

        if(typeof generator.smartDonationAllowedValues !='undefined' && generator.smartDonationAllowedValues)
        {
            generator.allowedValuesArray=generator.smartDonationAllowedValues.split(',');
            for(var i=0;i<generator.allowedValuesArray.length;i++)
            {
                try
                {
                    generator.allowedValuesArray[i]=parseFloat(generator.allowedValuesArray[i]);
                }catch(exceptin)
                {

                    return;
                }
            }
            if(generator.allowedValuesArray.length>0)
            {
                generator.allowedValuesArray=generator.allowedValuesArray.sort(function(a,b){return a<b?-1:1});

                minValue=0;
                maxValue=generator.allowedValuesArray.length-1;
                incrementOf=1;
                try{
                    defaultValue=parseFloat(defaultValue);
                    defaultValue=generator.allowedValuesArray.indexOf(defaultValue);
                }catch(exception)
                {
                    defaultValue=0;
                }

                if(defaultValue<0)
                    defaultValue=0;
                slideCallback=function(slide,ui){generator.slide( generator.allowedValuesArray[ui.value], generator.allowedValuesArray[0], generator.allowedValuesArray[ generator.allowedValuesArray.length-1],generator)};


            }
        }else
        {
            if(generator.smartDonationsDefaultValue<generator.smartDonationsMinValue)
                generator.smartDonationsDefaultValue= generator.smartDonationsMinValue;

            if(generator.smartDonationsDefaultValue>generator.smartDonationsMaxValue)
                generator.smartDonationsDefaultValue= generator.smartDonationsMaxValue;
        }


        var rootContainer=generator.GetRootContainer().find(".smartDonationsSlide");
        rootContainer.slider({
            range: "min",
            value: defaultValue,
            min: minValue,
            max: maxValue,
            step:incrementOf,
            slide: slideCallback,
            create:function(event,ui)
            {
                rootContainer.find(".ui-slider-range-min").addClass("smartDonationsSliderBar").addClass("smartDonationsEditableItem");
                rootContainer.find(".ui-slider-range-min").addClass("smartDonationsSliderBar");
            }
        });
        generator.StyleItem();
        generator.paper = Raphael(smileDiv[0], 50, 50);


        generator.GetRootContainer().find('.smartDonationsAmount').text(defaultValue);
        generator.slide(defaultValue,minValue,maxValue,generator)
        var ui={};
        ui.value=defaultValue;
        slideCallback(null,ui);
    });




}

smartDonationsSliderDonationGenerator.prototype.GetDonationText=function (){
    return '<span class="smartDonationsSliderText smartDonationsCommentText smartDonationsEditableItem" >'+this.smartDonationText+'</span>';
}


smartDonationsSliderDonationGenerator.prototype.GetButtonTag=function()
{
    var imageToUse;
    if(typeof this.styles=='undefined'||typeof this.styles.smartDonationsDonationButton_src=='undefined')
       imageToUse=this.GetDonationImage(false);
    else
       imageToUse=this.styles.smartDonationsDonationButton_src;

    return  this.donationProvider.GetButton(imageToUse);

}
smartDonationsSliderDonationGenerator.prototype.DonationGeneratedCode=function()
{

        return   this.GetStartOfDonationForm(this.smartDonationsDefaultValue)+
            '<div  class="smartDonationsSlider" > '
                +                     this.GetDonationText()+
                    ' <table class="smartDonationsSliderTable" >\
                    <tr>                            \
                        <td class="smartDonationsSliderTd"><span class="smartDonationsCurrentDonationText smartDonationsEditableItem">'+this.smartDonationDonationText+'</span><strong  class="smartDonationsAmount smartDonationsSliderDonationText smartDonationsEditableItem">10</strong></td>             \
                        <td rowspan="2" class="smartDonationsSliderTd"><div class="smartDonationsSmile smartDonationsSliderSmile smartDonationsEditableItem"></div></td>                   \
                    </tr>                                                                                                                               \
                    <tr>      \
                        <td class="smartDonationsSliderTd"><div class="smartDonationsSlide smartDonationsSliderDiv" ></div></td> \
                        <td class="smartDonationsSliderTd"></td>                                         \
                    </tr> \
                    <tr>\
                        <td class="smartDonationsSliderTd">\
                            '+this.GetButtonTag()+'\
                        </td>\
                    </tr>\
                </table>  \
            </div>'+this.GetEndOfDonationForm();




}

smartDonationsSliderDonationGenerator.prototype.SubmitFired=function(generator)
{
    generator.ChangeAmountToDonate(generator.currentValue);

}






/************************************************************************************* Forms ***************************************************************************************************/





function smartDonationsFormDonationGenerator(containerName,options,donationProvider,styles){
    smartDonationsBaseGenerator.call(this,containerName,options,donationProvider,styles);

    if(options.isNew)
        this.FormElements=options.FormElements;
    else
        this.GenerateFormElements(options.FormElementsOptions);

    if(typeof options.emailToNotify =='undefined')
        this.emailToNotify='';
    else
        this.emailToNotify=options.emailToNotify;
}

smartDonationsFormDonationGenerator.prototype=Object.create(smartDonationsBaseGenerator.prototype);



smartDonationsFormDonationGenerator.prototype.GenerateFormElements=function(formElementsOptions)
{
    this.FormElements=new Array();

    for(var i=0;i<formElementsOptions.length;i++)
    {
        this.FormElements.push(RedNaoCreateFormElementByOptions(formElementsOptions[i],this));
    }
}


smartDonationsFormDonationGenerator.prototype.DonationGeneratedCode=function()
{
    return this.GetStartOfDonationForm()+this.GetEndOfDonationForm(); //'<form id="redNaoElementlist" class="formelements" style="width:600px;"></form>';
}


smartDonationsFormDonationGenerator.prototype.GenerationCompleted=function()
{
    var form=this.GetRootContainer().find('form');
    form.addClass('formelements').attr('id','redNaoElementlist');

    for(var i=0;i<this.FormElements.length;i++)
    {
        this.FormElements[i].AppendElementToContainer(form);
    }

    var me=this;
    form.find('.smartDonationsDonationButton').click(function()
                                                {
                                                    try{
                                                    me.SaveForm();

                                                    }catch(error)
                                                    {


                                                    }finally{
                                                        return false;
                                                    }
                                                }
                                            );



}

smartDonationsFormDonationGenerator.prototype.GenerateDefaultStyle=function()
{
    this.styles.formelements="width:600px;padding:10px;margin:0px;";
}


smartDonationsFormDonationGenerator.prototype.SaveForm=function()
{

    var formValues="";
    var formIsValid=true;
    var amount=0;

    this.GetRootContainer().find('.redNaoValidationMessage').remove();
    this.GetRootContainer().find('.redNaoInputText,.redNaoRealCheckBox,.redNaoInputRadio,.redNaoInputCheckBox,.redNaoSelect,.redNaoTextArea').css('border-color','#ccc');
   for(var i=0;i<this.FormElements.length;i++)
   {

       if((this.FormElements[i].Options.IsRequired==1||this.FormElements[i].Options.IsRequired=='y')&&!this.FormElements[i].IsValid())
       {
           formIsValid=false;
           rnJQuery('#'+this.FormElements[i].Id).find('.redNaoInputText,.redNaoRealCheckBox,.redNaoInputRadio,.redNaoInputCheckBox,.redNaoSelect,.redNaoTextArea').css('border-color','red');
           continue;
       }
       var value=this.FormElements[i].GetValueString();
       amount+=this.FormElements[i].amount;
       formValues+="&"+value;
   }
    if(!formIsValid)
    {
        this.GetRootContainer().prepend('<p class="redNaoValidationMessage" style="margin:0;padding: 0; font-style: italic; color:red;font-family:Arial;font-size:12px;">*Please fill all the required fields</p>')
        return;
    }

    if(this.IsRecurrentPayment(this.GetRootContainer().find('form')))
    {
        if(amount<=0)
        {
            alert('Please set a donation amount before proceeding');
            return;
        }
    }


    if(formValues.length>0)
        formValues=formValues.substr(1);

    var data={
        action:"rednao_smart_donations_save_form_values",
        emailToNotify:this.emailToNotify,
        additionalData:JSON.stringify({anonymousDonation:(this.GetRootContainer().find('.redNaoAnonymousDonation').is(':checked')?'y':'n')}),
        formString:formValues,
        provider:this.donationProvider.Id
    };

    var me=this;


    rnJQuery.post(ajaxurl,data,function(data){me.donationProvider.FormSubmissionCompleted(data,me,amount);},"json");
};



smartDonationsFormDonationGenerator.prototype.TurnFormIntoRecurrentPayment=function(form)
{
    form.find('.amountToDonate').attr('name','a3');
    form.find('.smartDonationsPaypalCommand').val('_xclick-subscriptions');
    form.append('<input type="hidden" name="src" value="1"><input type="hidden" name="p3" value="1"><input type="hidden" name="t3" value="'+form.find('.redNaoRecurrence').find(':selected').val()+'">');
}

smartDonationsFormDonationGenerator.prototype.IsRecurrentPayment=function(form)
{
    return form.find('.redNaoRecurrence').length>0&&form.find('.redNaoRecurrence').find(':selected').val()!='OT';
}

smartDonationsFormDonationGenerator.prototype.GetOptions=function()
{
    var options=new Object();
    options.FormElementsOptions=new Array();

    for(var i=0;i<this.FormElements.length;i++)
    {
        options.FormElementsOptions.push(this.FormElements[i].Options);
    }

    return options;

}
