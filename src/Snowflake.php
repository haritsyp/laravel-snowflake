<?php

namespace Haritsyp\Snowflake;

use DateTime;
use DateTimeZone;
use Exception;

class Snowflake
{
    const EPOCH = 1612224000000;

    const DATACENTER_BITS = 5;
    const NODE_BITS = 5;
    const SEQUENCE_BITS = 12;

    const NODE_MAX = (1 << self::NODE_BITS) - 1;
    const DATACENTER_MAX = (1 << self::DATACENTER_BITS) - 1;
    const SEQUENCE_MAX = (1 << self::SEQUENCE_BITS) - 1;

    const NODE_SHIFT = self::SEQUENCE_BITS;
    const DATACENTER_SHIFT = self::SEQUENCE_BITS + self::NODE_BITS;
    const TIMESTAMP_SHIFT = self::SEQUENCE_BITS + self::NODE_BITS + self::DATACENTER_BITS;

    private $datacenter;
    private $node;
    private $sequence = 0;
    private $lastTimestamp = 0;
    private $format = 'int';
    private $offset = 0;

    public function __construct($datacenter = 1, $node = 1, $format = 'int', $offset = 0)
    {
        if ($datacenter < 0 || $datacenter > self::DATACENTER_MAX) {
            throw new Exception('Invalid datacenter ID');
        }
        if ($node < 0 || $node > self::NODE_MAX) {
            throw new Exception('Invalid node ID');
        }
        $this->datacenter = $datacenter;
        $this->node = $node;
        $this->format = $format;
        $this->offset = $offset;
    }

    private function timeMillis()
    {
        return (int) round(microtime(true) * 1000);
    }

    public function nextId()
    {
        $timestamp = $this->timeMillis();

        if ($timestamp == $this->lastTimestamp) {
            $this->sequence = ($this->sequence + 1) & self::SEQUENCE_MAX;
            if ($this->sequence === 0) {
                while ($timestamp <= $this->lastTimestamp) {
                    $timestamp = $this->timeMillis();
                }
            }
        } else {
            $this->sequence = 0;
        }

        $this->lastTimestamp = $timestamp;

        $id = (($timestamp - self::EPOCH) << self::TIMESTAMP_SHIFT) |
            ($this->datacenter << self::DATACENTER_SHIFT) |
            ($this->node << self::NODE_SHIFT) |
            $this->sequence;

        $id += $this->offset;

        if ($this->format === 'base62') {
            return Base62::encode($id);
        }

        return $id;
    }

    public static function parse($id)
    {
        if (is_string($id)) {
            $id = Base62::decode($id);
        }

        $sequence = $id & self::SEQUENCE_MAX;
        $node = ($id >> self::NODE_SHIFT) & self::NODE_MAX;
        $datacenter = ($id >> self::DATACENTER_SHIFT) & self::DATACENTER_MAX;
        $timestamp = (($id >> self::TIMESTAMP_SHIFT) + self::EPOCH);

        $dt = DateTime::createFromFormat('U.u', sprintf('%.3f', $timestamp / 1000));
        $dt->setTimezone(new DateTimeZone('UTC'));

        return [
            'timestamp' => $dt,
            'datacenter' => $datacenter,
            'node' => $node,
            'sequence' => $sequence
        ];
    }
}
