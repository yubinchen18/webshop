<?php
namespace CakeIdeal\Controller\Component;

use Cake\Controller\Component;

class CakeIdealComponent extends Component
{

    /**
     * The socket connection we use to connect
     * to the iDeal server.
     *
     * @access private
     * @var resource
     */
    private $connection = null;

    /**
     * An array with error messages
     *
     * @access public
     * @var array
     */
    public $errorMessages = array(
        'CERTIFICATE_NOT_FOUND' => 'The certificate \'%s\' could not be found',
        'CERTIFICATE_UNKNOWN' => 'The certificate with fingerprint \'%s\' is unknown',
        'COULD_NOT_CONNECT' => 'Could not connect to the iDeal transaction server'
    );

    /**
     * The default settings.
     *
     * @access public
     * @var array
     */
    public $defaults = array(
        'authenticationType' => 'SHA1_RSA', // Authentication type to use
        'acquirersCertificate' => 'simulator/simulator-2048.cer', // Acquirer's certificate
        'currency' => 'EUR', // Do not change currenty unless you have specific reasons to do so
        'description' => 'default description', // Used when you do not want to use transaction specific descriptions
        'entranceCode' => '123456789', // Used when you do not want to use transaction specific entrance codes
        'expirationPeriod' => 'PT1H', // PT1H (1 hour)
        'url' => 'ssl://www.ideal-checkout.nl:443/simulator/', // Address of the iDEAL acquiring server
        'language' => 'nl', // Used only for showing errormessages in the prefered language
        'merchantId' => '123456789', // Merchant ID can be retrieved via the iDEAL Dashboard
        'privateKey' => 'simulator/private-2048.key', // Private key file
        'privateKeyPass' => 'Password', // Private key file password
        'privateCert' => 'simulator/private-2048.cer', // Private certificate
        'subId' => 0, // Do not change subID unless you have specific reasons to do so
        'timeout' => 10, // Do not change AcquirerTimeout unless you have specific reasons to do so
        'merchantReturnUrl' => false,
        'certificatesFolder' => false
    );

    /**
     * Initialize the component.
     *
     * @access public
     * @param AppController $controller
     * @param array $settings
     * @return void
     */
    public function __construct($collection, $settings = array())
    {
        if (empty($settings['certificatesFolder'])) {
            $settings['certificatesFolder'] =
            dirname(dirname(dirname(__FILE__))) . DS . 'Config' . DS . 'certificates' . DS;
        }

        // Merge the given settings with the default.
        $settings = array_merge($this->defaults, $settings);

        // Call the parent constructor if this is a CakePHP component
        // otherwise set the settings property
        if (is_subclass_of($this, 'Component')) {
            parent::__construct($collection, $settings);
        } else {
            $this->settings = $settings;
        }
    }

    /**
     * Close the connection with the iDeal server.
     *
     * @access private
     * @return void
     */
    private function closeConnection()
    {
        if ($this->connection != null) {
            fclose($this->connection);
            $this->connection = null;
        }
    }

    /**
     * Create a fingerprint based on the certificate.
     *
     * @access private
     * @param boolean $isPublicCertificate Private or Public certificate
     * @return string
     */
    private function createCertFingerprint($isPublicCertificate = false)
    {
        $certificateFile = ($isPublicCertificate) ?
            $this->settings['acquirersCertificate'] : $this->settings['privateCert'];
        $fullPath = $this->settings['certificatesFolder'] . $certificateFile;

        if ($isPublicCertificate == false && !file_exists($fullPath)) {
            throw new \Exception(sprintf($this->errorMessages['CERTIFICATE_NOT_FOUND'], $fullPath));
        }

        $certificate = file_get_contents($fullPath);

        $data = openssl_x509_read($certificate);

        if (!openssl_x509_export($data, $data)) {
            return false;
        }

        $data = str_replace(array('-----BEGIN CERTIFICATE-----', '-----END CERTIFICATE-----'), '', $data);

        $data = base64_decode($data);

        return strtoupper(sha1($data));
    }

