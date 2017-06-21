var smartDonationsCurrentElement;
var smartDonationsPreviousStyleElement;
var smartDonationsPreviousElement;


function SmartDonationsEditStyle(Generator,Element,Properties)
{
    var styles=Generator.styles;
    if(typeof styles[Element]=='undefined')
        styles[Element]="";
    var styleToEdit=styles[Element];

    for(property in Properties)
        styleToEdit=SmartDonationsReplaceStyle(styleToEdit,property,Properties[property]);

    styles[Element]=styleToEdit;


}

function SmartDonationsEditImage(Generator,Element,Src)
{
    var styles=Generator.styles;
    if(typeof styles[Element]=='undefined')
        styles[Element]="";
    var styleToEdit=styles[Element];

    styleToEdit=Src;
    styles[Element]=styleToEdit;
}



function SmartDonationsReplaceStyle(style,property,newValue)
{
    var re = new RegExp(property+":[^;]*;", "g");
    style=style.replace(re,'');
    style+=property+":"+newValue+";";
    return style;
}
function SmartDonationsStartStyling()
{
    smartDonationsEditDialog.dialog('open');
    rnJQuery('#smartDonationsApplyStyle').unbind('click').click(ApplyStyle);
    rnJQuery("#smartDonationsCSS").val("");
    smartDonationsCurrentElement=null;
    smartDonationsPreviousStyleElement=null;
    smartDonationsPreviousElement=null;
    if(smartDonationsDonationType&&smartDonationsDonationType.generator)
    {
        BindGeneratedItemToStyleEvents();
    }

}

function SmartDonationsRecoverPreviousBorder()
{

    if(smartDonationsPreviousStyleElement=="none")
        rnJQuery(smartDonationsPreviousElement).css('border','');
    else
        rnJQuery(smartDonationsPreviousElement).css('border', smartDonationsPreviousStyleElement);

    smartDonationsPreviousStyleElement=null;
    smartDonationsPreviousElement=null;
}

function BindGeneratedItemToStyleEvents()
{
    smartDonationsPreviousStyleElement=null;
    smartDonationsPreviousElement=null;
    rnJQuery("#smartDonationsPreviewEditionContainer").find('.smartDonationsEditableItem, .ui-slider-handle, .ui-slider-horizontal, .ui-slider-handle, .smartDonationsSliderSmile').hover(
        function(event){
            event.stopPropagation();

            if(smartDonationsPreviousElement)
            {
                rnJQuery(smartDonationsPreviousElement).css('border', smartDonationsPreviousStyleElement);
            }

            smartDonationsPreviousStyleElement=rnJQuery(this).css('border');
            if(typeof smartDonationsPreviousStyleElement =='undefined'||!smartDonationsPreviousStyleElement||smartDonationsPreviousStyleElement=="0px solid rgb(0, 0, 0)")
                smartDonationsPreviousStyleElement="none";
            smartDonationsPreviousElement=this;
            rnJQuery(this).css('border', '3px solid black');
        },
        //unhover
        function(event){
            event.stopPropagation();
            if(smartDonationsPreviousStyleElement==null)
                return;
            SmartDonationsRecoverPreviousBorder();


        }
    ).unbind('click').unbind('mousedown').click(function(event)
        {
            event.preventDefault();
            event.stopPropagation();
            var element=rnJQuery("#smartDonationsPreviewEditionContainer").find("."+SmartDonationsGetReferenceClass(rnJQuery(this)));
            smartDonationsCurrentElement=element;
            var tagName=element.prop("tagName").toUpperCase();

            SmartDonationsSetStyleText();
            if(tagName=="INPUT")
            {
                if(element.attr("type").toUpperCase()=="IMAGE")
                {
                    smartDonationsEditImage(element);
                }

                if(element.attr("type").toUpperCase()=="TEXT")
                {
                    smartDonationsEditTextBox(element);
                }


            }
            if(tagName=="SPAN" ||tagName=="STRONG")
            {
                smartDonationsEditText(element);
            }

            if(tagName=="IMG")
            {
                smartDonationsEditImage(element);
            }

            if(element.hasClass('smartDonationsSliderSmile'))
            {
                smartDonationsEditSmile(element);
                return;
            }
            if(element.hasClass('progress'))
            {
                smartDonationsEditProgressBar(rnJQuery('.progressBar'));
                return;
            }

            if(tagName=="DIV"||element.hasClass('ui-slider-handle'))
            {
                smartDonationsEditDiv(element);
            }

            if(element.hasClass('wepay-widget-button'))
            {
                smartDonationsEditWePayButton(element);
            }

        });
}

