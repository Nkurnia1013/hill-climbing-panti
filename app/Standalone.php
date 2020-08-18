<?php

/**
 *
 */

namespace app;

use \Crud as Crud;

class Standalone
{

    public function Login($Request, $Session)
    {
        $data = [
            'judul' => 'Login',
            'path' => 'Login',
            'link' => 'Login',

        ];

        if (isset($Request->login)) {
            $data['admin'] = collect(Crud::table('user')->select()->where('username', $Request->user)->where('password', $Request->pass)->get());
            if ($data['admin']->isEmpty()) {
                echo "<script>alert('Maaf, Username atau Password yang anda inputkan salah');</script>";
                echo "<script>location.href = 'Login';</script>";
                die();
            } else {
                $_SESSION['admin'] = $data['admin']->first();
                echo "<script>alert('Berhasil');</script>";
                echo "<script>location.href = 'Panti';</script>";
                die();
            }

        }
        return $data;
    }
    public static function node($rute, $result, $jarak)
    {
        $data = array();
        $permutations = new \drupol\phpermutations\Generators\Combinations(array_keys($rute), 2);
        $permutations = $permutations->toArray();

        $data['kombi'] = $permutations;
        $data['level'] = array();
        foreach ($data['kombi'] as $k) {
            $x = $rute;
            $x[$k[0]] = $rute[$k[1]];
            $x[$k[1]] = $rute[$k[0]];
            if ($x[0] != $rute[0]) {
                continue;
            }
            $x1 = ['rute' => array(), 'step' => array(), 'kombi' => $k];

            $x1['rute'] = $x;
            $jum = count($x1['rute']) - 1;
            for ($i = 0; $i < $jum; $i++) {
                $r = [
                    'dari' => $x1['rute'][$i],
                    'ke' => $x1['rute'][$i + 1],
                    'join' => $x1['rute'][$i] . "," . $x1['rute'][$i + 1],
                    'jarak' => $result->distances[$x1['rute'][$i]][$x1['rute'][$i + 1]],
                ];
                array_push($x1['step'], $r);

            }
            $x1['step'] = collect($x1['step']);
            $x1['jarak'] = round($x1['step']->sum('jarak'), 2);
            array_push($data['level'], $x1);

        }
        $jarak2 = collect($data['level'])->sortBy('jarak')->take(1);
        $jarak3 = $jarak2->toArray();
        $jarak4 = $jarak2->first();
        if ($jarak4['jarak'] < $jarak) {
            $data['level'][array_keys($jarak3)[0]]['cabang'] = Standalone::node($jarak4['rute'], $result, $jarak4['jarak']);
        }
        return collect($data['level']);
    }
    public static function pendek($level)
    {
        $data = array();
        $data['level'] = $level;
        $k = $data['level']->sortBy('jarak')->first();
        if (isset($k['cabang'])):

            $pendek = Standalone::pendek($k['cabang']);
        else:
            $pendek = $k;
        endif;

        return $pendek;

    }

    public function Logout()
    {
        session_destroy();
        echo "<script>alert('Berhasil');</script>";
        echo "<script>location.href = 'Login';</script>";
        die();
    }