    /**
     * This method creates that base for the XML document.
     *
     * @access public
     * @param string $rootName The name for the root node.
     * @return DOMDocument
     */
    private function createDocument($rootName)
    {
        $doc = new \DOMDocument('1.0', 'UTF-8');

        // Create the the root element.
        $rootElement = $doc->createElement($rootName);
        $rootElement->setAttribute('version', '3.3.1');

        $createDateTimestampElement = $doc->createElement('createDateTimestamp', date('Y-m-d\TH:i:s.000\Z'));

        $rootElement->appendChild($createDateTimestampElement);
        $doc->appendChild($rootElement);
        $doc->createAttributeNS('http://www.idealdesk.com/ideal/messages/mer-acq/3.3.1', 'xmlns');
        
        return $doc;
    }

    /**
     * Alias for sendDirectoryRequest.
     *
     * @access public
     * @return array List of available issuers
     */
    public function getIssuers()
    {
        return $this->sendDirectoryRequest();
    }

    /**
     * Generates a message digest.
     *
     * @access private
     * @param DOMDocument $doc
     * @return string
     */
    private function getMessageDigest($doc)
    {
        return base64_encode(hash('sha256', $doc->C14N(false), true));
    }

    /**
     * Open a new connection.
     *
     * @access private
     * @return void
     */
    private function openConnection()
    {
        if ($this->connection != null) {
            $this->closeConnection();
        }

        $parsedUrl = parse_url($this->settings['url']);
        $scheme = $parsedUrl['scheme'];
        $host = $parsedUrl['host'];
        $port = $parsedUrl['port'];
        $timeout = $this->settings['timeout'];
        $errorNr = 0;
        $errorString = '';
        $this->connection = fsockopen($scheme . '://' . $host, $port, $errorNr, $errorString, $timeout);

        if ($errorNr > 0) {
            throw new \Exception($this->errorMessages['COULD_NOT_CONNECT']);
        }

        return true;
    }

    /**
     * Method that converts an XML document to an array.
     *
     * @param DOMElement $root
     * @return array The XML as an array
     */
    private function xmlToArray($root)
    {
        $result = array();

        if ($root->hasAttributes()) {
            $attrs = $root->attributes;
            foreach ($attrs as $attr) {
                $result['@attributes'][$attr->name] = $attr->value;
            }
        }

        if ($root->hasChildNodes()) {
            $children = $root->childNodes;
            if ($children->length == 1) {
                $child = $children->item(0);
                if ($child->nodeType == XML_TEXT_NODE) {
                    $result['_value'] = $child->nodeValue;
                    return count($result) == 1 ? $result['_value'] : $result;
                }
            }
            $groups = array();
            foreach ($children as $child) {
                if (!isset($result[$child->nodeName])) {
                    $result[$child->nodeName] = $this->xmlToArray($child);
                } else {
                    if (!isset($groups[$child->nodeName])) {
                        $result[$child->nodeName] = array($result[$child->nodeName]);
                        $groups[$child->nodeName] = 1;
                    }
                    $result[$child->nodeName][] = $this->xmlToArray($child);
                }
            }
        }

        return $result;
    }

    /**
     * Send a directory request.
     *
     * @access public
     * @return array
     */
    public function sendDirectoryRequest()
    {
        // Create a new document for the message.
        $doc = $this->createDocument('DirectoryReq');
        $rootElement = $doc->firstChild;

        // Create and add the merchant element to the document.
        $merchantElement = $doc->createElement('Merchant');
        $rootElement->appendChild($merchantElement);

        // Add the merchant data to the merchant element
        $merchantElement->appendChild($doc->createElement('merchantID', $this->settings['merchantId']));
        $merchantElement->appendChild($doc->createElement('subID', $this->settings['subId']));

        // Send the request to iDeal
        $idealResult = $this->sendRequest($doc);

        $countries = $idealResult['DirectoryRes']['Directory']['Country'];
        if (array_key_exists('countryNames', $countries)) {
            $countries = array($countries);
        }

        $issuers = array();
        foreach ($countries as $country) {
            $issuers[$country['countryNames']] = array();
            foreach ($country['Issuer'] as $issuerData) {
                $issuers[$country['countryNames']][$issuerData['issuerID']] = $issuerData['issuerName'];
            }
        }

        return $issuers;
    }