function ApplyStyle(event)
{
    event.preventDefault();

    if(smartDonationsCurrentElement==null)
        return;

    var className=SmartDonationsGetReferenceClass(smartDonationsCurrentElement);

    smartDonationsDonationType.generator.styles[className]=rnJQuery("#smartDonationsCSS").val().replace(/\r?\n/g,'');
    SmartDonationsRefreshDonation(className);
    smartDonationsCurrentElement.click();

}

function SmartDonationsRefreshDonation(className)
{
    smartDonationsDonationType.generator.GenerateDonationItem();
    smartDonationsCurrentElement= rnJQuery("#smartDonationsPreviewEditionContainer").find("."+className);
    BindGeneratedItemToStyleEvents();
    SmartDonationsSetStyleText();
}

function SmartDonationsSetStyleText()
{
    if(smartDonationsPreviousStyleElement)
        SmartDonationsRecoverPreviousBorder();

    var elementObject=smartDonationsDonationType.generator.styles[SmartDonationsGetReferenceClass(smartDonationsCurrentElement)];
    if(typeof(elementObject)!='undefined')
    {
        if(typeof(elementObject)=="string")
            cssText=elementObject;
        else
            cssText=elementObject.attr('style');
    }

    if(typeof cssText =='undefined'||!cssText)
        cssText='';
    rnJQuery("#smartDonationsCSS").val(cssText.replace(/[ ]*;[ ]*/g,";\r"));
}
function SmartDonationsGetReferenceClass(element)
{
    if(element.hasClass('smartDonationsDonationButton'))
        return'smartDonationsDonationButton';

    if(element.hasClass('smartDonationsCommentText'))
        return 'smartDonationsCommentText';

    if(element.hasClass('smartDonationsDonationBox'))
        return 'smartDonationsDonationBox';



    if(element.hasClass('smartDonationsThreeButtonSpan1'))
        return 'smartDonationsThreeButtonSpan1';

    if(element.hasClass('smartDonationsThreeButtonSpan2'))
        return 'smartDonationsThreeButtonSpan2';

    if(element.hasClass('smartDonationsThreeButtonSpan3'))
        return 'smartDonationsThreeButtonSpan3';


    if(element.hasClass('smartDonationsThreeButtonImage1'))
        return 'smartDonationsThreeButtonImage1';

    if(element.hasClass('smartDonationsThreeButtonImage2'))
        return 'smartDonationsThreeButtonImage2';

    if(element.hasClass('smartDonationsThreeButtonImage3'))
        return 'smartDonationsThreeButtonImage3';



    if(element.hasClass('ui-slider-handle'))
        return 'ui-slider-handle';

    if(element.hasClass('ui-slider-horizontal'))
        return 'ui-slider-horizontal';

    if(element.hasClass('ui-slider-range-min'))
        return 'ui-slider-range-min';

    if(element.hasClass('smartDonationsCurrentDonationText'))
        return 'smartDonationsCurrentDonationText';

    if(element.hasClass('smartDonationsAmount'))
        return 'smartDonationsAmount';


    if(element.hasClass('smartDonationsSliderSmile'))
        return 'smartDonationsSliderSmile';

    if(element.hasClass('wepay-widget-button'))
        return 'wepay-widget-button';



    if(element.hasClass('amountText'))
        return 'amountText';

    if(element.hasClass('currentText'))
        return 'currentText';

    if(element.hasClass('goalMessage'))
        return 'goalMessage';

    if(element.hasClass('progress'))
        return 'progressBar';




    if(element.hasClass('panelAmount'))
        return 'panelAmount';

    if(element.hasClass('amountText'))
        return 'amountText';

    if(element.hasClass('panelTitle'))
        return 'panelTitle';

    if(element.hasClass('titleText'))
        return 'titleText';

    if(element.hasClass('smartDonationsHorizontalThermomenter'))
        return 'smartDonationsHorizontalThermomenter';


    if(element.hasClass('smartDonationsVerticalThermomenter'))
        return 'smartDonationsVerticalThermomenter';


}

