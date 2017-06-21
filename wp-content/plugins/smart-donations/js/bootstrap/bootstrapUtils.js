rnJQuery.fn.RNWait=function(param)
{

    if(param=='start')
    {
        rnJQuery(this).addClass('ladda-button');
        rnJQuery(this).attr('data-style','expand-left');
        var buttonAnimation=Ladda.create(this[0]);
        buttonAnimation.start();
        rnJQuery.data(this[0],'sdLadda',buttonAnimation);
    }

    if(param=='stop')
    {
        var buttonAnimation=rnJQuery.data(this[0],'sdLadda');
        if(buttonAnimation!=null)
            buttonAnimation.stop();

        rnJQuery.removeData(this[0],'sdLadda');
    }

};

rnJQuery.fn.RDNotifications=function(dynamicHeight)
{
    if(typeof dynamicHeight =='undefined')
        dynamicHeight=false;

    if(dynamicHeight==false)
        this.wrap('<div style="height: 50px;"></div>')

    return {
        Element:rnJQuery(this),
        ShowError:function(message)
        {
            this.SetAlert('error',message);

        },

        ShowSuccess:function(message)
        {
            this.SetAlert('success',message);

        },
        Clear:function()
        {
          this.Element.slideUp('1000','easeInQuint');
        },
        SetAlert:function(type,message)
        {
            this.ClearAlertTypes();
            var classType='';
            var glyph='';
            switch (type)
            {
                case 'error':
                    classType='alert-danger';
                    glyph='glyphicon glyphicon-remove';
                    break;
                case 'success':
                    classType='alert-success';
                    glyph='glyphicon glyphicon-ok';
                    break;
                case 'warning':
                    classType='alert-warning';
                    glyph='glyphicon glyphicon-warning-sign';
                    break;
            }

            this.Element.addClass('alert '+classType );
            this.Element.hide();
            this.Element.empty()
            this.Element.append('<span class="'+glyph+'" style="margin-right: 5px;"></span><span>'+message+'</span>');
            this.Element.slideDown('1000','easeInQuint');
        },
        ClearAlertTypes:function()
        {
            this.Element.removeClass('alert alert-success alert-info alert-warning alert-danger')
        }
    };
}