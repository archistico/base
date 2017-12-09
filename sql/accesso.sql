CREATE TABLE `accesso` (
  `accessoid` int(11) NOT NULL,
  `cookiename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `utentefk` int(11) NOT NULL,
  `utentetipologia` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `data` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-',
  `errore` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `accesso`
  ADD PRIMARY KEY (`accessoid`);

ALTER TABLE `accesso`
MODIFY `accessoid` int(11) NOT NULL AUTO_INCREMENT;