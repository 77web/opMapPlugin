<?php include_component("mitemin", "communityHead", array("community"=>$community)); ?>

<div class="parts box">
<div class="partsHeading">
<h3><?php echo $community->getName(); ?>の地図</h3>
</div>

<?php include_component("map", "googleMaps", array("geocodings"=>$geocodings, "captions"=>$captions, "urls"=>$urls)); ?>


</div>