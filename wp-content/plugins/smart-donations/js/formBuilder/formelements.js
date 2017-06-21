"use strict";

function RedNaoFormElementEscape(property)
{
    return property.replace(' ','_');
}

function RedNaoCreateFormElementByName(elementName,options,generator)
{
    if(elementName=='rednaotextinput')
        return new TextInputElement(options,generator);
    if(elementName=='rednaodonationamount')
        return new DonationAmountElement(options,generator);
    if(elementName=='rednaoprependedtext')
        return new PrependTexElement(options,generator);
    if(elementName=='rednaoappendedtext')
        return new AppendedTexElement(options,generator);
    if(elementName=='rednaoprependedcheckbox')
        return new PrependCheckBoxElement(options,generator);
    if(elementName=='rednaoappendedcheckbox')
        return new AppendCheckBoxElement(options,generator);
    if(elementName=='rednaobuttondropdown')
        return 'rednaobuttondropdown';
    if(elementName=='tabradioscheckboxes')
        return 'tabradioscheckboxes';
    if(elementName=='rednaomultiplecheckboxes')
        return new MultipleCheckBoxElement(options,generator);
    if(elementName=='rednaoinlinecheckboxes')
        return new InlineCheckboxElement(options,generator);
    if(elementName=='rednaoselectbasic')
        return new SelectBasicElement(options,generator);
    if(elementName=='rednaoselectmultiple')
        return new SelectMultipleElement(options,generator);
    if(elementName=='rednaofilebutton')
        return 'rednaofilebutton';
    if(elementName=='rednaosinglebutton')
        return 'rednaosinglebutton';
    if(elementName=='rednaodoublebutton')
        return 'rednaodoublebutton';
    if(elementName=='rednaotitle')
        return new TitleElement(options,generator);
    if(elementName=='rednaotextarea')
        return  new TextAreaElement(options,generator);
    if(elementName=='rednaomultipleradios')
        return new MultipleRadioElement(options,generator);
    if(elementName=='rednaoinlineradios')
        return new InlineRadioElement(options,generator);
    if(elementName=='rednaodonationbutton')
        return new DonationButtonElement(options,generator);
    if(elementName=='rednaodonationrecurrence')
        return new RecurrenceElement(options,generator);
    if(elementName=='rednaoanonymousdonation')
        return new AnonymousDonation(options,generator);

}



function RedNaoCreateFormElementByOptions(options,generator)
{
    var element=RedNaoCreateFormElementByName(options.ClassName,options,generator);
    return element;

}

/************************************************************************************* Base Class  ***************************************************************************************************/
function FormElementBase(options,generator)
{
    if(options==null)
    {
        this.Options=new Object();
        this.Options.Styles=new Object();
        this.Options.ClassName="";
        this.Options.IsRequired='n';
        this.Options.Styles.rednao_control_label='float: left;width: 160px;padding-top: 5px;text-align: right;'
        this.Options.Styles.redNaoControls="margin-left:180px;text-align:left;"
        this.Options.Styles.redNaoHelp="margin:0px;padding:0px;text-align:left;"
        this.IsNew=true;
        this.GenerateDefaultStyle();
    }
    else
    {
        this.IsNew=false;
        if(typeof options.IsRequired=='undefined')
            options.IsRequired='n';
        this.Options=options;

    }
    FormElementBase.IdCounter++;
    this.generator=generator;
    this.Id='redNaoFormElement'+FormElementBase.IdCounter;
    this.Properties=null;
    this.amount=0;





}

FormElementBase.IdCounter=0;


FormElementBase.prototype.GenerateDefaultStyle=function()
{
}


FormElementBase.prototype.GenerateHtml=function(jqueryElement)
{
    jqueryElement.replaceWith( '<div class="rednao-control-group '+this.Options.ClassName+'" id="'+this.Id+'" style="margin-bottom:15px;clear:both;">'+this.GenerateInlineElement()+'</div>');
    this.ApplyStyle();
    this.GenerationCompleted();

}

FormElementBase.prototype.AppendElementToContainer=function(jqueryElement)
{
    jqueryElement.append( '<div class="rednao-control-group '+this.Options.ClassName+'" id="'+this.Id+'" style="margin-bottom:15px;">'+this.GenerateInlineElement()+'</div>');
    this.ApplyStyle();
    this.GenerationCompleted();

}

FormElementBase.prototype.CreateProperties=function()
{
    throw 'Abstract method';
}

FormElementBase.prototype.GenerateInlineElement=function()
{
    throw 'Abstract method';
}

FormElementBase.prototype.GetProperties=function()
{
    if(this.Properties==null)
    {
        this.Properties=new Array();
        this.CreateProperties();
    }

    return this.Properties;
}


FormElementBase.prototype.UpdateProperties=function()
{
    if(this.Properties!=null)
    {
        for(var i=0;i<this.Properties.length;i++)
        {
            this.Properties[i].UpdateProperty();
        }
    }
}

FormElementBase.prototype.GetPropertyName=function()
{
    return RedNaoFormElementEscape(this.Options.Label);
}



FormElementBase.prototype.ApplyStyle=function()
{
    if(this.Options.Styles==null)
        return;

    for(var property in this.Options.Styles)
    {

        rnJQuery('#'+this.Id + ' .'+property).attr("style",this.Options.Styles[property]);
    }
}


FormElementBase.prototype.GeneratePropertiesHtml=function(jQueryObject)
{
    var properties=this.GetProperties();
    for(var i=0;i<properties.length;i++)
    {
        properties[i].CreateProperty(jQueryObject);
    }
}


FormElementBase.prototype.GetValueString=function()
{

}

FormElementBase.prototype.GenerationCompleted=function()
{

}

FormElementBase.prototype.IsValid=function()
{
    return true;
}

/************************************************************************************* Title Element ***************************************************************************************************/

function TitleElement(options,generator)
{
    FormElementBase.call(this,options,generator);



    this.Title="Title";

    if(this.IsNew)
    {
        this.Options.ClassName="rednaotitle";
        this.Options.Title="Title";
    }
}

TitleElement.prototype=Object.create(FormElementBase.prototype);

TitleElement.prototype.CreateProperties=function()
{
    this.Properties.push(new SimpleTextProperty(this.Options,"Title","Title",'basic'));
}

TitleElement.prototype.GenerateInlineElement=function()
{
    return '<legend class="redNaoLegend">'+this.Options.Title+'</legend>';
}


