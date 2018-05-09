<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sighting;
use DB;

class SightingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $data = Sighting::all();

        // Build GeoJSON feature collection array
        $geojson = array(
           'type'      => 'FeatureCollection',
           'features'  => array()
        );
        // Loop through rows to build feature arrays
        foreach($data as $row) {
            $feature = array(
                'type' => 'Feature',
                'geometry' => array(
                    'type' => 'Point',
                    // Pass Longitude and Latitude Columns here
                    'coordinates' => array($row['long'], $row['lat'])
                ),
                // Pass other attribute columns here
                'properties' => array(
                    'user_id' => $row['user_id'],
                    'description' => $row['description'],
                    'date_time' => $row['date_time']
                    )
                );
            // Add feature arrays to feature collection array
            array_push($geojson['features'], $feature);
        }
        return $geojson;
    }

    public function store() {

    }

    public function show($id) {
        return Sighting::find($id);
    }

    public function showByUser($user_id) {
        return DB::table('sightings')->where('user_id', $user_id)->get();
    }

    public function showByDate($date_time) {
        return DB::table('sightings')->whereDate('date_time', '>', $date_time)->get();
    }
}
