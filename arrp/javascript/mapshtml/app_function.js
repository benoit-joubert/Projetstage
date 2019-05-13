//var mdf = 'Library://MODELES/CARTE/MODELE_PDV.MapDefinition';
//var mdf = 'Library://EQUIPEMENTS/DOMAINE_PUBLIC/CARTE/DOMAINE_PUBLIC.MapDefinition'
//var mdf = 'Library://DIFFUSION/SIGAIX/CARTE/PLAN_DE_VILLE_2.MapDefinition';
var mdf = 'Library://DIFFUSION/RESEAUX/CARTE/RESEAUX.MapDefinition';
//var mdf = 'Library://RESEAUX/RESEAUX_ARRP/CARTE/RESEAUX_ARRP.MapDefinition';
//&PWD=&WEBLAYOUT=Library%3a%2f%2fDIFFUSION%2fRESEAUX%2fRESEAUX.WebLayout&LOCALE=fr
var agentUrl = 'http://starentule.intranet/mapserver2012/mapagent/mapagent.fcgi?USERNAME=Anonymous';


var bounds = [
  1881316.50155079,
  3139428.02970279,
  1906510.26146978,
  3163225.09423037
];

//var centerX = 1897823.7097; // (bounds[2] + bounds[0]) / 2;
//var centerY = 3150706.4029; // (bounds[3] + bounds[1]) / 2;
var centerX = (bounds[2] + bounds[0]) / 2;
var centerY = (bounds[3] + bounds[1]) / 2;
var zoomDefault = 16;
var hostname = 'http://web2.intranet/arrp';
//var hostname = 'http://127.0.0.1/arrp';

var iconStyleParams = {
  //anchor: [0.5, -50],
  anchorXUnits: 'fraction',
  anchorYUnits: 'pixels',
  opacity: 1, //0.75,
  //src: 'mapshtml/data/icon.png',
  src: 'images/pin_blue_24.png',
  //imgSize: [150, 150],
  //size: [100, 100]
  //scale: 0.10,
  offsetOrigin: 'bottom-left',
  anchorOrigin: 'bottom-left'
};

var hoverRecherche = false;
var focusRecherche = false;
var inputRecherche = '';
var racoursiRecherche = false;
var typeRecherche = 'adresse';
var typeRechercheListe = {
  'adresse' : {
    'libelle' : 'Adresse',
    'icon' : 'glyphicon glyphicon-map-marker'
  },
  'equipement' : {
    'libelle' : 'Equipement',
    'icon' : 'glyphicon glyphicon-home'
  }
};
var popup;
var popup2;
var featureClick = null;
var geolocation = null;

var isPopupClick = false;

var accuracyFeature = null;
var positionFeature = null;
var featuresOverlay = null;

var projection = null;
var projection2 = null;

var projectionKey = {
  'EPSG:3944': '+proj=lcc +lat_1=43.25 +lat_2=44.75 +lat_0=44 +lon_0=3 +x_0=1700000 +y_0=3200000 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs',
  //'EPSG:2154': '+proj=lcc +lat_1=49 +lat_2=44 +lat_0=46.5 +lon_0=3 +x_0=700000 +y_0=6600000 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs',
  //'EPSG:2154': '+proj=lcc +lat_1=43.65 +lat_2=43.43 +lat_0=43.54 +lon_0=5.405 +x_0=1881000 +y_0=3139000 +ellps=GRS1980 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs',
  //'EPSG:2154': '+proj=lcc +lat_1=43.65 +lat_2=43.43 +lat_0=43.54 +lon_0=5.405 +x_0=1894000 +y_0=3151500 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs',
  'EPSG:2154': '+proj=lcc +lat_1=43.65 +lat_2=43.43 +lat_0=43.54 +lon_0=5.405 +x_0=1894390 +y_0=3151829 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs',
  'EPSG:4326': '+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs',
};

if (typeof(layerPointJson) == 'undefined')
{
  var layerPointJson = null;
}

if (typeof(isFrame) == 'undefined')
{
  var isFrame = false;
}


function initMap(callback)
{
    // initialisation de la projection
    initProjection();

    // initialisation du fond de plan
    initLayerTile();

    map = new ol.Map({
      layers: listLayers,
      target: 'map',
      view: new ol.View({
        center: [centerX, centerY],
        projection: projection,
        zoom: zoomDefault,
        maxZoom: 19,
        minZoom: 11
        //zoom: 12
      })
    });

    console.log('map', map);

    // zoom slider
    //zoomslider = new ol.control.ZoomSlider();
    //map.addControl(zoomslider);

    // fullscreen
    /*map.addControl( new ol.control.FullScreen({
      target: 'menu_fullscreen'
    }) );*/

    // popover
    //element = document.getElementById('popup');

    /*popup = new ol.Overlay({
      element: element,
      positioning: 'bottom-center',
      stopEvent: false
    });*/
    //map.addOverlay(popup);

    element2 = document.getElementById('map-point-select-detail');

    popup2 = new ol.Overlay({
      element: element2,
      positioning: 'bottom-center',
      stopEvent: false
    });
    map.addOverlay(popup2);

    

    // event
    map.on('postrender', function(evt) {
        $$('#layer-menu').show();
    });

    map.on(['click'], function(evt) {
        //console.log('[click, poitermove]', evt.type);
        console.log(evt);
        console.log('#map-point-select-detail', $('#map-point-select-detail').is(":visible"));

        closePopupTimeout = true;
        
        if ($('#map-point-select-detail').is(":visible") == false)
        {
          startOpenPopup(evt.pixel);
        }
        else
        {

          setTimeout(function() {
            if (closePopupTimeout == true)
            {
              console.log('test', evt);
              startOpenPopup(evt.pixel);
            }
          }, 50);
        }
        //startOpenPopup(evt.pixel, evt.type);
    });

    map.on('moveend', function(evt) {
      //console.log( evt );
      /*
      var tempoUrl = hostname + '/';
      tempoUrl += '?P=3';
      tempoUrl += '&iframe=1';
      tempoUrl += '&center=' + map.getView().getCenter();
      tempoUrl += '&zoom=' + map.getView().getZoom();

      var tempoStyle = 'width:100%;';
      tempoStyle += 'height:100%;';
      tempoStyle += 'border:0px;';
      tempoStyle += 'margin:0px;';
      tempoStyle += 'padding:0px;';

      //var tempo = '<iframe style="'+tempoStyle+'" src="'+tempoUrl+'"></iframe>';
      var tempo = tempoUrl;
      */

      $$('#frame_map').val( getUrl() );
      
      if ( $$('#set_tracking').val() == '1')
      {
        menuGeoloc();
      }
      
    });

    map.on('pointermove', function(e) {
        if (e.dragging)
        {
          if (isXs() == true)
          {
            $$('#map-point-select-detail-text-xs').html( '' );
            $$('#map-point-select-detail-xs').hide();
            $$('#popup_id').val( '' );
          }
          else
          {// $$(element).popover('destroy');
            //$$(element).popover('hide');
            $$('#map-point-select-detail-text').html( '' );
            $$('#map-point-select-detail').hide();
            $$('#popup_id').val( '' );
          }
          return;
        }
        var pixel = map.getEventPixel(e.originalEvent);
        var hit = map.hasFeatureAtPixel(pixel);
    });

    //initLayerPoint();
    /*
    if (layerPointJson == null)
    {
      initLayerPoint();
    }
    else
    {
      addLayerPoint(layerPointJson);
    }
    */

    if (typeof(layerPointWktJson) != 'undefined')
    {
      addLayerPointWkt(layerPointWktJson);
    }

    if (typeof(layerPointJson) != 'undefined')
    {
      addLayerPoint(layerPointJson);
    }

    var exportPNGElement = document.getElementById('menu_print');
    
    if (exportPNGElement != null)
    {
      if ('download' in exportPNGElement) {
        exportPNGElement.addEventListener('click', function(e) {
          map.once('postcompose', function(event) {
            var canvas = event.context.canvas;
            exportPNGElement.href = canvas.toDataURL('image/png');
          });
          map.renderSync();
        }, false);
      } else {
        var info = document.getElementById('no-download');
        /**
         * display error message
         */
        info.style.display = '';
      }
    }

    $('#map-point-select-detail').on('click', '#lien_etablissement', function (event) {
      console.log('windowOpen', windowOpen);

      if (windowOpen == null)
      {
        windowOpen = window.open( $(this).attr('href') ,'_blank');
      }
      else
      {
        windowOpen.location.href = $(this).attr('href');
      }
      
      //console.log('click lien href : ', $(this).attr('href'));
      //window.location.href = $(this).attr('href');
      closePopupTimeout = false;
      event.preventDefault();
      event.stopPropagation();
    });

    $('#map-point-select-detail').on('click', function (event) {
      closePopupTimeout = false;
      event.preventDefault();
      event.stopPropagation();
    });

    //initGeoloc();

    //autoRefresh();

    if (typeof(callback) == 'function')
    {
      callback();
    }
}

