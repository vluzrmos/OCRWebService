<?php

namespace OCRWebService\Response;

/**
 * Class ProcessDocument
 * @package OCRWebService\Response
 *
 * @property string $OCRText
 * @property int $availablePages
 * @property string $errorMessage
 * @property string $reserved
 * @property string $outputFileUrl
 * @property string $taskDescription
 *
 * @method int getAvailablePages()
 * @method string getErrorMessage()
 * @method string getReserved()
 * @method string getOutputFileUrl()
 * @method string getTaskDescription()
 */
class ProcessDocument extends AbstractResponse
{
    /**
     * @return array
     */
    public function toArray()
    {
        $data = $this->data;

        if ($this->hasAttribute('OCRText')) {
            $data['OCRText'] = $this->getOCRText();
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getOCRText()
    {
        $ocr = $this->getAttribute('OCRText', []);

        $pages = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($ocr)), 0);

        $text = '';

        foreach ($pages as $page) {
            $text .= $page . PHP_EOL;
        }

        return $text;
    }

}