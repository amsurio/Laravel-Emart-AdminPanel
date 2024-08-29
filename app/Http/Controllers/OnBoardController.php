<?php

namespace App\Http\Controllers;
class OnBoardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {

        return view("OnDemandService.on-board.index");
    }


    public function save($id)
    {
        return view('OnDemandService.on-board.save')->with('id', $id);
    }


}
