
function SDPayPalProviderDesigner(){
    SDProviderBaseDesigner.call();
    this.Name='PayPal';
    this.Id='paypal';
    this.ClassicImage=smartDonationsPluginUrl+'images/'+'classic_donation.png';
    this.TextBoxImage=smartDonationsPluginUrl+'images/'+'text_box_donation.png';
    this.SliderImage=smartDonationsPluginUrl+'images/'+'slider_donation.png';
    this.FormImage=smartDonationsPluginUrl+'images/'+'form_donation.png';
    this.Currencies=["USD","AUD","BRL","GBP","CAD","CZK","DKK","EUR","HKD","HUF","ILS","JPY","MXN","TWD","NZD","NOK","PHP","PLN","SGD","SEK","CHF","THB"];
}
SDPayPalProviderDesigner.prototype=Object.create(SDProviderBaseDesigner.prototype);


SDPayPalProviderDesigner.prototype.ClearProviderScreen=function()
{

};

SDPayPalProviderDesigner.prototype.InitializeProviderScreen=function()
{

};

SDPayPalProviderDesigner.prototype.InitializeFormConfiguration=function()
{

};


RedNaoEventManager.Subscribe('RegisterProvider',function(listOfProviders)
{
    listOfProviders.push(new SDPayPalProviderDesigner());
});