function SmartDonationsChangeCurrentStyle(styleElement,value)
{

    var className=SmartDonationsGetReferenceClass(smartDonationsCurrentElement);
    var propertyToSave=className;
    if(styleElement=="src")
    {
        propertyToSave=className+"_src";
        SmartDonationsEditImage(smartDonationsDonationType.generator,propertyToSave,value);
    }else
    {
        var property={};
        property[styleElement]=value;
        SmartDonationsEditStyle(smartDonationsDonationType.generator,propertyToSave,property);
    }


    SmartDonationsRefreshDonation(className);
}





/************************************************************************************* EDITTING ELEMENTS ***************************************************************************************************/



function smartDonationsEditImage(imageElement)
{
    var events=new Array();
    rnJQuery("#smartDonationsEditionArea").html(
        "<table>" +
             SmartDonationsAddImageField(imageElement,events,'src')+
             SmartDonationsAddNumericField(imageElement,events,'Width')+
             SmartDonationsAddNumericField(imageElement,events,'Height')+
       "</table>"
    );

    for(var i=0;i<events.length;i++)
        events[i]();
}




function smartDonationsEditText(element)
{
    var events=new Array();

    rnJQuery("#smartDonationsEditionArea").html(
        "<table>" +
            SmartDonationsAddFontFamily(element,events)+
            SmartDonationsAddColorPicker(element,events,'color')+
            SmartDonationsAddNumericField(element,events,'Font-Size')+
        "</table>"
    );

    for(var i=0;i<events.length;i++)
        events[i]();



}




function smartDonationsEditTextBox(element)
{
    var events=new Array();

    rnJQuery("#smartDonationsEditionArea").html(
        "<table>" +
            SmartDonationsAddFontFamily(element,events)+
            SmartDonationsAddColorPicker(element,events,'color')+
            SmartDonationsAddNumericField(element,events,'Font-Size')+
            SmartDonationsAddNumericField(element,events,'Width')+
            SmartDonationsAddNumericField(element,events,'Height')+
            "</table>"
    );

    for(var i=0;i<events.length;i++)
        events[i]();



}

function smartDonationsEditDiv(element)
{
    var events=new Array();

    rnJQuery("#smartDonationsEditionArea").html(
        "<table>" +
            SmartDonationsAddColorPicker(element,events,'Border-Color')+
            SmartDonationsAddNBorderStyle(element,events)+
            SmartDonationsAddNumericField(element,events,'Border-Width')+

            SmartDonationsAddColorPicker(element,events,'Background-Color')+
            SmartDonationsAddImageField(element,events,'Background-Image')+

            "</table>"
    );

    for(var i=0;i<events.length;i++)
        events[i]();
}


function smartDonationsEditWePayButton(element)
{
    var events=new Array();

    rnJQuery("#smartDonationsEditionArea").html(
        "<table>" +

            SmartDonationsAddFontFamily(element,events)+
            SmartDonationsAddColorPicker(element,events,'color')+
            SmartDonationsAddNumericField(element,events,'Font-Size')+

            SmartDonationsAddColorPicker(element,events,'Border-Color')+
            SmartDonationsAddNBorderStyle(element,events)+
            SmartDonationsAddNumericField(element,events,'Border-Width')+

            SmartDonationsAddColorPicker(element,events,'Background-Color')+
            SmartDonationsAddImageField(element,events,'Background-Image')+

            "</table>"
    );

    for(var i=0;i<events.length;i++)
        events[i]();
}


function smartDonationsEditSmile(element)
{
    var events=new Array();

    rnJQuery("#smartDonationsEditionArea").html(
        "<table>" +
            SmartDonationsAddColorPickerForRaphael(element,events,'SmileStrokeColor')+
            SmartDonationsAddColorPickerForRaphael(element,events,'SmileFillColor')+

            "</table>"
    );

    for(var i=0;i<events.length;i++)
        events[i]();
}

