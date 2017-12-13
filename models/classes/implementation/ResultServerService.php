<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2017 (original work) Open Assessment Technologies SA (under the project TAO-PRODUCT);
 *
 */
namespace oat\taoResultServer\models\classes\implementation;

use oat\taoResultServer\models\classes\AbstractResultStorage;
use taoResultServer_models_classes_ResultServer;
use oat\generis\model\OntologyAwareTrait;
use oat\taoResultServer\models\classes\ResultServiceTrait;
use oat\oatbox\service\ConfigurableService;
use oat\taoResultServer\models\classes\ResultServerService as ResultServerServiceInterface;
use taoResultServer_models_classes_Variable;

/**
 * Class ResultServerService
 *
 * Configuration example (taoResultServer/resultservice.conf.php):
 * ```php
 *
 * use oat\taoResultServer\models\classes\implementation\ResultServerService;
 * return new ResultServerService([
 *     ResultServerService::OPTION_RESULT_STORAGE => 'taoOutcomeRds/RdsResultStorage'
 * ]);
 *
 * ```
 *
 * @package oat\taoResultServer\models\classes\implementation
 * @author Aleh Hutnikau, <hutnikau@1pt.com>
 */
class ResultServerService extends AbstractResultStorage implements \taoResultServer_models_classes_ReadableResultStorage,  \taoResultServer_models_classes_WritableResultStorage
{

    use OntologyAwareTrait;
    use ResultServiceTrait;
    use ReadableResultStorage;
    use WritableResultStorage;

    const OPTION_RESULT_STORAGE = 'result_storage';

    /**
     * Returns the storage engine of the result server
     *
     * @param string $deliveryId
     * @throws \common_exception_Error
     * @return \taoResultServer_models_classes_WritableResultStorage
     */
    public function getResultStorage($deliveryId)
    {
        $resultServerId = $this->getOption(self::OPTION_RESULT_STORAGE);
        return $this->instantiateResultStorage($resultServerId);
    }

    /**
     * @param $executionIdentifier
     * @param null $compiledDelivery
     * @param array $options
     * @return taoResultServer_models_classes_ResultServer
     */
    protected function getResultServer($executionIdentifier = null, $compiledDelivery = null, array $options = []){
        return new taoResultServer_models_classes_ResultServer($this->getOption(self::OPTION_RESULT_STORAGE), $options);

    }
}