    public function Home($Request, $Session)
    {
        $data = [
            'judul' => 'Home',
            'path' => 'Website/Home',
            'link' => 'Home',
            'icon' => 'fa-home',

            'warna' => 'primary',

        ];
        $data['data'] = collect(Crud::table('panti')->select()->get());

        $place = [
            "type" => "FeatureCollection",
            "features" => array(),
        ];
        foreach ($data['data'] as $k) {
            $x = [
                "type" => "Feature",
                "properties" => [
                    "description" => ucfirst($k->nama),
                    "icon" => "bicycle",
                ],
                "geometry" => [
                    "type" => "Point",
                    "coordinates" => explode(',', $k->koordinat),
                ],
            ];
            array_push($place['features'], $x);
        }
        $data['place'] = json_encode($place);

        return $data;
    }
    public function Website($Request, $Session)
    {
        $data = [
            'judul' => 'Home',
            'path' => 'Website/Website',
            'link' => 'Website',
            'icon' => 'fa-place-of-worship',

            'warna' => 'primary',

        ];
        $data['data'] = collect(Crud::table('panti')->select()->where('idpanti', $Request->idpanti)->get());
        if ($data['data']->isEmpty()) {
            echo "<script>alert('data panti tidak ditemukan');</script>";
            echo "<script>location.href = 'Home';</script>";
            die();
        }
        $data['data'] = $data['data']->first();
        $data['data']->foto = collect(Crud::table('foto')->select()->where('idpanti', $Request->idpanti)->get());
        $data['data']->cp = collect(Crud::table('cp')->select()->where('idpanti', $Request->idpanti)->get());
        $data['judul'] = ucfirst($data['data']->nama);

        return $data;
    }
    public function Metode($Request, $Session)
    {
        $data = [
            'judul' => 'Metode',
            'path' => 'Admin/Metode',
            'link' => 'Metode',
            'icon' => 'fa-calculator',

            'warna' => 'primary',

        ];
        //  $data['user'] = $Request->koor;
        $curl = curl_init();
        $data['panti'] = collect(Crud::table('panti')->select()->get());
        $place = [
            "type" => "FeatureCollection",
            "features" => array(),
        ];
        foreach ($data['panti'] as $k) {
            $x = [
                "type" => "Feature",
                "properties" => [
                    "description" => ucfirst($k->nama),
                    "icon" => "bicycle",
                ],
                "geometry" => [
                    "type" => "Point",
                    "coordinates" => explode(',', $k->koordinat),
                ],
            ];
            array_push($place['features'], $x);
        }
        $data['place'] = json_encode($place);
        if (isset($Request->koor)) {
            $ta = json_decode(json_encode(['idpanti' => 0, 'nama' => 'Titik Awal', 'koordinat' => $Request->koor]));
            $data['panti'] = $data['panti']->merge([$ta])->sortBy('idpanti');

        }
        $data['data'] = $data['panti']->where('koordinat', '!=', '')->map(function ($item) {

            $item->koordinat2 = $item->koordinat;
            return $item;
        })->groupBy('idpanti')->map(function ($item) {
            return $item[0]->koordinat2;
        });
        $data['panti'] = $data['panti']->groupBy('idpanti');
        $koor = $data['data']->toArray();
        $rute = array_keys($koor);

        $koor = implode(";", $koor);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, "https://api.mapbox.com/directions-matrix/v1/mapbox/driving/$koor?annotations=distance,duration&destinations=all&access_token=pk.eyJ1Ijoibmt1cm5pYTEwMzEiLCJhIjoiY2szMnNmdTJ2MGVvZDNnb2J5M2FwZmUxYiJ9.NQOOv2ivABH_v75lSXZr2A");
        $result = curl_exec($curl);
        $result = json_decode($result);
        if (is_null($result)) {
            echo "<script>alert('Koneksi gagal, Silahkan Ulangi');</script>";
            echo "<script>location.href = 'Metode';</script>";
            die();

        }
        $result->distances = collect($result->distances)->mapWithKeys(function ($item, $key) use ($rute) {
            $item = collect($item)->mapWithKeys(function ($item, $key) use ($rute) {
                return [$rute[$key] => $item];
            });
            return [$rute[$key] => $item];
        });
        for ($i = 0; $i < count($rute); $i++) {
            for ($i2 = 0; $i2 < count($rute); $i2++) {

                $result->distances[$rute[$i]][$rute[$i2]] = $result->distances[$rute[$i2]][$rute[$i]];
            }
        }
        for ($i = 0; $i < count($rute); $i++) {
            for ($i2 = 0; $i2 < count($rute); $i2++) {
                $result->distances[$rute[$i]][$rute[$i2]] = round($result->distances[$rute[$i]][$rute[$i2]] / 1000, 2);

            }
        }
        $data['hasil'] = $result;

        $data['koor'] = $koor;
        $data['rute'] = $rute;
        $data['jarak'] = 0;
        $x = ['rute' => array(), 'step' => array()];

        $x['rute'] = $data['rute'];
        $jum = count($x['rute']) - 1;
        for ($i = 0; $i < $jum; $i++) {
            $r = [
                'dari' => $x['rute'][$i],
                'ke' => $x['rute'][$i + 1],
                'join' => $x['rute'][$i] . "," . $x['rute'][$i + 1],
                'jarak' => $result->distances[$x['rute'][$i]][$x['rute'][$i + 1]],
            ];
            array_push($x['step'], $r);

        }
        $x['step'] = collect($x['step']);
        $x['jarak'] = round($x['step']->sum('jarak'), 2);
        $data['root'] = $x;
        $data['level'] = $this::node($rute, $result, $x['jarak']);

        //  $koor = collect($koor)->prepend(implode(",", $data['user']))->toArray();

        //dd($result);

