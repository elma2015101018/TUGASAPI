<?php

namespace App\Controllers;

use App\Models\BukuModel;

class Buku extends BaseController
{

    protected $bukuModel;
    public function __construct()
    {
        $this-> bukuModel = new BukuModel();
    }
    public function index()
    {
        //$buku = $this->bukuModel->findAll();

        $data = [
            'title' => 'Daftar Buku',
            'buku' => $this->bukuModel->getBuku()
        ];


        return view ('buku/index', $data);
    }

    public function detail ($slug)
    {
        $data = [
            'title' => 'Detail Buku',
            'buku' => $this->bukuModel->getBuku($slug)
        ];

        
        return view ('buku/detail', $data);
    }

    public function create ()
    {
        //session();
        $data = [
            'title' => 'Form Tambah Data Buku',
            'validation' => \Config\Services::validation()
         ];


        return view ('buku/create', $data);
    }

    public function save()
    {

        if(!$this->validate([
            'judul'=> [
                'rules'=> 'required|is_unique[buku.judul]',
                'errors'=>[
                    'required'=>'{field} buku harus diisi.',
                    'is_unique'=>'{field} buku sudah terdaftar.'
                ]
            ]
        ])) {
            $validation = \config\services::validation();
            return redirect()->to('/buku/create')->withInput()->with('validation', $validation);    
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->bukuModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
            
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        return redirect()->to('/buku');
    }

    public function delete($id)
    {
        $this->bukuModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/buku');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Form Ubah Data Buku',
            'validation' => \Config\Services::validation(),
            'buku' => $this->bukuModel->getBuku($slug )
         ];


        return view ('buku/edit', $data);
    }

    public function update($id)
    {
       $bukuLama = $this->bukuModel->getBuku($this->request->getVar('slug'));
       if($bukuLama['judul'] == $this->request->getVar('judul')){
           $rule_judul = 'required';
       } else {
          $rule_judul = 'required|is_unique[buku.judul]';
       }

        if(!$this->validate([
            'judul'=> [
                'rules'=> $rule_judul,
                'errors'=>[
                    'required'=>'{field} buku harus diisi.',
                    'is_unique'=>'{field} buku sudah terdaftar.'
                ]
            ]
        ])) {
            $validation = \config\services::validation();
            return redirect()->to('/buku/edit/'. $this->request->getVar('slug'))->withInput()->with('validation', $validation);    
        }


        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->bukuModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
            
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');

        return redirect()->to('/buku');  
    }

}