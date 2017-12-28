<?php
/**
 * SEOmatic plugin for Craft CMS 3.x
 *
 * A turnkey SEO implementation for Craft CMS that is comprehensive, powerful,
 * and flexible
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2017 nystudio107
 */

namespace nystudio107\seomatic\models;

use craft\base\Model;

/**
 * @author    nystudio107
 * @package   Seomatic
 * @since     3.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * The public-facing name of the plugin
     *
     * @var string
     */
    public $pluginName = 'SEOmatic';

    /**
     * The server environment, either `live`, `staging`, or `local`
     *
     * @var string
     */
    public $environment = 'live';

    /**
     * If `devMode` is on, prefix the <title> with this string
     *
     * @var string
     */
    public $devModeTitlePrefix = '[devMode] ';

    /**
     * The max number of characters in the `<title>` tag
     *
     * @var int
     */
    public $maxTitleLength = 70;

    /**
     * The max number of characters in the `<meta name="description">` tag
     *
     * @var int
     */
    public $maxDescriptionLength = 160;

    /**
     * The Twitter handle
     *
     * @var string
     */
    public $twitterHandle = '';

    /**
     * The Facebook profile ID
     *
     * @var string
     */
    public $facebookProfileId = '';

    /**
     * The Facebook app ID
     *
     * @var string
     */
    public $facebookAppId = '';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['pluginName', 'string'],
            ['pluginName', 'default', 'value' => 'SEOmatic'],
            ['environment', 'string'],
            ['environment', 'default', 'value' => 'live'],
            ['environment', 'in', 'range' => [
                'live',
                'staging',
                'production',
            ]],
            ['devModeTitlePrefix', 'string'],
            ['devModeTitlePrefix', 'default', 'value' => '[devMode] '],
            ['maxTitleLength', 'integer', 'min' => 10],
            ['maxTitleLength', 'default', 'value' => 70],
            ['maxDescriptionLength', 'integer', 'min' => 10],
            ['maxDescriptionLength', 'default', 'value' => 160],
            ['twitterHandle', 'string'],
            ['twitterHandle', 'default', 'value' => ''],
        ];
    }

    /**
     * Magic getter/setter for the static properties of the class
     *
     * @param string $method    The method name (static property name)
     * @param array  $args      The arguments list
     *
     * @return mixed           The value of the property
     */
    public function __call($method, $args)
    {
        if (preg_match('/^([gs]et)([A-Z])(.*)$/', $method, $match)) {
            $reflector = new \ReflectionClass(get_called_class());
            $property = strtolower($match[2]).$match[3];
            if ($reflector->hasProperty($property)) {
                $property = $reflector->getProperty($property);
                switch ($match[1]) {
                    case 'get':
                        return $property->getValue();
                    case 'set':
                        $property->setValue($this, $args[0]);
                }
            } else {
                throw new InvalidParamException("Property {$property} doesn't exist");
            }
        }

        return null;
    }
}
