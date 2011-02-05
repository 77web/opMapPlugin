<script type="text/javascript">
  geocodeList = new Array();
  <?php foreach($list as $i => $geocode): ?>
    geocodeList[<?php echo $i; ?>] = { caption: "<?php echo $geocode->getForeignTitle(); ?>", url: "<?php echo url_for($geocode->getForeignUrl(ESC_RAW)); ?>", lat: <?php echo $geocode->getLat(); ?>, lng: <?php echo $geocode->getLng(); ?> };
  <?php endforeach; ?>
  geocodeCount = <?php echo count($list); ?>;
  mapZoom = <?php echo sfConfig::get('app_map_default_zoom', 13); ?>;
</script>
<div class="parts box">
<div class="partsHeading">
<h3><?php echo __('%member%\'s map', array('%member%'=>$member->getName())); ?></h3>
</div>

<div id="map">
</div>


</div>