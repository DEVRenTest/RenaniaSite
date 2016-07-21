<?php
class ModelSettingCustomerSetting extends Model
{
    public function getSetting($customer_id, $group, $key)
    {
        $query = $this->db->query("SELECT `value`, `is_json` FROM " . DB_PREFIX . "customer_setting WHERE `customer_id` = '" . (int)$customer_id . "' AND `group` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "'");
        if ($query->num_rows) {
            if ($query->row['is_json']) {
                return json_decode($query->row['value'], true);
            } else {
                return $query->row['value'];
            }
        }
        return false;
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
}
