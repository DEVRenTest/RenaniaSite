<?php
//-----------------------------------------------------
// Newsletter Enhancements for Opencart
// Created by @DmitryNek (Dmitry Shkoliar)
// exmail.Nek@gmail.com
//-----------------------------------------------------

class ModelNeSubscribeBox extends Model {

    public function getList() {
        $query = $this->db->query("SELECT subscribe_box_id, name, datetime, status FROM " . DB_PREFIX . "ne_subscribe_box");
        return $query->rows;
    }

    public function delete($subscribe_box_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "ne_subscribe_box WHERE subscribe_box_id = '" . (int)$subscribe_box_id . "'");
        return $this->db->countAffected();
    }

    public function save($data) {
        $name = $data['name'] ? $data['name'] : date('Y-m-d H:i:s');
        unset($data['name']);
        $status = $data['status'] ? $data['status'] : '0';
        unset($data['status']);

        $data['modal_bg_color'] = empty($data['modal_bg_color']) ? '#ffffff' : $data['modal_bg_color'];
        $data['modal_line_color'] = empty($data['modal_line_color']) ? '#e5e5e5' : $data['modal_line_color'];
        $data['modal_heading_color'] = empty($data['modal_heading_color']) ? '#222222' : $data['modal_heading_color'];

        if (isset($data['id']) && $data['id']) {
            $id = $data['id'];
            unset($data['id']);
            $this->db->query("UPDATE " . DB_PREFIX . "ne_subscribe_box SET `name` = '" . $this->db->escape($name) . "', `status` = '" . (int)$status . "', `data` = '" . $this->db->escape(serialize($data)) . "' WHERE subscribe_box_id = '" . (int)$id . "'");
        } else {
            $this->db->query("INSERT INTO " . DB_PREFIX . "ne_subscribe_box SET `name` = '" . $this->db->escape($name) . "', `status` = '" . (int)$status . "', `data` = '" . $this->db->escape(serialize($data)) . "'");
            $id = $this->db->getLastId();
        }

        $this->cache->delete('ne_subscribe_box.' . (int)$id);

        return $id;
    }

    public function get($subscribe_box_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ne_subscribe_box WHERE subscribe_box_id = '" . (int)$subscribe_box_id . "'");
        $subscribe_box_info = $query->row;

        if ($subscribe_box_info) {
            $subscribe_box_info = array_merge($subscribe_box_info, unserialize($subscribe_box_info['data']));
            unset($subscribe_box_info['data']);

            return $subscribe_box_info;
        } else {
            return false;
        }
    }

    public function copy($subscribe_box_id) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "ne_subscribe_box (`name`, `data`) SELECT `name`, `data` FROM " . DB_PREFIX . "ne_subscribe_box WHERE `subscribe_box_id` = '" . (int)$subscribe_box_id . "'");
        return $this->db->getLastId();
    }

    public function editSettingValue($group = '', $key = '', $value = '', $store_id = 0) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "'");
        $setting_info = $query->row;

        if ($setting_info) {
            if (!is_array($value)) {
                $this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape($value) . "', serialized = '1' WHERE `group` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "'");
            } else {
                $this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1' WHERE `group` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "'");
            }
        } else {
            if (!is_array($value)) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
            } else {
                $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1'");
            }
        }
    }

    public function deleteSettingValue($group = '', $key = '') {
        $this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `group` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "'");
    }

}