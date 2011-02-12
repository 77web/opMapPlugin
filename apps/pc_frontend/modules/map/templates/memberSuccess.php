<script type="text/javascript">
  geocodeList = new Array();
  <?php foreach($list as $i => $geocode): ?>
    geocodeList[<?php echo $i; ?>] = { caption: "<?php echo $geocode->getForeignTitle(); ?>", url: "<?php echo url_for($geocode->getForeignUrl(ESC_RAW)); ?>", lat: <?php echo $geocode->getLat(); ?>, lng: <?php echo $geocode->getLng(); ?> };
  <?php endforeach; ?>
  geocodeCount = <?php echo count($list); ?>;
  mapZoom = <?php echo sfConfig::get('app_map_default_zoom', 13); ?>;
</script>
<?php include_partial('global/partsSimpleBox', array('id'=>'membersMap', 'title'=>__('%member%\'s map', array('%member%'=>$member->getName())), 'block'=>'<div id="map"></div>', 'options'=>array('border'=>false))); ?>

