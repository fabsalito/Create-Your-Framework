<?php

namespace Calendar\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GreetingController
{
    public function helloAction(Request $request, $name)
    {
        return render_template($request);
    }

    public function byeAction(Request $request){
        return render_template($request);
    }
}
