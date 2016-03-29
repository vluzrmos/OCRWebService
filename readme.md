## OCRWebService

This package is a wrapper for http://www.ocrwebservice.com/api/restguide.


## Installation

    composer require vluzrmos/ocrwebservice

##  Usage

You should have an account with a trial or other subscription plan to use that package.

### Getting Account Information

```php
/*
 * USERNAME and LICENSE_KEY are strings, and both are provided by ocrwebservice.com.
 */
$ocr = new OCRWebService\OCRWebService(USERNAME, LICENSE_KEY);
$account = $ocr->getAccountInformation();

/*
 Returns an object AccountInformation which has a method ->toArray():
 [                                                  
   "AvailablePages" => 22,                          
   "MaxPages" => 25,                                
   "ExpirationDate" => "04/29/2016",                
   "LastProcessingTime" => "3/29/2016 10:42:13 AM", 
   "SubcriptionPlan" => "TRIAL",                    
   "ErrorMessage" => "",                            
 ]                                                  
*/

$account->getAvailablePages();
$account->getMaxPages();
//...

$account->availablePages; //same of getAvailablePages() method;
//...

```
### Processing a Document 
```php
/*
 * USERNAME and LICENSE_KEY are strings, and both are provided by ocrwebservice.com.
 */
$ocr = new OCRWebService\OCRWebService(USERNAME, LICENSE_KEY);

$document = $ocr->processDocument($pathToPdfOrImage, [
	'gettext' => 'true',
	'pagerange' => 'allpages',
	'language' => 'brazilian'
]);

//all options like described in http://www.ocrwebservice.com/api/restguide

// $document will be an instance of ProcessDocument, with that following methods:

$document->getOCRText(); //return ocr 
$document->toArray(); //return an array with all data 
//...
```