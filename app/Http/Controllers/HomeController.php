<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Models\Segobra;
use App\Sat;
use App\Estado;
use App\Departamento;
use App\Programa;

class HomeController extends Controller
{
    //
    public function index()
    {

        $ids = [15];
        $nodep = [18, 19, 20, 999];
        $noestados = ['A', 'I', 'Y', 'S', 'D'];
        $addprogramas = [4, 11, 5, 2, 3, 1];
        $data = [];
        $datasat = [];
        $error = [];

        $projects = Segobra::whereIn('SEOBPlan', $ids)
            //->where('SEOBProgr','=','11')
            ->whereNotIn('SEOBEst', $noestados)
            ->whereIn('SEOBProgr', $addprogramas)
            ->get();
        //$demo = Segobra::find(6);
        //dd($demo->getMedia('gallery'));
        $estados = Estado::whereNotIn('value', $noestados)->get();
        //dd($estados->toJson());
        $departamentos = Departamento::whereNotIn('DptoId', $nodep)
            //->select('DptoNom')
            //->whereNotIn('DptoId', $nodep)
            ->get();
        $programas = Programa::whereIn('value', $addprogramas)
            ->get();

        $sats = Sat::where('NucEst', '=', 'H')
            ->get();
        //dd($sats->toJson());
        foreach ($sats as $key => $sat) {
            $datasat[] = [
                'id' => trim($sat->NucCod),
                'name' => trim($sat->NucCod ? $sat->satnombre->PerNom : ""),
            ];
        }

        foreach ($projects as $key => $value) {
            try {

                $latlong = $this->ToLL((int)$value->SEOBUtmY, (int)$value->SEOBUtmX, preg_replace("/[^0-9]/", '', $value->SEOBUtm1));
                $data[] = [
                    'id' => trim($value->SEOBId),
                    'llamado' => trim($value->SEOBNCont),
                    'programa_id' => trim($value->SEOBProgr),
                    'programa' => trim($value->SEOBProgr ? $value->programa->name : ""),
                    'proyecto' => trim($value->SEOBProy),
                    'estado_id' => trim($value->SEOBEst),
                    'estado' => trim($value->SEOBEst ? $value->estado->name : ""),
                    'departamento_id' => $value->DptoId,
                    'departamento' => trim($value->DptoId ? $value->departamento->DptoNom : ""),
                    'distrito' => trim($value->CiuId ? $value->distrito->CiuNom : ""),
                    'sat' => trim($value->SEOBEmpr),
                    'codigo_sat' => trim($value->SEOBCodSAT),
                    'cantidad_viviendas' => $value->SEOBViv,
                    'constructora' => $value->SEOBConstr,
                    'resolucion' => $value->SEOBAdjRes,
                    'fresolucion' => date('d/m/Y', strtotime($value->SEOBFecCo)),
                    'frecepcion' => date('d/m/Y', strtotime($value->SEOBReDe)),
                    'avance' => number_format($value->SEOBFisAva, 2, '.', '.'),
                    'lat' => $latlong['lat'],
                    'lng' => $latlong['lon'],
                    'gallery' => $value->getMedia('gallery'),
                    'monto_total' => number_format(trim($value->SEOBMonCo), 0, ',', '.'),
                ];
            } catch (\Throwable $th) {
                $error[] = [
                    'id' => trim($value->SEOBId),
                    'proyecto' => trim($value->SEOBProy),
                    'departamento' => trim($value->DptoId ? $value->departamento->DptoNom : ""),
                    'distrito' => trim($value->CiuId ? $value->distrito->CiuNom : ""),
                    'utmx' => trim($value->SEOBUtmX),
                    'utmy' => trim($value->SEOBUtmY),
                    'zona' => trim($value->SEOBUtm1),
                ];
            }
        }
        //dd($datasat);
        return view('welcome', compact('projects', 'data', 'departamentos', 'programas', 'datasat', 'estados'));
    }