    /**
     * Send a request to the acquirer's server.
     *
     * @access private
     * @param string $request
     * @return array
     */
    private function sendRequest($doc)
    {
        if (!$this->openConnection()) {
            return false;
        }
        
        $doc = $this->signRequest($doc);
        
        $doc->formatOutput = true;
        $request = $doc->C14N(true);

        $result = '';
        $parsedUrl = parse_url($this->settings['url']);
        if ($this->connection) {
            fputs($this->connection, "POST " . $parsedUrl['path'] . " HTTP/1.0\r\n");
            fputs($this->connection, "Accept: text/html\r\n");
            fputs($this->connection, "Accept: charset=UTF-8\r\n");
            fputs($this->connection, "Host: " . $parsedUrl['host'] . "\r\n");
            fputs($this->connection, "Content-Length:" . strlen($request) . "\r\n");
            fputs($this->connection, "Content-Type: text/xml; charset=utf-8\r\n\r\n");
            fputs($this->connection, $request, strlen($request));

            $passedHeader = false;
            while (!feof($this->connection)) {
                $line = fgets($this->connection, 128);
                if ($passedHeader === false) {
                    $passedHeader = strpos($line, '<?xml') !== false;
                }

                if ($passedHeader) {
                    $result .= $line;
                }
            }
        }
        $this->closeConnection();
        
        // Convert the result to a DOMDocument object.
        $resultDoc = new \DOMDocument();
        $resultDoc->loadXML($result);
        
        // Convert the xml to an array
        $resultAsArray = $this->xmlToArray($resultDoc);

        // Throw an exception if the acquirer return an error.
        if (empty($resultAsArray) || !empty($resultAsArray['AcquirerErrorRes'])) {
            throw new \Exception(sprintf(
                '%s: %s. %s',
                $resultAsArray['AcquirerErrorRes']['Error']['errorCode'],
                $resultAsArray['AcquirerErrorRes']['Error']['errorMessage'],
                $resultAsArray['AcquirerErrorRes']['Error']['errorDetail']
            ));
        }
        
        
        
        // Verify that the response is secure.
        if (!$this->verifyResponse($resultDoc)) {
            return false;
        }

        return $resultAsArray;
    }

    /**
     * Send a status request.
     *
     * @access public
     * @param $data
     * @return array
     */
    public function sendStatusRequest($data)
    {
        // Create a new document for the message.
        $doc = $this->createDocument('AcquirerStatusReq');
        $rootElement = $doc->firstChild;

        // Create and add the merchant element to the document.
        $merchantElement = $doc->createElement('Merchant');
        $transactionElement = $doc->createElement('Transaction');
        $rootElement->appendChild($merchantElement);
        $rootElement->appendChild($transactionElement);


        // Add the merchant data to the merchant element.
        $merchantElement->appendChild($doc->createElement('merchantID', $this->settings['merchantId']));
        $merchantElement->appendChild($doc->createElement('subID', $this->settings['subId']));

        // Add the transaction data to the transaction element.
        $transactionElement->appendChild($doc->createElement('transactionID', $data['Transaction']['transactionId']));

        $idealResult = $this->sendRequest($doc);

        $result = array(
            'createDateTimestamp' => $idealResult['AcquirerStatusRes']['createDateTimestamp'],
            'Acquirer' => $idealResult['AcquirerStatusRes']['Acquirer'],
            'Transaction' => $idealResult['AcquirerStatusRes']['Transaction']
        );

        return $result;
    }

