<?php

namespace App\Routing\Filter;

use Cake\Event\Event;
use Cake\Routing\DispatcherFilter;


class TestFilter extends DispatcherFilter
{

    public function beforeDispatch(Event $event)
    {
//        $request = $event->data['request'];
        $response = $event->data['response'];
        if ($response->statusCode() == 200) {
//           die();
        } else {
            
        }
    }

}
