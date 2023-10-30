<?php
class MockDeliveryList extends DeliveryList {
    public function __construct()
    {
        $this->deliveries = [
            'slow' => new MockDeliverySlow(APIConfig::$slow['url'], APIConfig::$slow['login'], APIConfig::$slow['password']),
            'fast' => new MockDeliveryFast(APIConfig::$fast['url'], APIConfig::$fast['login'], APIConfig::$fast['password'])
        ];
    }
}