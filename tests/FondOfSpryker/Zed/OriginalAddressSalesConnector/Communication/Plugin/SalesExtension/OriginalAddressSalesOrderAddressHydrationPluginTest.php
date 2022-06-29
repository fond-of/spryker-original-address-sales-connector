<?php

namespace FondOfSpryker\Zed\OriginalAddressSalesConnector\Communication\Plugin\SalesExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\AddressTransfer;

class OriginalAddressSalesOrderAddressHydrationPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\AddressTransfer
     */
    protected $addressTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Sales\Persistence\SpySalesOrderAddress
     */
    protected $spySalesOrderAddressMock;

    /**
     * @var \FondOfSpryker\Zed\OriginalAddressSalesConnector\Communication\Plugin\SalesExtension\OriginalAddressSalesOrderAddressHydrationPlugin
     */
    protected $originalAddressSalesOrderAddressHydrationPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->addressTransferMock = $this->getMockBuilder(AddressTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spySalesOrderAddressMock = $this->getMockBuilder('\Orm\Zed\Sales\Persistence\SpySalesOrderAddress')
            ->disableOriginalConstructor()
            ->setMethods(['setFkResourceCustomerAddress', 'setFkResourceCompanyUnitAddress'])
            ->getMock();

        $this->originalAddressSalesOrderAddressHydrationPlugin = new OriginalAddressSalesOrderAddressHydrationPlugin();
    }

    /**
     * @return void
     */
    public function testHydrateWithCustomerAddress(): void
    {
        $idCustomerAddress = 1;

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getIdCustomerAddress')
            ->willReturn($idCustomerAddress);

        $this->spySalesOrderAddressMock->expects($this->atLeastOnce())
            ->method('setFkResourceCustomerAddress')
            ->with($idCustomerAddress)
            ->willReturn($this->spySalesOrderAddressMock);

        $spySalesOrderAddress = $this->originalAddressSalesOrderAddressHydrationPlugin->hydrate(
            $this->addressTransferMock,
            $this->spySalesOrderAddressMock,
        );

        $this->assertEquals($this->spySalesOrderAddressMock, $spySalesOrderAddress);
    }

    /**
     * @return void
     */
    public function testHydrateWithCompanyUnitAddress(): void
    {
        $idCustomerAddress = null;
        $idCompanyUnitAddress = 1;

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getIdCustomerAddress')
            ->willReturn($idCustomerAddress);

        $this->spySalesOrderAddressMock->expects($this->never())
            ->method('setFkResourceCustomerAddress');

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyUnitAddress')
            ->willReturn($idCompanyUnitAddress);

        $this->spySalesOrderAddressMock->expects($this->atLeastOnce())
            ->method('setFkResourceCompanyUnitAddress')
            ->with($idCompanyUnitAddress)
            ->willReturn($this->spySalesOrderAddressMock);

        $spySalesOrderAddress = $this->originalAddressSalesOrderAddressHydrationPlugin->hydrate(
            $this->addressTransferMock,
            $this->spySalesOrderAddressMock,
        );

        $this->assertEquals($this->spySalesOrderAddressMock, $spySalesOrderAddress);
    }

    /**
     * @return void
     */
    public function testHydrate(): void
    {
        $idCustomerAddress = null;
        $idCompanyUnitAddress = null;

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getIdCustomerAddress')
            ->willReturn($idCustomerAddress);

        $this->spySalesOrderAddressMock->expects($this->never())
            ->method('setFkResourceCustomerAddress');

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyUnitAddress')
            ->willReturn($idCompanyUnitAddress);

        $this->spySalesOrderAddressMock->expects($this->never())
            ->method('setFkResourceCompanyUnitAddress');

        $spySalesOrderAddress = $this->originalAddressSalesOrderAddressHydrationPlugin->hydrate(
            $this->addressTransferMock,
            $this->spySalesOrderAddressMock,
        );

        $this->assertEquals($this->spySalesOrderAddressMock, $spySalesOrderAddress);
    }
}
