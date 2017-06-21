rnJQuery(function () {

    var Notifications=rnJQuery('#rnNotifications').RDNotifications();
    rnJQuery('#cbDisplayType').change(function () {
        FormatStartDate();
        FormatEndDate();
    });

    rnJQuery(".datePicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'MM/dd/yy',
        onClose: function (dateText, inst) {

            var id = rnJQuery(this).attr('id');

            if (id == 'dpStartDate')
                FormatStartDate();
            else
                FormatEndDate();
        }
    });


    function FormatStartDate() {
        var dp = rnJQuery('#dpStartDate');
        var date = dp.datepicker('getDate');
        if (date == null)
            return;
        switch (rnJQuery('#cbDisplayType').val()) {
            case 'd':
                return;
                break;
            case 'w':
                dp.datepicker('setDate', new Date(date.setDate(date.getDate() - date.getDay())));
                break;
            case 'm':
                dp.datepicker('setDate', new Date(date.getFullYear(), date.getMonth(), 1));
                break;
            case 'y':
                dp.datepicker('setDate', new Date(date.getFullYear(), 0, 1));
                break;
        }
    }

    function FormatEndDate() {
        var dp = rnJQuery('#dpEndDate');
        var date = dp.datepicker('getDate');
        if (date == null)
            return;
        switch (rnJQuery('#cbDisplayType').val()) {
            case 'd':
                return;
                break;
            case 'w':
                dp.datepicker('setDate', new Date(date.setDate(date.getDate() + (6 - date.getDay()))));
                break;
            case 'm':
                date = new Date(date.getFullYear(), date.getMonth() + 1, 1);
                dp.datepicker('setDate', new Date(date.setDate(0)));
                break;
            case 'y':
                dp.datepicker('setDate', new Date(date.getFullYear(), 11, 31));
                break;
        }
    }


    rnJQuery('#ui-datepicker-div').wrap('<div class="smartDonationsSlider"></div>');

    var plot1 = rnJQuery.jqplot('Chart', [
        ['2013-2-1', 0]
    ], {
        title: 'Donations Summary',
        axes: {
            xaxis: {
                renderer: rnJQuery.jqplot.DateAxisRenderer,
                tickOptions: { formatString: '%b/%d/%Y' },

                min: '2013-1-1',
                max: '2013-4-1',
                tickInterval: '1 month',

                pointLabels: {show: true, edgeTolerance: -15}
            }
        },

        highlighter: {
            show: true,
            sizeAdjust: 7.5
        },
        cursor: {
            show: false
        },
        series: [
            { label: 'Donations' }
        ]
    });


    /************************************************************************************* Execute Query ***************************************************************************************************/

    rnJQuery('#btnExecute').click(ExecuteQuery);

    function ExecuteQuery() {

        Notifications.Clear();
        var startDate = rnJQuery.datepicker.formatDate('yy-mm-dd', rnJQuery('#dpStartDate').datepicker('getDate'));
        var endDate = rnJQuery.datepicker.formatDate('yy-mm-dd', rnJQuery('#dpEndDate').datepicker('getDate'));
        var displayType = rnJQuery('#cbDisplayType').val();
        var campaign = rnJQuery('#cbCampaign').val();

        if (!startDate) {
            Notifications.ShowError('Start Date is Mandatory');
            return;
        }


        if (!endDate) {
            Notifications.ShowError('End Date is Mandatory');
            return;
        }

        if (!displayType) {
            Notifications.ShowError('Display Format is mandatory');
            return;
        }

        if (!campaign) {
            Notifications.ShowError('Campaign is mandatory');
            return;
        }


        var data = {
            action: "rednao_smart_donations_execute_analytics",
            startDate: startDate,
            endDate: endDate,
            displayType: displayType,
            campaign_id: campaign
        };

        var tick = "";
        switch (displayType) {
            case 'd':
                tick = '1 day';
                break;
            case 'w':
                tick = '1 week';
                break;
            case 'm':
                tick = '1 month';
                break;
            case 'y':
                tick = '1 year';
                break;

        }
        rnJQuery('#btnExecute').RNWait('start');
        rnJQuery.post(ajaxurl, data, function (result) {
            ajaxCompleted(result, tick,displayType,campaign)
        });
    }




    /************************************************************************************* Chart  ***************************************************************************************************/
    var handler = function(ev, gridpos, datapos, neighbor, plot) {
        if (neighbor) {
            var selectedDate = new Date(neighbor.data[0]);
            selectedDate = selectedDate.getFullYear()+ "/" +(selectedDate.getMonth()+ 1) + "/" +selectedDate.getDate() ;
            //selectedSerie = SerieToString(neighbor.seriesIndex);


            Grid[0].p.url = ajaxurl+'?action=rednao_smart_donations_execute_analytics_list&date=' + selectedDate +
                '&campaign_Id=' + GridCampaign_Id+'&displayType='+GridDisplayType;
            Grid[0].grid.populate();

        }
    };


    rnJQuery.jqplot.eventListenerHooks.push(['jqplotClick', handler]);

    var GridCampaign_Id='';
    var GridDisplayType="";
    var Grid;
    function ajaxCompleted(result, tick, displayType, campaign_id) {
        rnJQuery('#btnExecute').RNWait('stop');
        var values = rnJQuery.parseJSON(result);
        GridCampaign_Id=campaign_id;
        GridDisplayType=displayType;

        var xAxis={
            renderer: rnJQuery.jqplot.DateAxisRenderer,
            tickOptions: { formatString: '%d/%b/%Y' },
            tickInterval: tick,
            pointLabels: {show: true, edgeTolerance: -15}
        };

        if(values.length>1)
        {
            xAxis.min= values[0][0],
            xAxis.max=values[values.length - 1][0];
        }

        rnJQuery('#Chart').empty();
        rnJQuery('#Chart').width(values.length * 100);
        rnJQuery.jqplot('Chart', [values], {
            title: 'Donations Summary',
            axes: {
                xaxis: xAxis
            },

            highlighter: {
                show: true,
                sizeAdjust: 7.5
            },
            cursor: {
                show: false
            },
            series: [
                { label: 'Donations' }
            ]
        });


    }




    /*----------------------------------------------------------------------------GRID------------------------------*/

    rnJQuery(document).ready(function ($) {
        Grid=rnJQuery('#grid').jqGrid({"width": "1000", "hoverrows": true,mtype:"POST",  "viewrecords": true, "jsonReader": {"repeatitems": false, "subgrid": {"repeatitems": false}}, "gridview": true, "url": ajaxurl+"?action=rednao_smart_donations_execute_analytics_list", "editurl": ajaxurl+"?action=rednao_smart_donations_execute_analytics_op", "cellurl": ajaxurl+"?action=rednao_smart_donations_execute_analytics_op",  "rowList": [10, 20, 30], "sortname": "TransactionId", "datatype": "json", "colModel": [
            {"name": "actions", "formatter": "actions", "editable": false, "sortable": false, "resizable": false, "fixed": true, "width": 60, "formatoptions": {"keys": true}},
            {"name": "TransactionId", "index": "TransactionId", "sorttype": "int", "key": true, "editable": false,hidden:true},
            {"name": "Date", "index": "Date", "sorttype": "datetime", "formatter": "date", "formatoptions": {"srcformat": "Y-m-d H:i:s", "newformat": "Y-m-d"}, "editable": true,"editoptions": {"dataInit": function(elm) {
                setTimeout(function() {
                    rnJQuery(elm).datepicker({dateFormat: 'yy-mm-dd'});
                    rnJQuery('.ui-datepicker').css({'font-size': '75%'});
                }, 200);
            }}},
            {"name": "FirstName", "index": "FirstName", "sorttype": "string", "editable": true},
            {"name": "LastName", "index": "LastName", "sorttype": "string", "editable": true},
            {"name": "Email", "index": "Email", "sorttype": "string", "editable": true},
            {"name": "Gross", "index": "Gross", "sorttype": "string", "editable": true, width:70},
            {"name": "Fee", "index": "Fee", "sorttype": "string", "editable": true,width:70},
            {"name": "campaign_id", "index": "campaign_id", "sorttype": "int", "key": false, "editable": true,"hidden":true,viewable:true,"edittype":'select' ,editoptions:{ value: RedNaoCampaignList } , editrules: {edithidden: true}}

        ], "postData": {"oper": "grid"}, "prmNames": {"page": "page", "rows": "rows", "sort": "sidx", "order": "sord", "search": "_search", "nd": "nd", "id": "TransactionId", "filter": "filters", "searchField": "searchField", "searchOper": "searchOper", "searchString": "searchString", "oper": "oper", "query": "grid", "addoper": "add", "editoper": "edit", "deloper": "del", "excel": "excel", "subgrid": "subgrid", "totalrows": "totalrows", "autocomplete": "autocmpl"}
            ,"loadError": function (xhr, status, err) {
            try {
                if(xhr.responseText)
                    alert(xhr.responseText);
            } catch (e) {
                alert(xhr.responseText);
            }
        }, "pager": "#pager"});

        rnJQuery('#grid').jqGrid('navGrid', '#pager', {"edit":false,"del":false,"search":false,"refresh":false,"view":false,"excel":false,"pdf":false,"csv":false, addtext:"", addtitle:"Add new row" ,"errorTextFormat": function(r) {
            return r.responseText;
        }});

        rnJQuery('#grid').jqGrid('editGridRow')


        Grid.on('jqGridAddEditAfterSubmit',function(a,b,c)
        {
            if(b.responseText)
                rnJQuery.jgrid.info_dialog(rnJQuery.jgrid.errors.errcap, '<div class="ui-state-error">' + b.responseText + '</div>', rnJQuery.jgrid.edit.bClose, {buttonalign: 'right'});
            else
            {
                var myInfo = '<div class="ui-state-highlight ui-corner-all">' +
                        '<span class="ui-icon ui-icon-info" ' +
                        'style="float: left; margin-right: .3em;"></span>' +
                        '<span>Information saved</span></div>';

                $infoTr = rnJQuery("#TblGrid_grid >tbody>tr.tinfo"),
                $infoTd = $infoTr.children("td.topinfo");
                $infoTd.html(myInfo);
                $infoTr.show();

                // hide the info after 3 sec timeout
                setTimeout(function () {
                    $infoTd.children("div")
                        .fadeOut("slow", function () {
                            // Animation complete.
                            $infoTr.hide();
                        });
                }, 3000);
            }

        });


    });










});




