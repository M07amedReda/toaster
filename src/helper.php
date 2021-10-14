<?php

if (!function_exists('toaster')) {
    /**
     * Return the instance of toastr.
     *
     * @return MohamedReda\Toaster\Toaster
     */
    function toastr()
    {
        return app('toaster');
    }
}
