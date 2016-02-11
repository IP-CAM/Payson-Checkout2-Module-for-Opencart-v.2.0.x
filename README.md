Payson-Checkout2-Opencart
========================

Module for OpenCart 2 implementing Payson Checkout 2.0

# Payson OpenCart Module

## Description

Module for OpenCart implementing Payson

## Installation

* Make a BACKUP of your web store and database. 
* Copy all files from this repository into yor OpenCart root. 

### Configuration

* Login into your web shop Administration Panel.

* Go to Extensions->Payments and install Payson. 

* Click Edit.

* Enter your Merchant ID, Api-Key before enabling the module.

* Click Save.

## Upgrade

* You should have a BACKUP of your web store and database.

* Login into your web shop Administration Panel.

* Go to Extensions->Payments. Uninstall Payson. 

* Go to Opencart folder to the root directory of your store.

* remove the files:

****Admin****

Admin/contoller/payment/paysondirect.php
Admin/contoller/payment/paysoninvoice.php

Admin/contoller/total/paysoninvoice.fee.php 

Admin/language/english/payment/paysondirect.php
Admin/language/english/payment/paysoninvoice.php
Admin/language/swedish/payment/paysondirect.php
Admin/language/swedish/payment/paysoninvoice.php

Admin/language/english/total/paysoninvoice.fee.php 
Admin/language/swedish/total/paysoninvoice.fee.php 
Admin/model/module/paysondirect.php
Admin/model/module/paysoninvoice.php

Admin/view/image/payment/payson.png
Admin/view/image/payment/paysoninvoice.png

Admin/view/template/payment/paysondirect.tpl
Admin/view/template/payment/paysoninvoice.tpl

Admin/view/template/total/paysoninvoice.fee.tpl 

****Catalog****

catalog/contoller/payment/payson (folder)
catalog/contoller/payment/paysondirect.php
catalog/contoller/payment/paysoninvoice.php

catalog/language/english/payment/paysondirect.php
catalog/language/english/payment/paysoninvoice.php
catalog/language/english/total/paysoninvoice_fee.php

catalog/language/swedish/payment/paysondirect.php
catalog/language/swedish/payment/paysoninvoice.php
catalog/language/swedish/total/paysoninvoice_fee.php

catalog/model/payment/paysondirect.php
catalog/model/payment/paysoninvoice.php
catalog/model/total/paysoninvoice_fee.php

catalog/view/theme/default/image/payment/payson.png
catalog/view/theme/default/image/payment/paysoninvoice.png

catalog/view/theme/default/template/payment/paysondirect.tpl
catalog/view/theme/default/template/payment/paysoninvoice.tpl

* Go to INSTALLATION in this document. 

## Usage

If you only are interested to use this module in your store, please download it from [here](http://www.opencart.com/index.php?route=extension/extension/info&extension_id=10923)

## Contributing

Issue pull requests or send feature requests.