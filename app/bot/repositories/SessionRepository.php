<?php

namespace Pcs\Bot\repositories;

use Pcs\Bot\Models\Session;

class SessionRepository
{
    public function getSessionByID($id)
    {
        return Session::all()->where('session_id', '=', $id)->first();
    }

    public function setSession($id, $status = null)
    {
        $session = new Session();
        $session->session_id = $id;
        if (!is_null($status)) {
            $session->status = $status;
        }
        $session->save();
    }

    public function setStatus($sessionID, $status)
    {
        $session = $this->getSessionByID($sessionID);

        if (empty($session->session_id)) {
            $this->setSession($sessionID, $status);
        } else {
            $session->status = $status;
            $session->save();
        }
    }

    public function getStatus($sessionID)
    {
        $session = $this->getSessionByID($sessionID);

        return $session->status;
    }
}