TitleElement.prototype.GenerateDefaultStyle=function()
{
    this.Options.Styles.redNaoLegend='margin:0px;padding:0px;text-align:left;font-size:21px;line-height:40px;color:#333;border:0;border-bottom: 1px solid #e5e5e5;width:100%;';
}

TitleElement.prototype.GetValueString=function()
{
    return '';

}



/************************************************************************************* Text Element ***************************************************************************************************/

function TextInputElement(options,generator)
{
    FormElementBase.call(this,options,generator);
    this.Title="Text Input";
    if(this.IsNew)
    {
        this.Options.ClassName="rednaotextinput";
        this.Options.Label="Text Input";
        this.Options.Placeholder="Placeholder";
        this.Options.Help="Help";
    }





}

TextInputElement.prototype=Object.create(FormElementBase.prototype);

TextInputElement.prototype.CreateProperties=function()
{
    this.Properties.push(new SimpleTextProperty(this.Options,"Label","Label",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options,"Placeholder","Placeholder",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options,"Help","Help",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options.Styles,"width","Width",{type:'style',"class":'redNaoInputText'}));
    this.Properties.push(new CheckBoxProperty(this.Options,"IsRequired","Required",'basic'));

}

TextInputElement.prototype.GenerateInlineElement=function()
{

    return '<label class="rednao_control_label" >'+this.Options.Label+'</label>\
                <div class="redNaoControls">\
                    <input  name="'+this.GetPropertyName()+'" type="text" placeholder="'+this.Options.Placeholder+'" class="redNaoInputText">'+
                    (this.Options.Help?' <p class="redNaoHelp">'+this.Options.Help+'</p>':'')+
                '</div>';
}

TextInputElement.prototype.GenerateDefaultStyle=function()
{
    this.Options.Styles.redNaoInputText='height:20px;width:300px;margin:0;vertical-align:middle;background-color: #fff;border: 1px solid #ccc;-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);-webkit-transition: border linear .2s, box-shadow linear .2s;-moz-transition: border linear .2s, box-shadow linear .2s;-o-transition: border linear .2s, box-shadow linear .2s;transition: border linear .2s, box-shadow linear .2s;padding: 4px 6px;line-height: 20px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;';

}


TextInputElement.prototype.GetValueString=function()
{
    return  encodeURI(this.Options.Label)+"="+encodeURI(rnJQuery('#'+this.Id+ ' .redNaoInputText').val());
}


TextInputElement.prototype.IsValid=function()
{
    return rnJQuery('#'+this.Id+ ' .redNaoInputText').val()!="";
}
/************************************************************************************* Donation Amount ***************************************************************************************************/

function DonationAmountElement(options,generator)
{
    FormElementBase.call(this,options,generator);
    this.Title="Donation Amount";

    if(this.IsNew)
    {
        this.Options.ClassName="rednaodonationamount";
        this.Options.Label="Donation Amount";
        this.Options.Placeholder="Amount";
        this.Options.Help="Help";
        this.Options.DefaultValue=0;
        this.Options.Disabled='n';
    }

    if(typeof  this.Options.DefaultValue=='undefined')
        this.Options.DefaultValue=0;





}

DonationAmountElement.prototype=Object.create(FormElementBase.prototype);

DonationAmountElement.prototype.CreateProperties=function()
{
    this.Properties.push(new SimpleTextProperty(this.Options,"Label","Label",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options,"DefaultValue","Default Value",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options,"Help","Help",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options.Styles,"width","Width",{type:'style',"class":'redNaoInputText'}));
    this.Properties.push(new CheckBoxProperty(this.Options,"IsRequired","Required",'basic'));
    this.Properties.push(new CheckBoxProperty(this.Options,"Disabled","Read Only",'basic'));



}

DonationAmountElement.prototype.GenerateInlineElement=function()
{

    return '<label class="rednao_control_label" >'+this.Options.Label+'</label>\
                <div class="redNaoControls">\
                    <input   type="text" placeholder="'+this.Options.Placeholder+'" class="redNaoInputText" value="'+this.Options.DefaultValue+'"  >'+
        (this.Options.Help?' <p class="redNaoHelp">'+this.Options.Help+'</p>':'')+
        '</div>';
}

DonationAmountElement.prototype.GenerateDefaultStyle=function()
{

    this.Options.Styles.redNaoInputText='text-align:right;height:20px;width:50px;margin:0;vertical-align:middle;background-color: #fff;border: 1px solid #ccc;-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);-webkit-transition: border linear .2s, box-shadow linear .2s;-moz-transition: border linear .2s, box-shadow linear .2s;-o-transition: border linear .2s, box-shadow linear .2s;transition: border linear .2s, box-shadow linear .2s;padding: 4px 6px;line-height: 20px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;';

}

DonationAmountElement.prototype.GetValueString=function()
{
    try
    {
        this.amount=parseFloat(rnJQuery('#'+this.Id+ ' .redNaoInputText').val());
    }catch(exception)
    {

    }

    return  encodeURI(this.Options.Label)+"="+encodeURI(rnJQuery('#'+this.Id+ ' .redNaoInputText').val());
}

DonationAmountElement.prototype.GenerationCompleted=function()
{
    if(this.Options.Disabled=='y')
    {
        rnJQuery('#'+this.Id).find('.redNaoInputText').attr('readonly','readonly').css('background-color','#eeeeee');
    }
}

DonationAmountElement.prototype.IsValid=function()
{
    try{
        var number=parseFloat(rnJQuery('#'+this.Id+ ' .redNaoInputText').val());
        return number>0;
    }catch(exception)
    {
        return false;
    }
}

/************************************************************************************* Prepend Text Element ***************************************************************************************************/

function PrependTexElement(options,generator)
{
    FormElementBase.call(this,options,generator);
    this.Title="Prepend Text";

    if(this.IsNew)
    {
        this.Options.Label="Prepend Text";
        this.Options.ClassName="rednaoprependedtext";
        this.Options.Placeholder="Placeholder";
        this.Options.Help="Help";
        this.Options.Prepend="Prepend";
    }



}

PrependTexElement.prototype=Object.create(FormElementBase.prototype);

