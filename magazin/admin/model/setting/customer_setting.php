<?php
class ModelSettingCustomerSetting extends Model
{
    public function addSetting($customer_id, $group, $key, $value, $is_json = 0, $store_id = -1)
    {
        if (!is_numeric($store_id) || $store_id < -1 || !is_numeric($customer_id) || $customer_id <= 0 || !trim($group) || !trim($key) || trim($value) === '' || ($is_json && !json_decode(htmlspecialchars_decode($value)))) {
            return;
        }
        $this->db->query("INSERT INTO `" . DB_PREFIX . "customer_setting` SET `store_id` = '" . (int)$store_id . "', `customer_id` = '" . (int)$customer_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . ($is_json ? $this->db->escape(htmlspecialchars_decode($value)) : $this->db->escape($value)) . "', `is_json` = '" . (int)$is_json . "' ON DUPLICATE KEY UPDATE `value` = '" . $this->db->escape($value) . "', `is_json` = '" . (int)$is_json . "'");
    }

    public function addSettings($entries)
    {
        $values = array();
        $required = array('store_id', 'customer_id', 'group', 'key', 'value', 'is_json');
        foreach ($entries as $entry) {
            if (count(array_intersect_key(array_flip($required), $entry)) != count($required)
                || !is_numeric($entry['store_id'])
                || $entry['store_id'] < -1
                || !is_numeric($entry['customer_id'])
                || $entry['customer_id'] <= 0
                || !trim($entry['group'])
                || !trim($entry['key'])
                || trim($entry['value']) === ''
                || ((bool)$entry['is_json'] && !json_decode(htmlspecialchars_decode($entry['value']), true))) {
                continue;
            }
            $sanitized = array(
                (int)$entry['store_id'],
                (int)$entry['customer_id'],
                $this->db->escape($entry['group']),
                $this->db->escape($entry['key']),
                ($entry['is_json'] ? $this->db->escape(htmlspecialchars_decode($entry['value'])) : $this->db->escape($entry['value'])),
                (int)(bool)$entry['is_json']
            );
            $values[] = "('" . implode("', '", $sanitized) . "')";
        }     
        if ($values) {
            $sql = "INSERT INTO `" . DB_PREFIX . "customer_setting` (`store_id`, `customer_id`, `group`, `key`, `value`, `is_json`) VALUES ";
            $sql .= implode(', ', $values);
            $sql .= " ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `is_json` = VALUES(`is_json`)";
            $this->db->query($sql);
        }
    }

    public function getSettings($data = array())
    {
        $data = array_merge(array('store_id' => null, 'customer_id' => 0, 'group' => '', 'key' => ''), $data);
        extract($data);
        $result = array();
        $sql = "SELECT * FROM " . DB_PREFIX . "customer_setting WHERE ";
        if ($store_id !== null) {
            $sql .= "`store_id` = '" . (int)$store_id . "' AND ";
        }
        if ($customer_id) {
            $sql .= "`customer_id` = '" . (int)$customer_id . "' AND ";
        }
        if ($group) {
            $sql .= "`group` = '" . $this->db->escape($group) . "' AND ";
        }
        if ($key) {
            $sql .= "`key` = '" . $this->db->escape($key) . "' AND ";
        }
        $sql .= "1";
        $query = $this->db->query($sql);
        foreach ($query->rows as $row) {
            if ($row['is_json']) {
                $row['value'] = json_decode($row['value'], true);
            }
            $result[] = $row;
        }
        return $result;
    }

    public function updateCustomerSettings($customer_id, $data)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "customer_setting WHERE customer_id = '" . (int)$customer_id . "'");
        if ($data) {
            foreach ($data as $k => $v) {
                $data[$k]['customer_id'] = (int)$customer_id;
            }
            $this->addSettings($data);
        }
    }

    public function updateStoreSettings($store_id, $data)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "customer_setting WHERE store_id = '" . (int)$store_id . "'");
        if ($data) {
            foreach ($data as $k => $v) {
                $data[$k]['store_id'] = (int)$store_id;
            }
            $this->addSettings($data);
        }
    }

    public function deleteSetting($id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "customer_setting WHERE customer_setting_id = '" . (int)$id . "'");
    }

    public function getSettingGroups($group = '')
    {
        $result = array();
        $query = $this->db->query("SELECT DISTINCT(`group`) FROM `" . DB_PREFIX . "setting` WHERE `group` LIKE '%" . $this->db->escape($group) . "%'");
        foreach ($query->rows as $row) {
            $result[] = $row['group'];
        }
        return $result;
    }

    public function getSettingKeys($key = '', $group = '')
    {
        $result = array();
        $sql = "SELECT DISTINCT(`key`) FROM `" . DB_PREFIX . "setting` WHERE `key` LIKE '%" . $this->db->escape($key) . "%'";
        if ($group) {
            $sql .= " AND `group` LIKE '%" . $this->db->escape($group) . "%'";
        }
        $query = $this->db->query($sql);
        foreach ($query->rows as $row) {
            $result[] = $row['key'];
        }
        return $result;
    }
}
