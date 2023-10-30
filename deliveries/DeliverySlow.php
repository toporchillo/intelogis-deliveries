<?php
class DeliverySlow extends DeliveryAPI {
    public $base_price = 150;

    protected function getQuotes($sourceKladr, $targetKladr, $weight)
    {
        $url = "/shipping-price/?sourceKladr=$sourceKladr&targetKladr=$targetKladr&weight=$weight";
        $quotes = $this->apicall($url, 'GET', '', true);
        return $quotes;
    }

    public function calculate($sourceKladr, $targetKladr, $weight)
    {
        $quotes = $this->getQuotes($sourceKladr, $targetKladr, $weight);
        if ($quotes === false) {
            return ['error' => $this->api_error];
        }
        $ret = ['error' => $quotes['error']];
        if ($quotes['coefficient']) {
            $ret['price'] = $this->base_price*$quotes['coefficient'];
            $ret['date'] = $quotes['date'];
        }
        return $ret;
    }
}