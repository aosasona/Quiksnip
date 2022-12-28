<?php

namespace Quiksnip\Web\Utils;

use Quiksnip\Web\Models\Logs;


class Logger
{

  public const SHARED = "shared";
  public const CREATED = "created";
  public const VIEWED = "viewed";
  public const GENERATED_SESSION_URL = "generated session url";


  public static function logEvent(int $sid, string $event, string $data, string $subject = "web"): void
  {
    $user = Auth::getSessionUser() ?? null;
    if (!$user) return;
    $log = new Logs();
    $log->event = $event;
    $log->subject = $subject;
    $log->data = $data;
    $log->user_id = $user["id"] ?? 0;
    $log->snippet_id = $sid;
    $log->save();
  }
}