function initProjection()
{
  projection = new ol.proj.Projection({
    code: 'EPSG:2154',
    units: 'm'
  });

  projection2 = new ol.proj.Projection({
    code: 'EPSG:3944', //code: 'EPSG:3857',
    units: 'm'
  });
}

function initLayerTile()
{
  var sourceImageMapGuide = new ol.source.ImageMapGuide({
    projection: projection,
    url: agentUrl,
    useOverlay: false,
    metersPerUnit: 1, //2915.56, //value returned from mapguide
    params: {
      MAPDEFINITION: mdf,
      FORMAT: 'PNG'
    },
    ratio: 2
  });

  sourceImageMapGuide.on('imageloadstart', function(evt){
    $$('#map-loading').show();
  });

  sourceImageMapGuide.on('imageloadend', function(evt){
    $$('#map-loading').hide();
    $$('.ol-logo-only').remove();
  });

  // calque image d'affichage de mapguide
  listLayers.push(
    new ol.layer.Image({
      extent: bounds,
      source: sourceImageMapGuide,
      title: 'fond_plan'
    })
  );

  listLayers.push(
    new ol.layer.Vector({
      source: new ol.source.Vector(),
      visible: true,
      title: 'recherche_result'
    })
  );
}

function initLayerPointOld()
{
  $.ajax({
    method: 'GET',
    dataType: 'json',
    url: 'mapapi.php',
    data: {
      action: 'get_layers_point'
    }
  })
  .done(function( json ) {
    addLayerPoint(json);
  });
}

function addLayerPoint(json)
{
  console.log(json);
  var iconFeatures = new Array();
  for (var i in json)
  {
    var iconFeature = new ol.Feature({
      geometry: new ol.geom.Point([ json[i]['LABX'], json[i]['LABY']])
    });

     var iconStyle = new ol.style.Style({
        image: new ol.style.Icon(iconStyleParams)
      });

    iconFeature.setStyle( iconStyle );

    for (var j in json[i])
    {
      if (j != 'LABX' && j != 'LABY')
      {
        iconFeature.set(j, json[i][j]);
      }
    }

    iconFeatures.push( iconFeature );
  }

  var transparent = 0.90;
  var colorFill = [0, 128, 0, transparent];
  var colorStroke = [0, 255, 0, transparent];

  map.addLayer(
      new ol.layer.Vector({
          source: new ol.source.Vector({
              features: iconFeatures
          }),
          visible: true,/*,
          style: new ol.style.Style({
            image: new ol.style.Circle({
              radius: 8,
              fill: new ol.style.Fill({color: colorFill}),
              stroke: new ol.style.Stroke({color: colorStroke, width: 1})
            })
          }),*/
          title: 'point',
      })
  );
}

function addLayerPointOld(json)
{
    for (var i in json)
    {
        var iconFeatures = new Array();
        for (var j in json[i])
        {
            var iconStyleParamsTempo = iconStyleParams;
            // iconStyleParamsTempo.src = json[i][j]['icon'];
            //iconStyleParamsTempo.src = 'mapshtml/puces/puce_bleue_claire_small.png';
            iconStyleParamsTempo.src = json[i][j]['puce'];
            //iconStyleParamsTempo.scale = 0.5;


            //if (iconStyleParamsTempo.src == 'mapshtml/picto/gymnase.png')
            if (iconStyleParamsTempo.src == 'mapshtml/puces/vierge-gris.png')
            {
                //iconStyleParamsTempo.scale = 1;
            }

            var iconFeature = new ol.Feature({
              geometry: new ol.geom.Point([ json[i][j]['x'], json[i][j]['y']]),
              name: formatPopup(json[i][j]['icon'], json[i][j]['nom_equipement']),
              /*  '<p><img src="' + json[i][j]['icon'] + '" /> '
                + json[i][j]['libelle_affichage'] + '</p>',*/
              /*
              name:
                json[i][j]['libelle_affichage'] + '<br />'
                + json[i][j]['nomencl_niveau2'] + '<br />'
                + json[i][j]['nomencl_niveau3'] + '<br />'
                + json[i][j]['nomencl_niveau4'] + '<br />',
              */
              iconGrande: json[i][j]['icon'],
              scaleGrande: 1,
              iconPetite: iconStyleParamsTempo.src,
              scalePetite: iconStyleParamsTempo.scale,
              population: 4000,
              rainfall: 500
            });
            iconFeature.setStyle(
                new ol.style.Style({
                    image: new ol.style.Icon( iconStyleParamsTempo )
                })
            );

            iconFeatures.push( iconFeature );
        }

        //listLayers.push(
        map.addLayer(
            new ol.layer.Vector({
                source: new ol.source.Vector({
                    features: iconFeatures
                }),
                visible: true,
                title: i
            })
        );
    }
}

function addLayerPointWkt( data )
{
  console.log('addLayerPointWkt', data);
  var format = new ol.format.WKT();
  var features = new Array();
  var color = ['0', '3', '2'];

  for (var i in data)
  {
    if (typeof(data[i]['GEOMETRY']) != 'undefined')
    {
      var feature = format.readFeature( data[i]['GEOMETRY'] );

      for (var j in data[i])
      {
        if (j != 'GEOMETRY')
        {
          feature.set(j, data[i][j]);
        }
      }

      setStyleFeature(feature, color[Math.floor(Math.random() * color.length)], data[i]['IDPARC']);

      features.push( feature );
    }
  }

  map.addLayer(
    new ol.layer.Vector({
      source: new ol.source.Vector({
        features: features
      }),
      visible: true,
      title: 'Parcelle'
    })
  );

}


