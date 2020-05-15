<?php
namespace App\Traits;
use DateTimeInterface;
trait UnixTimestampSerializable
{
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('H:i:s d-m-Y');
    }
}
