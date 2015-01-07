<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
     
       {include file="extrahead.tpl"}
        
       
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

       
        {include file="theme-setting.tpl"}
       
       {include file="header.tpl"}

        <!-- BEGIN Container -->
        <div class="container-fluid" id="main-container">
           
            {include file="sidebar.tpl"} 
            

            <!-- BEGIN Content -->
            <div id="main-content">
                <!-- BEGIN Page Title -->
                <div class="page-title">
                    <div>
                        <h1><i class="icon-file-alt"></i>Corporate Actions Calendar</h1>
                        
                    </div>
                </div>
                <!-- END Page Title -->

                <!-- BEGIN Breadcrumb -->
                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="index.html">Home</a>
                            <span class="divider"><i class="icon-angle-right"></i></span>
                        </li>
                        <li class="active">Calendar</li>
                    </ul>
                </div>
                <!-- END Breadcrumb -->

                <!-- BEGIN Main Content -->
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="icon-calendar"></i> Calendar</h3>
                                <div class="box-tool">
                                    <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                                    <a data-action="close" href="#"><i class="icon-remove"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <div class="row-fluid">
                                  
                                  <div class="span9">
                                     <div id="calendar" class="has-toolbar"></div>
                                  </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Main Content -->
                
                  {include file="footer.tpl"}
            </div>
            <!-- END Content -->
        </div>
        <!-- END Container -->


        <!--basic scripts-->
        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>-->
        <script>window.jQuery || document.write('<script src="{$BASE_URL}assets/assets/jquery/jquery-1.10.1.min.js"><\/script>')</script>
        {include file="extrafooter.tpl"}
        
        {literal}
<script language="javascript">
   if (jQuery().fullCalendar) {
        var l = new Date;
        var c = l.getDate();
        var h = l.getMonth();
        var p = l.getFullYear();
        var d = {};
        if ($(window).width() <= 320) {
            d = {
                left: "title, prev,next",
                center: "",
                right: "today,month,agendaWeek,agendaDay"
            }
        } else {
            d = {
                left: "title",
                center: "",
                right: "prev,next,today,month,agendaWeek,agendaDay"
            }
        }
        var v = function (e) {
            var t = {
                title: $.trim(e.text())
            };
            e.data("eventObject", t);
            e.draggable({
                zIndex: 999,
                revert: true,
                revertDuration: 0
            })
        };
        var m = function (e, t) {
            e = e.length == 0 ? "Untitled Event" : e;
            t = t.length == 0 ? "default" : t;
            var n = $('<div data-class="label label-' + t + '" class="external-event label label-' + t + '">' + e + "</div>");
            jQuery("#event_box").append(n);
            v(n)
        };
        $("#external-events div.external-event").each(function () {
            v($(this))
        });
        $("#event_add").click(function () {
            var e = $("#event_title").val();
            var t = $("#event_priority").val();
            m(e, t)
        });
        var g = function () {
            $("#event_priority_chzn .chzn-search").hide();
            $("#event_priority_chzn_o_1").html('<span class="label label-default">' + $("#event_priority_chzn_o_1").text() + "</span>");
            $("#event_priority_chzn_o_2").html('<span class="label label-success">' + $("#event_priority_chzn_o_2").text() + "</span>");
            $("#event_priority_chzn_o_3").html('<span class="label label-info">' + $("#event_priority_chzn_o_3").text() + "</span>");
            $("#event_priority_chzn_o_4").html('<span class="label label-warning">' + $("#event_priority_chzn_o_4").text() + "</span>");
            $("#event_priority_chzn_o_5").html('<span class="label label-important">' + $("#event_priority_chzn_o_5").text() + "</span>")
        };
        $("#event_priority_chzn").click(g);
        m("My Event 1", "default");
        m("My Event 2", "success");
        m("My Event 3", "info");
        m("My Event 4", "warning");
        m("My Event 5", "important");
        m("My Event 6", "success");
        m("My Event 7", "info");
        m("My Event 8", "warning");
        m("My Event 9", "success");
        m("My Event 10", "default");
	//	alert(new Date('2013-10-15'));
        $("#calendar").fullCalendar({
            header: d,
            editable: true,
            droppable: true,
            drop: function (e, t) {
                var n = $(this).data("eventObject");
                var r = $.extend({}, n);
                r.start = e;
                r.allDay = t;
                r.className = $(this).attr("data-class");
                $("#calendar").fullCalendar("renderEvent", r, true);
                if ($("#drop-remove").is(":checked")) {
                    $(this).remove()
                }
            },
            events: [{
                title: "All Day Event",
                start: new Date(p, h, 1),
                className: "label label-default"
            }, {
                title: "Long Event",
                start: new Date(p, h, c - 5),
                end: new Date(p, h, c - 2),
                className: "label label-success"
            }, {
                id: 999,
                title: "Repeating Event",
                start: new Date(p, h, c - 3, 16, 0),
                allDay: false,
                className: "label label-default"
            }, {
                id: 999,
                title: "Repeating Event",
                start: new Date(p, h, c + 4, 16, 0),
                allDay: false,
                className: "label label-important"
            }, {
                title: "Meeting",
                start: new Date(p, h, c, 10, 30),
                allDay: false,
                className: "label label-info"
            }, {
                title: "Lunch",
                start: new Date(p, h, c, 12, 0),
                end: new Date(p, h, c, 14, 0),
                allDay: false,
                className: "label label-warning"
            }, {
                title: "Birthday Party",
                start: new Date(p, h, c + 1, 19, 0),
                end: new Date(p, h, c + 1, 22, 30),
                allDay: false,
                className: "label label-success"
            }, {
                title: "Click for Google",
                start: new Date(p, h, 28),
                end: new Date(p, h, 29),
                url: "http://google.com/",
                className: "label label-warning"
            }]
        });
        $(".fc-button").addClass("btn")
    }
</script>
{/literal}
    </body>
</html>