function changePosition(x, y)
{
    map.getView().setCenter([x, y]);
    setTimeout(function() { startOpenPopup(map.getPixelFromCoordinate([x, y])); }, 20);
    
    //map.getView().getCenter()
}

function toggleCalque(cle)
{
    var layersTempo = map.getLayers().getArray();
    for (var i in layersTempo)
    {
        if (layersTempo[i].get('title') == cle)
        {
            if (layersTempo[i].getVisible() == true)
            {
                layersTempo[i].setVisible( false );
                $$('#button_calque_' + cle)
                    .removeClass('btn-success')
                    .addClass('btn-danger');
            }
            else
            {
                layersTempo[i].setVisible( true );
                $$('#button_calque_' + cle)
                    .removeClass('btn-danger')
                    .addClass('btn-success');
            }
        }
    }
}

function showCalque(cle)
{
    var layersTempo = map.getLayers().getArray();
    for (var i in layersTempo)
    {
        if (layersTempo[i].get('title') == cle)
        {
            layersTempo[i].setVisible( true );
        }
    }
}

function hideCalque(cle)
{
    var layersTempo = map.getLayers().getArray();
    for (var i in layersTempo)
    {
        if (layersTempo[i].get('title') == cle)
        {
            layersTempo[i].setVisible( false );
        }
    }
}


function toggleCalqueXs(cle)
{
    var layersTempo = map.getLayers().getArray();
    for (var i in layersTempo)
    {
        if (layersTempo[i].get('title') == cle)
        {
            if (layersTempo[i].getVisible() == true)
            {
                layersTempo[i].setVisible( false );
                $$('#button_calque_xs_' + cle)
                    .removeClass('btn-success')
                    .addClass('btn-danger');
            }
            else
            {
                layersTempo[i].setVisible( true );
                $$('#button_calque_xs_' + cle)
                    .removeClass('btn-danger')
                    .addClass('btn-success');
            }
        }
    }
}

function getCalque(cle)
{
    var retour = null;
    var layersTempo = map.getLayers().getArray();
    for (var i in layersTempo)
    {
        if (layersTempo[i].get('title') == cle)
        {
            retour = layersTempo[i];
        }
    }

    return retour;
}

function toggleMenuCalque()
{
    if($$('#menu_calque').css('display') !== 'none')
    {
        $$('#menu_calque').hide();
        $$('#dropdownMenu1')
          .removeClass('btn-info')
          .addClass('btn-primary');
    }
    else
    {
        $$('#menu_calque').show();
        $$('#dropdownMenu1')
          .removeClass('btn-primary')
          .addClass('btn-info');
    }
}

function toggleMenuCalqueXs()
{
  $$('#modal_menu_calque').modal('show');
}

function mapCenter(x, y, title, zoom, icon, puce)
{
  if (typeof(zoom) != 'undefined')
  {
    map.getView().setZoom(zoom);
  }

  if (typeof(icon) == 'undefined'
    || icon == '')
  {
    icon = 'mapshtml/puces/vierge-gris.png';
  }

  if (isXs() == true)
  {
    $$('#map-point-select-detail-text-xs').html( '' );
    $$('#map-point-select-detail-xs').hide();
    $$('#popup_id').val( '' );
  }
  else
  {// $$(element).popover('destroy');
    // $$(element).popover('hide');
    $$('#map-point-select-detail-text').html( '' );
    $$('#map-point-select-detail').hide();
    $$('#popup_id').val( '' );
  }

  //title = '<p class="popup_p"><img src="' + icon + '" /> ' + title + '</p>';
  //title = '<img class="popup_img" src="' + icon + '" /><p class="popup_p">' + title + '</p>';
  //title = formatPopup(icon, title);

  map.getView().setCenter([x, y]);


  var iconStyleParamsTempo = iconStyleParams;
  //console.log('icon', icon);
  iconStyleParamsTempo.src = icon; // 'mapshtml/picto/gymnase.png';
  iconStyleParamsTempo.scale = 1;
  
  var iconFeature = new ol.Feature({
    geometry: new ol.geom.Point([ x, y]),
    //name: title,
    name: formatPopup(icon, title),

    iconGrande: icon,
    scaleGrande: 1,
    iconPetite: puce,
    scalePetite: 1,

    population: 4000,
    rainfall: 500
  });




  iconFeature.setStyle(
      new ol.style.Style({
          image: new ol.style.Icon( iconStyleParamsTempo )
      })
  );

  var layerRR = getCalque('recherche_result');
  if(layerRR != null)
  {
    layerRR.getSource().clear();
    layerRR.getSource().addFeature( iconFeature );

    // $$(element).popover('destroy');
    //$$(element).popover('hide');
    //setTimeout(function() {
    if (isXs() == true)
    {
      //$$('#map-point-select-detail-text-xs').html( '<img src="'+icon+'" /> ' + iconFeature.get('name') );
      $$('#map-point-select-detail-text-xs').html( iconFeature.get('name') );
      $$('#map-point-select-detail-xs').show();
    }
    else
    {
      var geometry = iconFeature.getGeometry();
      var coord = geometry.getCoordinates();
      /*
      popup.setPosition(coord);
      $$(element).popover({
          'placement': 'top',
          'html': true,
          'content': iconFeature.get('name')
      });
      $$(element).popover('show');
      */

      // TODO
      popup2.setPosition(coord);
      // $$('#map-point-select-detail-text').html( '<img src="'+icon+'" /> ' + iconFeature.get('name') );
      $$('#map-point-select-detail-text').html( iconFeature.get('name') );
      $$('#map-point-select-detail').show();
    }
    //}, 150);

  }
  else
  {
    console.log('layer recherche_result is null');
  }

  //$$('#map-recherche-result').hide();
}

