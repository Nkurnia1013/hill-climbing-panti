<?php

/**
 *
 */

namespace app;

use \Crud as Crud;

class Admin
{
    public function Dashboard($Request, $Session)
    {
        $data = [
            'judul' => 'Dashboard',
            'path' => 'Dashboard',
            'link' => 'Dashboard',
            'icon' => 'fa-home',

            'warna' => 'primary',

        ];

        return $data;
    }
    public function Panti($Request, $Session)
    {
        $data = [
            'judul' => 'Data Panti',
            'path' => 'Admin/Panti',
            'link' => 'Panti',
            'icon' => 'fa-place-of-worship',

        ];
        //Fungsi::fields('panti', new Crud);
        $fields1 = '[
                {"name":"nama","label":"Nama Panti","type":"text","max":"50","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true},
                {"name":"lakilaki","label":"Anak Laki-Laki","type":"number","max":"999999","pnj":6,"val":null,"red":"required","input":true,"up":true,"tb":true},
                {"name":"perempuan","label":"Anak Perempuan","type":"number","max":"999999","pnj":6,"val":null,"red":"required","input":true,"up":true,"tb":true},
                {"name":"visi","label":"Visi","type":"textarea","max":"65535","pnj":6,"val":null,"red":"required","input":true,"up":true,"tb":true},
                {"name":"misi","label":"Misi","type":"textarea","max":"65535","pnj":6,"val":null,"red":"required","input":true,"up":true,"tb":true},
                {"name":"alamat","label":"Alamat lengkap","type":"text","max":"100","pnj":6,"val":null,"red":"required","input":true,"up":true,"tb":true},
                {"name":"link","label":"Link Website","type":"text","max":"50","pnj":6,"val":null,"red":"","input":true,"up":true,"tb":true}
                ]';
        $data['form'] = json_decode($fields1, true);
        $data['koordinat'] = null;
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
        if (isset($Request->key)) {
            $data['foto'] = collect(Crud::table('foto')->select()->where('idpanti', $Request->key)->get());
            $data['cp'] = collect(Crud::table('cp')->select()->where('idpanti', $Request->key)->get());

            $data['key'] = $data['data']->where('idpanti', $Request->key)->first();
            foreach ($data['form'] as $v => $k) {
                $b = $k['name'];
                $data['form'][$v]['val'] = $data['key']->$b;
            }
            $data['foto.key']['desk'] = null;
            $data['koordinat'] = $data['key']->koordinat;

            if (isset($Request->idfoto)) {
                $data['foto.key']['desk'] = $data['foto']->where('idfoto', $Request->idfoto)->first()->desk;
            }
            $data['cp.key']['nama'] = null;
            $data['cp.key']['nohp'] = null;
            $data['cp.key']['jabatan'] = null;
            if (isset($Request->idcp)) {
                $data['cp.key']['nama'] = $data['cp']->where('idcp', $Request->idcp)->first()->nama;
                $data['cp.key']['nohp'] = $data['cp']->where('idcp', $Request->idcp)->first()->nohp;
                $data['cp.key']['jabatan'] = $data['cp']->where('idcp', $Request->idcp)->first()->jabatan;

            }

        }

        return $data;
    }