    public function ToLL($north, $east, $utmZone)
    {
        // This is the lambda knot value in the reference
        $LngOrigin = Deg2Rad($utmZone * 6 - 183);

        // The following set of class constants define characteristics of the
        // ellipsoid, as defined my the WGS84 datum.  These values need to be
        // changed if a different dataum is used.

        $FalseNorth = 10000000;   // South or North?
        //if (lat < 0.) FalseNorth = 10000000.  // South or North?
        //else          FalseNorth = 0.

        $Ecc = 0.081819190842622;       // Eccentricity
        $EccSq = $Ecc * $Ecc;
        $Ecc2Sq = $EccSq / (1. - $EccSq);
        $Ecc2 = sqrt($Ecc2Sq);      // Secondary eccentricity
        $E1 = (1 - sqrt(1 - $EccSq)) / (1 + sqrt(1 - $EccSq));
        $E12 = $E1 * $E1;
        $E13 = $E12 * $E1;
        $E14 = $E13 * $E1;

        $SemiMajor = 6378137.0;         // Ellipsoidal semi-major axis (Meters)
        $FalseEast = 500000.0;          // UTM East bias (Meters)
        $ScaleFactor = 0.9996;          // Scale at natural origin

        // Calculate the Cassini projection parameters

        $M1 = ($north - $FalseNorth) / $ScaleFactor;
        $Mu1 = $M1 / ($SemiMajor * (1 - $EccSq / 4.0 - 3.0 * $EccSq * $EccSq / 64.0 - 5.0 * $EccSq * $EccSq * $EccSq / 256.0));

        $Phi1 = $Mu1 + (3.0 * $E1 / 2.0 - 27.0 * $E13 / 32.0) * sin(2.0 * $Mu1);
        + (21.0 * $E12 / 16.0 - 55.0 * $E14 / 32.0)           * sin(4.0 * $Mu1);
        + (151.0 * $E13 / 96.0)                          * sin(6.0 * $Mu1);
        + (1097.0 * $E14 / 512.0)                        * sin(8.0 * $Mu1);

        $sin2phi1 = sin($Phi1) * sin($Phi1);
        $Rho1 = ($SemiMajor * (1.0 - $EccSq)) / pow(1.0 - $EccSq * $sin2phi1, 1.5);
        $Nu1 = $SemiMajor / sqrt(1.0 - $EccSq * $sin2phi1);

        // Compute parameters as defined in the POSC specification.  T, C and D

        $T1 = tan($Phi1) * tan($Phi1);
        $T12 = $T1 * $T1;
        $C1 = $Ecc2Sq * cos($Phi1) * cos($Phi1);
        $C12 = $C1 * $C1;
        $D  = ($east - $FalseEast) / ($ScaleFactor * $Nu1);
        $D2 = $D * $D;
        $D3 = $D2 * $D;
        $D4 = $D3 * $D;
        $D5 = $D4 * $D;
        $D6 = $D5 * $D;

        // Compute the Latitude and Longitude and convert to degrees
        $lat = $Phi1 - $Nu1 * tan($Phi1) / $Rho1 * ($D2 / 2.0 - (5.0 + 3.0 * $T1 + 10.0 * $C1 - 4.0 * $C12 - 9.0 * $Ecc2Sq) * $D4 / 24.0 + (61.0 + 90.0 * $T1 + 298.0 * $C1 + 45.0 * $T12 - 252.0 * $Ecc2Sq - 3.0 * $C12) * $D6 / 720.0);

        $lat = Rad2Deg($lat);

        $lon = $LngOrigin + ($D - (1.0 + 2.0 * $T1 + $C1) * $D3 / 6.0 + (5.0 - 2.0 * $C1 + 28.0 * $T1 - 3.0 * $C12 + 8.0 * $Ecc2Sq + 24.0 * $T12) * $D5 / 120.0) / cos($Phi1);

        $lon = Rad2Deg($lon);

        // Create a object to store the calculated Latitude and Longitude values
        $PC_LatLon['lat'] = $lat;
        $PC_LatLon['lon'] = $lon;

        // Returns a PC_LatLon object
        return $PC_LatLon;
        //return "['latitude' => ".$lat.", 'longitude' => ".$lon."], ";
    }
}