function mapRecherche(word, page, type)
{
  if (word.length == 0)
  {
    var cssPlus = '';
    if (type == 'xs')
    {
      cssPlus = '-xs';
    }
    $$('#map-recherche-result'+cssPlus).html( '' );
    $$('#map-recherche-result'+cssPlus).hide();
    return false;
  }

  var limit;
  if (typeof(type) != 'undefined'
    && type == 'xs')
  {
    limit = 5;
  }
  else
  {
    limit = 10;
  }
  
  $.ajax({
    method: 'GET',
    dataType: 'json',
    url: 'mapapi.php',
    data: {
      action: 'get_recherche',
      word: word,
      page: page,
      type: typeRecherche,
      limit: limit
    }
  })
  .done(function( json ) {
    var html = '';
    var compte = json['count'];
    var sPageLimit = limit;
    var nbPage = Math.ceil( (compte / limit) );
    var cssPlus = '';
    var adr1 = '';
    var adr2 = '';
    if (type == 'xs')
    {
      cssPlus = '-xs';
    }

    // ajout de la barre de progression
    var projectionPourcent = ((page * 100) / nbPage);
    var progression = '<div class="progress" id="recherche-progress-bar">';
    progression += '<div class="progress-bar progress-bar-info" role="progressbar"';
    progression += ' aria-valuenow="'+projectionPourcent+'" aria-valuemin="0" aria-valuemax="100" style="width: '+projectionPourcent+'%">';
    progression += '<span class="sr-only">'+projectionPourcent+'% Complete (success)</span>';
    progression += '</div>';
    progression += '</div>';

    html += '<div id="map-recherche-result-html'+cssPlus+'" class="panel panel-default">';

    html += '<div class="panel-heading"><span class="glyphicon glyphicon-plus"></span> Nombre de r&eacute;sultat : ' + compte + '</div>';
    html += progression;

    html += '<div class="list-group">';
    
    json = json['data'];




    for (var i in json)
    {
      adr1 = '';
      adr2 = '';
      if (typeRecherche == 'adresse')
      {
        adr1 = json[i]['adr1'];
        adr2 = json[i]['adr2'];
      }
      else if (typeRecherche == 'equipement')
      {
        adr1 = json[i]['nom_equipement'];
        adr2 = '';
      }


      html += '<a href="#" class="list-group-item map-recherche-result-one"';
      html +=' id="map-recherche-result-one-'+i+'"';

      html +=' data-point-icon="' + json[i]['icon'] + '"';
      html +=' data-point-puce="' + json[i]['puce'] + '"';
      html +=' data-point-x="' + json[i]['x'] + '"';
      html +=' data-point-y="' + json[i]['y'] + '"';
      html +=' data-point-adr1="' + adr1 + '"';
      html +=' data-point-adr2="' + adr2 + '"';
      html +=' onclick="javascript:clickPoint(\'' + i + '\');return false;">';

      if (typeRecherche == 'adresse')
      {
        html += '<span class="map-recherche-result-one-parti1">';
        html += adr1;
        html += '</span> - ';
        html += '<span class="map-recherche-result-one-parti2">';
        html += adr2;
        html += '</span>';
      }
      else if (typeRecherche == 'equipement')
      {
        html += '<img src="' + json[i]['icon'] + '" /> ';
        html += '<span class="map-recherche-result-one-parti1">';
        html += adr1;
        html += '</span>';
      }

      html += '</a></small>';
    }



    /*
    if (typeRecherche == 'adresse')
    {
      for (var i in json)
      {
        html += '<a href="#" class="list-group-item map-recherche-result-one"';
        html +=' id="map-recherche-result-one-'+i+'"';

        html +=' data-point-x="' + json[i]['x'] + '"';
        html +=' data-point-y="' + json[i]['y'] + '"';
        html +=' data-point-adr1="' + json[i]['adr1'] + '"';
        html +=' data-point-adr2="' + json[i]['adr2'] + '"';
        html +=' onclick="javascript:clickPoint(\'' + i + '\');return false;">';

        html += '<span class="map-recherche-result-one-parti1">';
        html += json[i]['adr1'];
        html += '</span> - ';
        html += '<span class="map-recherche-result-one-parti2">';
        html += json[i]['adr2'];
        html += '</span>';

        html += '</a></small>';
      }
    }
    else if (typeRecherche == 'equipement')
    {
      for (var i in json)
      {
        html += '<a href="#" class="list-group-item map-recherche-result-one"';
        html +=' id="map-recherche-result-one-'+i+'"';

        html +=' data-point-icon="' + json[i]['icon'] + '"';
        html +=' data-point-puce="' + json[i]['puce'] + '"';
        html +=' data-point-x="' + json[i]['x'] + '"';
        html +=' data-point-y="' + json[i]['y'] + '"';
        html +=' data-point-adr1="' + json[i]['libelle_affichage'] + '"';
        html +=' data-point-adr2=""';
        html +=' onclick="javascript:clickPoint(\'' + i + '\');return false;">';

        html += '<img src="' + json[i]['icon'] + '" /> ';
        html += '<span class="map-recherche-result-one-parti1">';
        html += json[i]['libelle_affichage'];
        html += '</span>';

        html += '</a></small>';
      }
    }
    */
    
    html += '</div>';

    html += '<div class="panel-footer" id="map-recherche-result-footer">';

    html += '<ul class="pagination pagination-sm" id="map-recherche-result-pagination">';
    
    pagination = '<li';
    if (page == 1)
    {
      pagination += ' class="disabled"';
    }
    pagination += '><a href="#"';

    if (page != 1)
    {
      pagination += ' onclick="javascript:mapRecherche(\''+word+'\', '+(page-1)+', \''+type+'\');return false;"';
    }

    pagination += '>&laquo;</a></li>';


    var pageStart = 1;

    if (nbPage > 5)
    {
      var nbPageEnd = 5;
    }
    else
    {
      var nbPageEnd = nbPage;
    }

    if (page > 3
      && nbPage > 5)
    {
      if ((nbPage - page) > 2)
      {
        pageStart = page - 2;
      }
      else
      {
        pageStart = nbPage - 4;
      }
    }

    for (var i = 0; i < nbPageEnd; i++)
    {
      var pageTemp = pageStart + i;
      pagination += '<li';

      if (page == pageTemp)
      {
        pagination += ' class="active"';
      }

      pagination += '><a href="#"';

      if (page != pageTemp)
      {
        pagination += ' onclick="javascript:mapRecherche(\''+word+'\', '+pageTemp+', \''+type+'\');return false;"';
      }

      pagination += '>' + pageTemp + '</a></li>';
    }
    
    pagination += '<li';

    if (page == nbPage)
    {
      pagination += ' class="disabled"';
    }

    pagination += '><a href="#"';

    if (page != nbPage)
    {
      pagination += ' onclick="javascript:mapRecherche(\''+word+'\', '+(page + 1) +', \''+type+'\');return false;"';
    }

    pagination += '>&raquo;</a></li>';

    if (nbPage > 0)
    {
      html += pagination;
    }
    
    html += '</ul>';
    
    html += '</div>';

    html += '</div>';

    html += '<div id="map-recherche-result-html-focusout'+cssPlus+'" class="panel panel-default" style="display:none;">';
    html += '<div class="panel-heading"><span class="glyphicon glyphicon-minus"></span> Nombre de r&eacute;sultat : ' + compte + '</div>';
    html += progression;
    html += '</div>';


    $$('#map-recherche-result'+cssPlus).html( html );
    $$('#map-recherche-result'+cssPlus).show();

    $$('#map-recherche-result-html-focusout'+cssPlus).click(function() {
      $$('#map-recherche-result-html-focusout'+cssPlus).hide();
      $$('#map-recherche-result-html'+cssPlus).show();
    });

    $$('#map-recherche-result-html'+cssPlus+' > .panel-heading').click(function() {
      $$('#map-recherche-result-html'+cssPlus).hide();
      $$('#map-recherche-result-html-focusout'+cssPlus).show();
    });
  });
}