    /**
     * Send a transaction request.
     *
     * @access public
     * @param array $data
     * @return array
     */
    public function sendTransactionRequest($data)
    {
        // Check some items and set the defaults if an item is not set
        foreach (array('currency', 'expirationPeriod', 'language') as $item) {
            if (empty($data['Transaction'][$item])) {
                $data['Transaction'][$item] = $this->settings[$item];
            }
        }

        // Create a new document for the message.
        $doc = $this->createDocument('AcquirerTrxReq');
        $rootElement = $doc->firstChild;

        // Create and add the merchant element to the document.
        $merchantElement = $doc->createElement('Merchant');
        $issuerElement = $doc->createElement('Issuer');
        $transactionElement = $doc->createElement('Transaction');
        $rootElement->appendChild($issuerElement);
        $rootElement->appendChild($merchantElement);
        $rootElement->appendChild($transactionElement);

        // Add the merchant data to the merchant element.
        $merchantElement->appendChild($doc->createElement('merchantID', $this->settings['merchantId']));
        $merchantElement->appendChild($doc->createElement('subID', $this->settings['subId']));
        $merchantElement->appendChild($doc->createElement('merchantReturnURL', $data['Merchant']['merchantReturnUrl']));

        // Add the issuer data to the issuer element.
        $issuerElement->appendChild($doc->createElement('issuerID', $data['Issuer']['issuerId']));

        // Add the transaction data to the transaction element.
        $transactionElement->appendChild($doc->createElement('purchaseID', $data['Transaction']['purchaseId']));
        $transactionElement->appendChild($doc->createElement('amount', $data['Transaction']['amount']));
        $transactionElement->appendChild($doc->createElement('currency', $data['Transaction']['currency']));
        $transactionElement->appendChild(
            $doc->createElement('expirationPeriod', $data['Transaction']['expirationPeriod'])
        );
        $transactionElement->appendChild($doc->createElement('language', $data['Transaction']['language']));
        $transactionElement->appendChild($doc->createElement('description', $data['Transaction']['description']));
        $transactionElement->appendChild($doc->createElement('entranceCode', $data['Transaction']['entranceCode']));


        $idealResult = $this->sendRequest($doc);

        $result = array(
            'createDateTimestamp' => $idealResult['AcquirerTrxRes']['createDateTimestamp'],
            'Acquirer' => $idealResult['AcquirerTrxRes']['Acquirer'],
            'Issuer' => $idealResult['AcquirerTrxRes']['Issuer'],
            'Transaction' => $idealResult['AcquirerTrxRes']['Transaction'],
        );

        return $result;
    }

