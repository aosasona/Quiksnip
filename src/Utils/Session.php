<?php

namespace Quiksnip\Web\Utils;

use Quiksnip\Web\Models\Session as SessionModel;

class Session
{
  public static function createSession(int $sid, int $ttl = 43200, array $data = []): string
  {
    $key = Auth::generateSessionKey();
    $session = new SessionModel();
    $session->session_key = $key;
    $session->snippet_id = $sid;
    $session->ttl = $ttl;
    $session->data = json_encode($data);
    $session->save();
    return $key;
  }

  /*
   * @return array<string,mixed>
   */
  public static function decodeSession(string $key): array|null
  {
    $session = new SessionModel();
    $session_data = $session->selectOne("SELECT * FROM sessions WHERE session_key = ?", [$key]);
    if (!$session_data) return null;

    return [
      "snippet_id" => $session_data["snippet_id"],
      "key" => $session_data["session_key"],
      "data" => json_decode($session_data["data"]),
      "ttl" => $session_data["ttl"]
    ];
  }
}
