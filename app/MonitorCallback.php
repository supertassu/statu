<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonitorCallback extends Model
{

    protected $fillable = [
        'monitor_id', 'key', 'last_callback'
    ];

    protected $appends = [
        'url'
    ];

    public function getUrlAttribute() {
        return config('app.url', 'http://localhost') . '/api/heartbeat?monitor=' . $this->monitor_id . '&key=' . $this->key;
    }

    public function getMonitor() {
        return Monitor::where('id', $this->monitor_id)->first();
    }

    public static function createKey(): string {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < 64; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

}