PrependTexElement.prototype.CreateProperties=function()
{
    this.Properties.push(new SimpleTextProperty(this.Options,"Label","Label",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options,"Prepend","Prepend",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options,"Placeholder","Placeholder",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options,"Help","Help",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options.Styles,"width","Width",{type:'style',"class":'redNaoInputText'}));
    this.Properties.push(new CheckBoxProperty(this.Options,"IsRequired","Required",'basic'));

}

PrependTexElement.prototype.GenerateInlineElement=function()
{

    return '<label class="rednao_control_label" for="prependedtext">'+this.Options.Label+'</label>\
            <div class="redNaoControls">\
               <div class="rednao-input-prepend">\
                    <span class="redNaoPrepend">'+this.Options.Prepend+'</span>\
                    <input id="prependedtext" name="prependedtext" class="redNaoInputText" placeholder="'+this.Options.Placeholder+'" type="text">\
                </div>\
            <p class="redNaoHelp">'+this.Options.Help+'</p>\
            </div>';
}

PrependTexElement.prototype.GenerateDefaultStyle=function()
{
    this.Options.Styles.redNaoInputText='height:20px;width:250px;margin:0;vertical-align:middle;background-color: #fff;border: 1px solid #ccc;-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);-webkit-transition: border linear .2s, box-shadow linear .2s;-moz-transition: border linear .2s, box-shadow linear .2s;-o-transition: border linear .2s, box-shadow linear .2s;transition: border linear .2s, box-shadow linear .2s;padding: 4px 6px;line-height: 20px;-webkit-border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;border-radius: 0 4px 4px 0;';
    this.Options.Styles.redNaoPrepend='margin-right: -5px;vertical-align: top;display: inline-block;width: auto;height: 20px;min-width: 16px;padding: 4px 5px;font-size: 14px;font-weight: normal;line-height: 20px;text-align: center;    text-shadow: 0 1px 0 #fff;background-color: #eee;border: 1px solid #ccc;-webkit-border-radius: 4px 0 0 4px;-moz-border-radius: 4px 0 0 4px;border-radius: 4px 0 0 4px;';
}



PrependTexElement.prototype.GetValueString=function()
{
    return  encodeURI(this.Options.Label)+"="+encodeURI(rnJQuery('#'+this.Id+ ' .redNaoInputText').val());
}


PrependTexElement.prototype.IsValid=function()
{
    return rnJQuery('#'+this.Id+ ' .redNaoInputText').val()!="";
}

/************************************************************************************* Appended Text Element ***************************************************************************************************/

function AppendedTexElement(options,generator)
{
    FormElementBase.call(this,options,generator);
    this.Title="Appended Text";

    if(this.IsNew)
    {
        this.Options.Label="Appended Text";
        this.Options.ClassName="rednaoappendedtext";
        this.Options.Placeholder="Placeholder";
        this.Options.Help="Help";
        this.Options.Append="Append";
    }




}

AppendedTexElement.prototype=Object.create(FormElementBase.prototype);

AppendedTexElement.prototype.CreateProperties=function()
{
    this.Properties.push(new SimpleTextProperty(this.Options,"Label","Label",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options,"Append","Append",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options,"Placeholder","Placeholder",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options,"Help","Help",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options.Styles,"width","Width",{type:'style',"class":'redNaoInputText'}));
    this.Properties.push(new CheckBoxProperty(this.Options,"IsRequired","Required",'basic'));

}

AppendedTexElement.prototype.GenerateInlineElement=function()
{
    return '<label class="rednao_control_label" for="appendedtext">'+this.Options.Label+'</label>\
            <div class="redNaoControls">\
                <div class="rednao-input-append">\
                    <input id="appendedtext" name="appendedtext"  placeholder="'+this.Options.Placeholder+'" type="text" class="redNaoInputText">\
                    <span class="redNaoAppend">'+this.Options.Append+'</span>\
                </div>\
                <p class="redNaoHelp">'+this.Options.Help+'</p>\
            </div>';


}

AppendedTexElement.prototype.GenerateDefaultStyle=function()
{
    this.Options.Styles.redNaoInputText='height:20px;width:250px;margin:0;vertical-align:middle;background-color: #fff;border: 1px solid #ccc;-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);-webkit-transition: border linear .2s, box-shadow linear .2s;-moz-transition: border linear .2s, box-shadow linear .2s;-o-transition: border linear .2s, box-shadow linear .2s;transition: border linear .2s, box-shadow linear .2s;padding: 4px 6px;line-height: 20px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;';
    this.Options.Styles.redNaoAppend='-webkit-border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;border-radius: 0 4px 4px 0;margin-left: -6px;vertical-align: top;display: inline-block;width: auto;height: 20px;min-width: 16px;padding: 4px 5px;font-size: 14px;font-weight: normal;line-height: 20px;text-align: center;text-shadow: 0 1px 0 #fff;background-color: #eee;border: 1px solid #ccc;';
}




AppendedTexElement.prototype.GetValueString=function()
{
    return  encodeURI(this.Options.Label)+"="+encodeURI(rnJQuery('#'+this.Id+ ' .redNaoInputText').val());
}

AppendedTexElement.prototype.IsValid=function()
{
    return rnJQuery('#'+this.Id+ ' .redNaoInputText').val()!="";
}
/************************************************************************************* Prepend Checkbox Element ***************************************************************************************************/

function PrependCheckBoxElement(options,generator)
{
    FormElementBase.call(this,options,generator);
    this.Title="Prepend Checkbox";

    if(this.IsNew)
    {
        this.Options.Label="Prepend Checkbox";
        this.Options.ClassName="rednaoprependedcheckbox";
        this.Options.Placeholder="Placeholder";
        this.Options.Help="Help";
        this.Options.IsChecked='n';
    }


}

PrependCheckBoxElement.prototype=Object.create(FormElementBase.prototype);

PrependCheckBoxElement.prototype.CreateProperties=function()
{
    this.Properties.push(new SimpleTextProperty(this.Options,"Label","Label",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options,"Placeholder","Placeholder",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options,"Help","Help",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options.Styles,"width","Width",{type:'style',"class":'redNaoInputText'}));
    this.Properties.push(new CheckBoxProperty(this.Options,"IsChecked","Is Checked",'basic'));
    this.Properties.push(new CheckBoxProperty(this.Options,"IsRequired","Required",'basic'));

}

