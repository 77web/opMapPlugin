window.onload = function(e){ initGmap(e); };
window.onunload = function(e){ GUnload(e)  };

function initGmap(e)
{
  if(typeof(geocodings)!="undefined")
  {
    var div = document.getElementById('map');
    var map = new google.maps.Map2(div);
  
    map.addControl(new GLargeMapControl());

    for(var i=0;i<geocodings.length;i++)
    {
      var cd = geocodings[i].split(',');
      var point = new google.maps.LatLng(cd[0], cd[1]);
      if(i==0)
      {
        map.setCenter(point, 13);
      }
      var marker = new GMarker(point);
      map.addOverlay(marker);
      var html = urls[i]?'<a href="' + urls[i] + '">' + captions[i] + '</a>':captions[i];
      marker.bindInfoWindowHtml(html);
    }
  }
}