
function Unlock()
{
    rnJQuery('#licenseDiv').html('<form id="rednaoLicenseForm" method="post" ">' +
        '                           <table>' +
        '                               <tr>' +
        '                                   <td>' +
        '                                       <span>Email </span>' +
        '                                   </td>' +
        '                                   <td>' +
        '                                       <input type="text" name="license_email" value="'+smartDonationsEmail+'"/>' +
        '                                   </td>' +
        '                               </tr>' +
        '                               <tr>' +
        '                                   <td> ' +
        '                                       <span>License </span>' +
        '                                   </td>' +
        '                                   <td>' +
        '                                       <input type="text" name="license_key" value="'+smartDonationsKey+'"/>' +
        '                                   </td>' +
        '                               </tr>' +
        '                               <tr>' +
        '                                   <td style="text-align: right" colspan="2">' +
        '                                       <Button id="applyButton">Apply</Button> ' +
        '                                   </td>' +
        '                               </tr>' +
        '                           </table> ' +
        '                       </form>')

    rnJQuery('#applyButton').click(function()
    {
        rnJQuery(this).text('Validating...');
        rnJQuery(this).prop('disabled','disabled');
        rnJQuery('#rednaoLicenseForm').submit();

    })
}



if(typeof smartDonationsLicensingError !='undefined'&&smartDonationsLicensingError==1)
    Unlock();