<?php
// dl ticket event hooks

function onCreate($DATA)
{
  global $fromAddr, $masterPath;

  // log
  $type = (!$DATA["expire"]? "permanent": "temporary");
  logTicketEvent($DATA, "$type ticket created");
}


function onDownload($DATA)
{
  global $fromAddr, $masterPath;

  // log
  logTicketEvent($DATA, "downloaded by " . $_SERVER["REMOTE_ADDR"]);

  // notify if request
  if(!empty($DATA["email"]))
    mail($DATA["email"], "[dl] " . ticketStr($DATA) . " download notification",
	humanTicketStr($DATA) . " was downloaded by " . $_SERVER["REMOTE_ADDR"]
	. " from $masterPath\n", "From: $fromAddr");
}


function onPurge($DATA, $auto)
{
  global $fromAddr, $masterPath;

  // log
  $reason = ($auto? "automatically": "manually");
  logTicketEvent($DATA, "purged $reason after "
      . $DATA["downloads"] . " downloads");

  // notify if requested
  if(!empty($DATA["email"]))
    mail($DATA["email"], "[dl] " . ticketStr($DATA) . " purge notification",
	humanTicketStr($DATA) . " was purged after " . $DATA["downloads"]
	. " downloads from $masterPath\n", "From: $fromAddr");
}

?>