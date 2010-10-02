<?php if(count($geocodings)>0): ?>
<script type="text/javascript">
geocodings = ['<?php echo implode("','", $geocodings->getRawValue()); ?>'];
captions = ['<?php echo implode("','", $captions->getRawValue()); ?>'];
urls = ['<?php echo implode("','", $urls->getRawValue()); ?>'];
</script>
<div id="map">
</div>
<?php endif; ?>