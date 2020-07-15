<?php declare(strict_types=1);
/**
 * A test to send a return email
 *
 * LICENSE: This source file is subject to the Creative Commons License.
 * It is available through the world-wide-web at this URL:
 * http://creativecommons.org/licenses/by-nc-nd/3.0/nl/deed.en_US
 *
 * If you want to add improvements, please create a fork in our GitHub:
 * https://github.com/myparcelnl/magento
 *
 * @author      Reindert Vetter <reindert@myparcel.nl>
 * @copyright   2010-2017 MyParcel
 * @license     http://creativecommons.org/licenses/by-nc-nd/3.0/nl/deed.en_US  CC BY-NC-ND 3.0 NL
 * @link        https://github.com/myparcelnl/magento
 * @since       File available since Release 2.0.0
 */

namespace MyParcelNL\Sdk\Tests\ReturnLabelTest;

use MyParcelNL\Sdk\src\Factory\ConsignmentFactory;
use MyParcelNL\Sdk\src\Helper\MyParcelCollection;
use MyParcelNL\Sdk\src\Model\Consignment\PostNLConsignment;

class SendReturnLabelTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @return $this
     * @throws \MyParcelNL\Sdk\src\Exception\ApiException
     * @throws \MyParcelNL\Sdk\src\Exception\MissingFieldException
     */
    public function testSendReturnLabel()
    {
        if (getenv('API_KEY') == null) {
            echo "\033[31m Set MyParcel API-key in 'Environment variables' before running UnitTest. Example: API_KEY=f8912fb260639db3b1ceaef2730a4b0643ff0c31. PhpStorm example: http://take.ms/sgpgU5\n\033[0m";

            return $this;
        }

        $consignmentTest = $this->additionProviderNewConsignment();

        $myParcelCollection = new MyParcelCollection();

        $consignment = (ConsignmentFactory::createByCarrierId($consignmentTest['carrier_id']))
            ->setApiKey($consignmentTest['api_key'])
            ->setCountry($consignmentTest['cc'])
            ->setPerson($consignmentTest['person'])
            ->setCompany($consignmentTest['company'])
            ->setFullStreet($consignmentTest['full_street_input'])
            ->setPostalCode($consignmentTest['postal_code'])
            ->setCity($consignmentTest['city'])
            ->setEmail($consignmentTest['email'])
            ->setPhone($consignmentTest['phone'])
            ->setLabelDescription($consignmentTest['label_description'])
            ->setRetourInTheBox($consignmentTest['retour_in_the_box']);

        $myParcelCollection
            ->addConsignment($consignment)
            ->setLinkOfLabels()
//            ->sendReturnLabel()
            ->setLatestData();

        var_dump($myParcelCollection->getLinkOfLabels());
        exit("\n|-------------\n" . __FILE__ . ':' . __LINE__ . "\n|-------------\n");
        $this->assertNotNull($myParcelCollection);
    }

    /**
     * Data for the test
     *
     * @return array
     */
    private function additionProviderNewConsignment()
    {
        return [
            'api_key'           => getenv('API_KEY'),
            'carrier_id'        => PostNLConsignment::CARRIER_ID,
            'cc'                => 'NL',
            'person'            => 'Piet',
            'email'             => 'richard@myparcel.nl',
            'company'           => 'Mega Store',
            'full_street_input' => 'Koestraat 55',
            'number_suffix'     => '',
            'postal_code'       => '2231JE',
            'city'              => 'Katwijk',
            'phone'             => '123-45-235-435',
            'label_description' => 'Label description',
            'retour_in_the_box' => true,
        ];
    }
}
