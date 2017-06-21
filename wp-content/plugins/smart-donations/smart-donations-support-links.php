<?php

wp_enqueue_script('jquery');


?>
    <script>
        jQuery(document).ready(function() {


            //Get all the LI from the #tabMenu UL
            jQuery('#tabMenu li').click(function(){

                //perform the actions when it's not selected
                if (!jQuery(this).hasClass('selected')) {

                    //remove the selected class from all LI
                    jQuery('#tabMenu li').removeClass('selected');

                    //Reassign the LI
                    jQuery(this).addClass('selected');

                    //Hide all the DIV in .boxBody
                    jQuery('.smartDonationsBoxBody div.parent').slideUp('1500');

                    //Look for the right DIV in boxBody according to the Navigation UL index, therefore, the arrangement is very important.
                    jQuery('.smartDonationsBoxBody div.parent:eq(' + jQuery('#tabMenu > li').index(this) + ')').slideDown('1500');

                }

            }).mouseover(function() {

                    //Add and remove class, Personally I dont think this is the right way to do it, anyone please suggest
                    jQuery(this).addClass('mouseover');
                    jQuery(this).removeClass('mouseout');

                }).mouseout(function() {

                    //Add and remove class
                    jQuery(this).addClass('mouseout');
                    jQuery(this).removeClass('mouseover');

                });




        });

    </script>
    <style>

        a {color:#ccc;text-decoration:none;}
        a:hover {color:#ccc;text-decoration:none}

        #tabMenu {
            margin:0;
            padding:0 0 0 15px;
            list-style:none;
            height:32px;
            text-align: left;
        }
        #tabMenu li {
            height:32px;
            width:39px;
            cursor:pointer;
            cursor:hand;
            display: inline-block;
            float:left;
        }

        .supportMenuItem {
            margin:0;
            padding:0;
            width:40px;
            height:40px;

            border-radius: 11px 11px 0px 0px;
            -moz-border-radius: 11px 11px 0px 0px;
            -webkit-border-radius: 11px 11px 0px 0px;
            border: 0px solid #800000;
        }

        .supportMenuItem:hover{
            background-color:#BBB;
        }

        .supportMenuImage{
            width: 32px;
            height: 32px;
            margin:2px 0 0 4px;
            padding: 0px;

        }

        .supportMenuItem.selected{
            background-color: #333;

        }



        li.selected {background-position:0 0;}



        .smartDonationsBoxBody {
            background-color:#282828;
            display:inline-block;
            padding-left:1px;
            padding-right:1px;
            padding-top:10px;
            padding-bottom:2px;
            border-radius: 10px 10px 37px 9px;
            -moz-border-radius: 10px 10px 37px 9px;
            -webkit-border-radius: 10px 10px 37px 9px;
            border: 0px solid #800000;
            width:500px;

        }


        .smartDonationsBoxBody div.parent {display:none;}
        .smartDonationsBoxBody div.show {display:block;}

        .smartDonationsBoxBody div ul {padding:0;width:100%;list-style: none;}

        .smartDonationsBoxBody div ul li.last {
            border-bottom:none;
        }
        .smartDonationsBoxBody div li span {font-size:8px;font-style:italic; color:#888;}
    </style>
<h2 style="color:Green">Please Support!, there are a <span style="color: red">BUNCH</span> of ways to do it.</h2>

<div class="box" style="display: inline-block; text-align: center;">

    <div class="smartDonationsHeaders">
        <ul id="tabMenu">
            <li class="supportMenuItem selected"><img title="Donate!!" class="supportMenuImage" src="<?php echo plugin_dir_url(__FILE__)?>images/dollar.png"/></li>
            <li class="supportMenuItem"><img title="Affiliates" class="supportMenuImage" src="<?php echo plugin_dir_url(__FILE__)?>images/handshake.png" style="width:32px;height:32px;"/></li>
            <li class="supportMenuItem"><img title="Rating" class="supportMenuImage" src="<?php echo plugin_dir_url(__FILE__)?>images/star.png" style="width:30px;height:30px;"/></li>
        </ul>
    </div>

    <div class="smartDonationsBoxBody">

        <div id="posts" class="show parent">
            <ul>
                <li style="color:white">You can donate, every penny counts =)</li>
                <li><form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                        <input type="hidden" name="cmd" value="_donations">
                        <input type="hidden" name="business" value="edseventeen@gmail.com">
                        <input type="hidden" name="lc" value="US">
                        <input type="hidden" name="item_name" value="Edgar Rojas">
                        <input type="hidden" name="no_note" value="0">
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHostedGuest">
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                    </form></li>

            </ul>
        </div>

        <div id="comments" class="parent">
            <ul>
                <li style="color:white">Improve your site by buying from my affiliate links, i will earn an small commission =)</li>
                <li>
                    <a target="_blank" href="http://prettylinkpro.com/amember/go.php?r=5095&i=b2"><img src="http://prettylinkpro.com/wp-content/uploads/2009/07/125.jpg" border=0 alt="Shrink, Track, Share, Control ... Dominate" width=125 height=125></a>
                    <a style="margin-left: 20px;"  target="_blank" href="http://www.aweber.com/?419500" title="Email Marketing"><img src="http://www.aweber.com/banners/01-12/125x125_v4.jpg" alt="Email Marketing $19/Month!" style="border:none;" /></a>

                </li>


                <li>
                    <div style="text-align:center;">
                        <a   target="_blank" href="http://edgarrojas.optinskin.hop.clickbank.net" title="Email Marketing"><img src="http://optinskin.com/aff2.png"  style="border:none;" /></a>
                        <a style="margin-left: 20px;"  target="_blank" href="http://edgarrojas.corbonya.hop.clickbank.net" title="Email Marketing"><img src="http://startablogthatmatters.com/wp-content/uploads/2012/01/start-a-blog-that-matters-125x125.jpg"  style="border:none;" /></a>
                    </div>
                </li>

            </ul>
        </div>

        <div id="category" class="parent">
            <ul>
                <li style="color:white">Rate the plugin (high please!!), i don't know how much that will help but i will definitely love to have a high score :P</li>

                <a href="http://wordpress.org/extend/plugins/smart-donations/" style="color: red; font-size: 15px; text-decoration: underline;" target="_blank">You can rate it here</a>
            </ul>
        </div>



    </div>



</div>

<p><strong>Side Note:</strong>Did you liked the component above? would you like to see it as a plugin? let me now by sending a request in the wishlist =)</p>