        return $data;
    }
    public function Proses($Request, $Session)
    {
        $curl = curl_init();
        $data['panti'] = collect(Crud::table('panti')->select()->get());

        if (isset($Request->koor)) {
            $ta = json_decode(json_encode(['idpanti' => 0, 'nama' => 'Titik Awal', 'koordinat' => $Request->koor]));
            $data['panti'] = $data['panti']->merge([$ta])->sortBy('idpanti');

        }
        $data['data'] = $data['panti']->where('koordinat', '!=', '')->map(function ($item) {

            $item->koordinat2 = $item->koordinat;
            return $item;
        })->groupBy('idpanti')->map(function ($item) {
            return $item[0]->koordinat2;
        });
        $data['panti'] = $data['panti']->groupBy('idpanti');
        $koor = $data['data']->toArray();
        $rute = array_keys($koor);

        $koor = implode(";", $koor);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, "https://api.mapbox.com/directions-matrix/v1/mapbox/driving/$koor?annotations=distance,duration&destinations=all&access_token=pk.eyJ1Ijoibmt1cm5pYTEwMzEiLCJhIjoiY2szMnNmdTJ2MGVvZDNnb2J5M2FwZmUxYiJ9.NQOOv2ivABH_v75lSXZr2A");
        $result = curl_exec($curl);
        $result = json_decode($result);
        $result->distances = collect($result->distances)->mapWithKeys(function ($item, $key) use ($rute) {
            $item = collect($item)->mapWithKeys(function ($item, $key) use ($rute) {
                return [$rute[$key] => $item];
            });
            return [$rute[$key] => $item];
        });
        for ($i = 0; $i < count($rute); $i++) {
            for ($i2 = 0; $i2 < count($rute); $i2++) {

                $result->distances[$rute[$i]][$rute[$i2]] = $result->distances[$rute[$i2]][$rute[$i]];
            }
        }
        for ($i = 0; $i < count($rute); $i++) {
            for ($i2 = 0; $i2 < count($rute); $i2++) {
                $result->distances[$rute[$i]][$rute[$i2]] = round($result->distances[$rute[$i]][$rute[$i2]] / 1000, 2);

            }
        }
        $data['hasil'] = $result;
        $data['koor'] = $koor;
        $data['rute'] = $rute;
        $data['jarak'] = 0;
        $x = ['rute' => array(), 'step' => array()];

        $x['rute'] = $data['rute'];
        $jum = count($x['rute']) - 1;
        for ($i = 0; $i < $jum; $i++) {
            $r = [
                'dari' => $x['rute'][$i],
                'ke' => $x['rute'][$i + 1],
                'join' => $x['rute'][$i] . "," . $x['rute'][$i + 1],
                'jarak' => $result->distances[$x['rute'][$i]][$x['rute'][$i + 1]],
            ];
            array_push($x['step'], $r);

        }
        $x['step'] = collect($x['step']);
        $x['jarak'] = round($x['step']->sum('jarak') / 1000, 2);
        $data['root'] = $x;
        $data['level'] = $this::node($rute, $result, $x['jarak']);
        $pendek = Standalone::pendek($data['level']);

        $rule = $pendek;
        foreach ($rule['rute'] as $t => $k) {
            $rule['detail'][$t] = array();
            if ($k > 0) {
                if ($data['panti'][$k][0]->link == '') {
                    $data['panti'][$k][0]->link = "Website?idpanti=" . $data['panti'][$k][0]->idpanti;
                }
                $rule['detail'][$t]['nama'] = $data['panti'][$k][0]->nama;
                $rule['detail'][$t]['koordinat'] = $data['data'][$k];
                $rule['detail'][$t]['panti'] = $data['panti'][$k][0];
            } else {
                $rule['detail'][$t]['nama'] = "Lokasi Anda";
                $rule['detail'][$t]['koordinat'] = $data['data'][$k];

            }

        }
        $rule['detail'] = collect($rule['detail']);
        $curl = curl_init();

        $token = "u3nTEQHXOJvhQsBr2GUo0Odfk8airzprz1XtREsjLBb4citrzrmENkqRi2QP4Nku";
        $data = [
            'coordinates' => $rule['detail']->implode('koordinat', ';'),
            'banner_instructions' => 'true',
            'steps' => 'true',
            'language' => 'id',

            'geometries' => 'geojson',
        ];

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, "https://api.mapbox.com/directions/v5/mapbox/driving?access_token=pk.eyJ1Ijoibmt1cm5pYTEwMzEiLCJhIjoiY2szMnNmdTJ2MGVvZDNnb2J5M2FwZmUxYiJ9.NQOOv2ivABH_v75lSXZr2A");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = json_decode(curl_exec($curl));
        $result->rule = $rule;
        curl_close($curl);
        echo json_encode($result);
        //  dd($result);
        die();
    }

}