function toggleAllCalque()
{
  var visibleCalque = true;
  var removeClass = 'btn-danger';
  var addClass = 'btn-success';
  var layersTempo = map.getLayers().getArray();

  if ($$('#toggleAllCalque > span').hasClass('glyphicon-eye-open') == true)
  {
    visibleCalque = false;
    removeClass = 'btn-success';
    addClass = 'btn-danger';

    $$('#toggleAllCalque > span')
      .removeClass('glyphicon-eye-open')
      .addClass('glyphicon-eye-close');

    $$('#toggleAllCalque')
      .removeClass('label-success')
      .addClass('label-danger');
  }
  else
  {
    //visibleCalque = true;
    $$('#toggleAllCalque > span')
      .removeClass('glyphicon-eye-close')
      .addClass('glyphicon-eye-open');

    $$('#toggleAllCalque')
      .removeClass('label-danger')
      .addClass('label-success');
  }

  var layersTempo = map.getLayers().getArray();
  for (var i in layersTempo)
  {
    if (layersTempo[i].get('title') != 'fond_plan'
      && layersTempo[i].get('title') != 'recherche_result')
    {
      layersTempo[i].setVisible( visibleCalque );

      $$('#button_calque_' + layersTempo[i].get('title') )
        .removeClass( removeClass )
        .addClass( addClass );
    }
  }
}

function toggleAllCalqueXs()
{
  var visibleCalque = true;
  var removeClass = 'btn-danger';
  var addClass = 'btn-success';
  var layersTempo = map.getLayers().getArray();

  if ($$('#toggleAllCalque-xs > span').hasClass('glyphicon-eye-open') == true)
  {
    visibleCalque = false;
    removeClass = 'btn-success';
    addClass = 'btn-danger';

    $$('#toggleAllCalque-xs > span')
      .removeClass('glyphicon-eye-open')
      .addClass('glyphicon-eye-close');

    $$('#toggleAllCalque-xs')
      .removeClass('label-success')
      .addClass('label-danger');
  }
  else
  {
    //visibleCalque = true;
    $$('#toggleAllCalque-xs > span')
      .removeClass('glyphicon-eye-close')
      .addClass('glyphicon-eye-open');

    $$('#toggleAllCalque-xs')
      .removeClass('label-danger')
      .addClass('label-success');
  }

  var layersTempo = map.getLayers().getArray();
  for (var i in layersTempo)
  {
    if (layersTempo[i].get('title') != 'fond_plan'
      && layersTempo[i].get('title') != 'recherche_result')
    {
      layersTempo[i].setVisible( visibleCalque );

      $$('#button_calque_xs_' + layersTempo[i].get('title') )
        .removeClass( removeClass )
        .addClass( addClass );
    }
  }
}

function clickPoint(i)
{
  var icon = $$('#map-recherche-result-one-' + i).attr('data-point-icon');
  var puce = $$('#map-recherche-result-one-' + i).attr('data-point-puce');
  var x = parseFloat( $$('#map-recherche-result-one-' + i).attr('data-point-x') );
  var y = parseFloat( $$('#map-recherche-result-one-' + i).attr('data-point-y') );
  var title = 
    $$('#map-recherche-result-one-' + i).attr('data-point-adr1')
    + '<br />'
    + $$('#map-recherche-result-one-' + i).attr('data-point-adr2');
  isPopupClick = true;
  mapCenter(x, y, title, 18, icon, puce);
  if (isXs() == true)
  {
    $$('#map-recherche-result-html-xs').hide();
    $$('#map-recherche-result-html-focusout-xs').show();
  }
  else
  {
    $$('#map-recherche-result-html').hide();
    $$('#map-recherche-result-html-focusout').show();
  }
}

function mapRechercheVersBas()
{
  if ( $$('#map-recherche-result-html > .list-group > a').hasClass( 'list-group-item-info' ) == false )
  {
    $$('#map-recherche-result-html > .list-group > a').first().addClass( 'list-group-item-info' );
  }
  else
  {
    var firstElement = null;
    var selectElement = false;
    var isFinish = false;

    $$('#map-recherche-result-html > .list-group > a').each(function( index, element ) {

      if (isFinish == false)
      {
        if (index == 0)
        {
          firstElement = element;
        }

        if (selectElement == true)
        {
          $$('#map-recherche-result-html > .list-group > a').removeClass( 'list-group-item-info' );
          $$(element).addClass( 'list-group-item-info' );
          selectElement = false;
          isFinish = true;
        }
        else if ( $$(element).hasClass( 'list-group-item-info' ) == true )
        {
          if (index == 9)
          {
            $$('#map-recherche-result-html > .list-group > a').removeClass( 'list-group-item-info' );
            $$(firstElement).addClass( 'list-group-item-info' );
          }
          else
          {
            selectElement = true;
          }
        }
      }

    });
  }
}

function mapRechercheVersHaut()
{
  if ( $$('#map-recherche-result-html > .list-group > a').hasClass( 'list-group-item-info' ) == false )
  {
    $$('#map-recherche-result-html > .list-group > a').last().addClass( 'list-group-item-info' );
  }
  else
  {
    var precedentElement = null;
    var selectElement = false;
    var isFinish = false;

    $$('#map-recherche-result-html > .list-group > a').each(function( index, element ) {

      if (isFinish == false)
      {
        if ( $$(element).hasClass( 'list-group-item-info' ) == true )
        {
          if (index == 0)
          {
            $$('#map-recherche-result-html > .list-group > a').removeClass( 'list-group-item-info' );
            $$('#map-recherche-result-html > .list-group > a').last().addClass( 'list-group-item-info' );
            isFinish = true;
          }
          else
          {
            $$('#map-recherche-result-html > .list-group > a').removeClass( 'list-group-item-info' );
            $$(precedentElement).addClass( 'list-group-item-info' );
            isFinish = true;
          }
        }

        precedentElement = element;
      }
    });
  }
}

function menuZoomIn()
{
  var zoom = map.getView().getZoom()
  zoom = zoom + 1;
  map.getView().setZoom(zoom);
}

function menuZoomOut()
{
  var zoom = map.getView().getZoom();
  zoom = zoom - 1;
  map.getView().setZoom(zoom);
}

function menuFullscreen()
{
  //menu_fullscreen
  $$("#map").toggleFullScreen();

  if ( $$('#menu_fullscreen').hasClass('btn-info') == true )
  {
    $$('#menu_fullscreen')
      .removeClass('btn-info')
      .addClass('btn-primary');
    
  }
  else
  {
    $$('#menu_fullscreen')
      .removeClass('btn-primary')
      .addClass('btn-info');
  }
}

function setRechercheType(type)
{
  typeRecherche = type;
  $$('#map_recherche_type_name').attr('class', typeRechercheListe[typeRecherche]['icon'] );
  $$('#map_recherche_input').attr('placeholder', typeRechercheListe[typeRecherche]['libelle'] + '...');
  mapRecherche(  $$('#map_recherche_input').val(), 1 );
}

