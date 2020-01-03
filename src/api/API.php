<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/link/db.php";

class API {

    public $db;

    function __construct()
    {
        $this->db = new DB();
        $this->db->getConnection();
    }

    function addSession($sessionid, $pubKey, $domain, $username)
    {
        $response = $this->searchRemote($domain, $username);
        if (!isset($response["error"])) {
            if (isset($this->getSession($sessionid)["error"])) {
                $this->db->insert("sessions", "sessionid, pubKey, loginid, password", "'$sessionid', '$pubKey', '" . $response["id"] . "', ''");
                return array("status" => "success");
            } else {
                return array("error" => "sessionid already in use");
            }
        }
        return $response;
    }

    function setPassword($sessionid, $password)
    {
        if (!isset($this->getSession($sessionid)["error"])) {
            $this->db->update("sessions", "password", $password, "sessionid='$sessionid'");
            return array("status" => "success");
        }
        return array("error" => "sessionid not found");
    }

    function getSession($sessionid)
    {

        $res = $this->db->select("pubkey, loginid, password", "sessions", "sessionid='$sessionid'");
        if ($res->num_rows > 0) {
            return $res->fetch_assoc();
        } else {
            return array("error" => "sessionid not found");
        }

    }

    function getRemote($id)
    {

        $res = $this->db->select("id, domain, username, fieldPwId, form", "logins", "id='$id'");
        if ($res->num_rows > 0) {
            return $res->fetch_assoc();
        } else {
            return array("error" => "login not found");
        }

    }

    function searchRemote($domain, $username) {
        $res = $this->db->select("id", "logins", "domain='$domain' AND username='$username'");
        if ($res->num_rows > 0) {
            return $res->fetch_assoc();
        } else {
            return array("error" => "login not found");
        }
    }

    function addLogin($domain, $username, $fieldPwId, $form)
    {
        if (isset($this->searchRemote($domain, $username)["error"])) {
            $this->db->insert("logins", "domain, username, fieldPwId, form", "'$domain', '$username', '$fieldPwId', '$form'");
            return array("status" => "success");
        }
        return array("error" => "domain/username combination already in use");
    }

    function deleteSession($sessionid)
    {
        if (!isset($this->getSession($sessionid)["error"])) {
            $this->db->delete("sessions", "sessionid", "'$sessionid'");
            return array("status" => "success");
        }
        return array("error" => "sessionid not found");
    }

}
