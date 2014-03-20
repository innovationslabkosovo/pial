<style type="text/css">
	.slider-holder {
		display: none;
	}
	.category-filters {
		margin-top: 15px !important ;
	}
</style>
<!-- map -->
<div class="map <?php if (Kohana::config('settings.enable_timeline')) echo 'timeline-enabled'; ?>" id="map" style="width:900px;"></div>
<div style="clear:both;"></div>
<div id="mapStatus" style="width: 900px;">
	<div id="mapScale"></div>
	<div id="mapMousePosition"></div>
	<div id="mapProjection"></div>
	<div id="mapOutput"></div>
</div>
<div style="clear:both;"></div>
<!-- / map -->