function RedNaoShowMessage(message)
{
    rnJQuery('.rednaoMessageManager').empty();
    rnJQuery('.rednaoMessageManager').append('<p>'+message+'</p>');
    rnJQuery('.rednaoMessageManager').css('display','block');

    rnJQuery(".rednaoMessageManager" ).animate({
        height: "30"
    },500);
}

function RedNaoHiddeMessage()
{
    rnJQuery(".rednaoMessageManager" ).animate({
        height: "0"
    },500,function(){
        rnJQuery('.rednaoMessageManager').css('display','none');
    });
}


rnJQuery(function()
{

});
