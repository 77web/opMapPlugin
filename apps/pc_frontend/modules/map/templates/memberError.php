<?php slot('block', '<p>'.__('No geocode found.').'</p><div id="map"></div>'); ?>
<?php include_partial('global/partsSimpleBox', array('id'=>'membersMap', 'title'=>__('%member%\'s map', array('%member%'=>$member->getName())), 'block'=>get_slot('block'), 'options'=>array('border'=>false))); ?>
