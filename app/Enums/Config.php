<?php

namespace App\Enums;

// Tambahkan ': string' di sini agar menjadi Backed Enum
enum Config: string
{
    case DEFAULT_PASSWORD = 'default_password';
    case PAGE_SIZE = 'page_size';
    case APP_NAME = 'app_name';
    case INSTITUTION_NAME = 'institution_name';
    case INSTITUTION_ADDRESS = 'institution_address';
    case INSTITUTION_PHONE = 'institution_phone';
    case INSTITUTION_EMAIL = 'institution_email';
    case LANGUAGE = 'language';
    case PIC = 'pic';
}