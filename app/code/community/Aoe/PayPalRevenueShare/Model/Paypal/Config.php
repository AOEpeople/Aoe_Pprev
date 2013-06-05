<?php

/**
 * Paypal_Model_Config rewrite to add custom build notation code
 *
 * @author David Robinson
 * @since 2013-06-03
 */
class Aoe_PayPalRevenueShare_Model_Paypal_Config extends Mage_Paypal_Model_Config
{

    /**
     * BN code getter
     *
     * @param string $countryCode ISO 3166-1
     * @return string
     */
    public function getBuildNotationCode($countryCode = null)
    {
        $product = 'WPP';

        if (!($bnCode = Mage::getStoreConfig('dev/aoe_paypalrevenueshare/bn_code'))) {
            $bnCode = 'Varien_Cart_%s%s';
        };

        if ($this->_methodCode && isset($this->_buildNotationPPMap[$this->_methodCode])) {
            $product = $this->_buildNotationPPMap[$this->_methodCode];
        }
        if (null === $countryCode) {
            $countryCode = $this->_matchBnCountryCode($this->getMerchantCountry());
        }
        if ($countryCode) {
            $countryCode = '_' . $countryCode;
        }
        return sprintf($bnCode, $product, $countryCode);
    }
}
