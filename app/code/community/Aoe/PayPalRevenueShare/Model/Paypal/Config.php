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
        }

        if ($this->_methodCode && isset($this->_buildNotationPPMap[$this->_methodCode])) {
            $product = $this->_buildNotationPPMap[$this->_methodCode];
        }

        if (null === $countryCode) {
            $countryCode = $this->_matchBnCountryCode($this->getMerchantCountry());
        }

        return sprintf($bnCode, $product, $countryCode);
    }

    /**
     * Check whether specified country code is supported by build notation codes for specific countries
     *
     * Copied from parent because it's marked private for some reason...
     *
     * @param $code
     * @return string|null
     */
    protected function _matchBnCountryCode($code)
    {
        switch ($code) {
            // GB == UK
            case 'GB':
                return 'UK';
            // Australia, Austria, Belgium, Canada, China, France, Germany, Hong Kong, Italy
            case 'AU': case 'AT': case 'BE': case 'CA': case 'CN': case 'FR': case 'DE': case 'HK': case 'IT':
            // Japan, Mexico, Netherlands, Poland, Singapore, Spain, Switzerland, United Kingdom, United States
            case 'JP': case 'MX': case 'NL': case 'PL': case 'SG': case 'ES': case 'CH': case 'UK': case 'US':
                return $code;
        }
    }
}
