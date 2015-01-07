{capture name="googleMapLat"}{if $postData[$Form_Params.itemData.map_feilds.lat]}{$postData[$Form_Params.itemData.map_feilds.lat]}{else}8.971897294083027{/if}{/capture}
{capture name="googleMapLong"}{if $postData[$Form_Params.itemData.map_feilds.long]}{$postData[$Form_Params.itemData.map_feilds.long]}{else}7.5146484375{/if}{/capture}
{capture name="googleMapZoom"}{if $postData[$Form_Params.itemData.map_feilds.zoom]}{$postData[$Form_Params.itemData.map_feilds.zoom]}{else}5{/if}{/capture}

<div align="center" style="margin:0;padding:0">
	<div id="phoca_geo_map" style="margin:0;padding:0;width:370px;height:320px"></div>
</div>
<script src="http://maps.google.com/maps?file=api&v=2&key={$GOOGLE_API}" type="text/javascript"></script>
{literal}
<script type='text/javascript'>

//<![CDATA[
var tst_phoca_geo=document.getElementById('phoca_geo_map');
var tstint_phoca_geo;
var map_phoca_geo;

function CancelEventPhocaGeoMap(event) { 
	var e = event; 
	if (typeof e.preventDefault == 'function') e.preventDefault(); 
	if (typeof e.stopPropagation == 'function') e.stopPropagation(); 
	
	if (window.event) { 
		window.event.cancelBubble = true; // for IE 
		window.event.returnValue = false; // for IE 
	} 
}

function CheckPhocaGeoMap()
{
	if (tst_phoca_geo) {
		if (tst_phoca_geo.offsetWidth != tst_phoca_geo.getAttribute("oldValue"))
		{
			tst_phoca_geo.setAttribute("oldValue",tst_phoca_geo.offsetWidth);

			if (tst_phoca_geo.getAttribute("refreshMap")==0)
				if (tst_phoca_geo.offsetWidth > 0) {
					clearInterval(tstint_phoca_geo);
					getPhocaGeoMap();
					tst_phoca_geo.setAttribute("refreshMap", 1);
				} 
		}
		//window.top.document.forms.stateform.elements.zoom.value = tstint_phoca_geo;
		
	
		//document.getElementById('{$Form_Params.itemData.map_feilds.zoom}').value =tstint_phoca_geo;
		
	}
}

function getPhocaGeoMap(){
	if (tst_phoca_geo.offsetWidth > 0) {
		
	
		map_phoca_geo = new GMap2(document.getElementById('phoca_geo_map'));
		map_phoca_geo.addControl(new GMapTypeControl());
		map_phoca_geo.addControl(new GLargeMapControl());
		var overviewmap = new GOverviewMapControl();
		map_phoca_geo.addControl(overviewmap, new GControlPosition(G_ANCHOR_BOTTOM_RIGHT));
		{/literal}
		map_phoca_geo.setCenter(new GLatLng({$smarty.capture.googleMapLat}, {$smarty.capture.googleMapLong}), {$smarty.capture.googleMapZoom});
	 {literal}
		map_phoca_geo.setMapType(G_NORMAL_MAP);
		map_phoca_geo.enableContinuousZoom();
		map_phoca_geo.enableDoubleClickZoom();
		map_phoca_geo.enableScrollWheelZoom();
		
		var startzoom = 2;
		var zoom = null;
		GEvent.addListener(map_phoca_geo, "zoomend", function(startzoom,zoom) {
		 {/literal}
			document.getElementById('{$Form_Params.itemData.map_feilds.zoom}').value =zoom;
		{literal}
		}); 
		 
		var marker = null;
		
		marker = new GMarker(new GLatLng({/literal}{$smarty.capture.googleMapLat}, {$smarty.capture.googleMapLong}{literal}), {draggable: true});
		
		map_phoca_geo.addOverlay(marker);
		GEvent.addListener(map_phoca_geo, 'click', function(overlay,point) {
			if (overlay) {
			} else {
		
				marker.setPoint(point);
				addPoint(point);
			}
		});

		GEvent.addListener(marker, "mouseout", function() {
			var point = marker.getLatLng();
		//	marker.openInfoWindowHtml(marker.getLatLng().toUrlValue(6));
			addPoint(point);
		});
		function addPoint(point) {
			{/literal}
			
			document.getElementById('{$Form_Params.itemData.map_feilds.lat}').value = point.y;
			document.getElementById('{$Form_Params.itemData.map_feilds.long}').value = point.x;
			{literal}
		}
		
		GEvent.addDomListener(tst_phoca_geo, 'DOMMouseScroll', CancelEventPhocaGeoMap);
		GEvent.addDomListener(tst_phoca_geo, 'mousewheel', CancelEventPhocaGeoMap);
	}
}
//]]> 
 
tst_phoca_geo.setAttribute("oldValue",0);
tst_phoca_geo.setAttribute("refreshMap",0);
CheckPhocaGeoMap();
//tstint_phoca_geo=setInterval("CheckPhocaGeoMap()",500);

</script>

{/literal}