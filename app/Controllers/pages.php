<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home | sistem informasi'
        ];
         
        return view ('pages/home', $data);
         
         
    }

    public function about()
    {
        $data = [
            'title' => 'About Us'
        ];
    
        return view('pages/about', $data);
        
    }

    public function Contact()
    {
        $data = [
            'title' => 'Contact Us',
            'alamat' => [
                [
                    'tipe' => 'Kantor',
                    'alamat' => 'JL.Bunga No.2',
                    'kota' => 'Jakarta'
                ]
            ]
        ];

        return view ('pages/contact', $data);
    }
}
