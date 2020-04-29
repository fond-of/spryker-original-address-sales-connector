<?php

namespace FondOfSpryker\Zed\OriginalAddressSalesConnector\Communication\Plugin\SalesExtension;

use FondOfSpryker\Zed\SalesExtension\Dependency\Plugin\SalesOrderAddressHydrationPluginInterface;
use Generated\Shared\Transfer\AddressTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderAddress;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class OriginalAddressSalesOrderAddressHydrationPlugin extends AbstractPlugin implements SalesOrderAddressHydrationPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderAddress $salesOrderAddressEntity
     *
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderAddress
     */
    public function hydrate(
        AddressTransfer $addressTransfer,
        SpySalesOrderAddress $salesOrderAddressEntity
    ): SpySalesOrderAddress {
        if ($addressTransfer->getIdCustomerAddress() !== null) {
            return $salesOrderAddressEntity->setFkResourceCustomerAddress(
                $addressTransfer->getIdCustomerAddress()
            );
        }

        if ($addressTransfer->getIdCompanyUnitAddress() !== null) {
            return $salesOrderAddressEntity->setFkResourceCompanyUnitAddress(
                $addressTransfer->getIdCompanyUnitAddress()
            );
        }

        return $salesOrderAddressEntity;
    }
}