function setRechercheTypeV2(type)
{
  var listeType = ['equipement', 'adresse'];

  typeRecherche = type;

  for (var i in listeType)
  {
    if (type == listeType[i])
    {
      $$('#recherche_type_button_' + listeType[i]).removeClass('btn-default').addClass('btn-primary');
      $$('#recherche_type_button_' + listeType[i] + '_xs').removeClass('btn-default').addClass('btn-primary');
    }
    else
    {
      $$('#recherche_type_button_' + listeType[i]).removeClass('btn-primary').addClass('btn-default');
      $$('#recherche_type_button_' + listeType[i] + '_xs').removeClass('btn-primary').addClass('btn-default');
    }
  }

  $$('#map_recherche_input').attr('placeholder', typeRechercheListe[typeRecherche]['libelle'] + '...');
  mapRecherche(  $$('#map_recherche_input').val(), 1 );
}

function setRechercheTypeXs(type)
{
  typeRecherche = type;
  $$('#map_recherche_type_name-xs').attr('class', typeRechercheListe[typeRecherche]['icon'] );
  $$('#map_recherche_input-xs').attr('placeholder', typeRechercheListe[typeRecherche]['libelle'] + '...');
  mapRecherche(  $$('#map_recherche_input-xs').val(), 1 );
}

function setRechercheTypeXsV2(type)
{
  var listeType = ['equipement', 'adresse'];

  typeRecherche = type;

  for (var i in listeType)
  {
    if (type == listeType[i])
    {
      $$('#recherche_type_button_' + listeType[i] + '_xs').removeClass('btn-default').addClass('btn-primary');
      $$('#recherche_type_button_' + listeType[i]).removeClass('btn-default').addClass('btn-primary');
    }
    else
    {
      $$('#recherche_type_button_' + listeType[i] + '_xs').removeClass('btn-primary').addClass('btn-default');
      $$('#recherche_type_button_' + listeType[i]).removeClass('btn-primary').addClass('btn-default');
    }
  }

  //$$('#map_recherche_type_name-xs').attr('class', typeRechercheListe[typeRecherche]['icon'] );
  $$('#map_recherche_input-xs').attr('placeholder', typeRechercheListe[typeRecherche]['libelle'] + '...');
  mapRecherche(  $$('#map_recherche_input-xs').val(), 1 );
}

function isXs()
{
  if ($$(window).width() < 768)
  {
    return true;
  }
  else
  {
    return false;
  }
}

function menuGeoloc()
{
  var track = true;
  if ( $$('#set_tracking').val() == '1')
  {
    track = false;
    $$('#set_tracking').val('0');
    $$('.menu_geoloc')
      .removeClass('btn-success')
      .addClass('btn-primary');
    console.log('remove "btn-primary", add "btn-success');
  }
  else
  {
    track = true;
    $$('#set_tracking').val('1');
    $$('.menu_geoloc')
      .removeClass('btn-primary')
      .addClass('btn-success');
    console.log('remove "btn-success", add "btn-primary');
  }

  console.log('set_tracking', track);

  geolocation.setTracking( track );
}

function ajoutePoint(listePoints)
{
  //var iconFeatures = new Array( listePoints.length );
  var iconFeatures = new Array();

  for (var i in listePoints)
  {
    var iconStyleParamsTempo = iconStyleParams;
    //iconStyleParamsTempo.src = listePoints[i]['puce'];
    iconStyleParamsTempo.src = listePoints[i]['icon'];

    /*
    var iconFeature = new ol.Feature({
      geometry: new ol.geom.Point([ listePoints[i]['x'], listePoints[i]['y']]),
      name: listePoints[i]['libelle_affichage'],
      population: 4000,
      rainfall: 500
    });
    */
    var iconFeature = new ol.Feature({
      geometry: new ol.geom.Point([ parseFloat(listePoints[i]['x']), parseFloat(listePoints[i]['y']) ]),
      //name: '<p><img src="' + listePoints[i]['icon'] + '" /> ' + listePoints[i]['libelle_affichage'] + '</p>',
      name: formatPopup(listePoints[i]['icon'], listePoints[i]['nom_equipement']),
      iconGrande: listePoints[i]['icon'],
      scaleGrande: 1,
      iconPetite: iconStyleParamsTempo.src,
      scalePetite: iconStyleParamsTempo.scale,
      population: 4000,
      rainfall: 500
    });
    
    iconFeature.setStyle(
      new ol.style.Style({
          image: new ol.style.Icon( iconStyleParamsTempo )
      })
    );

    iconFeatures.push( iconFeature );

    //iconFeatures[i] = iconFeature;
  }

  var vectorSource = new ol.source.Vector({
    features: iconFeatures
  });

  map.addLayer(
    new ol.layer.Vector({
      source: vectorSource,
      visible: true,
      title: 'liste_id'
    })
  );
}

function formatPopup(icon, title)
{
  return '<img class="popup_img" src="' + icon + '" /><p class="popup_p">' + title + '</p>';
}


function initLayerPoint(reload)
{
  if (typeof(reload) == 'undefined')
  {
    reload = false;
  }

  var format = new ol.format.WKT();
  var type = '';

  var bureau = new Array();
  var bureauFeature = new Array();

  var color = ['0', '3', '2'];

  for (var i in layerJson)
  {
    if (typeof(layerJson[i]['GEOMETRY']) != 'undefined')
    {
      var bureauFeature = format.readFeature( layerJson[i]['GEOMETRY'] );

      for (var j in layerJson[i])
      {
        if (j != 'GEOMETRY')
        {
          bureauFeature.set(j, layerJson[i][j]);
        }
      }

      setStyleFeature(bureauFeature, color[Math.floor(Math.random() * color.length)], layerJson[i]['NUM_BUREAU']);

      bureau.push( bureauFeature );
    }
  }

  
  var quartier = new Array();
  var quartierFeature = new Array();

  var color = ['0', '3', '2'];

  for (var i in layerQuartierJson)
  {
    if (typeof(layerQuartierJson[i]['GEOMETRY']) != 'undefined')
    {
      var quartierFeature = format.readFeature( layerQuartierJson[i]['GEOMETRY'] );

      for (var j in layerQuartierJson[i])
      {
        if (j != 'GEOMETRY')
        {
          quartierFeature.set(j, layerQuartierJson[i][j]);
        }
      }

      setStyleFeatureQuartier(quartierFeature, color[Math.floor(Math.random() * color.length)], layerQuartierJson[i]['NUM_BUREAU']);

      quartier.push( quartierFeature );
    }
  }


  if (reload == true)
  {
    var layersTempo = map.getLayers().getArray();
    for (var i in layersTempo)
    {
      if (typeof(layersTempo[i].get) == 'function')
      {
        if (layersTempo[i].get('title') == 'bureau')
        {
            layersTempo[i].setSource(
              new ol.source.Vector({
                features: bureau
              })
            );
        }
        else if (layersTempo[i].get('title') == 'quartier')
        {
            layersTempo[i].setSource(
              new ol.source.Vector({
                features: quartier
              })
            );
        }
      }
    }
  }
  else
  {

    map.addLayer(
      new ol.layer.Vector({
        source: new ol.source.Vector({
          features: quartier
        }),
        visible: true,
        title: 'quartier'
      })
    );

    map.addLayer(
      new ol.layer.Vector({
        source: new ol.source.Vector({
          features: bureau
        }),
        visible: true,
        title: 'bureau'
      })
    );
  }
}

