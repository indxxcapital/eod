       
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
            events: [{/literal}{$cadata}{literal}]
        });
        $(".fc-button").addClass("btn")
    }
</script>
{/literal}   