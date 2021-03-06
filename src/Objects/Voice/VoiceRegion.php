<?php
/**
 * VoiceRegion.php
 */
namespace Discord\Objects\Voice;

use \Discord\Discord;
use \Discord\Objects\Voice\VoiceRegionArray;

/**
 * The VoiceRegion class contains all information about a Voice region.
 * @see https://discordapp.com/developers/docs/resources/voice#voice-region
 */
class VoiceRegion {

    /** @var string|null the id of the region */
    public $id;
    /** @var string|null the name of the region */
    public $name;
    /** @var string|null an example hostname for the region */
    public $sample_hostname;
    /** @var integer|null an example port for the region */
    public $sample_port;
    /** @var boolean|null true if this is an vip-only server */
    public $vip;
    /** @var boolean|null true for a single server that is closest to the current user's client */
    public $optimal;
    /** @var boolean|null whether this is a deprecated voice region (avoid switching to these) */
    public $deprecated;
    /** @var boolean|null whether this is a custom voice region (used for events/etc)*/
    public $custom;

    /**
     * Function to load all Voice regions
     *
     * This is the static function to load all Voice Regions.
     *
     * @param string $token_type this is the type of authentication you want to use
     * @param string $token you'r bots user's token
     *
     * @return object a new VoiceRegionArray Object
     */
    public static function loadVoiceRegions($token_type, $token) {
        $returnarray;
        $ch = curl_init(); //

        curl_setopt_array($ch, array(
            CURLOPT_URL => "http://discordapp.com/api/v" . Discord::$apiv . "/voice/regions",
            CURLOPT_HTTPHEADER     => array('Authorization: ' . $token_type . ' ' . $token),
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_VERBOSE        => 1,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));

        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data, true);

        if (isset($data['code']) && isset($data['message'])) {
            echo $data['code'] . ": " . $data['message'];
        } else {
            return new VoiceRegionArray($data);
        }
    }
    /**
     * The constructor for creating a VoiceRegion
     *
     * This creates a new VoiceRegion array based on the json input
     *
     * @param array $data this is the json string, containing all information about a voice region
     *
     * @return object the new object
     */
    public function __construct($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        if (isset($data['sample_hostname'])) {
            $this->sample_hostname = $data['sample_hostname'];
            $this->sample_port = $data['sample_port'];
        }
        $this->vip = $data['vip'];
        $this->optimal = $data['optimal'];
        $this->deprecated = $data['deprecated'];
        $this->custom = $data['custom'];

        return $this;
    }
    /**
     * Get the regions ID.
     *
     * This returns the regions unique Identifier.
     *
     * @param none
     *
     * @return string returns the id of the region
     */
    public function getId() {
        return $this->id;
    }
    /**
     * Get the Name of the region
     *
     * This returns the name of the region
     *
     * @param none
     *
     * @return string the name of the region
     */
    public function getName() {
        return $this->name;
    }
    /**
     * Get the Sample Hostname for the Region
     *
     * This returns the exmample hostname of the Region
     *
     * @param none
     *
     * @return string|null the sample hostname
     */
    public function getSampleHostname() {
        return $this->sample_hostname;
    }
    /**
     * Get the Sample port for the Region
     *
     * This returns the exmample port of the Region
     *
     * @param none
     *
     * @return integer|null the sample port
     */
    public function getSamplePort() {
        return $this->sample_port;
    }
    /**
     * Get if the Region is VIP only
     *
     * This returns wether the region is VIP only or nah.
     *
     * @param none
     *
     * @return boolean|null returns the boolean if the region is VIP only.
     */
    public function getVIP() {
        return $this->vip;
    }
    /**
     * Get if the Region is optimal for the client
     *
     * This returns wether the region is optimal for the client
     *
     * @param none
     *
     * @return boolean returns the boolean if the region is optimal.
     */
    public function getOptimal() {
        return $this->optimal;
    }
    /**
     * Get if the Region is deprecated
     *
     * This returns wether the region is deprecated
     *
     * @param none
     *
     * @return boolean|null returns the boolean if the region is deprecated
     */
    public function getDeprecated() {
        return $this->deprecated;
    }
    /**
     * Get if the Region is custom
     *
     * This returns wether the region is custom (events etc.)
     *
     * @param none
     *
     * @return boolean|null returns the boolean if the region is custom for events etc.
     */
    public function getCustom() {
        return $this->custom;
    }
}