PrependCheckBoxElement.prototype.GenerateInlineElement=function()
{
    return '<label class="rednao_control_label" for="prependedcheckbox">'+this.Options.Label+'</label>\
                <div class="redNaoControls">\
                    <div class="input-prepend">\
                    <span class="redNaoPrepend">\
                        <label class="rednao_checkbox">\
                            <input type="checkbox" class="redNaoRealCheckBox"  '+(this.Options.IsChecked=='y'? 'checked="checked"':'')+'/>\
                        </label>\
                    </span>\
                    <input id="prependedcheckbox" name="prependedcheckbox"  class="redNaoInputText" type="text" placeholder="'+this.Options.Placeholder+'"/>\
                    </div>\
                    <p class="redNaoHelp">'+this.Options.Help+'</p>\
                </div>';


}

PrependCheckBoxElement.prototype.GenerateDefaultStyle=function()
{
    this.Options.Styles.redNaoInputText='height:20px;width:300px;margin:0;vertical-align:middle;background-color: #fff;border: 1px solid #ccc;-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);-webkit-transition: border linear .2s, box-shadow linear .2s;-moz-transition: border linear .2s, box-shadow linear .2s;-o-transition: border linear .2s, box-shadow linear .2s;transition: border linear .2s, box-shadow linear .2s;padding: 4px 6px;line-height: 20px;-webkit-border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;border-radius: 0 4px 4px 0;';
    this.Options.Styles.redNaoPrepend='margin-right: -4px;vertical-align: top;display: inline-block;width: auto;height: 20px;min-width: 16px;padding: 4px 5px;font-size: 14px;font-weight: normal;line-height: 20px;text-align: center;    text-shadow: 0 1px 0 #fff;background-color: #eee;border: 1px solid #ccc;-webkit-border-radius: 4px 0 0 4px;-moz-border-radius: 4px 0 0 4px;border-radius: 4px 0 0 4px;font-size:0px;';
    this.Options.Styles.redNaoRealCheckBox="vertical-align:baseline;";
}



PrependCheckBoxElement.prototype.GetValueString=function()
{
    return  encodeURI(this.Options.Label)+"="+(rnJQuery('#'+this.Id+ ' .redNaoRealCheckBox').is(':checked')?'Yes':'No')+'. '+encodeURI(rnJQuery('#'+this.Id+ ' .redNaoInputText').val()) ;
}


PrependCheckBoxElement.prototype.IsValid=function()
{
    return rnJQuery('#'+this.Id+ ' .redNaoInputText').val()!="";
}
/************************************************************************************* Append Checkbox Element ***************************************************************************************************/

function AppendCheckBoxElement(options,generator)
{
    FormElementBase.call(this,options,generator);
    this.Title="Append Checkbox";

    if(this.IsNew)
    {
        this.Options.Label="Append Checkbox";
        this.Options.ClassName="rednaoappendedcheckbox";
        this.Options.Placeholder="Placeholder";
        this.Options.Help="Help";
        this.Options.IsChecked='n';
    }


}

AppendCheckBoxElement.prototype=Object.create(FormElementBase.prototype);

AppendCheckBoxElement.prototype.CreateProperties=function()
{
    this.Properties.push(new SimpleTextProperty(this.Options,"Label","Label",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options,"Placeholder","Placeholder",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options,"Help","Help",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options.Styles,"width","Width",{type:'style',"class":'redNaoInputText'}));
    this.Properties.push(new CheckBoxProperty(this.Options,"IsChecked","Is Checked",'basic'));
    this.Properties.push(new CheckBoxProperty(this.Options,"IsRequired","Required",'basic'));

}

AppendCheckBoxElement.prototype.GenerateInlineElement=function()
{
    return '<label class="rednao_control_label" for="appendedcheckbox">'+this.Options.Label+'</label>\
            <div class="redNaoControls">\
                <div class="rednao-input-append">\
                    <input id="appendedcheckbox" class="redNaoInputText" name="appendedcheckbox" class="span2" type="text" placeholder="'+this.Options.Placeholder+'"/>\
                        <span class="redNaoAppend">\
                            <input type="checkbox" class="redNaoRealCheckBox"   '+(this.Options.IsChecked=='y'? 'checked="checked"':'')+'/>\
                        </span>\
                </div>\
                <p class="redNaoHelp">'+this.Options.Help+'</p>\
            </div>';


}

AppendCheckBoxElement.prototype.GenerateDefaultStyle=function()
{
    this.Options.Styles.redNaoInputText='height:20px;width:300px;margin:0;vertical-align:middle;background-color: #fff;border: 1px solid #ccc;-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);-webkit-transition: border linear .2s, box-shadow linear .2s;-moz-transition: border linear .2s, box-shadow linear .2s;-o-transition: border linear .2s, box-shadow linear .2s;transition: border linear .2s, box-shadow linear .2s;padding: 4px 6px;line-height: 20px;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;';
    this.Options.Styles.redNaoAppend='-webkit-border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;border-radius: 0 4px 4px 0;margin-left: -6px;vertical-align: top;display: inline-block;width: auto;height: 20px;min-width: 16px;padding: 4px 5px;font-size: 14px;font-weight: normal;line-height: 20px;text-align: center;text-shadow: 0 1px 0 #fff;background-color: #eee;border: 1px solid #ccc;font-size:0px;';
    this.Options.Styles.redNaoRealCheckBox="vertical-align:baseline";
}


AppendCheckBoxElement.prototype.GetValueString=function()
{
    return  encodeURI(this.Options.Label)+"="+(rnJQuery('#'+this.Id+ ' .redNaoRealCheckBox').is(':checked')?'Yes':'No')+'. '+encodeURI(rnJQuery('#'+this.Id+ ' .redNaoInputText').val());
}


AppendCheckBoxElement.prototype.IsValid=function()
{
    return rnJQuery('#'+this.Id+ ' .redNaoInputText').val()!="";
}
/************************************************************************************* Text Area Element ***************************************************************************************************/

function TextAreaElement(options,generator)
{
    FormElementBase.call(this,options,generator);
    this.Title="Text Area";

    if(this.IsNew)
    {
        this.Options.Label="Text Area";
        this.Options.DefaultText="";
        this.Options.ClassName="rednaotextarea";
        this.Options.PlaceHolder="Placeholder";
    }else
    {
        if(typeof this.Options.PlaceHolder=='undefined')
            this.Options.PlaceHolder='';
    }




}

TextAreaElement.prototype=Object.create(FormElementBase.prototype);

