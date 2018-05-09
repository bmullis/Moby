<template>
    <div id="map">
        <div class="btnAddNew" v-on:click="toggleAdding">
            <i class="fa fa-plus"></i>
        </div>
        <div class="addNewMarker" v-if="adding">
            <h3>Add a New Sighting</h3>
            <label>You can enter the coordinates manually, or click on your desired location on the map to get the coordinates automatically.</label>
            <form class="form-group" v-on:submit.prevent="addSighting">
                <input class="form-control" type="text" name="lat" placeholder="Latitude" v-model="newmark.lat" v-bind:class="{ 'success': changed }" />
                <input class="form-control" type="text" name="long" placeholder="Longitude" v-model="newmark.long" v-bind:class="{ 'success': changed }" />
                <textarea class="form-control" name="description" placeholder="Add a brief description of this sighting" rows="5" v-model="newmark.description"></textarea>
                <button class="btn btn-md btn-primary" type="submit">Add Sighting</button>
            </form>
            <div class="addNewMarkerTip"></div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                adding: false,
                changed: false,
                sightings: {},
                newmark: {
                    description: '',
                    lat: '',
                    long: '',
                    user_id: '',
                    date_time: ''
                }
            }
        },
        mounted() {
            this.getThisUserSightings();
        },
        methods: {
            loadMap: function() {
                let self = this;

                var map = new Mapbox.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v10',
                    center: [ -124.87878, 45.9898 ],
                    zoom: 6
                });

                map.getCanvas().style.cursor = 'crosshair';

                map.on('load', function () {
                    map.loadImage('https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678111-map-marker-512.png', function(error, image) {
                        if (error) throw error;
                        map.addImage('marker', image);

                        map.addLayer({
                            "id": "markers",
                            "source": {
                                "type": "geojson",
                                "data": self.sightings
                            },
                            "type": "symbol",
                            "layout": {
                                "icon-image": "marker",
                                "icon-size": .07
                            }
                        });
                    });
                });

                let popup = new Mapbox.Popup({
                    closeButton: false,
                    closeOnClick: false,
                    anchor: "bottom",
                    offset: 25
                });

                map.on('click', function(e) {
                    self.newmark.lat = e.lngLat.lat;
                    self.newmark.long = e.lngLat.lng;
                    self.changed = true;
                    setTimeout(()=>{
                       self.changed = false;
                   }, 500);
                });

                map.on('mouseenter', 'markers', function (e) {
                    var coordinates = e.features[0].geometry.coordinates.slice();
                    var description = e.features[0].properties.description;
                    var date_time = e.features[0].properties.date_time;
                    map.getCanvas().style.cursor = 'pointer';

                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    popup.setLngLat(coordinates)
                        .setHTML('<h3>Sighting</h3>' + '<p>' + description + '</p>' + date_time)
                        .addTo(map);
                });

                // Change it back to a pointer when it leaves.
                map.on('mouseleave', 'markers', function () {
                    map.getCanvas().style.cursor = 'crosshair';
                    popup.remove();
                });
            },
            getThisUserSightings: function() {
                let self = this;

                axios.get('/api/sightings')
                    .then(function(response) {
                        console.log(response.data);
                        self.sightings = response.data;
                        self.loadMap();
                    });
            },
            toggleAdding: function() {
                let self = this;

                self.adding ? self.adding = false : self.adding = true;
            },
            addSighting: function() {
                axios.post()
                    .then();
            }
        }
    }
</script>
