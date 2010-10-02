window.onload = initGoogleMapEditor;
global_geopoint = '';


function initGoogleMapEditor(e)
{
  var mapobj = new GMap2(document.getElementById('map'));
  mapobj.addControl(new GLargeMapControl());
  
  mapobj.setCenter(new GLatLng(center_y, center_x), 13);

    GEvent.addListener
    (
      mapobj, "click", 
      function(current_icon, geopoint)
      { 
        if(current_icon)
        {
          mapobj.removeOverlay(current_icon); 
        }
        else
        {
          locatePointer(mapobj, geopoint);
        } 
      }
    );

}

function locatePointer(mapobj, geopoint)
{
  var icon = new GIcon();
  icon.image      = "/mitemin/opMapPlugin/img/mappointer.png";
  icon.shadow     = "/mitemin/opMapPlugin/img/mappointer.png";
  icon.iconSize   = new GSize(28,32);
  icon.shadowSize = new GSize(28,32);
  icon.iconAnchor = new GPoint(14,32);

  var pointer = new GMarker(geopoint, icon);
  mapobj.clearOverlays();
  mapobj.addOverlay(pointer);
  
  global_geopoint = geopoint;
}


function setLocation()
{
  var url = '';
  if(global_geopoint!='')
  {
    url = 'http://maps.google.co.jp/maps?oe=UTF-8&hl=ja&z=13&ll=' + global_geopoint.y + "," + global_geopoint.x;
  }

  window.returnValue = url;
  window.close();

}