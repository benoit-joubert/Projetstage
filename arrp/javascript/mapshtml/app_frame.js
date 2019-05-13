// creation des variables global
var map = null;
var element = null;
var popup = null;
var listLayers = new Array();
var projection = null;
var isFrame = true;

// on lance l'initialisation de la carte
initMap(
	function(){
		if (typeof(listePoints) != 'undefined')
		{
			var compte = 0;
			for (var i in listePoints)
			{
				compte++;
			}

			ajoutePoint(listePoints);
			map.getView().setCenter([ centerX, centerY ]);

			if (compte >= 1)
			{
				if (
					(maxX - minX) == 0
					&& (maxY - minY) == 0
					)
				{
					map.getView().setZoom(18);
				}
				else
				{
					var extent = [minX,minY,maxX,maxY];
	            	map.getView().fitExtent(extent, map.getSize());
				}
			}
		}
	}
);

initMenu();