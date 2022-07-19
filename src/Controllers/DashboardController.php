<?php

namespace Hani221b\Grace\Controllers;


class DashboardController
{
    public function grace_cp()
    {
        return view('Grace::index');
    }

    /**
     * get user dashboard
     */

     public function get_dashboard(){
         return view('grace.dashboard');
     }

}
