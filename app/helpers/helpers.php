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

if (!function_exists('checkRole')) {
    function checkRole($id)
    {
        $role_user = DB::table('role_user')->where('user_id', $id)->first();
        $role = DB::table('roles')->where('id', $role_user->role_id)->first();
        return $role->slug;
    }
}

if (!function_exists('price_unit')) {
    function price_unit()
    {
        return 'Rs. ';
    }
}

if (!function_exists('formatted_price')) {
    function formatted_price($amount)
    {
        return price_unit() . number_format($amount);
    }
}

