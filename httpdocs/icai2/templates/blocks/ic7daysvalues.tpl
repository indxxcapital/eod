<script type="text/javascript" src="//www.google.com/jsapi"></script>
<script type="text/javascript">
   {literal} google.load('visualization', '1', {packages: ['annotatedtimeline']});
    function drawVisualization() {
      var data = new google.visualization.DataTable();
     {/literal}{$columns}{literal}
      data.addRows([{/literal}{$datastr}{literal}
       ]);
    
      var annotatedtimeline = new google.visualization.AnnotatedTimeLine(
          document.getElementById('visualization'));
      annotatedtimeline.draw(data, {'displayAnnotations': false,'displayZoomButtons':false,'displayExactValues':true});
    }
    
    google.setOnLoadCallback(drawVisualization);
{/literal}  </script>

<div class="span6">
  <div class="box">
    <div class="box-title">
      <h3><i class="icon-bar-chart"></i>Last 7 days index values chart</h3>
      <div class="box-tool"> <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a> <a data-action="close" href="#"><i class="icon-remove"></i></a> </div>
    </div>
    <div class="box-content">
      <div id="visualization" style="position:relative;  height: 290px;"></div>
    </div>
  </div>
</div>