TextAreaElement.prototype.CreateProperties=function()
{
    this.Properties.push(new SimpleTextProperty(this.Options,"Label","Label",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options,"DefaultText","Default Text",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options,"PlaceHolder","PlaceHolder",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options.Styles,"width","Width",{type:'style',"class":'redNaoTextArea'}));
    this.Properties.push(new SimpleTextProperty(this.Options.Styles,"height","Height",{type:'style',"class":'redNaoTextArea'}));
    this.Properties.push(new CheckBoxProperty(this.Options,"IsRequired","Required",'basic'));


}

TextAreaElement.prototype.GenerateInlineElement=function()
{

    return  '<label class="rednao_control_label" for="textarea">'+this.Options.Label+'</label>\
                <div class="redNaoControls">\
                <textarea  name="textarea" class="redNaoTextArea" placeholder="'+this.Options.PlaceHolder+'">'+this.Options.DefaultText+'</textarea>\
            </div>';
}

TextAreaElement.prototype.GenerateDefaultStyle=function()
{
    this.Options.Styles.redNaoTextArea='width:300px;height:50px;background-color: #fff;border: 1px solid #ccc;-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);-webkit-transition: border linear .2s, box-shadow linear .2s;-moz-transition: border linear .2s, box-shadow linear .2s;-o-transition: border linear .2s, box-shadow linear .2s;transition: border linear .2s, box-shadow linear .2s;padding: 4px 6px;';
}

TextAreaElement.prototype.GetValueString=function()
{
    return  encodeURI(this.Options.Label)+"="+encodeURI(rnJQuery('#'+this.Id+ ' .redNaoTextArea').val());
}


TextAreaElement.prototype.IsValid=function()
{
    return rnJQuery('#'+this.Id+ ' .redNaoTextArea').val()!=this.Options.DefaultText;
}

/*************************************************************************************Multiple Radio Element ***************************************************************************************************/

function MultipleRadioElement(options,generator)
{
    FormElementBase.call(this,options,generator);
    this.Title="Multiple Radio";

    if(this.IsNew)
    {
        this.Options.Label="Multiple Radio";
        this.Options.ClassName="rednaomultipleradios";
        this.Options.Options=new Array({label:'Option 1(10$)',amount:10},{label:'Option 2(20$)',amount:20},{label:'Option 3(30$)',amount:30});
    }else
    {
        if(this.Options.Options.length>0&&typeof this.Options.Options[i]=='string')
        {
            var aux=new Array();
            for(var i=0;i<this.Options.Options.length;i++)
            {
                aux.push({label:this.Options.Options[i],amount:0});
            }

            this.Options.Options=aux;
        }
    }


}

MultipleRadioElement.prototype=Object.create(FormElementBase.prototype);

MultipleRadioElement.prototype.CreateProperties=function()
{
    this.Properties.push(new SimpleTextProperty(this.Options,"Label","Label",'basic'));
    this.Properties.push(new ArrayProperty(this.Options,"Options","Options",'basic'));
    this.Properties.push(new CheckBoxProperty(this.Options,"IsRequired","Required",'basic'));



}

MultipleRadioElement.prototype.GenerateInlineElement=function()
{

    var html=  '<label class="rednao_control_label">'+this.Options.Label+'</label>\
        <div class="redNaoControls">';

    var checked='checked="checked"';
    for(var i=0;i<this.Options.Options.length;i++)
    {
        html+='<label class="redNaoRadio" for="radios-0">\
                    <input class="redNaoRadio redNaoInputRadio" type="radio" name="'+this.GetPropertyName()+'"  value="'+this.Options.Options[i].amount+'" '+checked+'>'+rnJQuery.trim(this.Options.Options[i].label)+'</input>\
                </label>';

        checked="";

    }

        html+='</div>';
    return html;
}


MultipleRadioElement.prototype.GenerateDefaultStyle=function()
{
    this.Options.Styles.redNaoRadio='padding-top:5px;padding-left: 20px;display: block;line-height: 18px';
    this.Options.Styles.redNaoInputRadio='float: left;margin-left: -20px;width:auto;'
}


MultipleRadioElement.prototype.GetValueString=function()
{
    var jQueryElement=rnJQuery('#'+this.Id+ ' .redNaoInputRadio:checked');
    if(jQueryElement.length>0)
        this.amount=parseFloat(jQueryElement.val());
    return  encodeURI(this.Options.Label)+"="+encodeURI(rnJQuery.trim(jQueryElement.parent().text()));
}


MultipleRadioElement.prototype.IsValid=function()
{
    return rnJQuery('#'+this.Id+ ' .redNaoInputRadio:checked').length>0;
}
/*************************************************************************************Inline Radio Element ***************************************************************************************************/

function InlineRadioElement(options,generator)
{
    FormElementBase.call(this,options,generator);
    this.Title="Inline Radio";

    if(this.IsNew)
    {
        this.Options.Label="Inline Radio";
        this.Options.ClassName="rednaoinlineradios";
        this.Options.Options=new Array({label:'Option 1(10$)',amount:10},{label:'Option 2(20$)',amount:20},{label:'Option 3(30$)',amount:30});
    }else
    {
        if(this.Options.Options.length>0&&typeof this.Options.Options[i]=='string')
        {
            var aux=new Array();
            for(var i=0;i<this.Options.Options.length;i++)
            {
                aux.push({label:this.Options.Options[i],amount:0});
            }

            this.Options.Options=aux;
        }
    }


}

InlineRadioElement.prototype=Object.create(FormElementBase.prototype);

InlineRadioElement.prototype.CreateProperties=function()
{
    this.Properties.push(new SimpleTextProperty(this.Options,"Label","Label",'basic'));
    this.Properties.push(new ArrayProperty(this.Options,"Options","Options",'basic'));
    this.Properties.push(new CheckBoxProperty(this.Options,"IsRequired","Required",'basic'));



}

InlineRadioElement.prototype.GenerateInlineElement=function()
{

    var html=  '<label class="rednao_control_label">'+this.Options.Label+'</label>\
        <div class="redNaoControls">';

    var checked='checked="checked"';
    for(var i=0;i<this.Options.Options.length;i++)
    {
        html+='<label class="redNaoRadio" >\
                    <input class="redNaoInputRadio" type="radio" name="'+this.GetPropertyName()+'"  value="'+this.Options.Options[i].amount+'" '+checked+'/>'+this.Options.Options[i].label+'\
                </label>';

        checked="";

    }

    html+='</div>';
    return html;
}

