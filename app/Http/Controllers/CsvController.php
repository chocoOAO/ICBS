<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CsvController extends Controller
{
    public function index()
    {
        $users = [];
        setlocale(LC_ALL, 'en_US.UTF-8');

        if (($open = fopen(storage_path() . "\app\\excels\aaa.xls", "r")) !== FALSE) {

            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                $users[] = $data;
            }

            fclose($open);
        }

        echo "<pre>";
        print_r($users);
    }
}