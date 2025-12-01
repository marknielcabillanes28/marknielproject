<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $allowedFields = ['key', 'value'];
    public $timestamps = false;

    public function getValue($key)
    {
        $record = $this->where('key', $key)->first();
        return $record ? $record['value'] : 'off';
    }

    public function setValue($key, $value)
    {
        $exists = $this->where('key', $key)->first();
        if ($exists) {
            $this->where('key', $key)->set(['value' => $value])->update();
        } else {
            $this->insert(['key' => $key, 'value' => $value]);
        }
    }
}
