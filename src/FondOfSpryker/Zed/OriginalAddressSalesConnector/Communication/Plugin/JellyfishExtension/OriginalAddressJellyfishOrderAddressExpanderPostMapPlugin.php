<?php

namespace FondOfSpryker\Zed\OriginalAddressSalesConnector\Communication\Plugin\JellyfishExtension;

use FondOfSpryker\Zed\JellyfishExtension\Dependency\Plugin\JellyfishOrderAddressExpanderPostMapPluginInterface;
use Generated\Shared\Transfer\JellyfishOrderAddressTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderAddress;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class OriginalAddressJellyfishOrderAddressExpanderPostMapPlugin extends AbstractPlugin implements JellyfishOrderAddressExpanderPostMapPluginInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\JellyfishOrderAddressTransfer $jellyfishOrderAddressTransfer
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderAddress $salesOrderAddress
     *
     * @return \Generated\Shared\Transfer\JellyfishOrderAddressTransfer
     */
    public function expand(
        JellyfishOrderAddressTransfer $jellyfishOrderAddressTransfer,
        SpySalesOrderAddress $salesOrderAddress
    ): JellyfishOrderAddressTransfer {
        if ($salesOrderAddress->getFkResourceCustomerAddress() !== null) {
            return $jellyfishOrderAddressTransfer->setId($salesOrderAddress->getFkResourceCustomerAddress());
        }

        if ($salesOrderAddress->getFkResourceCompanyUnitAddress() !== null) {
            return $jellyfishOrderAddressTransfer->setId($salesOrderAddress->getFkResourceCompanyUnitAddress());
        }

        return $jellyfishOrderAddressTransfer;
    }
}
