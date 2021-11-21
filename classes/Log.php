<?php
/**
 * Open Source Social Network
 *
 * @package   Wallet
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright (c) Engr. Syed Arsalan Hussain Shah (OpenTeknik LLC)
 * @license   OpenTeknik LLC, COMMERCIAL LICENSE  https://www.openteknik.com/license/commercial-license-v1
 * @link      https://www.openteknik.com/
 */
namespace Wallet;
class Log extends \OssnObject {
		/**
		 * Add a log
		 *
		 * @param integer $guid User GUID
		 * @param string  $type Type (debit/credit)
		 * @param integer $amount Amount
		 * @param string  $description Purpose
		 *
		 * @return integer|boolean
		 */
		public function addLog($guid, $type, $amount, $description) {
				if(!empty($guid) && !empty($type) && !empty($amount) && !empty($description)) {
						$this->type         = 'user';
						$this->subtype      = 'wallet:log';
						$this->owner_guid   = $guid;
						$this->title        = $type; //debit/credit
						$this->description  = $description;
						$this->data->amount = $amount;
						return $this->addObject();
				}
				return false;
		}
		/**
		 * Add a log
		 *
		 * @param integer $guid User GUID
		 * @param array  $params Option values
		 *
		 * @return boolean|array
		 */
		public function show($owner_guid, array $params = array()) {
				if(empty($owner_guid)) {
						return false;
				}
				$default               = array();
				$default['type']       = 'user';
				$default['owner_guid'] = $owner_guid;
				$default['subtype']    = 'wallet:log';
				$default['order_by']   = 'o.guid DESC';
				$vars                  = array_merge($default, $params);
				return $this->searchObject($vars);
		}
		/**
		 * Delete log
		 *
		 * @return boolean
		 */
		public function deleteLog() {
				$object = clone $this;
				if(!empty($this->guid)) {
						if($this->deleteObject()) {
								ossn_trigger_callback('user', 'wallet:log:delete', array(
										'log' => $object,
								));
								return true;
						}
				}
				return false;
		}
}