function smartDonationsEditProgressBar(element)
{
    var events=new Array();

    rnJQuery("#smartDonationsEditionArea").html(
        "<table>" +
            SmartDonationsAddColorPickerWithAlpha(element,events,'Background-Color',.9)+

            "</table>"
    );

    for(var i=0;i<events.length;i++)
        events[i]();
}

/************************************************************************************* ADD FIELDS ***************************************************************************************************/



function SmartDonationsAddFontFamily(element,eventListener)
{
    eventListener.push(function(){
        rnJQuery("#smartDonationsEditFont").change(function()
        {
            SmartDonationsChangeCurrentStyle("font-family",rnJQuery("#smartDonationsEditFont").val());
        });
    });

    var fonts = new Array(
        'Arial,Helvetica,sans-serif',
        'Arial Black,Gadget,sans-serif',
        'Comic Sans MS,cursive',
        'Courier New,Courier,monospace',
        'Georgia,serif',
        'Impact,Charcoal,sans-serif',
        'Lucida Console,Monaco,monospace',
        'Lucida Sans Unicode,Lucida Grande,sans-serif',
        'Palatino Linotype,Book Antiqua,Palatino,serif',
        'Tahoma,Geneva,sans-serif',
        'Times New Roman,Times,serif',
        'Trebuchet MS,Helvetica,sans-serif',
        'Verdana,Geneva,sans-serif' );

    var fontOptions="";
    var selectedFont=element.css('font-family');

    if(selectedFont)
    {
        var indexOfFont=fonts.indexOf(selectedFont);
        if(indexOfFont>0)
            selectedFont=fonts[indexOfFont];
        else
            fonts.push(selectedFont);


    }else
        selectedFont=fonts[0];
    for(var i=0;i<fonts.length;i++)
    {
        if(fonts[i]==selectedFont)
            fontOptions+="<option value='"+fonts[i]+"' selected='sel'>"+fonts[i]+"</option>";
        else
            fontOptions+="<option value='"+fonts[i]+"'>"+fonts[i]+"</option>";

    }

    return "<tr>" +
        "   <td>" +
        "Font Family" +
        "</td>" +
        "   <td> " +
        "<select id='smartDonationsEditFont'  style='width:500px'>"+
        fontOptions+
        "</select>"  +
        "   </td>" +
        "</tr>" ;
}


function SmartDonationsAddNumericField(imageElement,eventListener,attribute)
{
    eventListener.push(function(){rnJQuery("#SmartDonationsAddNumericField_"+attribute).keyup(function()
    {
        SmartDonationsChangeCurrentStyle(attribute.toLowerCase(),rnJQuery("#SmartDonationsAddNumericField_"+attribute).val());

    })});

    return "<tr>" +
        "   <td>" +
        attribute +
        "</td>" +
        "   <td> " +
        "<input type='text' id='SmartDonationsAddNumericField_"+attribute+"' class='smartDonationsNumericField_Larger' value='"+imageElement.css(attribute.toLowerCase())+"'/>"  +
        "   </td>" +
        "</tr>";
}


function SmartDonationsAddImageField(imageElement,eventListener,attribute)
{
    var currentValue="";

    if(attribute.toLowerCase()=="src")
        currentValue=imageElement.attr("src");
    else
        currentValue=imageElement.css(attribute.toLowerCase());


    eventListener.push(function(){rnJQuery("#smartDonationsEditImage_"+attribute).keyup(function()
    {
        var selectedValue=rnJQuery("#smartDonationsEditImage_"+attribute).val();
        if(attribute.toLowerCase()=='background-image'&&!selectedValue)
            selectedValue="none";


        SmartDonationsChangeCurrentStyle(attribute.toLowerCase(),selectedValue);

    })});

    return "<tr>" +
        "   <td>" +
        attribute+
        "</td>" +
        "   <td> " +
        "<input type='text' id='smartDonationsEditImage_"+attribute+"'  style='width:500px' value='"+currentValue+"'/>"  +
        "   </td>" +
        "</tr>";


}


