<?php

namespace FondOfSpryker\Zed\OriginalAddressSalesConnector\Communication\Plugin\JellyfishExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\JellyfishOrderAddressTransfer;

class OriginalAddressJellyfishOrderAddressExpanderPostMapPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\JellyfishOrderAddressTransfer
     */
    protected $jellyfishOrderAddressTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Sales\Persistence\SpySalesOrderAddress
     */
    protected $spySalesOrderAddressMock;

    /**
     * @var \FondOfSpryker\Zed\OriginalAddressSalesConnector\Communication\Plugin\JellyfishExtension\OriginalAddressJellyfishOrderAddressExpanderPostMapPlugin
     */
    protected $originalAddressJellyfishOrderAddressExpanderPostMapPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->jellyfishOrderAddressTransferMock = $this->getMockBuilder(JellyfishOrderAddressTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spySalesOrderAddressMock = $this->getMockBuilder('\Orm\Zed\Sales\Persistence\SpySalesOrderAddress')
            ->disableOriginalConstructor()
            ->setMethods(['getFkResourceCustomerAddress', 'getFkResourceCompanyUnitAddress'])
            ->getMock();

        $this->originalAddressJellyfishOrderAddressExpanderPostMapPlugin = new OriginalAddressJellyfishOrderAddressExpanderPostMapPlugin();
    }

    /**
     * @return void
     */
    public function testExpandWithCustomerAddress(): void
    {
        $idCustomerAddress = 1;

        $this->spySalesOrderAddressMock->expects($this->atLeastOnce())
            ->method('getFkResourceCustomerAddress')
            ->willReturn($idCustomerAddress);

        $this->jellyfishOrderAddressTransferMock->expects($this->atLeastOnce())
            ->method('setId')
            ->with($idCustomerAddress)
            ->willReturn($this->jellyfishOrderAddressTransferMock);

        $jellyfishOrderAddressTransfer = $this->originalAddressJellyfishOrderAddressExpanderPostMapPlugin->expand(
            $this->jellyfishOrderAddressTransferMock,
            $this->spySalesOrderAddressMock
        );

        $this->assertEquals($this->jellyfishOrderAddressTransferMock, $jellyfishOrderAddressTransfer);
    }

    /**
     * @return void
     */
    public function testExpandWithCompanyUnitAddress(): void
    {
        $idCustomerAddress = null;
        $idCompanyUnitAddress = 1;

        $this->spySalesOrderAddressMock->expects($this->atLeastOnce())
            ->method('getFkResourceCustomerAddress')
            ->willReturn($idCustomerAddress);

        $this->spySalesOrderAddressMock->expects($this->atLeastOnce())
            ->method('getFkResourceCompanyUnitAddress')
            ->willReturn($idCompanyUnitAddress);

        $this->jellyfishOrderAddressTransferMock->expects($this->atLeastOnce())
            ->method('setId')
            ->with($idCompanyUnitAddress)
            ->willReturn($this->jellyfishOrderAddressTransferMock);

        $jellyfishOrderAddressTransfer = $this->originalAddressJellyfishOrderAddressExpanderPostMapPlugin->expand(
            $this->jellyfishOrderAddressTransferMock,
            $this->spySalesOrderAddressMock
        );

        $this->assertEquals($this->jellyfishOrderAddressTransferMock, $jellyfishOrderAddressTransfer);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $idCustomerAddress = null;
        $idCompanyUnitAddress = null;

        $this->spySalesOrderAddressMock->expects($this->atLeastOnce())
            ->method('getFkResourceCustomerAddress')
            ->willReturn($idCustomerAddress);

        $this->spySalesOrderAddressMock->expects($this->atLeastOnce())
            ->method('getFkResourceCompanyUnitAddress')
            ->willReturn($idCompanyUnitAddress);

        $this->jellyfishOrderAddressTransferMock->expects($this->never())
            ->method('setId');

        $jellyfishOrderAddressTransfer = $this->originalAddressJellyfishOrderAddressExpanderPostMapPlugin->expand(
            $this->jellyfishOrderAddressTransferMock,
            $this->spySalesOrderAddressMock
        );

        $this->assertEquals($this->jellyfishOrderAddressTransferMock, $jellyfishOrderAddressTransfer);
    }
}
