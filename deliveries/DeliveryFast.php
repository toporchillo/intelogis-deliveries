<?php
class DeliveryFast extends DeliveryAPI {

    protected function getQuotes($sourceKladr, $targetKladr, $weight)
    {
        $post_data = ['sourceKladr'=>$sourceKladr, 'targetKladr'=>$targetKladr, 'weight'=>$weight];
        $quotes = $this->apicall('/quotes', 'POST', $post_data, true);
        return $quotes;
    }

    public function calculate($sourceKladr, $targetKladr, $weight)
    {
        $quotes = $this->getQuotes($sourceKladr, $targetKladr, $weight);
        if ($quotes === false) {
            return ['error' => $this->api_error];
        }
        $ret = ['error' => $quotes['error']];
        if ($quotes['period']) {
            $ts = time() + 24*3600*$quotes['period'];
            if (date('H') >= 18) {
                $ts+= 24*3600;
            }
            $ret['price'] = $quotes['price'];
            $ret['date'] = date('Y-m-d', $ts);
        }
        return $ret;
    }
}