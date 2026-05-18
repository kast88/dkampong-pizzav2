<?php
// app/Enums/LoginProvider.php

namespace App\Enums;

enum LoginProvider: string
{
    case Local = 'local';
    case Google = 'google';
    case Github = 'github';
}