InlineRadioElement.prototype.GenerateDefaultStyle=function()
{
    this.Options.Styles.redNaoRadio='padding-top:5px;display:inline-block;padding-right:20px;';
    this.Options.Styles.redNaoInputRadio='float:left;padding-right:20px;margin-right:5px;';
}


InlineRadioElement.prototype.GetValueString=function()
{
    var jQueryElement=rnJQuery('#'+this.Id+ ' .redNaoInputRadio:checked');
    if(jQueryElement.length>0)
        this.amount=parseFloat(jQueryElement.val());
    return  encodeURI(this.Options.Label)+"="+encodeURI(rnJQuery.trim(jQueryElement.parent().text()));
}

InlineRadioElement.prototype.IsValid=function()
{
    return rnJQuery('#'+this.Id+ ' .redNaoInputRadio:checked').length>0;
}

/*************************************************************************************Multiple Checkbox Element ***************************************************************************************************/

function MultipleCheckBoxElement(options,generator)
{
    FormElementBase.call(this,options,generator);
    this.Title="Multiple Checkboxes";

    if(this.IsNew)
    {
        this.Options.Label="Multiple Checkbox";
        this.Options.ClassName="rednaomultiplecheckboxes";
        this.Options.Options=new Array({label:'Check 1(10$)',amount:10},{label:'Check 2(20$)',amount:20},{label:'Check 3(30$)',amount:30});
    }else
    {
        if(this.Options.Options.length>0&&typeof this.Options.Options[i]=='string')
        {
            var aux=new Array();
            for(var i=0;i<this.Options.Options.length;i++)
            {
                aux.push({label:this.Options.Options[i],amount:0});
            }

            this.Options.Options=aux;
        }
    }


}

MultipleCheckBoxElement.prototype=Object.create(FormElementBase.prototype);

MultipleCheckBoxElement.prototype.CreateProperties=function()
{
    this.Properties.push(new SimpleTextProperty(this.Options,"Label","Label",'basic'));
    this.Properties.push(new ArrayProperty(this.Options,"Options","Options",'basic'));
    this.Properties.push(new CheckBoxProperty(this.Options,"IsRequired","Required",'basic'));


}

MultipleCheckBoxElement.prototype.GenerateInlineElement=function()
{

    var html=  '<label class="rednao_control_label">'+this.Options.Label+'</label>\
        <div class="redNaoControls">';

    var checked='checked=checked';
    for(var i=0;i<this.Options.Options.length;i++)
    {
        html+='<label class="redNaoCheckBox" for="radios-0">\
                    <input type="checkbox" class="redNaoInputCheckBox" name="'+this.GetPropertyName()+'"  value="'+this.Options.Options[i].amount+'" '+checked+'/>'+this.Options.Options[i].label+'\
                </label>';

        checked="";

    }

    html+='</div>';
    return html;
}



MultipleCheckBoxElement.prototype.GenerateDefaultStyle=function()
{
    this.Options.Styles.redNaoCheckBox='padding-top:5px;padding-left: 20px;display: block;line-height: 18px';
    this.Options.Styles.redNaoInputCheckBox='float: left;margin-left: -20px;width:auto;'
}



MultipleCheckBoxElement.prototype.GetValueString=function()
{
    var valueString="";
    var me=this;
    this.amount=0;
    rnJQuery('#'+this.Id+ ' .redNaoInputCheckBox:checked').each(function()
    {
        me.amount+=parseFloat(rnJQuery(this).val());
        valueString+=','+encodeURI(rnJQuery.trim(rnJQuery(this).parent().text()));
    })
    if(valueString.length>0)
        return encodeURI(me.Options.Label)+'='+valueString.substring(1);
    return '';

}


MultipleCheckBoxElement.prototype.IsValid=function()
{
    return rnJQuery('#'+this.Id+ ' .redNaoInputCheckBox:checked').length>0;
}

/*************************************************************************************Inline Checkbox Element ***************************************************************************************************/

function InlineCheckboxElement(options,generator)
{
    FormElementBase.call(this,options,generator);
    this.Title="Inline Checkboxes";

    if(this.IsNew)
    {
        this.Options.Label="Inline Checkbox";
        this.Options.ClassName="rednaoinlinecheckboxes";
        this.Options.Options=new Array({label:'Option 1(10$)',amount:10},{label:'Option 2(20$)',amount:20},{label:'Option 3(30$)',amount:30});
    }else
    {
        if(this.Options.Options.length>0&&typeof this.Options.Options[i]=='string')
        {
            var aux=new Array();
            for(var i=0;i<this.Options.Options.length;i++)
            {
                aux.push({label:this.Options.Options[i],amount:0});
            }

            this.Options.Options=aux;
        }
    }


}

InlineCheckboxElement.prototype=Object.create(FormElementBase.prototype);

InlineCheckboxElement.prototype.CreateProperties=function()
{
    this.Properties.push(new SimpleTextProperty(this.Options,"Label","Label",'basic'));
    this.Properties.push(new ArrayProperty(this.Options,"Options","Options",'basic'));
    this.Properties.push(new CheckBoxProperty(this.Options,"IsRequired","Required",'basic'));
}

InlineCheckboxElement.prototype.GenerateInlineElement=function()
{

    var html=  '<label class="rednao_control_label">'+this.Options.Label+'</label>\
        <div class="redNaoControls">';

    var checked='checked=checked';
    for(var i=0;i<this.Options.Options.length;i++)
    {
        html+='<label class="redNaoCheckBox" >\
                    <input  class="redNaoInputCheckBox" type="checkbox" name="'+this.GetPropertyName()+'"  value="'+this.Options.Options[i].amount+'" '+checked+'/>'+this.Options.Options[i].label+'\
                </label>';

        checked="";

    }

    html+='</div>';
    return html;
}


InlineCheckboxElement.prototype.GenerateDefaultStyle=function()
{
    this.Options.Styles.redNaoCheckBox='padding-top:5px;display:inline-block;padding-right:20px;';
    this.Options.Styles.redNaoInputCheckBox='float:left;padding-right:20px;margin-right:5px;';
}

