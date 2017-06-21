"use strict";
var SmartDonationsFormMouseDownFired;

function SmartDonationsPrepareDraggableItems()
{
    rnJQuery(".rednaoformbuilder .component,#redNaoElementlist .rednao-control-group").unbind('mousedown');
    rnJQuery(".rednaoformbuilder .component,#redNaoElementlist .rednao-control-group").mousedown(SmartDonationsFormMouseDownFired);

    rnJQuery(".redNaoDonationButton").unbind('click');
    rnJQuery(".redNaoDonationButton").click(function(){return false;})
}

function SmartDonationsStartFormElements() {
    var RedNaoFormElements=smartDonationsDonationType.generator.FormElements;

    function CreateDragabbleElements() {




/*--------------Drag and drop operations----------------------*/

        var moveFunction;
        SmartDonationsFormMouseDownFired=function(e) {
            e.stopPropagation();
            e.preventDefault();
            var draggedItemDisplayed=false;

            if(rnJQuery(this).hasClass('last'))
                return;

            var classOrigin="";
            if(rnJQuery(this).parent().hasClass('formelements'))
            {
                classOrigin="formelements";
                OpenProperties(e,rnJQuery(this));
            }

            var offset = rnJQuery(this).offset();
            rnJQuery("#tempForm").remove();



            rnJQuery("#tempForm").offset({ top: offset.top, left: offset.left });
            var draggedElementSource=this;
            var pageX= e.pageX;
            var pageY= e.pageY;
            var deltaX = pageX - offset.left;
            var deltaY = pageY - offset.top;
            UnbindMovefunction();
            moveFunction=function (e) {
                if(e.pageX>pageX-10&& e.pageX<pageX+10&& e.pageY>pageY-10&& e.pageY<pageY+10)
                    return;
                CloseProperties();
                if(!draggedItemDisplayed)
                {
                    DisplayDraggedItem(draggedElementSource,classOrigin);
                    draggedItemDisplayed=true;
                }
                rnJQuery("#tempForm").offset({ top: e.pageY - deltaY, left: e.pageX - deltaX });
                var list= rnJQuery("#redNaoElementlist .rednao-control-group,#redNaoElementlist .last");
                var elementSelected=false;
                for(var i=0;i<list.length;i++){
                    var currentElement=rnJQuery(list[i]);
                    var offset=currentElement.offset();
                    var width=currentElement.width();
                    var height=currentElement.height();

                    if(e.pageY>offset.top&& e.pageX>offset.left&& e.pageY<offset.top+height&& e.pageX<offset.left+width)
                    {
                        rnJQuery(draggedElementSource).fadeTo(0.5,1);
                        currentElement.addClass("target");
                        elementSelected=true;
                    }else
                    {
                        currentElement.removeClass("target");
                    }
                }

                if(rnJQuery("#tempForm").hasClass('formelements'))
                {
                    if(!elementSelected)
                        rnJQuery(draggedElementSource).fadeTo(0,0.2);
                }
            };


            rnJQuery(this).mouseup(UnbindMovefunction);
            rnJQuery("body").mousemove(moveFunction);


        }
        rnJQuery("#rednaoformbuilder .component,#redNaoElementlist .rednao-control-group").mousedown(SmartDonationsFormMouseDownFired);

        function SwitchFormElements(draggedElementSource,target)
        {
            if(target.hasClass('last'))
            {
                return;
            }
            var clonedSource=draggedElementSource.clone();
            var clonedTarget=target.clone();

            var sourceId=draggedElementSource.attr('id');
            var targetId=target.attr('id');
            var targetIndex=-1;
            var sourceIndex=-1;


            for(var i=0;i<RedNaoFormElements.length;i++)
            {
                if(RedNaoFormElements[i].Id==targetId)
                    targetIndex=i;

                if(RedNaoFormElements[i].Id==sourceId)
                    sourceIndex=i;
            }



            if(sourceIndex>=0&&targetIndex>=0)
            {

                if(targetIndex>sourceIndex)
                    targetIndex--;
                var aux=RedNaoFormElements[sourceIndex];

                RedNaoFormElements.splice(sourceIndex,1);
                RedNaoFormElements.splice(targetIndex,0,aux);


                RefreshForm();
            }
          /*  target.replaceWith(clonedSource);
            draggedElementSource.replaceWith(clonedTarget);
            SmartDonationsPrepareDraggableItems();*/

        }

        function AddFormElement(draggedElement,target)
        {
            var newElement=CreateNewInstanceOfElement(draggedElement);

            RefreshForm();

           if(target.hasClass("last"))
            {
                RedNaoFormElements.push(newElement);
               /* var emptyElement='<div class="rednaoformbuilder formelement last" style="height:77px;width:100%;"></div>';
                target.removeClass("last");
                rnJQuery("#redNaoElementlist").append(emptyElement);
                newElement.GenerateHtml(target);*/


            }else{
               var targetId=target.attr("id");
               for(var i=0;i<RedNaoFormElements.length;i++)
               {
                   if(RedNaoFormElements[i].Id==targetId)
                   {
                       RedNaoFormElements.splice(i,0,newElement);
                       break;
                   }
               }
                /*target.before('<div id="rednaoBeforeElement"></div>');
                var elementInserted=newElement.GenerateHtml(rnJQuery('#rednaoBeforeElement'));*/
            }

            RefreshForm();


        }

        function RefreshForm()
        {
            var form=rnJQuery("#redNaoElementlist");
            form.empty();
            for(var i=0;i<RedNaoFormElements.length;i++)
            {
                RedNaoFormElements[i].AppendElementToContainer(form);
            }

            form.append('<div class="rednaoformbuilder formelement last" style="height:77px;width:100%;"></div>');
            SmartDonationsPrepareDraggableItems();
        }

        function UnbindMovefunction() {
            if(moveFunction!=null)
            {
                rnJQuery("body").unbind('mousemove', moveFunction);
                moveFunction = null;
            }
        }

        function DisplayDraggedItem(draggedElementSource,classOrigin)
        {
            rnJQuery("#rednaoformbuilder").append('<div class="form-horizontal span6 temp '+classOrigin+'" id="tempForm" style="padding: 8px 4px;    border: 1px dotted #ccc;    position: absolute;    background: white;    box-shadow: 0 0 30px #999;    -webkit-transition: -webkit-transform .1s ease-out;    overflow: hidden;" >' + rnJQuery(draggedElementSource).html() + '</div>');
            rnJQuery("#tempForm").mouseup(function () {
                UnbindMovefunction();
                rnJQuery("#tempForm").remove();
                rnJQuery("body").unbind("mousemove");
                var target=rnJQuery(".rednaoformbuilder .target");
                target.removeClass("target");
                if(target.length>0)
                {

                    if(rnJQuery(this).hasClass('formelements'))
                        SwitchFormElements(rnJQuery(draggedElementSource),target);
                    else
                        AddFormElement(draggedElementSource,target);
                }else
                {
                    if(rnJQuery(this).hasClass('formelements'))
                    {
                        var id=rnJQuery(draggedElementSource).attr('id');
                        for(var i=0;i<RedNaoFormElements.length;i++)
                        {
                            if(RedNaoFormElements[i].Id==id)
                            {
                                RedNaoFormElements.splice(i,1);
                            }
                        }
                        rnJQuery(draggedElementSource).remove();
                    }
                }
            });
            if(rnJQuery("#tempForm").hasClass('formelements'))
            {
                rnJQuery(draggedElementSource).addClass('target');
            }
        }

    }



    
    /************************************************************************************* Properties Edition ***************************************************************************************************/
    
    
    

    var redNaoCurrentEditedFormObject=null;
    var redNaoCurrentEditedFormHtml=null;
    function OpenProperties(e,element)
    {
        propertiesPanel.fadeIn(0,0);
        propertiesPanel.offset({top: e.pageY-3,left: e.pageX+5});

        FillPropertiesPanel(element);
    }

    function FillPropertiesPanel(element)
    {
        redNaoCurrentEditedFormHtml=element;
        redNaoCurrentEditedFormObject=GetJavascriptObjectOfElement(element);

        var divProperties=rnJQuery('#rednaoPropertiesList');
        propertiesPanel.find("#rednaoPropertiesList").empty();


        propertiesPanel.find('.popover-title').text(redNaoCurrentEditedFormObject.Title);
        redNaoCurrentEditedFormObject.GeneratePropertiesHtml(divProperties);
    }

    function CloseProperties()
    {
        redNaoCurrentEditedFormObject=null;
        redNaoCurrentEditedFormHtml=null;
        propertiesPanel.fadeOut(0,0);

    }

    function SavePropertyEdition()
    {
        redNaoCurrentEditedFormObject.UpdateProperties();
        redNaoCurrentEditedFormObject.GenerateHtml(redNaoCurrentEditedFormHtml);
        SmartDonationsPrepareDraggableItems();
        CloseProperties();
    }



    /************************************************************************************* General Methods ***************************************************************************************************/




    function GetJavascriptObjectOfElement(element)
    {
        var id=element.attr("id");
        for(var i=0;i<RedNaoFormElements.length;i++)
            if(RedNaoFormElements[i].Id==id)
            {
                return RedNaoFormElements[i];
            }
    }

    function CreateNewInstanceOfElement(element)
    {
        var componentType=GetComponentType(element);
        return RedNaoCreateFormElementByName(componentType,null,smartDonationsDonationType.generator);
    }

    function GetComponentType(element)
    {
        if(rnJQuery(element).children().first().hasClass('rednaotextinput'))
            return 'rednaotextinput';
        if(rnJQuery(element).children().first().hasClass('rednaodonationamount'))
            return 'rednaodonationamount';
        if(rnJQuery(element).children().first().hasClass('rednaopasswordinput'))
            return 'rednaopasswordinput';
        if(rnJQuery(element).children().first().hasClass('rednaosearchinput'))
            return 'rednaosearchinput';
        if(rnJQuery(element).children().first().hasClass('rednaoprependedtext'))
            return 'rednaoprependedtext';
        if(rnJQuery(element).children().first().hasClass('rednaoappendedtext'))
            return 'rednaoappendedtext';
        if(rnJQuery(element).children().first().hasClass('rednaoprependedcheckbox'))
            return 'rednaoprependedcheckbox';
        if(rnJQuery(element).children().first().hasClass('rednaoappendedcheckbox'))
            return 'rednaoappendedcheckbox';
        if(rnJQuery(element).children().first().hasClass('rednaobuttondropdown'))
            return 'rednaobuttondropdown';
        if(rnJQuery(element).children().first().hasClass('tabradioscheckboxes'))
            return 'tabradioscheckboxes';
        if(rnJQuery(element).children().first().hasClass('rednaomultiplecheckboxes'))
            return 'rednaomultiplecheckboxes';
        if(rnJQuery(element).children().first().hasClass('rednaoinlinecheckboxes'))
            return 'rednaoinlinecheckboxes';
        if(rnJQuery(element).children().first().hasClass('rednaoselectbasic'))
            return 'rednaoselectbasic';
        if(rnJQuery(element).children().first().hasClass('rednaoselectmultiple'))
            return 'rednaoselectmultiple';
        if(rnJQuery(element).children().first().hasClass('rednaofilebutton'))
            return 'rednaofilebutton';
        if(rnJQuery(element).children().first().hasClass('rednaosinglebutton'))
            return 'rednaosinglebutton';
        if(rnJQuery(element).children().first().hasClass('rednaodoublebutton'))
            return 'rednaodoublebutton';
        if(rnJQuery(element).children().first().hasClass('rednaotitle'))
            return 'rednaotitle';
        if(rnJQuery(element).children().first().hasClass('rednaotextarea'))
            return 'rednaotextarea';
        if(rnJQuery(element).children().first().hasClass('rednaomultipleradios'))
            return 'rednaomultipleradios';
        if(rnJQuery(element).children().first().hasClass('rednaoinlineradios'))
            return 'rednaoinlineradios';
        if(rnJQuery(element).children().first().hasClass('rednaodonationbutton'))
            return 'rednaodonationbutton';
        if(rnJQuery(element).children().first().hasClass('rednaodonationrecurrence'))
            return 'rednaodonationrecurrence';
        if(rnJQuery(element).children().first().hasClass('rednaoanonymousdonation'))
            return 'rednaoanonymousdonation';


    }



    /************************************************************************************* Initialization ***************************************************************************************************/




    function InitializeTabs() {
        rnJQuery(".rednaoformbuilder .formtab").click(function() {
            var tabName = rnJQuery(this).attr("id");
            tabName = tabName.substr(1);

            rnJQuery(".rednaoformbuilder .rednaotablist").css("display", "none");
            rnJQuery(".rednaoformbuilder #" + tabName).css("display", "block");

        });
    }

    function InitializeComponents()
    {
        RedNaoCreateFormElementByName('rednaotitle',null,smartDonationsDonationType.generator).GenerateHtml(rnJQuery("#components .rednaotitle"));
        RedNaoCreateFormElementByName('rednaotextinput',null,smartDonationsDonationType.generator).GenerateHtml(rnJQuery("#components .rednaotextinput"));
        RedNaoCreateFormElementByName('rednaoprependedtext',null,smartDonationsDonationType.generator).GenerateHtml(rnJQuery("#components .rednaoprependedtext"));
        RedNaoCreateFormElementByName('rednaoappendedtext',null,smartDonationsDonationType.generator).GenerateHtml(rnJQuery("#components .rednaoappendedtext"));
        RedNaoCreateFormElementByName('rednaoprependedcheckbox',null,smartDonationsDonationType.generator).GenerateHtml(rnJQuery("#components .rednaoprependedcheckbox"));
        RedNaoCreateFormElementByName('rednaoappendedcheckbox',null,smartDonationsDonationType.generator).GenerateHtml(rnJQuery("#components .rednaoappendedcheckbox"));
        RedNaoCreateFormElementByName('rednaotextarea',null,smartDonationsDonationType.generator).GenerateHtml(rnJQuery("#components .rednaotextarea"));
        RedNaoCreateFormElementByName('rednaomultipleradios',null,smartDonationsDonationType.generator).GenerateHtml(rnJQuery("#components .rednaomultipleradios"));
        RedNaoCreateFormElementByName('rednaoinlineradios',null,smartDonationsDonationType.generator).GenerateHtml(rnJQuery("#components .rednaoinlineradios"));
        RedNaoCreateFormElementByName('rednaomultiplecheckboxes',null,smartDonationsDonationType.generator).GenerateHtml(rnJQuery("#components .rednaomultiplecheckboxes"));
        RedNaoCreateFormElementByName('rednaoinlinecheckboxes',null,smartDonationsDonationType.generator).GenerateHtml(rnJQuery("#components .rednaoinlinecheckboxes"));
        RedNaoCreateFormElementByName('rednaoselectbasic',null,smartDonationsDonationType.generator).GenerateHtml(rnJQuery("#components .rednaoselectbasic"));
        RedNaoCreateFormElementByName('rednaoselectmultiple',null,smartDonationsDonationType.generator).GenerateHtml(rnJQuery("#components .rednaoselectmultiple"));
        RedNaoCreateFormElementByName('rednaodonationamount',null,smartDonationsDonationType.generator).GenerateHtml(rnJQuery("#components .rednaodonationamount"));
        RedNaoCreateFormElementByName('rednaodonationbutton',null,smartDonationsDonationType.generator).GenerateHtml(rnJQuery("#components .rednaodonationbutton"));
        RedNaoCreateFormElementByName('rednaodonationrecurrence',null,smartDonationsDonationType.generator).GenerateHtml(rnJQuery("#components .rednaodonationrecurrence"));
        RedNaoCreateFormElementByName('rednaoanonymousdonation',null,smartDonationsDonationType.generator).GenerateHtml(rnJQuery("#components .rednaoanonymousdonation"));




    }

    CreateDragabbleElements();
    InitializeTabs();
    InitializeComponents();

    var propertiesPanel=rnJQuery("#rednaoPropertiesPanel");


    rnJQuery('#rednaoPropertySave').click(SavePropertyEdition);
    rnJQuery('#rednaoPropertyCancel').click(CloseProperties);




}