function setStyleFeature(oFeature, statut, text)
{
  if (typeof(oFeature) != 'undefined')
  {
    var colorFond = '';

    var colorCastaner, colorEstrosi, colorLepen = '';

    /*
    colorCastaner = '#FDD9D9';
    colorEstrosi = '#D2ECFD';
    colorLepen = '#8484ED';
    colorEgalite = '#888888';
    */

    var transparent = 0.5;
    colorCastaner = [253, 150, 150, transparent]; // [253, 217, 217, transparent];
    colorEstrosi = [200, 206, 253, transparent]; // [210, 236, 253, transparent];
    colorLepen = [0, 0, 255, transparent]; //[132, 132, 237, transparent];
    colorEgalite = [127, 127, 127, transparent];
    colorVide = [255, 255, 255, transparent];
    colorVert = [0, 255, 0, transparent];
    colorRouge = [255, 0, 0, transparent];

    colorFond = colorEstrosi;

    /*
    if (bureau == 1)
    {
      if (oFeature.get( tag ) == 1)
      {
       colorFond = colorVert;
      }
      else
      {
        colorFond = colorVide;
      }
    }
    else if (tour == 1)
    {
      if (oFeature.get('NB_VOIX1') == oFeature.get('NB_VOIX2'))
      {
        colorFond = colorEgalite;
      }
      if (oFeature.get('ID_CAND1') == 495)
      {
        colorFond = colorEstrosi;
      }
      else if (oFeature.get('ID_CAND1') == 496)
      {
        colorFond = colorCastaner;
      }
      else if (oFeature.get('ID_CAND1') == 494)
      {
        colorFond = colorLepen;
      }
      else
      {
        colorFond = colorVide;
      }
      
    }
    else
    {
      if (oFeature.get('NB_VOIX1') > oFeature.get('NB_VOIX2'))
      {
        colorFond = colorLepen;
      }
      else if (oFeature.get('NB_VOIX1') < oFeature.get('NB_VOIX2'))
      {
        colorFond = colorEstrosi;
      }
      else if (oFeature.get('NB_VOIX1') == oFeature.get('NB_VOIX2')
        && oFeature.get('NB_VOIX1') > 0)
      {
        colorFond = colorEgalite;
      }
      else
      {
        colorFond = colorVide;
      }
    }
    */

    

    var param = {
      fill: new ol.style.Fill({
        //color: 'rgba(0, 255, 0, 1)'
        color: colorFond, //'rgba(0, 255, 0, 1)'
        //opacity: 0.3
      }),
      stroke: new ol.style.Stroke({
        color: '#0000FF',
        width: 2
      }),
      text: new ol.style.Text({
        text: oFeature.get('NUM_BUREAU'),
        fill: new ol.style.Fill({
          color: '#000000',
          width: 4
        }),
        //scale: 1.2,
        font: '14px bold Arial Black,sans-serif'
        /*,
        stroke: new ol.style.Stroke({
          color: '#000000',
          
        })*/
      })
    };
   
    oFeature.setStyle(
      new ol.style.Style( param )
    );
  }
}

function setStyleFeatureQuartier(oFeature, statut, text)
{
  if (typeof(oFeature) != 'undefined')
  {
    var param = {
      stroke: new ol.style.Stroke({
        color: '#FF0000',
        width: 5,
        //lineDash: [20, 30]
      }),
      text: new ol.style.Text({
        text: oFeature.get('LIBELLE_QUARTIER'),
        fill: new ol.style.Fill({
          color: '#000000'
        }),
        font: '14px bold Arial Black,sans-serif'
      })
    };
   
    oFeature.setStyle(
      new ol.style.Style( param )
    );
  }
}

function formatPopupV2( feature )
{
  var retour = debug = '';

  /*'ID_DEM_PARC',
  'ID_DEMANDE',
  'ID_PARC',
  'LABX',
  'LABY',
  'ID_DEMANDEUR',
  'CONTACT',
  'REFERENCE',
  'DATE_DEMANDE',
  'DATE_REPONSE',
  'STATUT_DEMANDE',
  'STATUT_AEP',
  'STATUT_EU',
  'OBSERVATIONS',
  'ID_SIGNATAIRE',
  'URL_CARTE',
  'ID_ATTESTANT',
  'ID_INTERLOCUTEUR',*/

  // retour = '<div>';
  retour += '<div class="panel panel-default">';
  retour += '<div class="panel-heading">';

  retour += '<a id="lien_etablissement" href="index.php?P=301&from=0&demande='+feature.get('ID_DEMANDE')+'">';

  retour += 'No demande : ' + feature.get('ID_DEMANDE') + '<br />';
  retour += 'Nom : ' + feature.get('NOM') + '<br />';
    retour += 'Contact : ' + feature.get('CONTACT') + '<br />';

  retour += '</a>';

  retour += '</div>';
  retour += '</div>';
  return retour;

  /*
  var champ = [
    //'ANNEE_DECOUPAGE',
    //'LIB_NOM_BUREAU',
    'LIB_NUM_BUREAU',
    'NUM_BUREAU',
    //'ID_QUARTIER_ADMIN',
    //'LIB_QUARTIER',
    'CIRCONSCRIPTION',

    'ID_ELEC',
    'ID_BUREAU',
    'ID_CAND1',
    'NOM_CAND1',
    'NB_VOIX1',
    'ID_CAND2',
    'NOM_CAND2',
    'NB_VOIX2',

    'ID_BUREAU',
    'ID_ELEC',
    'NB_INSCRITS',
    'NB_VOTANTS',
    'NB_NULS',
    'NB_EXPRIMES',
    'NB_EMARGEMENTS',
    'NB_UN',
    'NB_DEUX',
    'NB_TROIS',
    'NB_QUATRE',
    'TAG',
    'NB_PROCURATIONS',
    'NB_CINQ',
    'TAG_TEL',
    'TAG_DIFFUSION',
    'HEURE_VALID',
    'HEURE_TEL',
    'NB_BLANCS'
  ];*/

  var champ = feature.getKeys();

  var champGlobal = {
    'NB_INSCRITS' : 'Nombre d\'inscrits',
    'NB_VOTANTS' : 'Votants',
    'POURCENTAGE_VOTANTS' : ''
    //'POURCENTAGE_NULS' : 'Nuls',
    //'POURCENTAGE_EXPRIMES' : 'Exprimes',
    //'POURCENTAGE_EMARGEMENTS' : 'Emargements'
  };

  var textGlobal = '';
  textGlobal += '<div class="row">';


  for (var i in champGlobal)
  {
    textGlobal += '<div class="col-sm-8">';
    //textGlobal += champGlobal[i] + ' : ';
    textGlobal += champGlobal[i];
    
    textGlobal += '</div>';
    textGlobal += '<div class="col-sm-4">';
    
    if (i == 'NB_INSCRITS'
      ||i == 'NB_VOTANTS')
    {
      textGlobal += feature.get(i);
    }
    else
    {
      textGlobal += parseFloat(feature.get(i)).toFixed(2) + ' %';
    }
    textGlobal += '</div>';
  }

  textGlobal += '</div>';

  /*
  [POURCENTAGE_VOTANTS] => 39.894086496028
  [POURCENTAGE_NULS] => 0.35304501323919
  [POURCENTAGE_EXPRIMES] => 39.27625772286
  [POURCENTAGE_EMARGEMENTS] => 39.894086496028
  */

  var textCandidat = '';
  textCandidat += '<div class="row">';

  if (tour == 1)
  {
    nbCandidat = 10;
  }
  else
  {
    nbCandidat = 2;
  }

  var candidatOk = false;

  for (i=1; i <= nbCandidat; i++)
  {
    if ( feature.get('NOM_CAND' + i) != 0)
    {
      candidatOk = true;
      textCandidat += '<div class="col-sm-8">';
      textCandidat += '<small>';
      textCandidat += feature.get('NOM_CAND' + i);
      textCandidat += '</small>';
      textCandidat += '</div>';

      textCandidat += '<div class="col-sm-4">';

      if (tour == 3)
      {
        textCandidat += parseFloat(feature.get('POURCENTAGE_CAND' + i)).toFixed(2) + ' %';
      }
      else
      {
        textCandidat += feature.get('NB_VOIX' + i);
      }
    }

    textCandidat += '</div>';
  }

  /*
  for (var i in champ)
  {
    debug += champ[i] + ' : ' + feature.get(champ[i]) + '<br />';
    console.log('champ[i]', champ[i]);

    //console.log('match', champ[i], champ[i].match('/NOM_CAND?/'));

    if (champ[i].match(/NOM_CAND/))
    {
      textCandidat += '<div class="col-sm-12">';
      textCandidat += feature.get(champ[i]) + ' : ';
    }
    else if (champ[i].match(/NB_VOIX/))
    {
      textCandidat += feature.get(champ[i]) + ' voix';
      textCandidat += '</div>';
    }
  }
  */

  textCandidat += '</div>';

  //return debug;

  retour = '';
  retour += '<div class="panel panel-default">';
  retour += '<div class="panel-heading">';
  retour += feature.get('NUM_BUREAU') +' - '+feature.get('LIB_NOM_BUREAU');
  retour += '<br /><small><i>' + feature.get('LIBELLE_QUARTIER') + '</i></small>';
  
  retour += '<button type="button" onclick="javascript;closePopup();return false;" class="close popup_button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';

  retour += '</div>';
  retour += '<div class="panel-body">';
  
  retour += textGlobal;

  retour += '</div>';

  retour += '<div class="panel-heading">R&eacute;sultats</div>';
  retour += '<div class="panel-body">';

  if (tour == 1)
  {
    retour += textCandidat;
  }
  else
  {
    if (candidatOk == true)
    {
      retour += textCandidat;
    }
    else
    {
      retour += 'Non valid&eacute;';
    }
  }

  retour += '</div>';
  
  
  

  retour += '  <div id="graphique">';
  retour += '  </div>';

  retour += '</div>';
  retour += '</div>';



  //retour += feature.get('LIB_NUM_BUREAU');

  return retour;
}


