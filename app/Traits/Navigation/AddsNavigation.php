<?php

namespace App\Traits\Navigation;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

trait AddsNavigation {

    protected $navigation = [];

    protected function addNavigation()
    {

        if(Auth::check()) {
            $this->buildAdminNavigation();
        } else {
            $this->buildGuestNavigation();
        }

        foreach ($this->navigation as &$link) {
            $link['class'] = Request::is($link['href']) ? 'active' : '';
        }
//        dump($this->navigation);
        View::share('navigation', $this->navigation);
    }

    protected function buildGuestNavigation() {
        $this->navigation = [
            [
                'href' => '/',
                'title' => 'Home'
            ]
        ];
    }

    protected function buildAdminNavigation() {

        $this->navigation = [
            [
                'href' => '/',
                'title' => 'Home'
            ],
            [
                'href' => '/home',
                'title' => 'Messenger'
            ],
            [
                'href' => 'users',
                'title' => 'Users'
            ],
        ];
    }
}