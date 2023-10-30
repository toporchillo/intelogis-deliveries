<?php
class DeliveryListTest extends \PHPUnit\Framework\TestCase
{
    protected $delivery_list;

    protected function setUp(): void
    {
        $this->delivery_list = new MockDeliveryList();
        parent::setUp();
    }

    public function testcalculate()
    {
        $quotes = $this->delivery_list->calculate(7700000000000,62000001000040500, 1.2);
        $this->assertTrue(count($quotes) == 2);
        $this->assertTrue($quotes['slow']['price'] == 105);
        $this->assertTrue($quotes['slow']['date'] == "2023-11-07");
        $this->assertTrue($quotes['fast']['price'] == 122.5);
        $this->assertFalse((bool)$quotes['fast']['error']);

        $quotes = $this->delivery_list->calculate(7700000000000,3502500076300, 2.2);
        $this->assertTrue($quotes['slow']['price'] == 405);
        $this->assertTrue((bool)$quotes['fast']['error']);
    }
}

