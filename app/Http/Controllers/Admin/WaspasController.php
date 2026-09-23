<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\WaspasService;

class WaspasController extends Controller
{
    protected $waspasService;

    public function __construct(WaspasService $waspasService)
    {
        $this->waspasService = $waspasService;
    }

    public function ranking()
    {
        $data = $this->waspasService->calculate();
        return view('admin.waspas.ranking', $data);
    }

    public function cetak()
    {
        $data = $this->waspasService->calculate();
        return view('admin.waspas.cetak', $data);
    }
}
