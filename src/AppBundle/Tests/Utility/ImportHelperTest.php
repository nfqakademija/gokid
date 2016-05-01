<?php

namespace AppBundle\Tests\Utility;

use AppBundle\Entity\OfferImage;
use AppBundle\Utility\Curl;
use AppBundle\Utility\ImportHelper;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamWrapper;
use ProxyManager\Proxy\Exception\RemoteObjectException;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ImportHelperTest extends \PHPUnit_Framework_TestCase
{
    private $fileSize = 100;

    public function setUp()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('root'));
    }

    private function getMockManagerRegistry()
    {
        return $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function getMockTokenStorage()
    {
        return $this->getMockBuilder(TokenStorage::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function getTestGetFileExtensionData()
    {
        return [
            ['song.mp3', 'mp3'],
            ['404.bak.tz', 'tz'],
            ['movie.mp4.tar.exe', 'exe'],
        ];
    }

    /**
     * @dataProvider getTestGetFileExtensionData()
     */
    public function testGetFileExtension($input, $output)
    {
        $importHelper = new ImportHelper(
            $this->getMockManagerRegistry(),
            $this->getMockTokenStorage()
        );
        $result = $importHelper->getFileExtension($input);
        $this->assertEquals($output, $result);
    }

    public function testDownloadImageWhenCantDownload()
    {
        $http = $this->getMockBuilder(Curl\HttpRequest::class)
            ->getMock();
        $http->expects($this->any())
            ->method('getInfo')
            ->will($this->returnValue(false));
        $importHelper = new ImportHelper(
            $this->getMockManagerRegistry(),
            $this->getMockTokenStorage()
        );
        $result = $importHelper->downloadImage(
            $http,
            'anypath',
            'anyname'
        );
        $this->assertEquals(
            null,
            $result
        );
    }

    public function createFile()
    {
        $fp = fopen(vfsStream::url('root/file'), 'w+');
        for ($i = 0; $i < $this->fileSize; $i++) {
            fwrite($fp, 'a');
        }
        fclose($fp);
    }

    public function testDownloadImageWhenCanDownload()
    {
        $http = $this->getMockBuilder(Curl\HttpRequest::class)
            ->getMock();
        $http->expects($this->any())
            ->method('getInfo')
            ->will($this->returnValue(200));
        $http->expects($this->any())
            ->method('execute')
            ->will($this->returnCallback(array($this, 'createFile')));
        $importHelper = new ImportHelper(
            $this->getMockManagerRegistry(),
            $this->getMockTokenStorage()
        );

        $result = $importHelper->downloadImage(
            $http,
            'root/file',
            vfsStream::url('root/file')
        );

        $size = filesize(vfsStream::url('root/file'));

        $this->assertEquals(vfsStream::url('root'), $result->getPath());
        $this->assertEquals('file', $result->getClientOriginalName());
        $this->assertEquals($this->fileSize, $result->getSize());
    }

    public function testCreateOfferImageFromFileFailure()
    {
        $mock = $this->getMockBuilder('ImportHelper')
            ->setMethods(['downloadImage', 'createOfferImageFromFile'])
            ->getMock();
        $mock->expects($this->any())
            ->method('downloadImage')
            ->will($this->returnValue(null));

        $result = $mock->createOfferImageFromFile('any', 'any');

        $this->assertEquals(null, $result);
    }

    public function testCreateOfferImageFromFileSuccess()
    {
        $this->createFile();
        $mock = $this->getMockBuilder(ImportHelper::class)
            ->disableOriginalConstructor()
            ->setMethods(['downloadImage'])
            ->getMock();
        $mock->expects($this->any())
            ->method('downloadImage')
            ->will($this->returnValue(new UploadedFile(
                vfsStream::url('root/file'),
                'root/file',
                'text/javascript',
                $this->fileSize
            )));

        $result = $mock->createOfferImageFromFile('file', 'file');

        $this->assertEquals(
            'file',
            $result->getImageFile()->getClientOriginalname()
        );
        $this->assertEquals(
            'text/javascript',
            $result->getImageFile()->getClientMimeType()
        );
        $this->assertEquals(
            vfsStream::url('root'),
            $result->getImageFile()->getPath()
        );
    }

    public function testParceCsvImageFailure()
    {
        $mock = $this->getMockBuilder(ImportHelper::class)
            ->disableOriginalConstructor()
            ->setMethods(['createOfferImageFromFile'])
            ->getMock();
        $mock->expects($this->any())
            ->method('createOfferImageFromFile')
            ->will($this->returnValue(null));

        $this->expectException(RemoteObjectException::class);
        $mock->parseCsv('offers.csv');
    }

    public function testParceCsvFileFailure()
    {
        $importHelper = new ImportHelper(
            $this->getMockManagerRegistry(),
            $this->getMockTokenStorage()
        );
        $this->expectException(FileNotFoundException::class);
        $importHelper->parseCsv($this->getTestParseCsvFileSuccessData()[0][0] . 'anything');
    }

    public function getTestParseCsvFileSuccessData()
    {
        return [
            [
                'src/AppBundle/Tests/Utility/offers.csv',
                [
                    'results' => 2,
                    'offers' => 2,
                    'offerImages' => 3,
                    'offerData' => [
                        [
                            'getName' => 'Sabonio krepšinio centras',
                            'getDescription' => 'Strateginis krepšinio rinkos partneris, ugdantis aktyvius ir ' .
                                'sveikus visuomenės narius, lyderiaujantis rengiant profesionalaus krepšinio ' .
                                'pamainą.',
                            'getPaymentType' => '0',
                            'getPrice' => '10',
                            'isMale' => true,
                            'isFemale' => true,
                            'getAgeFrom' => 5,
                            'getAgeTo' => 16,
                            'getAddress' => 'Kaunas',
                            'getLatitude' => '54.907187',
                            'getLongitude' => '23.965188',
                            'isImported' => true,
                            'getContactInfo' => 'Aurimas Jasilionis - 865778030',
                        ],
                        [
                            'getName' => '„TORNADO“ Krepšinio mokykla',
                            'getDescription' => '"Tornado" krepšinio mokykla kasmet sulaukia vis didesnio būrio ' .
                                'berniukų ir vaikinų,norinčių žaisti krepšinį. Šiuo metu mokykloje sportuoja ' .
                                'daugiau nei 550 vaikų."Tornado" KM dirba patyrę treneriai, ne vienerius '.
                                'metus ugdantys krepšininkus nuo pirmųjų žingsnių krepšinio aikštelėje.',
                            'getPaymentType' => '2',
                            'getPrice' => '5',
                            'isMale' => false,
                            'isFemale' => false,
                            'getAgeFrom' => 10,
                            'getAgeTo' => 18,
                            'getAddress' => 'Kaunas',
                            'getLatitude' => '54.8963829',
                            'getLongitude' => '23.8306256',
                            'isImported' => true,
                            'getContactInfo' => 'Darius Sirtautas - 868637833',
                        ],
                    ],
                ],
            ],
        ];
    }


    private $parseCsvTestFile = 'src/AppBundle/Tests/Utility/offers.csv';

    /**
     * @dataProvider getTestParseCsvFileSuccessData()
     */
    public function testParseCsvFileSuccess($input, $output)
    {
        $mock = $this->getMockBuilder(ImportHelper::class)
            ->disableOriginalConstructor()
            ->setMethods(['createOfferImageFromFile'])
            ->getMock();
        $mock->expects($this->any())
            ->method('createOfferImageFromFile')
            ->will($this->returnValue(new OfferImage()));

        $results = $mock->parseCsv($input);

        $this->assertEquals($output['results'], sizeof($results));
        $this->assertEquals($output['offers'], sizeof($results['offers']));
        $this->assertEquals($output['offerImages'], sizeof($results['offerImages']));
        foreach ($output['offerData'] as $index => $offer) {
            foreach ($offer as $key => $value) {
                $this->assertEquals(
                    $output['offerData'][$index][$key],
                    $results['offers'][$index]->$key()
                );
            }
        }
    }
}