    public function User($Request, $Session)
    {
        $data = [
            'judul' => 'Data User',
            'path' => 'Admin/User',
            'link' => 'User',
            'icon' => 'fa-users',

        ];
        //Fungsi::fields('user', new Crud);
        $fields1 = '[
                {"name":"username","label":"Username","type":"text","max":"15","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true},
                {"name":"password","label":"Password","type":"password","max":"15","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true},
                {"name":"nama","label":"Nama Lengkap","type":"text","max":"25","pnj":12,"val":null,"red":"required","input":true,"up":true,"tb":true}
                ]';
        $data['form'] = json_decode($fields1, true);
        $data['data'] = collect(Crud::table('user')->select()->get());
        if (isset($Request->key)) {
            $data['key'] = $data['data']->where('username', $Request->key)->first();
            foreach ($data['form'] as $v => $k) {
                $b = $k['name'];
                $data['form'][$v]['val'] = $data['key']->$b;
            }
        }

        return $data;
    }
    public function Kecamatan($Request, $Session)
    {
        $data = [
            'judul' => 'Data Kecamatan',
            'path' => 'Admin/Kecamatan',
            'link' => 'Kecamatan',
            'icon' => 'fa-map-signs',

        ];
        //Fungsi::fields('kecamatan', new Crud);
        $fields1 = '[
                {"name":"kecamatan","label":"Kecamatan","type":"text","max":"30","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true},
                {"name":"kodepos","label":"Kode Pos","type":"text","max":"6","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true}
                ]';
        $data['form'] = json_decode($fields1, true);
        $data['data'] = collect(Crud::table('kecamatan')->select()->get());
        if (isset($Request->key)) {
            $data['key'] = $data['data']->where('idkecamatan', $Request->key)->first();
            foreach ($data['form'] as $v => $k) {
                $b = $k['name'];
                $data['form'][$v]['val'] = $data['key']->$b;
            }
        }

        return $data;
    }

    public function Pengaturan($Request, $Session)
    {
        $data = [
            'judul' => 'Pengaturan',
            'path' => 'Admin/Pengaturan',
            'link' => 'Pengaturan',

        ];
        //Fungsi::fields('pengguna', new Crud);
        $data['smart'] = collect(Crud::table('smart')->select()->where('tahun', $Session['tahun'])->get());
        if ($data['smart']->isEmpty()) {
            Crud::table('smart')->insert(['tahun' => $Session['tahun'], 'min' => 0])->execute();
            $data['smart'] = collect(Crud::table('smart')->select()->where('tahun', $Session['tahun'])->get());

        }
        $data['smart'] = $data['smart']->first();
        $string = file_get_contents("hasil.json");
        $data['hasil'] = json_decode($string, true);

        $data['data.kriteria'] = collect(Crud::table('kriteria')->select()->get());
        $data['max'] = 100 - $data['data.kriteria']->sum('bobot');
        $data['form.kriteria'] = ['kriteria' => null, 'bobot' => 0];

        if (isset($Request->idkriteria)) {
            $data['key'] = $data['data.kriteria']->where('idkriteria', $Request->idkriteria)->first();
            $data['form.kriteria']['kriteria'] = $data['key']->kriteria;
            $data['form.kriteria']['bobot'] = $data['key']->bobot;
            $data['data.subkriteria'] = collect(Crud::table('subkriteria')->select()->where('idkriteria', $data['key']->idkriteria)->get());
            $data['form.subkriteria'] = ['subkriteria' => null, 'nilai' => 0];
            if (isset($Request->idsubkriteria)) {
                $data['key'] = $data['data.subkriteria']->where('idsubkriteria', $Request->idsubkriteria)->first();

                $data['form.subkriteria']['subkriteria'] = $data['key']->subkriteria;
                $data['form.subkriteria']['nilai'] = $data['key']->nilai;
            }

        }
        $data['data.bantuan'] = collect(Crud::table('bantuan')->select()->get());
        $data['form.bantuan'] = ['komponen' => null, 'uang' => 0];

        if (isset($Request->idbantuan)) {
            $data['key'] = $data['data.bantuan']->where('idbantuan', $Request->idbantuan)->first();
            $data['form.bantuan']['komponen'] = $data['key']->komponen;
            $data['form.bantuan']['uang'] = $data['key']->uang;
        }
        if (isset($Request->min)) {
            if (array_key_exists($Session['tahun'], $data['hasil'])) {
                $data['hasil'][$Session['tahun']]['min'] = $Request->min;
                $fp = fopen('results.json', 'w');
                fwrite($fp, json_encode($data['hasil']));
                fclose($fp);

            }
        }
        $data['hasil'] = json_decode(json_encode($data['hasil'][$Session['tahun']]));

        return $data;

    }

    public function LaporanBooking($Request, $Session)
    {
        $data = [
            'judul' => 'Laporan Booking',
            'path' => 'Admin/LaporanBooking',
            'link' => 'Laporan-Booking',

        ];
        //Fungsi::fields('perawatan', new Crud);
        $fields1 = '[
                {"name":"id_perawatan","label":"ID Perawatan","type":"text","max":"15","pnj":12,"val":null,"red":"readonly","input":true,"up":true,"tb":true},
                {"name":"nama_perawatan","label":"Nama Perawatan","type":"text","max":"30","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true},
                {"name":"jenis_perawatan","label":"Jenis Perawatan","type":"text","max":"25","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true},
                {"name":"harga","label":"Harga","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true},
                {"name":"gambar","label":"Gambar","type":"text","max":"65535","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true},
                {"name":"desk","label":"Deskripsi","type":"textarea","max":"65535","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true}
                ]';
        $data['form'] = json_decode($fields1, true);
        $data['form'][0]['val'] = "Pn-" . uniqid();
        $data['data'] = collect(Crud::table('perawatan')->select()->get());

        return $data;
    }

}
