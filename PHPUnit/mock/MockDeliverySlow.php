<?php
class MockDeliverySlow extends DeliverySlow {
    public function getQuotes($sourceKladr, $targetKladr, $weight)
    {
        $filename = PHPUNIT_DIR."/test_data/slow_{$sourceKladr}_{$targetKladr}.json";
        if (is_file($filename)) {
            return json_decode(file_get_contents($filename), true);
        }
        return ['error' => 'Не удалось узнать стоимость доставки'];
    }
}