function saveUrl(argument) {
  $$('#retour_save').text('');
  $$.ajax({
    method: 'POST',
    dataType: 'json',
    url: 'index.php',
    data: {
      P: 601,
      url_carte: getUrl(),
      id_demande : $$('#id_demande').val()
    }
  })
  .done(function( json ) {
    
    if (json.retour == true)
    {
      $$('#retour_save').html('Enregistr&eacute;');
    }
    else
    {
      $$('#retour_save').html('Erreur');
    }

  });
}

function getUrl()
{
  var tempoUrl = hostname + '/';
  tempoUrl += '?P=7';
  tempoUrl += '&iframe=1';
  tempoUrl += '&center=' + map.getView().getCenter();
  tempoUrl += '&zoom=' + map.getView().getZoom();

  var tempoStyle = 'width:100%;';
  tempoStyle += 'height:100%;';
  tempoStyle += 'border:0px;';
  tempoStyle += 'margin:0px;';
  tempoStyle += 'padding:0px;';

  //var tempo = '<iframe style="'+tempoStyle+'" src="'+tempoUrl+'"></iframe>';
  return tempoUrl;
}

function startOpenPopup(pixel, typeEvent)
{
    if (typeof(typeEvent) == 'undefined') { typeEvent = 'click'; }

    openPopup(pixel, typeEvent);

    /*
    if ($(element).parent().find('.popover-content').text() != '')
    {
        // $(element).popover('destroy');
        //$(element).popover('hide');
        //setTimeout(function() {
          openPopup(pixel, typeEvent);
        //}, 150);
    }
    else
    {
        openPopup(pixel, typeEvent);
    }
    */
}


function openPopup(pixel, typeEvent)
{
    if (typeof(typeEvent) == 'undefined') { typeEvent = 'click'; }
    var feature = map.forEachFeatureAtPixel(
        pixel,
        function(feature, layer) {
            return feature;
        }
    );

    if (feature
      && typeof(feature.get('ID_PARC')) != 'undefined')
    {
      
      if (isFrame == false && isXs() == true)
      {

        //$('#map-point-select-detail-text-xs').html( feature.get('LIB_NUM_BUREAU') );
        $('#map-point-select-detail-text-xs').html( formatPopupV2( feature ) );
        $('#map-point-select-detail-xs').show();
        $('.progress-bar').tooltip();
        
        //startPopupV2(feature, 'xs');
      }
      else
      {
        var geometry = feature.getGeometry();
        //var coord = geometry.getCoordinates();
        // var coord = geometry.getInteriorPoint().getCoordinates();
        var coord = geometry.getCoordinates();
        

        popup2.setPosition(coord);
        console.log('setPosition', coord);
        
        /*
        //$('#map-point-select-detail-text').html( feature.get('LIB_NUM_BUREAU') );
        $('#map-point-select-detail-text').html( formatPopupV2( feature ) );
        $('#map-point-select-detail').show();
        $('.progress-bar').tooltip();
        startGraphique();
        */

        startPopupV2(feature);

        if (typeEvent == 'click')
        {
          isPopupClick = true;
        }
      }
    }
    else
    {
        if (isFrame == false && isXs() == true)
        {
          $('#map-point-select-detail-text-xs').html( '' );
          $('#map-point-select-detail-xs').hide();
          $('#popup_id').val( '' );
        }
        else
        {
          if (typeEvent == 'click'
            || isPopupClick == false)
          {
            $('#map-point-select-detail-text').html( '' );
            $('#map-point-select-detail').hide();
            $('#popup_id').val( '' );
          }

        }
    }
}

function startPopupV2(feature, size)
{
  if (size == 'xs')
  {
    size = '-xs';
  }
  else
  {
    size = '';
  }

  
  $('#popup_id').val( feature.get('ID_PARC') );

  var html = formatPopupV2( feature );
  // console.log('startPopupV2', html);
  $('#map-point-select-detail-text' + size).html( html );
  $('#map-point-select-detail' + size).show();

}

function openLink(id)
{
  console.log('openLink', id);
}