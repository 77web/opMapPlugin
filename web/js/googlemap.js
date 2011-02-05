window.onload = function(e){ initGmap(e); };

function initGmap(e)
{
  if(geocodeCount>0)
  {
    var centerLatLng = new google.maps.LatLng(geocodeList[0]['lat'], geocodeList[0]['lng']);
    var map = new google.maps.Map(document.getElementById('map'), { zoom: mapZoom, center: centerLatLng, mapTypeId: google.maps.MapTypeId.ROADMAP });

    for(var i=0;i<geocodeCount;i++)
    {
      var infoWin = new google.maps.InfoWindow({ content: '<a href="' + geocodeList[i]['url'] + '">' + geocodeList[i]['caption'] + '</a>' });
      var marker = new google.maps.Marker({ position: new google.maps.LatLng(geocodeList[i]['lat'], geocodeList[i]['lng']), map: map, infoWin: infoWin  });
      google.maps.event.addListener(marker, 'click', function(){ this.infoWin.open(map, this); });
    }
  }
}