//crtanje rute ne radi -- vraća grešku request_denied

  function initMap2() {
    //var map = new google.maps.Map(document.getElementById('map'), {
    //  mapTypeControl: false,
    //  center: {lat: -33.8688, lng: 151.2195},
    //  zoom: 13
    //});

    new AutocompleteDirectionsHandler();
  }

  function AutocompleteDirectionsHandler() {
   // this.map = map;
    this.originPlaceId = null;
    this.destinationPlaceId = null;
    this.travelMode = 'DRIVING';
    var originInput = document.getElementById('StartPlaceNew');
    var destinationInput = document.getElementById('EndPlaceNew');
    var modeSelector = this.travelMode;
   // this.directionsService = new google.maps.DirectionsService;
   // this.directionsDisplay = new google.maps.DirectionsRenderer;
   // this.directionsDisplay.setMap(map);

    var originAutocomplete = new google.maps.places.Autocomplete(
        originInput, {placeIdOnly: true});
    var destinationAutocomplete = new google.maps.places.Autocomplete(
        destinationInput, {placeIdOnly: true});
        
    this.setupPlaceChangedListener(originAutocomplete, 'ORIG');
    this.setupPlaceChangedListener(destinationAutocomplete, 'DEST');
/*
    this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(originInput);
    this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(destinationInput);
    this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(modeSelector);
    */
  }

  AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(autocomplete, mode) {
    var me = this;
    //autocomplete.bindTo('bounds', this.map);
    autocomplete.addListener('place_changed', function() {
      var place = autocomplete.getPlace();
      if (!place.place_id) {
        window.alert("Please select an option from the dropdown list.");
        return;
      }
      if (mode === 'ORIG') {
        me.originPlaceId = place.place_id;
      } else {
        me.destinationPlaceId = place.place_id;
      }
      me.route();
    });

  };
/*
  AutocompleteDirectionsHandler.prototype.route = function() {
    if (!this.originPlaceId || !this.destinationPlaceId) {
      return;
    }
    var me = this;

    this.directionsService.route({
      origin: {'placeId': this.originPlaceId},
      destination: {'placeId': this.destinationPlaceId},
      travelMode: this.travelMode
    }, function(response, status) {
      if (status === 'OK') {
        me.directionsDisplay.setDirections(response);
      } else {
        window.alert('Directions request failed due to ' + status);
      }
    });
  };
*/
