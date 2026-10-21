<?php
return ['currency'=>env('STORE_CURRENCY','USD'), 'shipping_threshold'=>(float)env('STORE_SHIPPING_THRESHOLD',499), 'shipping_fee'=>(float)env('STORE_SHIPPING_FEE',25), 'tax_rate'=>(float)env('STORE_TAX_RATE',0)];
