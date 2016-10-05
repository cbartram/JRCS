<?php

class Swift_Bug650Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider encodingDataProvider
     *
     * @param string $name
     * @param string $expectedEncodedName
     */
    public function testMailboxHeaderEncoding($name, $expectedEncodedName)
    {
        $factory = new Swift_CharacterReaderFactory_SimpleCharacterReaderFactory();
        $charStream = new Swift_CharacterStream_NgCharacterStream($factory, 'utf-8');
        $encoder = new Swift_Mime_HeaderEncoder_QpHeaderEncoder($charStream);
        $header = new Swift_Mime_Headers_MailboxHeader('To', $encoder, new Swift_Mime_Grammar());
        $header->setCharset('utf-8');

        $header->setNameAddresses(array(
            'tests@example.com' => $name,
        ));

        $this->assertSame('To: '.$expectedEncodedName." <tests@example.com>\r\n", $header->toString());
    }

    public function encodingDataProvider()
    {
        return array(
            array('this is " a tests ö', 'this is =?utf-8?Q?=22?= a tests =?utf-8?Q?=C3=B6?='),
            array(': this is a tests ö', '=?utf-8?Q?=3A?= this is a tests =?utf-8?Q?=C3=B6?='),
            array('( tests ö', '=?utf-8?Q?=28?= tests =?utf-8?Q?=C3=B6?='),
            array('[ tests ö', '=?utf-8?Q?=5B?= tests =?utf-8?Q?=C3=B6?='),
            array('@ tests ö)', '=?utf-8?Q?=40?= tests =?utf-8?Q?=C3=B6=29?='),
        );
    }
}
