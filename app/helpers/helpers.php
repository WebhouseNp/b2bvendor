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


if (!function_exists('vendor_editable_package_status')) {
    function vendor_editable_package_status()
    {
        return ['pending', 'processing', 'shipped', 'completed'];
    }
}

if (!function_exists('get_order_status_number')) {
    function get_order_status_number($status)
    {
        switch ($status) {
            case "cancelled":
                $stage = 0;
                break;
            case "refunded":
                $stage = -1;
                break;
            case "pending":
                $stage = 1;
                break;
            case "processing":
                $stage = 2;
                break;
            case "shipped":
                $stage = 3;
                break;
            case "completed":
                $stage = 4;
                break;
            default:
                $stage = -100;
        }

        return $stage;
    }
}

if (!function_exists('get_package_status_number')) {
    function get_package_status_number($status)
    {
        switch ($status) {
            case "cancelled":
                $stage = 0;
                break;
            case "refunded":
                $stage = -1;
                break;
            case "pending":
                $stage = 1;
                break;
            case "processing":
                $stage = 2;
                break;
            case "shipped":
                $stage = 3;
                break;
            case "completed":
                $stage = 4;
                break;
            default:
                $stage = -100;
        }

        return $stage;
    }
}

if (!function_exists('sasto_wholesale_store_id')) {
    function sasto_wholesale_store_id() {
        return settings('sasto_wholesale_mall_vendor_id', null);
    }
}