function SmartDonationsAddColorPicker(imageElement,eventListener,attribute)
{
    eventListener.push(function(){
        jscolor.init();
        rnJQuery('#smartDonationsEditColor_'+attribute).change(function()
        {
            SmartDonationsChangeCurrentStyle(attribute.toLowerCase(),'#'+this.color.toString());
        });
    });

    return "<tr> " +
        "<td>" +
        attribute +
        "</td>" +
        "<td>" +
            "<input id='smartDonationsEditColor_"+attribute+"' class='color' value='"+RGBToEx(imageElement.css(attribute))+"'/>"+
        "</td>" +
    "</tr>"
}


function SmartDonationsAddColorPickerWithAlpha(imageElement,eventListener,attribute,alpha)
{
    eventListener.push(function(){
        jscolor.init();
        rnJQuery('#smartDonationsEditColor_'+attribute).change(function()
        {
            SmartDonationsChangeCurrentStyle(attribute.toLowerCase(),'#'+this.color.toString());
            var backgroundWithAlpha=attribute+":rgba("+hexToRgb(this.color.toString())+','+alpha+");";

            var className=SmartDonationsGetReferenceClass(smartDonationsCurrentElement);
            smartDonationsDonationType.generator.styles[className]+=backgroundWithAlpha.toLocaleLowerCase();
            SmartDonationsRefreshDonation(className);
        });
    });

    return "<tr> " +
        "<td>" +
        attribute +
        "</td>" +
        "<td>" +
        "<input id='smartDonationsEditColor_"+attribute+"' class='color' value='"+RGBToEx(imageElement.css(attribute))+"'/>"+
    "</td>" +
    "</tr>";
}

function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? parseInt(result[1], 16)+','+parseInt(result[2], 16)+','+parseInt(result[3], 16): '0,0,0';


}



function SmartDonationsAddColorPickerForRaphael(imageElement,eventListener,attribute)
{
    eventListener.push(function(){
        jscolor.init();
        rnJQuery('#smartDonationsEditColor_'+attribute).change(function()
        {
           smartDonationsDonationType.generator.styles[attribute]=this.color.toString();
           SmartDonationsRefreshDonation(SmartDonationsGetReferenceClass(imageElement));
        });
    });

    var selectedColor= smartDonationsDonationType.generator.styles[attribute];



    return "<tr> " +
        "<td>" +
        attribute +
        "</td>" +
        "<td>" +
        "<input id='smartDonationsEditColor_"+attribute+"' class='color' value='"+selectedColor+"'/>"+
    "</td>" +
    "</tr>";
}




function SmartDonationsAddNBorderStyle(element,eventListener)
{
    eventListener.push(function(){
        rnJQuery("#smartDonationsEditBorderStyle").change(function()
        {
            SmartDonationsChangeCurrentStyle("border-style",rnJQuery("#smartDonationsEditBorderStyle").val());
        });
    });

    var fonts = new Array(
        'none',
        'dotted',
        'dashed',
        'solid',
        'double');

    var fontOptions="";
    var selectedFont=element.css('border-style');

    if(selectedFont)
    {
        var indexOfFont=fonts.indexOf(selectedFont);
        if(indexOfFont>0)
            selectedFont=fonts[indexOfFont];
        else
            fonts.push(selectedFont);


    }else
        selectedFont=fonts[0];
    for(var i=0;i<fonts.length;i++)
    {
        if(fonts[i]==selectedFont)
            fontOptions+="<option value='"+fonts[i]+"' selected='sel'>"+fonts[i]+"</option>";
        else
            fontOptions+="<option value='"+fonts[i]+"'>"+fonts[i]+"</option>";

    }

    return "<tr>" +
        "   <td>" +
        "Border-Style" +
        "</td>" +
        "   <td> " +
        "<select id='smartDonationsEditBorderStyle' >"+
        fontOptions+
        "</select>"  +
        "   </td>" +
        "</tr>" ;
}




/************************************************************************************* EXTRAS  ***************************************************************************************************/





function RGBToEx(rgb) {
    if(typeof rgb =='undefined')
        return '';
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    function hex(x) {return ("0" + parseInt(x).toString(16)).slice(-2);}
    return hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}