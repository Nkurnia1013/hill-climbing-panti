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
                echo "<script>location.href = 'Home';</script>";
                die();
            }

        }
        return $data;
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
        $data['kecamatan'] = collect(Crud::table('kecamatan')->select()->get());

        return $data;
    }

}
