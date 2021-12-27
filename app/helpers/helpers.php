<?php

function orderProccess($type)
{
    switch ($type) {
        case 'New':
            $button = 'btn-primary';
            break;
        case 'Verified':
            $button = 'btn-warning';
            break;
        case 'Cancel':
            $button = 'btn-danger';
            break;
        case 'Process':
            $button = 'btn-secondary';
            break;
        case 'Delivered':
            $button = 'btn-success';
            break;
        default:
            $button = 'btn-info';
            break;
    }
    return $button;
}


