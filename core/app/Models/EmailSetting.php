<?php

namespace App\Models;
class EmailSetting extends BaseModel {
    protected  $fillable = ['protocol', 'smtp_host', 'smtp_username',  'smtp_password', 'smtp_port','from_email','mailgun_domain','mailgun_secret','mandrill_secret','from_name','encryption'];
}