InlineCheckboxElement.prototype.GetValueString=function()
{
    var valueString="";
    var me=this;
    this.amount=0;
    rnJQuery('#'+this.Id+ ' .redNaoInputCheckBox:checked').each(function()
    {
        me.amount+=parseFloat(rnJQuery(this).val());
        valueString+=','+encodeURI(rnJQuery.trim(rnJQuery(this).parent().text()));
    })
    if(valueString.length>0)
        return encodeURI(me.Options.Label)+'='+valueString.substring(1);
    return '';

}

InlineCheckboxElement.prototype.IsValid=function()
{
    return rnJQuery('#'+this.Id+ ' .redNaoInputCheckBox:checked').length>0;
}


/*************************************************************************************Select Basic Element ***************************************************************************************************/

function SelectBasicElement(options,generator)
{
    FormElementBase.call(this,options,generator);
    this.Title="Select Basic";

    if(this.IsNew)
    {
        this.Options.Label="Select Basic";
        this.Options.ClassName="rednaoselectbasic";
        this.Options.Options=new Array({label:'Option 1(10$)',amount:10},{label:'Option 2(20$)',amount:20},{label:'Option 3(30$)',amount:30});
    }else
    {
        if(this.Options.Options.length>0&&typeof this.Options.Options[i]=='string')
        {
            var aux=new Array();
            for(var i=0;i<this.Options.Options.length;i++)
            {
                aux.push({label:this.Options.Options[i],amount:0});
            }

            this.Options.Options=aux;
        }
    }


}

SelectBasicElement.prototype=Object.create(FormElementBase.prototype);

SelectBasicElement.prototype.CreateProperties=function()
{
    this.Properties.push(new SimpleTextProperty(this.Options,"Label","Label",'basic'));
    this.Properties.push(new ArrayProperty(this.Options,"Options","Options",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options.Styles,"width","Width",{type:'style',"class":'redNaoSelect'}));
    this.Properties.push(new CheckBoxProperty(this.Options,"IsRequired","Required",'basic'));



}

SelectBasicElement.prototype.GenerateInlineElement=function()
{

    var html=  '<label class="rednao_control_label">'+this.Options.Label+'</label>\
        <div class="redNaoControls">\
        <select name="'+this.GetPropertyName()+'" class="redNaoSelect">';

    var selected='selected="selected"';
    for(var i=0;i<this.Options.Options.length;i++)
    {
        html+='<option   value="'+this.Options.Options[i].amount+'" '+selected+'>'+this.Options.Options[i].label+'</opton>'

        selected="";

    }
    html+='</select></div>';
    return html;
}


SelectBasicElement.prototype.GenerateDefaultStyle=function()
{
    this.Options.Styles.redNaoSelect='width:auto;border: 1px solid #ccc;height:30px;line-height:30px;padding:4px 6px;';
}

SelectBasicElement.prototype.GetValueString=function()
{
    var jQueryElement=rnJQuery('#'+this.Id+ ' .redNaoSelect option:selected');
    if(jQueryElement.length>0)
        this.amount=parseFloat(jQueryElement.val());
    return  encodeURI(this.Options.Label)+"="+encodeURI(jQueryElement.text());
}


SelectBasicElement.prototype.IsValid=function()
{
    return rnJQuery('#'+this.Id+ ' .redNaoSelect option:selected').length>0;
}



/*************************************************************************************Select Multiple Element ***************************************************************************************************/

function SelectMultipleElement(options,generator)
{
    FormElementBase.call(this,options,generator);
    this.Title="Select Multiple Element";


    if(this.IsNew)
    {
        this.Options.Label="Select Multiple Element";
        this.Options.ClassName="rednaoselectmultiple";
        this.Options.Options=new Array({label:'Option 1(10$)',amount:10},{label:'Option 2(20$)',amount:20},{label:'Option 3(30$)',amount:30});
    }else
    {
        if(this.Options.Options.length>0&&typeof this.Options.Options[i]=='string')
        {
            var aux=new Array();
            for(var i=0;i<this.Options.Options.length;i++)
            {
                aux.push({label:this.Options.Options[i],amount:0});
            }

            this.Options.Options=aux;
        }
    }


}

SelectMultipleElement.prototype=Object.create(FormElementBase.prototype);

SelectMultipleElement.prototype.CreateProperties=function()
{
    this.Properties.push(new SimpleTextProperty(this.Options,"Label","Label",'basic'));
    this.Properties.push(new ArrayProperty(this.Options,"Options","Options",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options.Styles,"width","Width",{type:'style',"class":'redNaoSelect'}));
    this.Properties.push(new SimpleTextProperty(this.Options.Styles,"height","Height",{type:'style',"class":'redNaoSelect'}));
    this.Properties.push(new CheckBoxProperty(this.Options,"IsRequired","Required",'basic'));



}

SelectMultipleElement.prototype.GenerateInlineElement=function()
{

    var html=  '<label class="rednao_control_label">'+this.Options.Label+'</label>\
        <div class="redNaoControls">\
        <select name="'+this.GetPropertyName()+'" class="redNaoSelect" multiple="multiple">';

    var selected='selected="selected"';
    for(var i=0;i<this.Options.Options.length;i++)
    {
        html+='<option   value="'+this.Options.Options[i].amount+'" '+selected+'>'+this.Options.Options[i].label+'</opton>'

        selected="";

    }
    html+='</select></div>';
    return html;
}


SelectMultipleElement.prototype.GenerateDefaultStyle=function()
{
    this.Options.Styles.redNaoSelect='width:auto;border: 1px solid #ccc;line-height:30px;padding:4px 6px;height:60px;';
}


SelectMultipleElement.prototype.GetValueString=function()
{
    var valueString="";
    var me=this;
    this.amount=0;
    rnJQuery('#'+this.Id+ ' .redNaoSelect option:selected').each(function()
    {
        me.amount+=parseFloat(rnJQuery(this).val());
        valueString+=','+encodeURI(rnJQuery.trim(rnJQuery(this).text()));
    })
    if(valueString.length>0)
        return encodeURI(me.Options.Label)+'='+valueString.substring(1);
    return '';

}


SelectMultipleElement.prototype.IsValid=function()
{
    return rnJQuery('#'+this.Id+ ' .redNaoSelect option:selected').length>0;
}
/*************************************************************************************Donation Button***************************************************************************************************/