    /**
     * Signes the XML request and creates the signature block that is suposed to be included in to the request.
     *
     * @access private
     * @param DOMDocument $doc
     * @return string
     */
    private function signRequest($doc = null)
    {
        $signatureElement = $doc->createElement('Signature');
        $signatureElement->setAttribute('xmlns', 'http://www.w3.org/2000/09/xmldsig#');

        $signedInfoElement = $doc->createElement('SignedInfo');

        $canonicalizationMethodElement = $doc->createElement('CanonicalizationMethod');
        $canonicalizationMethodElement->setAttribute('Algorithm', 'http://www.w3.org/2001/10/xml-exc-c14n#');

        $signatureMethodElement = $doc->createElement('SignatureMethod');
        $signatureMethodElement->setAttribute('Algorithm', 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256');

        $transformsElement = $doc->createElement('Transforms');

        $transformElement = $doc->createElement('Transform');
        $transformElement->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#enveloped-signature');

        $referenceElement = $doc->createElement('Reference');
        $referenceElement->setAttribute('URI', '');

        $digestMethodElement = $doc->createElement('DigestMethod');
        $digestMethodElement->setAttribute('Algorithm', 'http://www.w3.org/2001/04/xmlenc#sha256');

        $digestValueElement = $doc->createElement('DigestValue', $this->getMessageDigest($doc));

        $referenceElement->appendChild($transformsElement);
        $referenceElement->appendChild($digestMethodElement);
        $referenceElement->appendChild($digestValueElement);

        $transformsElement->appendChild($transformElement);

        $signedInfoElement->appendChild($canonicalizationMethodElement);
        $signedInfoElement->appendChild($signatureMethodElement);
        $signedInfoElement->appendChild($referenceElement);

        $signatureElement->appendChild($signedInfoElement);

        $doc->firstChild->appendChild($signatureElement);

        $keyInfoElement = $doc->createElement('KeyInfo');
        $keyNameElement = $doc->createElement('KeyName', $this->createCertFingerprint(false));

        $keyInfoElement->appendChild($keyNameElement);
        
        $signatureValueElement = $doc->createElement('SignatureValue', $this->getMessageSignature($signedInfoElement));
        $signatureElement->appendChild($signatureValueElement);
        $signatureElement->appendChild($keyInfoElement);

        return $doc;
    }

    /**
     * Sign a message with the private certificate data.
     *
     * @access private
     * @param DOMDocument $data
     * @return string
     */
    private function getMessageSignature($signedInfoElement)
    {
        $privateKeyFile = $this->settings['certificatesFolder'] . $this->settings['privateKey'];
        if (!file_exists($privateKeyFile)) {
            throw new \Exception(sprintf($this->errorMessages['CERTIFICATE_NOT_FOUND'], $privateKeyFile));
        }

        // Get the contents of the private key file
        $privateKey = file_get_contents($privateKeyFile);

        // Generate a private key id
        $privateKeyId = openssl_get_privatekey($privateKey, $this->settings['privateKeyPass']);

        // compute signature
        openssl_sign($signedInfoElement->C14N(true), $signature, $privateKeyId, 'SHA256');

        // free the key from memory
        openssl_free_key($privateKeyId);

        // getMessageSignature
        $signature = base64_encode($signature);

        return $signature;
    }

    /**
     * Validates the xml signature against the ideal certificate and checks the message digest
     *
     * @access private
     * @param string $response
     * @return true on valid false on invalid
     */
    private function verifyResponse($doc)
    {
        $xpath = new \DOMXpath($doc);
        $xpath->registerNamespace("ns1", "http://www.idealdesk.com/ideal/messages/mer-acq/3.3.1");
        $xpath->registerNamespace("ns2", "http://www.w3.org/2000/09/xmldsig#");
        $fingerprint = $xpath->query('//ns2:Signature/ns2:KeyInfo/ns2:KeyName')->item(0)->nodeValue;

        $acquirersCertificate = $this->settings['certificatesFolder'] . $this->settings['acquirersCertificate'];
        if (!file_exists($acquirersCertificate)) {
            throw new \Exception(sprintf($this->errorMessages['CERTIFICATE_NOT_FOUND'], $acquirersCertificate));
        }

        // Get the fingerprint of the certificate
        $publicFingerprint = $this->createCertFingerprint(true);

        // Check if the certificatate is the same as ours
        if ($fingerprint !== $publicFingerprint) {
            throw new \Exception(sprintf($this->errorMessages['CERTIFICATE_UNKNOWN'], $fingerprint));
        }

        //Convert to dom element, so we can canonicalize it
        $signedInfoDomDocument = $xpath->query('//ns2:Signature/ns2:SignedInfo')->item(0);
        
        // Add namespace to signedinfo tag
        $signedInfo = $signedInfoDomDocument->C14N(true);

        // Get the acquirers certificate
        $publicCertificate = file_get_contents($acquirersCertificate);

        // Get the key out of the certificate
        $publicKey = openssl_get_publickey($publicCertificate);

        // Decode the signature
        $signature = base64_decode((string) $xpath->query('//ns2:Signature/ns2:SignatureValue')->item(0)->nodeValue);

        // If not the same
        if (openssl_verify($signedInfo, $signature, $publicKey, 'SHA256') !== 1) {
            return false;
        }

        $digestValue = (string) $xpath->query(
            '//ns2:Signature/ns2:SignedInfo/ns2:Reference/ns2:DigestValue'
        )->item(0)->nodeValue;

        // Remove signature from message
        $doc->firstChild->removeChild($xpath->query('//ns2:Signature')->item(0));

        if ($this->getMessageDigest($doc) !== $digestValue) {
            return false;
        }

        return true;
    }
}
