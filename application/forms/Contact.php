<?php

class Form_Contact extends Zend_Form {

    public function init() {
        //$this->setMethod('post');
        //create the form elements
        //Subject
        $subject = $this->createElement('text', 'subject');
        $subject->setLabel('Subject');
        $subject->setRequired('true');
        $subject->addFilter('StripTags');
        $subject->addErrorMessage('Please, give the Subject!');
        $subject->removeDecorator('label');
        $subject->removeDecorator('HtmlTag');
        $subject->setAttrib('size', 50);
        $this->addElement($subject);

        //Message
        $message = $this->createElement('textarea', 'message');
        $message->setLabel('Message');
        $message->setRequired('true');
        $message->addFilter('StripTags');
        $message->addErrorMessage('Please, give the Message!');
        $message->removeDecorator('label');
        //csillag hozzáadás
        //$message->getDecorator('label')->setOption('requiredSuffix', ' * ');
        $message->removeDecorator('HtmlTag');
        $message->setAttrib('cols', 40);
        $message->setAttrib('rows', 10);
        $this->addElement($message);

        //E-mail
        $contact_email = $this->createElement('text', 'contact_email');
        $contact_email->setLabel('E-mail');
        $contact_email->setRequired('true');
        $contact_email->addFilter('StripTags');
        //$contact_email->addErrorMessage('Kérem, adja meg az e-mail címett!');

        $validator = new Zend_Validate_NotEmpty();
        $validator->setMessage('Please, give your E-mail address!');
        $contact_email->addValidator($validator);
        $validator = new Zend_Validate_EmailAddress();
        $validator->setMessage('The E-mail address is not valid!');
        $validator->setMessages(
                /*  array(
                  Zend_Validate_EmailAddress::INVALID => 'Please enter in a valid email address in the format user@domain.co.uk',
                  Zend_Validate_EmailAddress::INVALID_FORMAT => 'Error with format',
                  Zend_Validate_EmailAddress::INVALID_HOSTNAME => 'Error with hostname',
                  Zend_Validate_EmailAddress::INVALID_LOCAL_PART => 'Error with Local Part',
                  Zend_Validate_EmailAddress::INVALID_MX_RECORD => 'Error with MX record',
                  Zend_Validate_EmailAddress::INVALID_SEGMENT => 'Error with Segment'
                  )
                 */
                array(
                    Zend_Validate_EmailAddress::INVALID_FORMAT => 'The E-mail address is not valid!',
                )
        );

        $contact_email->addValidator($validator);



        $contact_email->removeDecorator('label');
        $contact_email->removeDecorator('HtmlTag');
        $contact_email->setAttrib('size', 50);
        $this->addElement($contact_email);



        //Catcha kód
        $entered_code = $this->createElement('text','entered_code');
        $entered_code->setLabel('Tárgy');
        $entered_code->setRequired('true');
        $entered_code->addFilter('StripTags');
        $entered_code->addErrorMessage('Kérem, adja meg a képen látható karaktereket! / Please, enter code.');
        $entered_code->removeDecorator('label');
        $entered_code->removeDecorator('HtmlTag');
        $entered_code->setAttrib('size',50);
        $entered_code->setValue('');
        $this->addElement($entered_code);


        $client_ip_address = $this->createElement('hidden', 'client_ip_address');
        $client_ip_address->addFilter('StripTags');
        $client_ip_address->removeDecorator('label');
        $client_ip_address->removeDecorator('HtmlTag');
        $client_ip_address->setValue($_SERVER['REMOTE_ADDR'].", ".gethostbyaddr( $_SERVER['REMOTE_ADDR'] ));
        $this->addElement($client_ip_address);


        $client_location = $this->createElement('hidden', 'client_location');
        $client_location->addFilter('StripTags');
        $client_location->removeDecorator('label');
        $client_location->removeDecorator('HtmlTag');
        //$client_location->setValue($this->detect_city($_SERVER['REMOTE_ADDR']));
        $this->addElement($client_location);
    }

    public function detect_city($ip) {

        $default = 'UNKNOWN';
        $curl_info='';

        if (!is_string($ip) || strlen($ip) < 1 || $ip == '127.0.0.1' || $ip == 'localhost')
            $ip = '8.8.8.8';

        $curlopt_useragent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)';

        $url = 'http://ipinfodb.com/ip_locator.php?ip=' . urlencode($ip);
        $ch = curl_init();

        $curl_opt = array(
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_USERAGENT => $curlopt_useragent,
            CURLOPT_URL => $url,
            CURLOPT_TIMEOUT => 1,
            CURLOPT_REFERER => 'http://' . $_SERVER['HTTP_HOST'],
        );

        curl_setopt_array($ch, $curl_opt);

        $content = curl_exec($ch);

        if (!is_null($curl_info)) {
            $curl_info = curl_getinfo($ch);
        }

        curl_close($ch);

        if (preg_match('{<li>City : ([^<]*)</li>}i', $content, $regs)) {
            $city = $regs[1];
        }
        if (preg_match('{<li>State/Province : ([^<]*)</li>}i', $content, $regs)) {
            $state = $regs[1];
        }

        if ($city != '' && $state != '') {
            $location = $city . ', ' . $state;
            return $location;
        } else {
            return $default;
        }
    }

}

?>
