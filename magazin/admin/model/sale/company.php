<?php
class ModelSaleCompany extends Model
{
    public function addCompany($data)
    {
        $default = array('name' => '', 'cif' => 0, 'cui' => '', 'ax_code' => '', 'customers' => array());
        $data = array_merge($default, $data);
        $sql = "INSERT IGNORE INTO " . DB_PREFIX . "company SET name = '" . $this->db->escape($data['name']) . "'";
        if ($data['cif'] && (int)$data['cif']) {
            $sql .= ", cif = '" . (int)$data['cif'] . "'";
        }
        if ($data['cui']) {
            $sql .= ", cui = '" . $this->db->escape($data['cui']) . "'";
        }
        if ($data['ax_code']) {
            $sql .= ", ax_code = '" . $this->db->escape($data['ax_code']) . "'";
        }
        $this->db->query($sql);
        $company_id = $this->db->getLastId();
        $this->companyToCustomers($company_id, $data['customers']);

        return $company_id;
    }

    public function editCompany($company_id, $data)
    {
        $default = array('name' => '', 'cif' => 0, 'cui' => '', 'ax_code' => '', 'customers' => array());
        $data = array_merge($default, $data);
        $sql = "UPDATE " . DB_PREFIX . "company SET name = '" . $this->db->escape($data['name']) . "'";
        if ($data['cif']) {
            $sql .= ", cif = '" . (int)$data['cif'] . "'";
        }
        if ($data['cui']) {
            $sql .= ", cui = '" . $this->db->escape($data['cui']) . "'";
        }
        if ($data['ax_code']) {
            $sql .= ", ax_code = '" . $this->db->escape($data['ax_code']) . "'";
        }
        $sql .= " WHERE company_id = '" . (int)$company_id . "'";
        $this->db->query($sql);
        $this->companyToCustomers($company_id, $data['customers']);
    }

    public function companyToCustomers($company_id, $customers = array())
    {
        if ((int)$company_id <= 0) {
            return;
        }
        $this->db->query("DELETE FROM " . DB_PREFIX . "customer_to_company WHERE company_id = '" . (int)$company_id . "'");
        if (empty($customers)) {
            return;
        }
        $this->db->query(
            "INSERT IGNORE INTO " . DB_PREFIX . "customer_to_company (company_id, customer_id)
            SELECT " . (int)$company_id . ", customer_id FROM " . DB_PREFIX . "customer
            WHERE customer_id IN (" . implode(", ", array_map(function($item) { return (int)$item; }, $customers)) . ")"
        );
    }

    public function getCompany($company_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "company WHERE company_id = '" . (int)$company_id . "'");

        return $query->row;
    }

    public function getCompanyByCUI($cui)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "company WHERE cui = '" . $this->db->escape(trim($cui)) . "'");

        return $query->row;
    }

    public function getCompanyByCIF($cif)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "company WHERE cif = '" . (int)$cif . "'");

        return $query->row;
    }

    public function getCompanyByAxCode($ax_code)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "company WHERE ax_code = '" . $this->db->escape(trim($ax_code)) . "'");

        return $query->row;
    }

    public function searchCompany($term)
    {
        $term = $this->db->escape(trim($term));
        $query = $this->db->query(
            "SELECT * FROM " . DB_PREFIX . "company
            WHERE name LIKE '%" . $term . "%'
            OR cui LIKE '%" . $term . "%'
            OR cif LIKE '%" . $term . "%'
            OR ax_code LIKE '%" . $term . "%'"
        );
        return $query->rows;
    }

    public function getCompanies($data = array())
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "company";
        if (isset($data['filter_name']) && !empty($data['filter_name'])) {
            $sql .= " WHERE name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }
        // add other filters/sorting as necessary
        $sql .= " ORDER BY name";
        if (isset($data['order']) && $data['order'] == 'DESC') {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }
        if (isset($data['start']) || isset($data['limit'])) {
            if (!isset($data['start']) || (int)$data['start'] < 0) {
                $data['start'] = 0;
            }
            if (!isset($data['limit']) || (int)$data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $sql .= " LIMIT " . (int)$data['start'] . ", " . (int)$data['limit'];
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getCompanyCustomers($company_id)
    {
        $result = array();
        $query = $this->db->query("SELECT customer_id FROM " . DB_PREFIX . "customer_to_company WHERE company_id = '" . (int)$company_id . "'");
        foreach ($query->rows as $row) {
            $result[] = $row['customer_id'];
        }
        return $result;
    }

    public function getCompanyCount($data = array())
    {
        $sql = "SELECT COUNT(*) as total FROM " . DB_PREFIX . "company";
        if (isset($data['filter_name']) && !empty($data['filter_name'])) {
            $sql .= " WHERE name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function deleteCompany($company_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "company WHERE company_id = '" . (int)$company_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "customer_to_company WHERE company_id = '" . (int)$company_id . "'");
    }
}
