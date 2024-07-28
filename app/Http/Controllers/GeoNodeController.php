<?php

namespace App\Http\Controllers;

use App\Models\DataGeojson;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class GeoNodeController extends Controller
{
    public function index()
    {
        $client = new Client();
        $url = 'https://geonode.pspig.online/geoserver/wms?request=GetCapabilities';

        $response = $client->get($url);
        $body = $response->getBody();
        $xml = simplexml_load_string($body);
        $json = json_encode($xml);
        $array = json_decode($json, true);

        // Menampilkan daftar layer
        $layers = [];
        if (isset($array['Capability']['Layer']['Layer'])) {
            foreach ($array['Capability']['Layer']['Layer'] as $layer) {
                $layers[] = [
                    'name' => $layer['Name'],
                    'title' => $layer['Title']
                ];
            }
        }

        return view('welcome', compact('layers'));
    }

    public function getGeoJsonData()
    {
        // https://geonode.pspig.online/geoserver/geonode/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=geonode%3Aupdating_sawit_des_2023_wgs84&maxFeatures=50&outputFormat=application%2Fjson
        // $url = 'https://geonode.pspig.online/geoserver/geonode/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=geonode:updating_sawit_des_2023_wgs84&outputFormat=application/json';
        $client = new Client();
        $layerName = 'geonode:updating_sawit_des_2023_wgs84';
        $url = 'https://geonode.pspig.online/geoserver/geonode/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=' . $layerName . '&outputFormat=application%2Fjson';

        $response = $client->get($url);
        $geojsonData = json_decode($response->getBody(), true);

        return view('geojson', compact('geojsonData'));
    }

    public function getGeoJsonData2()
    {
        $client = new Client();
        $layerName = 'geonode:updating_sawit_des_2023_wgs84';
        $url = 'https://geonode.pspig.online/geoserver/geonode/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=' . $layerName . '&outputFormat=application%2Fjson';

        $response = $client->get($url);
        $geojsonData = json_decode($response->getBody(), true);

        return view('geojson2', compact('geojsonData'));
    }

    public function getGeoJsonData3()
    {
        $geojsonData = DataGeojson::all();
        // dd($geojsonData);

        return view('geojson3', compact('geojsonData'));
    }

    public function getGeoJsonData4()
    {
        $geojsonData = DataGeojson::all();
        // dd($geojsonData);

        return view('geojson4', compact('geojsonData'));
    }

    public function getGeoJsonData5()
    {
        $filePath = '/public/Risiko-Tanah-Longsor_6552a49f803b4_2023-11-13.geojson'; // ganti dengan path ke file GeoJSON di storage
        $geojsonData = Storage::get($filePath);
        $geojsonData = json_decode($geojsonData, true);

        // dd($geojsonData);
        
        return view('geojson5', compact('geojsonData'));
    }

    public function getGeoJSONDataPretier()
    {
        // https://geonode.pspig.online/geoserver/geonode/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=geonode%3Aupdating_sawit_des_2023_wgs84&maxFeatures=50&outputFormat=application%2Fjson
        $client = new Client();
        $layerName = 'geonode:updating_sawit_des_2023_wgs84';
        // $url = 'https://geonode.pspig.online/geoserver/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=' . $layerName . '&outputFormat=application/json';
        $url = 'https://geonode.pspig.online/geoserver/geonode/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=' . $layerName . '&outputFormat=application%2Fjson';


        // $url = 'https://geonode.pspig.online/geoserver/geonode/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=geonode:updating_sawit_des_2023_wgs84&outputFormat=application/json';

        $response = $client->get($url);
        $geojsonData = json_decode($response->getBody(), true);

        $nameobjGeojson = $geojsonData['features'][0]['properties']['namobj'];
        $kecGeojson = $geojsonData['features'][0]['properties']['wadmkc'];
        $typeGeometryGeojson = $geojsonData['features'][0]['geometry']['type'] ?? null;

        $geometry = DataGeojson::create([
            'name' => $nameobjGeojson,
            'title' => $nameobjGeojson,
            'geojson' => json_encode($geojsonData),
            'kecamatan' => $kecGeojson,
            'type' => $typeGeometryGeojson,
        ]);

        // dd($geojsonData);

        // Proses data GeoJSON sesuai kebutuhan Anda
        return view('listgeoserver', compact('geojsonData'));
    }
}
