<?php
class DeliveryList {
    protected $deliveries = [];

    public function __construct()
    {
        $this->deliveries = [
            'slow' => new DeliverySlow(APIConfig::$slow['url'], APIConfig::$slow['login'], APIConfig::$slow['password']),
            'fast' => new DeliveryFast(APIConfig::$fast['url'], APIConfig::$fast['login'], APIConfig::$fast['password'])
        ];
    }

    public function calculate($sourceKladr, $targetKladr, $weight) {
        $ret = [];
        //@todo тут хорошо бы распараллеливать вычисления,
        //например при помощи parallel https://www.php.net/manual/ru/book.parallel.php
        foreach ($this->deliveries as $key=>$delivery) {
            $ret[$key] = $delivery->calculate($sourceKladr, $targetKladr, $weight);
        }
        return $ret;
    }
}