<?php

use App\Libraries\Access;
use App\Models\UserModel;

if (! function_exists('has_role')) {
    function has_role(string ...$roles): bool
    {
        return Access::is(...$roles);
    }
}

if (! function_exists('user_name')) {
    function user_name(): string
    {
        return Access::userName();
    }
}

if (! function_exists('role_label')) {
    function role_label(?string $role): string
    {
        return UserModel::ROLES[$role] ?? (string) $role;
    }
}

if (! function_exists('delete_form')) {
    function delete_form(string $url, string $label = 'Hapus', string $confirm = 'Yakin ingin menghapus?'): string
    {
        return '<form method="post" action="' . esc($url, 'attr') . '" style="display:inline" onsubmit="return confirm(\''
            . esc($confirm, 'js') . '\')">' . csrf_field()
            . '<button type="submit" class="iconbtn">' . esc($label) . '</button></form>';
    }
}
