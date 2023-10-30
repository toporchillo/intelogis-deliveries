<?php
include '../config.php';
include '../DeliveryList.php';
include '../deliveries/DeliveryAPI.php';
include '../deliveries/DeliveryFast.php';
include '../deliveries/DeliverySlow.php';

include 'mock/MockDeliveryFast.php';
include 'mock/MockDeliverySlow.php';
include 'mock/MockDeliveryList.php';

define('PHPUNIT_DIR', __DIR__);