function DonationButtonElement(options,generator)
{
    FormElementBase.call(this,options,generator);
    this.Title="Donation Button";

    if(this.IsNew)
    {
        this.Options.Label="Donation Button";
        this.Options.ClassName="rednaodonationbutton";
        this.Options.Image='';
    }else
    {
        if(typeof this.Options.Image=='undefined')
            this.Options.Image='';
    }


}

DonationButtonElement.prototype=Object.create(FormElementBase.prototype);

DonationButtonElement.prototype.CreateProperties=function()
{
    this.Properties.push(new SimpleTextProperty(this.Options,"Label","Label",'basic'));
    this.Properties.push(new SimpleTextProperty(this.Options.Styles,"margin-left","Spacing",{type:'style',"class":'redNaoDonationButton'}));
    this.Properties.push(new SimpleTextProperty(this.Options.Styles,"width","Width",{type:'style',"class":'redNaoDonationButton',"default":'auto'}));
    this.Properties.push(new SimpleTextProperty(this.Options.Styles,"height","Height",{type:'style',"class":'redNaoDonationButton',"default":'auto'}));
    this.Properties.push(new SimpleTextProperty(this.Options,"Image","Image Url",'basic'));
}

DonationButtonElement.prototype.GenerateInlineElement=function()
{
    var imageToUse=this.Options.Image;
    if(imageToUse=="")
        imageToUse=this.generator.GetDonationImage();
    return '<div class="redNaoControls">'+this.generator.donationProvider.GetButton(imageToUse)+'</div>';
}

DonationButtonElement.prototype.GenerationCompleted=function()
{
    rnJQuery('#'+this.Id).find('.smartDonationsDonationButton').click(function(event)
    {
        event.preventDefault();
    });
}

DonationButtonElement.prototype.GenerateDefaultStyle=function()
{
    this.Options.Styles.redNaoDonationButton='margin-left:0px;width:auto;height:auto;';
}

DonationButtonElement.prototype.GetValueString=function()
{
    return '';

}




/************************************************************************************* Recurrence Element  ***************************************************************************************************/



function RecurrenceElement(options,generator)
{
    FormElementBase.call(this,options,generator);
    this.Title="Donation Button";

    if(this.IsNew)
    {
        this.Options.Label="Recurrence";
        this.Options.ClassName="rednaodonationrecurrence";
        this.Options.ShowOneTime='y';
        this.Options.ShowDaily='y';
        this.Options.ShowWeekly='y';
        this.Options.ShowMonthly='y';
        this.Options.ShowYearly='y';

    }


}

RecurrenceElement.prototype=Object.create(FormElementBase.prototype);

RecurrenceElement.prototype.CreateProperties=function()
{
    this.Properties.push(new SimpleTextProperty(this.Options,"Label","Label",'basic'));
    this.Properties.push(new CheckBoxProperty(this.Options,"ShowOneTime","Show one time option",'basic'));
    this.Properties.push(new CheckBoxProperty(this.Options,"ShowDaily","Show daily option",'basic'));
    this.Properties.push(new CheckBoxProperty(this.Options,"ShowWeekly","Show weekly option",'basic'));
    this.Properties.push(new CheckBoxProperty(this.Options,"ShowMonthly","Show monthly option",'basic'));
    this.Properties.push(new CheckBoxProperty(this.Options,"ShowYearly","Show yearly option",'basic'));
}

RecurrenceElement.prototype.GenerateInlineElement=function()
{
    var html= '<label class="rednao_control_label">'+this.Options.Label+'</label>\<div class="redNaoControls"><select class="redNaoSelect redNaoRecurrence">';
    var selected='selected="selected"';

    if(this.Options.ShowOneTime=='y')
    {
         html+='<option value="OT" '+selected+'>One Time</option>';
        selected='';
    }

    if(this.Options.ShowDaily=='y')
    {
        html+='<option value="D" '+selected+'>Daily</option>';
        selected='';
    }

    if(this.Options.ShowWeekly=='y')
    {
        html+='<option value="W" '+selected+'>Weekly</option>';
        selected='';
    }

    if(this.Options.ShowMonthly=='y')
    {
        html+='<option value="M" '+selected+'>Monthly</option>';
        selected='';
    }

    if(this.Options.ShowYearly=='y')
    {
        html+='<option value="Y" '+selected+'>Yearly</option>';
        selected='';
    }

    html+='</select></div>';

    return html;
}

RecurrenceElement.prototype.GenerateDefaultStyle=function()
{
    this.Options.Styles.redNaoSelect='width:auto;border: 1px solid #ccc;height:30px;line-height:30px;padding:4px 6px;';
}

RecurrenceElement.prototype.GetValueString=function()
{
    var jQueryElement=rnJQuery('#'+this.Id+ ' .redNaoSelect option:selected');
    return  encodeURI(this.Options.Label)+"="+encodeURI(jQueryElement.text());

}


/*************************************************************************************Anonymous Element ***************************************************************************************************/

function AnonymousDonation(options,generator)
{
    FormElementBase.call(this,options,generator);
    this.Title="Anonymous Checkboxes";

    if(this.IsNew)
    {
        this.Options.Label="Make anonymous donation";
        this.Options.ClassName="rednaoanonymousdonation";
    }

}

AnonymousDonation.prototype=Object.create(FormElementBase.prototype);

AnonymousDonation.prototype.CreateProperties=function()
{
    this.Properties.push(new SimpleTextProperty(this.Options,"Label","Label",'basic'));
}

AnonymousDonation.prototype.GenerateInlineElement=function()
{
    var html=  '<label class="rednao_control_label">'+this.Options.Label+'</label>\
        <div class="redNaoControls">';

    html+='<label class="redNaoCheckBox" >\
                    <input  class="redNaoInputCheckBox redNaoAnonymousDonation" type="checkbox" name="'+this.GetPropertyName()+'"  value="y"/>\
                </label>';
    html+='</div>';
    return html;
}


AnonymousDonation.prototype.GenerateDefaultStyle=function()
{
    this.Options.Styles.redNaoCheckBox='padding-top:5px;display:inline-block;padding-right:20px;';
    this.Options.Styles.redNaoInputCheckBox='float:left;padding-right:20px;margin-right:5px;';
}

AnonymousDonation.prototype.GetValueString=function()
{
    return  encodeURI(this.Options.Label)+"="+(rnJQuery('#'+this.Id+ ' .redNaoAnonymousDonation').is(':checked')?'y':'n');

}

AnonymousDonation.prototype.IsValid=function()
{
    return true;
}

