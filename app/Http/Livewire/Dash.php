<?php

namespace App\Http\Livewire;


use DateTime;

use Livewire\Component;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;

class Dash extends Component
{


    public function render()
    {



        return view('livewire.dash.component')->extends('layouts.theme.app')
            ->section('content');
    }
}
